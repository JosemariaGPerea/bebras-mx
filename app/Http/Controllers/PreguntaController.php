<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use App\Models\ProgresoUsuario;
use Illuminate\Http\Request;

class PreguntaController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAlumno()) {
                $preguntas = Pregunta::activas()->orderBy('numero')->get();
            } else {
                // Admin ve todas
                $preguntas = Pregunta::orderBy('numero')->get();
            }
            
            if (auth()->check()) {
                $progreso = ProgresoUsuario::where('user_id', auth()->id())
                    ->pluck('es_correcta', 'pregunta_id');
            } else {
                $progreso = collect();
            }
            
            return view('preguntas.index', compact('preguntas', 'progreso'));
    }

    public function show($id)
    {
        $pregunta = Pregunta::findOrFail($id);
        
        // Verificar si el alumno puede ver esta pregunta
        if (auth()->user()->isAlumno() && !$pregunta->activa) {
            abort(403, 'Esta pregunta no está disponible en este momento.');
        }
        
        // Verificar si ya respondió
        $progresoUsuario = null;
        $yaRespondio = false;
        
        if (auth()->check()) {
            $progresoUsuario = ProgresoUsuario::where('user_id', auth()->id())
                ->where('pregunta_id', $id)
                ->first();
            
            $yaRespondio = $progresoUsuario !== null;
        }
        
        return view('preguntas.show', compact('pregunta', 'progresoUsuario', 'yaRespondio'));
    }

    public function verificar(Request $request, $id)
    {
        $pregunta = Pregunta::findOrFail($id);
        
        // Verificar si ya respondió
        $progresoExistente = ProgresoUsuario::where('user_id', auth()->id())
            ->where('pregunta_id', $id)
            ->first();
        
        if ($progresoExistente && auth()->user()->isAlumno()) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Ya respondiste esta pregunta anteriormente.'
            ], 403);
        }
        
        $respuestaUsuario = $request->input('respuesta');
        $respuestaCorrecta = $pregunta->respuesta_correcta;
        
        $esCorrecta = $this->validarRespuesta(
            $pregunta->tipo_interaccion, 
            $respuestaUsuario, 
            $respuestaCorrecta
        );
        
        // Guardar progreso
        if (auth()->check()) {
            ProgresoUsuario::create([
                'user_id' => auth()->id(),
                'pregunta_id' => $id,
                'respuesta_usuario' => $respuestaUsuario,
                'es_correcta' => $esCorrecta,
                'completada_at' => now(),
            ]);
        }
        
        return response()->json([
            'correcta' => $esCorrecta,
            'explicacion' => $pregunta->explicacion,
            'respuesta_correcta_visual' => $this->formatearRespuestaCorrecta($pregunta->tipo_interaccion, $respuestaCorrecta),
            'imagen_respuesta' => $pregunta->imagen_respuesta,
        ]);
    }

    private function validarRespuesta($tipo, $usuario, $correcta)
    {
        if (!$usuario) {
            return false;
        }

        switch ($tipo) {
            case 'seleccion_simple':
                return $this->validarSeleccionSimple($usuario, $correcta);
            
            case 'seleccion_multiple':
                return $this->validarSeleccionMultiple($usuario, $correcta);
            
            case 'ordenar':
                return $this->validarOrdenar($usuario, $correcta);
            
            case 'grid_seleccion':
                return $this->validarGrid($usuario, $correcta);
            
            case 'emparejar':
                return $this->validarEmparejar($usuario, $correcta);
            
            case 'rellenar':
                return $this->validarRellenar($usuario, $correcta);
            
            case 'texto_libre':
                return $this->validarTextoLibre($usuario, $correcta);
            
            default:
                return false;
        }
    }

    private function validarSeleccionSimple($usuario, $correcta)
    {
        // $correcta puede ser ['B'] o [['B']]
        $correctaFlat = is_array($correcta[0] ?? null) ? $correcta[0] : $correcta;
        return isset($usuario[0]) && in_array($usuario[0], $correctaFlat);
    }

    private function validarSeleccionMultiple($usuario, $correcta)
    {
        // $correcta puede ser [['1', '2', '3']] o ['1', '2', '3']
        $correctaFlat = is_array($correcta[0] ?? null) && is_string($correcta[0]) 
            ? $correcta 
            : ($correcta[0] ?? []);
        
        if (count($usuario) !== count($correctaFlat)) {
            return false;
        }
        
        sort($usuario);
        sort($correctaFlat);
        
        return $usuario === $correctaFlat;
    }

    private function validarOrdenar($usuario, $correcta)
    {
        // Verificar si hay múltiples respuestas correctas posibles
        if (isset($correcta[0]) && is_array($correcta[0])) {
            // Múltiples soluciones posibles
            foreach ($correcta as $solucion) {
                if ($usuario === $solucion) {
                    return true;
                }
            }
            return false;
        }
        
        // Una sola solución
        return $usuario === $correcta;
    }

    private function validarGrid($usuario, $correcta)
    {
        if (!is_array($usuario) || !is_array($correcta)) {
            return false;
        }

        if (count($usuario) !== count($correcta)) {
            return false;
        }
        
        $usuarioSet = collect($usuario)
            ->map(function($r) {
                return "{$r['fila']}-{$r['columna']}";
            })
            ->sort()
            ->values()
            ->toArray();
            
        $correctaSet = collect($correcta)
            ->map(function($r) {
                return "{$r['fila']}-{$r['columna']}";
            })
            ->sort()
            ->values()
            ->toArray();
        
        return $usuarioSet === $correctaSet;
    }

    private function validarEmparejar($usuario, $correcta)
    {
        if (!is_array($usuario) || !is_array($correcta)) {
            return false;
        }

        if (count($usuario) !== count($correcta)) {
            return false;
        }
        
        foreach ($correcta as $emparejamiento) {
            $encontrado = false;
            foreach ($usuario as $respuesta) {
                if ($respuesta['objeto'] === $emparejamiento['objeto'] && 
                    $respuesta['destino'] === $emparejamiento['destino']) {
                    $encontrado = true;
                    break;
                }
            }
            if (!$encontrado) {
                return false;
            }
        }
        
        return true;
    }

    private function validarRellenar($usuario, $correcta)
    {
        if (!is_array($usuario) || !is_array($correcta)) {
            return false;
        }

        if (count($usuario) !== count($correcta)) {
            return false;
        }
        
        // Para rellenar, verificar que todas las áreas tengan el color correcto
        foreach ($correcta as $colorCorrecto) {
            $encontrado = false;
            foreach ($usuario as $respuesta) {
                if ($respuesta['area'] === $colorCorrecto['area'] && 
                    $respuesta['color'] === $colorCorrecto['color']) {
                    $encontrado = true;
                    break;
                }
            }
            if (!$encontrado) {
                return false;
            }
        }
        
        return true;
    }

private function validarTextoLibre($usuario, $correcta)
{
    // Validar que el usuario envió algo
    if (!isset($usuario[0]) || empty(trim($usuario[0]))) {
        return false;
    }

    $respuestaUsuario = strtolower(trim($usuario[0]));
    
    // Normalizar $correcta para que siempre sea un array plano de strings
    if (!is_array($correcta)) {
        $correcta = [$correcta];
    }
    
    // Si es array anidado [['4']], aplanar a ['4']
    if (isset($correcta[0]) && is_array($correcta[0])) {
        $correcta = $correcta[0];
    }
    
    // Comparar con cada respuesta válida
    foreach ($correcta as $opcionCorrecta) {
        $opcionCorrecta = strtolower(trim((string)$opcionCorrecta));
        
        if ($respuestaUsuario === $opcionCorrecta) {
            return true;
        }
    }
    
    return false;
    }

    private function formatearRespuestaCorrecta($tipo, $correcta)
    {
        switch ($tipo) {
            case 'seleccion_simple':
                $opciones = is_array($correcta[0] ?? null) ? $correcta[0] : $correcta;
                return 'Opción correcta: ' . implode(', ', $opciones);
            
            case 'seleccion_multiple':
                $opciones = is_array($correcta[0] ?? null) && is_string($correcta[0]) 
                    ? $correcta 
                    : ($correcta[0] ?? []);
                return 'Opciones correctas: ' . implode(', ', $opciones);
            
            case 'ordenar':
                if (isset($correcta[0]) && is_array($correcta[0])) {
                    return 'Una respuesta posible: ' . implode(' → ', $correcta[0]);
                }
                return 'Orden correcto: ' . implode(' → ', $correcta);
            
            case 'grid_seleccion':
                $texto = 'Celdas correctas: ';
                foreach ($correcta as $celda) {
                    $texto .= "Fila " . ($celda['fila'] + 1) . ", Columna " . ($celda['columna'] + 1) . "; ";
                }
                return rtrim($texto, '; ');
            
            case 'emparejar':
                $texto = 'Emparejamientos correctos: ';
                foreach ($correcta as $par) {
                    $texto .= "{$par['objeto']} → {$par['destino']}, ";
                }
                return rtrim($texto, ', ');
            
            case 'texto_libre':
                $opciones = is_array($correcta[0] ?? null) ? $correcta : [$correcta[0] ?? 'N/A'];
                return 'Respuesta correcta: ' . implode(' o ', $opciones);
            
            case 'rellenar':
                return 'Revisa la explicación para ver la solución completa.';
            
            default:
                return '';
        }
    }
}