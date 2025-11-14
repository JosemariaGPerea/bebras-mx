<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\TipoInteraccion;
use App\Models\Pregunta;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class PreguntasSeeder extends Seeder
{
    public function run()
    {
        //crear un usuario 
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@bebras.mx',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Crear algunos alumnos de ejemplo
        User::create([
            'name' => 'Alumno Ejemplo',
            'email' => 'alumno@bebras.mx',
            'password' => Hash::make('alumno123'),
            'role' => 'alumno',
        ]);

        $preguntas = [
            // PREGUNTA 01 - Libros Populares
            [
                'numero' => '01',
                'titulo' => 'Libros Populares',
                'descripcion' => 'Los niños piden libros en la Biblioteca. La maestra encargada hizo una tabla para saber qué libro pide cada niño.',
                'imagen_descripcion' => 'preguntas/01/tabla.png',
                'pregunta' => '¿Cuál libro es el que los niños piden más seguido de acuerdo a esta tabla?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'imagen', 'valor' => 'preguntas/01/caracol.png'],
                        ['id' => 'B', 'tipo' => 'imagen', 'valor' => 'preguntas/01/oruga.png'],
                        ['id' => 'C', 'tipo' => 'imagen', 'valor' => 'preguntas/01/mariposa.png'],
                        ['id' => 'D', 'tipo' => 'imagen', 'valor' => 'preguntas/01/catarina.png'],
                    ]
                ]),
                'respuesta_correcta' => json_encode(['B']),
                'explicacion' => 'Al analizar la tabla: 3 niños piden el libro de la Oruga, 1 niño pide el Caracol, 2 piden Mariposa y 1 Catarina. El libro más pedido es el de la Oruga.',
                'imagen_respuesta' => null,
                'nivel' => 'I',
                'dificultad' => 'Baja',
                'pais_origen' => 'Alemania',
                'codigo_tarea' => '2022-DE-06',
            ],

            // PREGUNTA 02 - Tutorial de Dibujo
            [
                'numero' => '02',
                'titulo' => 'Tutorial de Dibujo',
                'descripcion' => 'Deepa está aprendiendo a hacer un tipo de pintura tradicional de la India, llamado Warli. Tiene 6 tarjetas que le muestran paso a paso cómo hacerlo, pero se le cayeron al piso y ¡ahora se han revuelto!',
                'imagen_descripcion' => 'preguntas/02/dibujo_final.png',
                'pregunta' => 'Coloca las tarjetas de nuevo en orden.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'ordenar',
                'configuracion' => json_encode([
                    'elementos' => [
                        ['id' => 'A', 'imagen' => 'preguntas/02/tarjeta_a.png'],
                        ['id' => 'B', 'imagen' => 'preguntas/02/tarjeta_b.png'],
                        ['id' => 'C', 'imagen' => 'preguntas/02/tarjeta_c.png'],
                        ['id' => 'D', 'imagen' => 'preguntas/02/tarjeta_d.png'],
                        ['id' => 'E', 'imagen' => 'preguntas/02/tarjeta_e.png'],
                        ['id' => 'F', 'imagen' => 'preguntas/02/tarjeta_f.png'],
                    ],
                    'mostrar_numeros' => true,
                ]),
                'respuesta_correcta' => json_encode(['E', 'F', 'A', 'B', 'C', 'D']),
                'explicacion' => 'El orden correcto es E, F, A, B, C, D. Observando las tarjetas, hay partes del dibujo que se repiten y otras que se van agregando.',
                'imagen_respuesta' => null,
                'nivel' => 'I',
                'dificultad' => 'Baja',
                'pais_origen' => 'India',
                'codigo_tarea' => '2022-IN-01',
            ],

            // PREGUNTA 03 - Receta de Hamburguesas
            [
                'numero' => '03',
                'titulo' => 'Receta de Hamburguesas',
                'descripcion' => 'Jessica está preparando hamburguesas de acuerdo a las siguientes reglas:
1. La salsa debe estar justo arriba de la carne
2. La carne y el queso deben estar debajo de los pepinillos, la lechuga y la cebolla
3. Las cebollas no deben tocar el pan
4. Todos los ingredientes tienen que estar entre los panes',
                'imagen_descripcion' => 'preguntas/03/ingredientes.png',
                'pregunta' => '¿Cuál de las siguientes hamburguesas es correcta con las reglas?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'imagen', 'valor' => 'preguntas/03/hamburguesa_a.png'],
                        ['id' => 'B', 'tipo' => 'imagen', 'valor' => 'preguntas/03/hamburguesa_b.png'],
                        ['id' => 'C', 'tipo' => 'imagen', 'valor' => 'preguntas/03/hamburguesa_c.png'],
                        ['id' => 'D', 'tipo' => 'imagen', 'valor' => 'preguntas/03/hamburguesa_d.png'],
                    ]
                ]),
                'respuesta_correcta' => json_encode(['D']),
                'explicacion' => 'La opción D cumple con todas las reglas: la salsa está sobre la carne, la carne y queso están debajo de vegetales, las cebollas no tocan el pan, y todo está entre los panes.',
                'imagen_respuesta' => 'preguntas/03/respuesta.png',
                'nivel' => 'I',
                'dificultad' => 'Baja',
                'pais_origen' => 'Corea del Sur',
                'codigo_tarea' => '2022-KR-03',
            ],

            // PREGUNTA 04 - 5 Dulces
            [
                'numero' => '04',
                'titulo' => '5 Dulces',
                'descripcion' => 'Los dulces favoritos de Brian vienen en 5 sabores. Brian pone uno de cada sabor en un tubo que lleva a la escuela. Durante el día, Brian se come los dulces en el orden en el que salen de la parte superior del tubo.

Hoy quiere comerlos en este orden: Uva, Naranja, Limón, Fresa y Zarzamora.',
                'imagen_descripcion' => 'preguntas/04/orden_deseado.png',
                'pregunta' => 'Coloca los dulces en el tubo para que Brian los pueda comer en el orden que quiere.',
                'imagen_pregunta' => 'preguntas/04/tubo.png',
                'tipo_interaccion' => 'ordenar',
                'configuracion' => json_encode([
                    'elementos' => [
                        ['id' => 'uva', 'imagen' => 'preguntas/04/dulce_uva.png', 'nombre' => 'Uva'],
                        ['id' => 'naranja', 'imagen' => 'preguntas/04/dulce_naranja.png', 'nombre' => 'Naranja'],
                        ['id' => 'limon', 'imagen' => 'preguntas/04/dulce_limon.png', 'nombre' => 'Limón'],
                        ['id' => 'fresa', 'imagen' => 'preguntas/04/dulce_fresa.png', 'nombre' => 'Fresa'],
                        ['id' => 'zarzamora', 'imagen' => 'preguntas/04/dulce_zarzamora.png', 'nombre' => 'Zarzamora'],
                    ],
                    'tipo_contenedor' => 'vertical', // Los dulces se apilan verticalmente
                    'instruccion' => 'Arrastra los dulces al tubo. El primero que coloques será el último en salir.',
                ]),
                'respuesta_correcta' => json_encode(['zarzamora', 'fresa', 'limon', 'naranja', 'uva']),
                'explicacion' => 'El orden debe ser inverso: Zarzamora, Fresa, Limón, Naranja, Uva. El primero que entra al tubo será el último en salir (estructura tipo pila).',
                'imagen_respuesta' => 'preguntas/04/respuesta.png',
                'nivel' => 'I',
                'dificultad' => 'Baja',
                'pais_origen' => 'Reino Unido',
                'codigo_tarea' => '2022-UK-02',
            ],

            // PREGUNTA 05 - ¿Dónde quedó la bolita?
            [
                'numero' => '05',
                'titulo' => '¿Dónde quedó la bolita?',
                'descripcion' => 'Lila y sus amigas están jugando este juego. Al inicio Lila pone la canica en la Bolsa A, una gema en la Bolsa B y una bola de papel en la Bolsa C.

Luego, le pide a sus amigas que cierren los ojos. Y mientras tienen los ojos cerrados, mezcla el contenido de las bolsas:
1. Intercambia los objetos de la Bolsa A y B
2. Intercambia los objetos de las bolsas A y C
3. Intercambia los objetos de las bolsas B y C',
                'imagen_descripcion' => 'preguntas/05/estado_inicial.png',
                'pregunta' => '¿En dónde quedó cada uno de los objetos? Une cada objeto a su posición final.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'emparejar',
                'configuracion' => json_encode([
                    'objetos' => [
                        ['id' => 'canica', 'imagen' => 'preguntas/05/canica.png', 'nombre' => 'Canica'],
                        ['id' => 'gema', 'imagen' => 'preguntas/05/gema.png', 'nombre' => 'Gema'],
                        ['id' => 'papel', 'imagen' => 'preguntas/05/papel.png', 'nombre' => 'Papel'],
                    ],
                    'destinos' => [
                        ['id' => 'A', 'nombre' => 'Bolsa A'],
                        ['id' => 'B', 'nombre' => 'Bolsa B'],
                        ['id' => 'C', 'nombre' => 'Bolsa C'],
                    ]
                ]),
                'respuesta_correcta' => json_encode([
                    ['objeto' => 'canica', 'destino' => 'C'],
                    ['objeto' => 'gema', 'destino' => 'B'],
                    ['objeto' => 'papel', 'destino' => 'A'],
                ]),
                'explicacion' => 'Siguiendo los intercambios: Después del primer intercambio (A↔B), después del segundo (A↔C) y finalmente (B↔C), el papel queda en A, la gema en B y la canica en C.',
                'imagen_respuesta' => 'preguntas/05/respuesta.png',
                'nivel' => 'I',
                'dificultad' => 'Media',
                'pais_origen' => 'Alemania',
                'codigo_tarea' => '2022-CH-14',
            ],

            // PREGUNTA 06 - Palillos Chinos
            [
                'numero' => '06',
                'titulo' => 'Palillos Chinos',
                'descripcion' => 'Ana está jugando el juego de Palillos Chinos. Tira algunos palillos en la mesa y luego los tiene que recoger de acuerdo a las siguientes reglas:
1. Solo se puede recoger un palillo a la vez
2. Se puede recoger un palillo si no hay ningún otro palillo que esté arriba de él.',
                'imagen_descripcion' => 'preguntas/06/palillos_inicial.png',
                'pregunta' => '¿En qué orden debe recogerlos?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'ordenar',
                'configuracion' => json_encode([
                    'elementos' => [
                        ['id' => 'gris_puntos', 'imagen' => 'preguntas/06/palillo_gris_puntos.png'],
                        ['id' => 'blanco', 'imagen' => 'preguntas/06/palillo_blanco.png'],
                        ['id' => 'negro_puntos', 'imagen' => 'preguntas/06/palillo_negro_puntos.png'],
                        ['id' => 'gris', 'imagen' => 'preguntas/06/palillo_gris.png'],
                        ['id' => 'negro', 'imagen' => 'preguntas/06/palillo_negro.png'],
                        ['id' => 'blanco_puntos', 'imagen' => 'preguntas/06/palillo_blanco_puntos.png'],
                    ],
                    'mostrar_numeros' => true,
                ]),
                'respuesta_correcta' => json_encode(['gris_puntos', 'blanco', 'negro_puntos', 'gris', 'negro', 'blanco_puntos']),
                'explicacion' => 'Ana debe tomar siempre el que está arriba de todos. El primero es el gris con puntos negros, luego el blanco, después el negro con puntos blancos, el gris, el negro y finalmente el blanco con puntos negros.',
                'imagen_respuesta' => 'preguntas/06/respuesta.png',
                'nivel' => 'II',
                'dificultad' => 'Baja',
                'pais_origen' => 'Brasil',
                'codigo_tarea' => '2022-BR-01',
            ],

            // PREGUNTA 07 - Collares de Amistad
            [
                'numero' => '07',
                'titulo' => 'Collares de Amistad',
                'descripcion' => 'Monika y Veronika trajeron collares de recuerdo de sus vacaciones. Ahora quieren que su amiga Anastasia también tenga un collar, por lo que usaron 6 cuentas de sus collares para hacer uno nuevo.

Después de quitar las cuentas, los collares quedaron así:
- Monika: ahora tiene 3 cuentas amarillas menos
- Veronika: ahora tiene 3 cuentas rojas menos',
                'imagen_descripcion' => 'preguntas/07/collares_antes.png',
                'pregunta' => '¿Cuál de los siguientes es el collar de Anastasia?',
                'imagen_pregunta' => 'preguntas/07/collares_despues.png',
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'imagen', 'valor' => 'preguntas/07/collar_a.png'],
                        ['id' => 'B', 'tipo' => 'imagen', 'valor' => 'preguntas/07/collar_b.png'],
                        ['id' => 'C', 'tipo' => 'imagen', 'valor' => 'preguntas/07/collar_c.png'],
                        ['id' => 'D', 'tipo' => 'imagen', 'valor' => 'preguntas/07/collar_d.png'],
                    ]
                ]),
                'respuesta_correcta' => json_encode(['A']),
                'explicacion' => 'El nuevo collar debe tener 3 cuentas amarillas (de Monika) y 3 cuentas rojas (de Veronika). El único collar así es la opción A.',
                'imagen_respuesta' => null,
                'nivel' => 'II',
                'dificultad' => 'Media',
                'pais_origen' => 'Macedonia del Norte',
                'codigo_tarea' => '2022-MK-05B',
            ],

            // PREGUNTA 08 - Dividiendo el terreno
            [
                'numero' => '08',
                'titulo' => 'Dividiendo el terreno',
                'descripcion' => 'Los Castores y las Nutrias quieren dividirse el área del terreno en el que viven. De forma que todos los Castores queden de un lado y todas las Nutrias en el otro.',
                'imagen_descripcion' => 'preguntas/08/terreno.png',
                'pregunta' => '¿Cuál forma de dividir el terreno, logra que se tengan que mudar la menor cantidad de Castores y de Nutrias a otro lugar?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'imagen', 'valor' => 'preguntas/08/division_a.png'],
                        ['id' => 'B', 'tipo' => 'imagen', 'valor' => 'preguntas/08/division_b.png'],
                        ['id' => 'C', 'tipo' => 'imagen', 'valor' => 'preguntas/08/division_c.png'],
                        ['id' => 'D', 'tipo' => 'imagen', 'valor' => 'preguntas/08/division_d.png'],
                    ]
                ]),
                'respuesta_correcta' => json_encode(['A']),
                'explicacion' => 'En la opción A, solo un castor tiene que moverse. En las demás opciones se requiere que se muevan 2 o 3 animales.',
                'imagen_respuesta' => 'preguntas/08/respuesta.png',
                'nivel' => 'II',
                'dificultad' => 'Baja',
                'pais_origen' => 'Corea del Sur',
                'codigo_tarea' => '2023-KR-01',
            ],

            // PREGUNTA 09 - Rompecabezas
            [
                'numero' => '09',
                'titulo' => 'Rompecabezas',
                'descripcion' => 'Sam tiene un rompecabezas con hexágonos de 3 colores. Para colocar una pieza, debe asegurarse que en el triángulo que se forma (con las 2 piezas de abajo), todas sean del mismo color ó que todas sean de colores diferentes.',
                'imagen_descripcion' => 'preguntas/09/regla.png',
                'pregunta' => 'Ahora tu, intenta armar un cuadrado de 2x2 utilizando 4 de las siguientes 5 cartas.',
                'imagen_pregunta' => 'preguntas/09/tarjetas.png',
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'tipo' => 'texto',
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'texto', 'valor' => 'Tarjeta A'],
                        ['id' => 'B', 'tipo' => 'texto', 'valor' => 'Tarjeta B'],
                        ['id' => 'C', 'tipo' => 'texto', 'valor' => 'Tarjeta C'],
                        ['id' => 'D', 'tipo' => 'texto', 'valor' => 'Tarjeta D'],
                        ['id' => 'E', 'tipo' => 'texto', 'valor' => 'Tarjeta E'],
                    ],
                    'pregunta_especial' => '¿Qué tarjeta NO se puede usar?'
                ]),
                'respuesta_correcta' => json_encode(['C']),
                'explicacion' => 'La tarjeta C (con estrellas azules) no se puede usar. Las tarjetas A, B, D y E sí forman un cuadrado válido.',
                'imagen_respuesta' => null,
                'nivel' => 'III',
                'dificultad' => 'Media',
                'pais_origen' => 'Bélgica',
                'codigo_tarea' => '2022-BE-02',
            ],

            // PREGUNTA 10 - Placas en el mundo
            [
                'numero' => '10',
                'titulo' => 'Placas en el mundo',
                'descripcion' => 'En cada país, los autos utilizan diferentes diseños y formatos para sus placas. Generalmente, se utilizan las letras del alfabeto en inglés (que tiene solo 26 letras) y los dígitos del 0 al 9.',
                'imagen_descripcion' => null,
                'pregunta' => '¿En cuál de las siguientes placas se podrían llegar a registrar la mayor cantidad de automóviles?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'imagen', 'valor' => 'preguntas/10/placa_a.png', 'descripcion' => '3 letras y 3 números'],
                        ['id' => 'B', 'tipo' => 'imagen', 'valor' => 'preguntas/10/placa_b.png', 'descripcion' => '4 letras y 3 números'],
                        ['id' => 'C', 'tipo' => 'imagen', 'valor' => 'preguntas/10/placa_c.png', 'descripcion' => '5 letras y 2 números'],
                        ['id' => 'D', 'tipo' => 'imagen', 'valor' => 'preguntas/10/placa_d.png', 'descripcion' => '2 letras y 6 números'],
                        ['id' => 'E', 'tipo' => 'imagen', 'valor' => 'preguntas/10/placa_e.png', 'descripcion' => '4 letras y 4 números'],
                    ]
                ]),
                'respuesta_correcta' => json_encode(['E']),
                'explicacion' => 'La opción E (4 letras y 4 números) permite más combinaciones. Cada letra aporta 26 posibilidades y cada número 10. 26⁴ × 10⁴ es mayor que las demás opciones.',
                'imagen_respuesta' => null,
                'nivel' => 'III',
                'dificultad' => 'Media',
                'pais_origen' => 'Lituania',
                'codigo_tarea' => '2023-LT-07',
            ],

            // PREGUNTA 11 - Corazón
            [
                'numero' => '11',
                'titulo' => 'Corazón',
                'descripcion' => 'Tina inicia con una imagen de un círculo y un cuadrado en una computadora. Con estas dos figuras quiere lograr formar un corazón. Para hacerlo, las va a modificar con un programa, pero solo puede usar estas 3 instrucciones:
- Rotar o Girar alguna de las figuras
- Mover alguna de las figuras
- Duplicar la figura en su mismo lugar',
                'imagen_descripcion' => 'preguntas/11/figuras_iniciales.png',
                'pregunta' => '¿Qué instrucciones realizó y en qué orden para lograrlo?',
                'imagen_pregunta' => 'preguntas/11/corazon_final.png',
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'texto', 'valor' => 'Duplicar-círculo, Rotar-círculo, Mover-círculo, Mover-cuadrado'],
                        ['id' => 'B', 'tipo' => 'texto', 'valor' => 'Duplicar-círculo, Rotar-cuadrado, Mover-círculo, Mover-círculo'],
                        ['id' => 'C', 'tipo' => 'texto', 'valor' => 'Duplicar-cuadrado, Rotar-cuadrado, Mover-cuadrado, Mover-círculo'],
                        ['id' => 'D', 'tipo' => 'texto', 'valor' => 'Mover-círculo, Mover-círculo, Duplicar-círculo, Mover-cuadrado'],
                    ]
                ]),
                'respuesta_correcta' => json_encode(['B']),
                'explicacion' => 'La secuencia correcta es: Duplicar el círculo, Rotar el cuadrado 45°, Mover el primer círculo a la izquierda, Mover el segundo círculo a la derecha.',
                'imagen_respuesta' => 'preguntas/11/respuesta.png',
                'nivel' => 'II',
                'dificultad' => 'Baja',
                'pais_origen' => 'Alemania',
                'codigo_tarea' => '2022-DE-02',
            ],

            // PREGUNTA 12 - Prende la Luz
            [
                'numero' => '12',
                'titulo' => 'Prende la Luz',
                'descripcion' => 'Este juego se llama "Prende la Luz". Tienes 8 switches o interruptores que se pueden activar o desactivar. Además, hay cables que salen de cada uno de esos interruptores y que pasan por algunos componentes:

- La salida del componente AND está PRENDIDA solo si los DOS cables que llegan están PRENDIDOS
- La salida del componente XOR está PRENDIDA cuando exactamente UNO de los cables que entra está PRENDIDO',
                'imagen_descripcion' => 'preguntas/12/circuito.png',
                'pregunta' => '¿Cuáles interruptores deben prenderse para que se prenda el foco?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_multiple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => '1', 'tipo' => 'texto', 'valor' => 'Interruptor A'],
                        ['id' => '2', 'tipo' => 'texto', 'valor' => 'Interruptor B'],
                        ['id' => '3', 'tipo' => 'texto', 'valor' => 'Interruptor C'],
                        ['id' => '4', 'tipo' => 'texto', 'valor' => 'Interruptor D'],
                        ['id' => '5', 'tipo' => 'texto', 'valor' => 'Interruptor E'],
                        ['id' => '6', 'tipo' => 'texto', 'valor' => 'Interruptor F'],
                        ['id' => '7', 'tipo' => 'texto', 'valor' => 'Interruptor G'],
                        ['id' => '8', 'tipo' => 'texto', 'valor' => 'Interruptor H'],
                    ],
                    'nota' => 'Hay 16 posibles combinaciones correctas'
                ]),
                'respuesta_correcta' => json_encode([
                    ['1', '2', '4', '5', '6', '7', '8'],
                    ['1', '2', '3', '5', '6'],
                    ['1', '2', '4', '5', '6'],
                    ['1', '2', '3', '7'],
                    ['1', '4', '5', '8'],
                    ['1', '2', '3', '5', '6', '7', '8'],      
                    ['1', '2', '3', '5', '7'],
                    ['1', '2', '4', '6', '8'],
                    ['1', '2', '4', '6', '7'],
                    ['1', '2', '4', '7'],
                    ['1', '2', '3', '8'],
                    ['1', '2', '4', '5', '7'],
                    ['1', '2', '4', '5', '8'],
                    ['1', '2', '3', '6'],
                    ['1', '2', '3', '6', '7'],
                    
                ]),
                'explicacion' => 'Hay 16 combinaciones posibles. Una de ellas es prender los interruptores 1, 2, 3 y 5. Trabajando hacia atrás desde el foco, analizamos qué combinaciones de AND y XOR encienden el cable final.',
                'imagen_respuesta' => 'preguntas/12/Respuesta.png',
                'nivel' => 'III',
                'dificultad' => 'Media',
                'pais_origen' => 'Australia',
                'codigo_tarea' => '2022-AU-03',
            ],

            // PREGUNTA 13 - Espía de Cartas
            [
                'numero' => '13',
                'titulo' => 'Espía de Cartas',
                'descripcion' => 'La República de Bebraria mantiene un archivo lleno de cartas ultra secretas. Las cartas están numeradas del 1 al 16 y tan solo 10 de ellas se habían abierto. Las otras 6 seguían en sus sobres sellados.

Un día, un espía enemigo entró al archivo y abrió una de las cartas selladas. El vigilante recuerda que antes las cartas cumplían con lo siguiente:
- El número de cartas abiertas en las columnas de C2 y C4 juntas, era un número par
- El número de cartas abiertas en las columnas C3 y C4 juntas era también par
- El número de cartas abiertas en la fila R2 y R4 juntas era también par
- Y el número de cartas abiertas en la fila R3 y R4 juntas también era par',
                'imagen_descripcion' => 'preguntas/13/cartas_grid.png',
                'pregunta' => '¿Puedes saber cuál fue la carta sellada que abrió el espía?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'texto', 'valor' => '5'],
                        ['id' => 'B', 'tipo' => 'texto', 'valor' => '9'],
                        ['id' => 'C', 'tipo' => 'texto', 'valor' => '10'],
                        ['id' => 'D', 'tipo' => 'texto', 'valor' => '13'],
                        ['id' => 'E', 'tipo' => 'texto', 'valor' => 'No hay información suficiente para saberlo'],
                    ]
                ]),
                'respuesta_correcta' => json_encode(['D']),
                'explicacion' => 'La respuesta correcta es la carta 13. Usando las reglas de paridad (par/impar) para filas y columnas, podemos determinar que la carta abierta debe estar en C1 y R4, que corresponde a la carta 13.',
                'imagen_respuesta' => null,
                'nivel' => 'IV',
                'dificultad' => 'Media',
                'pais_origen' => 'Filipinas',
                'codigo_tarea' => '2023-PH-04',
            ],

            // PREGUNTA 14 - Colorear
            [
                'numero' => '14',
                'titulo' => 'Colorear',
                'descripcion' => 'Colorea la imagen con los colores verde, amarillo y azul, de forma que ninguna parte toque otra parte con el mismo color.',
                'imagen_descripcion' => 'preguntas/14/flor_sin_colorear.png',
                'pregunta' => 'Dibuja cada área con uno de los 3 colores siguiendo la regla.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'rellenar',
                'configuracion' => json_encode([
                    'colores_disponibles' => ['green', 'yellow', 'blue'],
                    'areas' => [
                        ['id' => 'fondo', 'nombre' => 'Fondo/Marco'],
                        ['id' => 'petalo1', 'nombre' => 'Pétalo 1'],
                        ['id' => 'petalo2', 'nombre' => 'Pétalo 2'],
                        ['id' => 'petalo3', 'nombre' => 'Pétalo 3'],
                        ['id' => 'petalo4', 'nombre' => 'Pétalo 4'],
                        ['id' => 'petalo5', 'nombre' => 'Pétalo 5'],
                        ['id' => 'centro', 'nombre' => 'Centro'],
                    ],
                    'tipo_validacion' => 'flexible', // Hay múltiples soluciones
                ]),
                'respuesta_correcta' => json_encode([
                    // Una de las 6 soluciones posibles
                    ['area' => 'fondo', 'color' => 'amarillo'],
                    ['area' => 'petalo1', 'color' => 'verde'],
                    ['area' => 'petalo2', 'color' => 'azul'],
                    ['area' => 'petalo3', 'color' => 'verde'],
                    ['area' => 'petalo4', 'color' => 'azul'],
                    ['area' => 'petalo5', 'color' => 'verde'],
                    ['area' => 'centro', 'color' => 'amarillo'],
                ]),
                'explicacion' => 'Existen 6 maneras correctas de colorear la flor. La estrategia es empezar por el área que toca más otras áreas (el fondo), luego alternar colores en los pétalos adyacentes.',
                'imagen_respuesta' => 'preguntas/14/flor_coloreada.png',
                'nivel' => 'III',
                'dificultad' => 'Alta',
                'pais_origen' => 'Austria',
                'codigo_tarea' => '2022-AT-01a',
            ],

            // PREGUNTA 15 - Panal de Abejas
            [
                'numero' => '15',
                'titulo' => 'Panal de Abejas',
                'descripcion' => 'Bebras necesita de tu ayuda para colocar las abejas en el panal. Se muestra una regla abajo de cada abeja: La abeja debe colocarse de esta forma en la celda gris. Y otras abejas deberán estar en las celdas en blanco.',
                'imagen_descripcion' => 'preguntas/15/panal_vacio.png',
                'pregunta' => 'Coloca las diferentes abejas en el panal de forma que sigan sus reglas.',
                'imagen_pregunta' => 'preguntas/15/abejas_reglas.png',
                'tipo_interaccion' => '',
                'configuracion' => json_encode([
                    'celdas_hexagonales' => 19, // Total de celdas en el panal
                    'abejas' => [
                        ['id' => '3', 'imagen' => 'preguntas/15/abeja1.png', 'regla' => 'preguntas/15/regla3.png'],
                        ['id' => '5', 'imagen' => 'preguntas/15/abeja2.png', 'regla' => 'preguntas/15/regla5.png'],
                        ['id' => '1', 'imagen' => 'preguntas/15/abeja3.png', 'regla' => 'preguntas/15/regla1.png'],
                        ['id' => '6', 'imagen' => 'preguntas/15/abeja4.png', 'regla' => 'preguntas/15/regla6.png'],
                        ['id' => '2', 'imagen' => 'preguntas/15/abeja5.png', 'regla' => 'preguntas/15/regla2.png'],
                        ['id' => '4', 'imagen' => 'preguntas/15/abeja6.png', 'regla' => 'preguntas/15/regla4.png'],
                        ['id' => '7', 'imagen' => 'preguntas/15/abeja7.png', 'regla' => 'preguntas/15/regla7.png'],
                    ],
                ]),
                'respuesta_correcta' => json_encode([
                    ['abeja' => '1', 'celda' => 5],
                    ['abeja' => '2', 'celda' => 1],
                    ['abeja' => '3', 'celda' => 12],
                    ['abeja' => '4', 'celda' => 18],
                    ['abeja' => '5', 'celda' => 8],
                    ['abeja' => '6', 'celda' => 14],
                    ['abeja' => '7', 'celda' => 10],
                ]),
                'explicacion' => 'La clave es empezar por las abejas con más restricciones (las que solo pueden ir en un lugar). Las abejas 2, 3 y 4 solo tienen una posición posible, lo que facilita colocar las demás.',
                'imagen_respuesta' => 'preguntas/15/panal_resuelto.png',
                'nivel' => 'IV',
                'dificultad' => 'Media',
                'pais_origen' => 'Francia',
                'codigo_tarea' => '2022-FR-02a',
            ],

            // PREGUNTA 16 - La Liebre y la Tortuga
            [
                'numero' => '16',
                'titulo' => 'La Liebre y la Tortuga',
                'descripcion' => 'La liebre y la tortuga decidieron hacer una nueva carrera. Ambas inician en el mismo lugar (corazón) y siguen la dirección de las flechas en la pista.
- La tortuga avanza un lugar cada minuto
- La liebre se mueve dos lugares cada minuto',
                'imagen_descripcion' => 'preguntas/16/pista.png',
                'pregunta' => '¿En qué lugar se van a encontrar la liebre y la tortuga nuevamente después del inicio?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'sandia', 'tipo' => 'imagen', 'valor' => 'preguntas/16/sandia.png'],
                        ['id' => 'manzana', 'tipo' => 'imagen', 'valor' => 'preguntas/16/manzana.png'],
                        ['id' => 'naranja', 'tipo' => 'imagen', 'valor' => 'preguntas/16/naranja.png'],
                        ['id' => 'platano', 'tipo' => 'imagen', 'valor' => 'preguntas/16/platano.png'],
                        ['id' => 'uva', 'tipo' => 'imagen', 'valor' => 'preguntas/16/uva.png'],
                    ]
                ]),
                'respuesta_correcta' => json_encode(['naranja']),
                'explicacion' => 'Después de 6 minutos, ambos se encuentran en la naranja. La tortuga avanza 6 lugares y la liebre 12, pero debido al ciclo en la pista, ambos llegan a la misma posición.',
                'imagen_respuesta' => null,
                'nivel' => 'IV',
                'dificultad' => 'Alta',
                'pais_origen' => 'Filipinas',
                'codigo_tarea' => '2022-PH-03',
            ],

            // PREGUNTA 17 - Juego en la Playa
            [
                'numero' => '17',
                'titulo' => 'Juego en la Playa',
                'descripcion' => 'Ana y Bob inventaron un juego en la playa. Ana juntó conchas color blanco y Bob juntó piedritas negras. Hicieron hoyos en la arena y los conectaron con surcos. Reglas:
- Van a jugar por turnos
- En cada turno, el jugador coloca una de sus piezas en un hoyo vacío
- Ana inicia el juego
- Pierde el jugador que coloque dos de sus piezas en dos hoyos conectados por un surco',
                'imagen_descripcion' => 'preguntas/17/tablero_inicial.png',
                'pregunta' => 'Es el turno de Ana, ¿en qué lugar debe colocar la concha para asegurar la victoria?',
                'imagen_pregunta' => 'preguntas/17/pista.png',
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => '2', 'tipo' => 'texto', 'valor' => 'Posición 2'],
                        ['id' => '3', 'tipo' => 'texto', 'valor' => 'Posición 3'],
                        ['id' => '5', 'tipo' => 'texto', 'valor' => 'Posición 5'],
                        ['id' => '7', 'tipo' => 'texto', 'valor' => 'Posición 7'],
                         ['id' => '2', 'tipo' => 'texto', 'valor' => 'Posición 1'],
                        ['id' => '3', 'tipo' => 'texto', 'valor' => 'Posición 4'],
                        ['id' => '5', 'tipo' => 'texto', 'valor' => 'Posición 6'],
                    ]
                ]),
                'respuesta_correcta' => json_encode(['7']),
                'explicacion' => 'Ana debe colocar su concha en la posición 7. Esto fuerza a Bob a una situación donde no tendrá movimientos válidos, asegurando la victoria de Ana.',
                'imagen_respuesta' => null,
                'nivel' => 'V',
                'dificultad' => 'Media',
                'pais_origen' => 'Italia',
                'codigo_tarea' => '2022-IT-02',
            ],

            // PREGUNTA 18 - Bitácora de fotos
            [
                'numero' => '18',
                'titulo' => 'Bitácora de fotos',
                'descripcion' => 'Bebras toma una caminata todas las mañanas por el bosque y siempre lleva una cámara. Durante la caminata, Bebras escribe una bitácora en donde registra todos los pasos que siguió. Cada fotografía muestra todos los objetos que se pueden ver desde ese lugar en una cuadrícula de 3x3 frente a la cámara.',
                'imagen_descripcion' => 'preguntas/18/bitacora.png',
                'pregunta' => 'Selecciona cuáles fueron las 3 fotografías que sacó Bebras ese día, 
                Cada fotografía muestra todos los objetos que se pueden ver desde ese lugar en una cuadrícula de 3x3 frente a la cámara.
                ',
                'imagen_pregunta' => 'preguntas/18/grid_mundo.png',
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'imagen', 'valor' => 'preguntas/18/foto_a.png'],
                        ['id' => 'B', 'tipo' => 'imagen', 'valor' => 'preguntas/18/foto_b.png'],
                        ['id' => 'C', 'tipo' => 'imagen', 'valor' => 'preguntas/18/foto_c.png'],
                        ['id' => 'D', 'tipo' => 'imagen', 'valor' => 'preguntas/18/foto_d.png'],
                    ],
                    'instruccion' => 'Elige el set de 3 fotos que corresponde a la bitácora'
                ]),
                'respuesta_correcta' => json_encode(['C']),
                'explicacion' => 'La opción C es correcta. Siguiendo los movimientos y rotaciones de la bitácora, podemos determinar qué vería Bebras en cada punto donde tomó fotos.',
                'imagen_respuesta' => 'preguntas/18/respuesta.png',
                'nivel' => 'V',
                'dificultad' => 'Media',
                'pais_origen' => 'Japón',
                'codigo_tarea' => '2023-JP-03b',
            ],

            // PREGUNTA 19 - Caja Fuerte
            [
                'numero' => '19',
                'titulo' => 'Caja Fuerte',
                'descripcion' => 'Bebras tiene que abrir una caja fuerte utilizando la combinación de números correcta. En cada movimiento, Bebras puede rotar la flecha en sentido de las manecillas del reloj ya sea 3 o 4 pasos. La flecha hace que se cambie la luz del número en donde aterriza. Si el número estaba apagado, lo prende. Si estaba prendido, lo apaga.',
                'imagen_descripcion' => 'preguntas/19/caja_fuerte.png',
                'pregunta' => '¿Cuál es el mínimo número de movimientos que debe hacer para lograr prender solamente los números 7 y 8?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'texto_libre',
                'configuracion' => json_encode([
                    'tipo_respuesta' => 'numero',
                    'min' => 1,
                    'max' => 10,
                ]),
                'respuesta_correcta' => json_encode(['4']),
                'explicacion' => 'Se necesitan 4 movimientos: Mover 3 pasos (prende 4), Mover 4 pasos (prende 8), Mover 4 pasos (apaga 4), Mover 3 pasos (prende 7). Solo quedan 7 y 8 encendidos.',
                'imagen_respuesta' => null,
                'nivel' => 'V',
                'dificultad' => 'Alta',
                'pais_origen' => 'Hungría',
                'codigo_tarea' => '2023-HU-05',
            ],

            // PREGUNTA 20 - Mapa en Clave
            [
                'numero' => '20',
                'titulo' => 'Mapa en Clave',
                'descripcion' => 'Castorus encontró dos buenos lugares para esconder su comida. Para recordarlos, quiere marcar los lugares en un mapa con una "X". Para confundir a Biberina, Castorus agrega de forma aleatoria "X"s en otros cuadros del mapa, asegurándose de que el número total de "X"s en cada fila y cada columna sea par. Luego, borra las dos "X"s originales.',
                'imagen_descripcion' => 'preguntas/20/mapa_final.png',
                'pregunta' => '¿Cuáles son los lugares en que Castorus escondió su comida? Marca los cuadros.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'grid_seleccion',
                'configuracion' => json_encode([
                    'filas' => 4,
                    'columnas' => 7,
                    'labels_filas' => ['R1', 'R2', 'R3', 'R4', 'R5', 'R6', 'R7'],
                    'labels_columnas' => ['C1', 'C2', 'C3', 'C4', 'C5', 'C6', 'C7'],
                    'estado_inicial' => [
                        [0, 1, 0, 1, 0, 0, 0],
                        [1, 0, 1, 1, 0, 0, 1],
                        [0, 1, 1, 1, 0, 0, 0],
                        [1, 1, 0, 1, 0, 1, 0],
                        [0, 0, 1, 0, 1, 1, 0],
                        [1, 0, 0, 1, 1, 0, 1],
                        [0, 1, 0, 0, 1, 0, 1],
                    ],
                    'numeros_celdas' => [
                        [1, 2, 3, 4, 5, 6, 7],
                        [8, 9, 10, 11, 12, 13, 14],
                        [15, 16, 17, 18, 19, 20, 21],
                        [22, 23, 24, 25, 26, 27, 28],
                        [29, 30, 31, 32, 33, 34, 35],
                        [36, 37, 38, 39, 40, 41, 42],
                        [43, 44, 45, 46, 47, 48, 49],
                    ]
                ]),
                'respuesta_correcta' => json_encode([
                    ['fila' => 3, 'columna' => 3],
                    ['fila' => 6, 'columna' => 5]
                ]),
                'explicacion' => 'Las casillas correctas son C1-R1 (casilla 1) y C1-R4 (casilla 22). Usando las reglas de paridad, identificamos que solo las filas C y E, y las columnas 3 y 5 tienen cantidad impar de X.',
                'imagen_respuesta' => 'preguntas/20/respuesta.png',
                'nivel' => 'V',
                'dificultad' => 'Alta',
                'pais_origen' => 'Suiza',
                'codigo_tarea' => '2022-CH-08',
            ],

            // PREGUNTA 21 - Hexágonos de Colores
            [
                'numero' => '21',
                'titulo' => 'Hexágonos de Colores',
                'descripcion' => 'Sam tiene un rompecabezas con hexágonos de 3 colores. Para colocar una pieza, debe asegurarse que en el triángulo que se forma cuando coloca esa pieza (con las 2 piezas de abajo), todas sean del mismo color ó que todas sean de colores diferentes.',
                'imagen_descripcion' => 'preguntas/21/regla_hexagonos.png',
                'pregunta' => 'Sam comienza colocando las piezas como se muestran. Colorea los hexágonos vacíos para que sigan la regla hasta terminar el rompecabezas.',
                'imagen_pregunta' => 'preguntas/21/hexagonos_inicial.png',
                'tipo_interaccion' => '',
                'configuracion' => json_encode([
                    'colores_disponibles' => ['verde', 'amarillo', 'azul'],
                    'estructura' => 'piramide',
                    'filas' => 5,
                    'hexagonos_iniciales' => [
                        // Fila inferior (5 hexágonos)
                        ['posicion' => [4, 0], 'color' => 'verde'],
                        ['posicion' => [4, 1], 'color' => 'verde'],
                        ['posicion' => [4, 2], 'color' => 'amarillo'],
                        ['posicion' => [4, 3], 'color' => 'azul'],
                        ['posicion' => [4, 4], 'color' => 'amarillo'],
                    ]
                ]),
                'respuesta_correcta' => json_encode([
                    // Solución completa de la pirámide
                    ['posicion' => [3, 0], 'color' => 'verde'],
                    ['posicion' => [3, 1], 'color' => 'azul'],
                    ['posicion' => [3, 2], 'color' => 'verde'],
                    ['posicion' => [3, 3], 'color' => 'verde'],
                    ['posicion' => [2, 0], 'color' => 'amarillo'],
                    ['posicion' => [2, 1], 'color' => 'amarillo'],
                    ['posicion' => [2, 2], 'color' => 'azul'],
                    ['posicion' => [1, 0], 'color' => 'azul'],
                    ['posicion' => [1, 1], 'color' => 'verde'],
                    ['posicion' => [0, 0], 'color' => 'amarillo'],
                ]),
                'explicacion' => 'Siguiendo el algoritmo: si dos hexágonos adyacentes son del mismo color, el de arriba debe ser del mismo color. Si son diferentes, el de arriba debe ser del tercer color.',
                'imagen_respuesta' => null,
                'nivel' => 'V',
                'dificultad' => 'Alta',
                'pais_origen' => 'Vietnam',
                'codigo_tarea' => '2022-VN-05a',
            ],

            // PREGUNTA 22 - Auto Autónomo
            [
                'numero' => '22',
                'titulo' => 'Auto Autónomo',
                'descripcion' => 'Tim está probando un auto autónomo. Una reciente actualización del software del auto, generó un gran error, que provoca que una vez que realiza un tipo de vuelta por primera vez, al llegar a una intersección, tendrá que hacer ese mismo tipo de vuelta cada vez que llegue a ese mismo tipo de intersección.',
                'imagen_descripcion' => 'preguntas/22/ciudad.png',
                'pregunta' => '¿Cuál será la letra en la que va a terminar Tim al final de su prueba?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'texto', 'valor' => 'Salida A'],
                        ['id' => 'B', 'tipo' => 'texto', 'valor' => 'Salida B'],
                        ['id' => 'C', 'tipo' => 'texto', 'valor' => 'Salida C'],
                        ['id' => 'D', 'tipo' => 'texto', 'valor' => 'Salida D'],
                        ['id' => 'E', 'tipo' => 'texto', 'valor' => 'Salida E'],
                        ['id' => 'F', 'tipo' => 'texto', 'valor' => 'Salida F'],
                    ]
                ]),
                'respuesta_correcta' => json_encode(['F']),
                'explicacion' => 'Siguiendo el patrón del auto: en intersecciones tipo "T" gira a la derecha, en glorietas toma la tercera salida, en cruces sigue recto. Esto lo lleva a la salida F.',
                'imagen_respuesta' => 'preguntas/22/respuesta.png',
                'nivel' => 'V',
                'dificultad' => 'Alta',
                'pais_origen' => 'Estados Unidos',
                'codigo_tarea' => '2023-US-03',
            ],

            // PREGUNTA 23 - Virus de computadora
            [
                'numero' => '23',
                'titulo' => 'Virus de computadora',
                'descripcion' => 'Dos computadoras en una red se infectaron de virus: La computadora A con el Virus Azul y la computadora B con el Virus Rojo. Ambos virus se empiezan a propagar: cada hora, cada computadora que está conectada directamente a una infectada también se va a infectar con el mismo virus. Si una computadora se infecta con ambos virus, entonces se desconecta de la red y ya no seguirá propagando ningún virus.',
                'imagen_descripcion' => 'preguntas/23/red_inicial.png',
                'pregunta' => '¿Cómo quedarán al final cuando la propagación del virus se haya detenido? Marca el estatus final de cada computadora.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_multiple',
                'configuracion' => json_encode([
                    'computadoras' => 12,
                    'opciones_por_computadora' => ['virus_rojo', 'virus_azul', 'desconectada'],
                    'nota' => 'Debes marcar el estado de cada una de las 12 computadoras'
                ]),
                'respuesta_correcta' => json_encode([
                    ['computadora' => 1, 'estado' => 'desconectada'],
                    ['computadora' => 2, 'estado' => 'virus_azul'],
                    ['computadora' => 3, 'estado' => 'desconectada'],
                    ['computadora' => 4, 'estado' => 'virus_rojo'],
                    ['computadora' => 5, 'estado' => 'desconectada'],
                    ['computadora' => 6, 'estado' => 'virus_azul'],
                    ['computadora' => 7, 'estado' => 'desconectada'],
                    ['computadora' => 8, 'estado' => 'virus_rojo'],
                    ['computadora' => 9, 'estado' => 'desconectada'],
                    ['computadora' => 10, 'estado' => 'virus_azul'],
                    ['computadora' => 11, 'estado' => 'virus_rojo'],
                    ['computadora' => 12, 'estado' => 'virus_azul'],
                ]),
                'explicacion' => 'La propagación se detiene cuando las computadoras que se infectan con ambos virus se desconectan, creando barreras en la red que impiden la propagación posterior.',
                'imagen_respuesta' => 'preguntas/23/red_final.png',
                'nivel' => 'VI',
                'dificultad' => 'Alta',
                'pais_origen' => 'Nueva Zelanda',
                'codigo_tarea' => '2022-NZ-01',
            ],

            // PREGUNTA 24 - Collar Marinero
            [
                'numero' => '24',
                'titulo' => 'Collar Marinero',
                'descripcion' => 'Cami está aprendiendo a fabricar collares marineros con dos tipos de cuentas. Todos los collares marineros deben comenzar colocando una cuenta con ondas roja y una azul. Luego, el collar se puede hacer mas largo usando:
- Agregando una cuenta azul a ambos extremos del collar (acción tipo B)
- Agregando dos cuentas de ondas en el extremo de la derecha (acción tipo W)',
                'imagen_descripcion' => 'preguntas/24/reglas_collar.png',
                'pregunta' => '¿Cuál de los siguientes collares NO es un collar marinero?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'imagen', 'valor' => 'preguntas/24/collar_a.png'],
                        ['id' => 'B', 'tipo' => 'imagen', 'valor' => 'preguntas/24/collar_b.png'],
                        ['id' => 'C', 'tipo' => 'imagen', 'valor' => 'preguntas/24/collar_c.png'],
                        ['id' => 'D', 'tipo' => 'imagen', 'valor' => 'preguntas/24/collar_d.png'],
                    ]
                ]),
                'respuesta_correcta' => json_encode(['D']),
                'explicacion' => 'El collar D no es posible. Siempre debe haber un número impar de cuentas azules y un número impar de cuentas con ondas rojas. El collar D tiene 4 de cada tipo, lo cual es par.',
                'imagen_respuesta' => null,
                'nivel' => 'VI',
                'dificultad' => 'Alta',
                'pais_origen' => 'Eslovaquia',
                'codigo_tarea' => '2022-SK-03',
            ],

            // PREGUNTA 25 - Hangar tipo Carusel
            [
                'numero' => '25',
                'titulo' => 'Hangar tipo Carusel',
                'descripcion' => 'En el aeropuerto de Bebraston, hay 6 aviones estacionados en un hangar circular, que gira como un carrusel. El carrusel se puede girar a la izquierda o a la derecha utilizando el panel de control que tiene dos flechas	. Al apretar el botón, el carrusel gira
exactamente un lugar de estacionamiento a la
derecha o izquierda.

La puerta del hangar es suficientemente ancha para que el avión pueda salir por ahí, si es que es su turno de salir. Este carrusel gira muy lento, por lo que se busca siempre girar la menor cantidad de veces para así, evitar retrasos en las salidas de los aviones.
 
En las mañanas, cuando los pilotos llegan a sacar sus aviones, la posición 1 siempre está frente a la puerta.
',
                'imagen_descripcion' => 'preguntas/25/hangar.png',
                'pregunta' => '¿Cuál sería el peor de los casos? Esto es, ¿en qué orden se tendrían que sacar los aviones para que se requiera la mayor cantidad de movimientos? Proporciona un peor caso para que los pilotos puedan sacar todos los aviones de las posiciones 1 a la 6.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'ordenar',
                'configuracion' => json_encode([
                    'elementos' => [
                        ['id' => '1', 'tipo' => 'texto', 'valor' => 'Avión 1'],
                        ['id' => '2', 'tipo' => 'texto', 'valor' => 'Avión 2'],
                        ['id' => '3', 'tipo' => 'texto', 'valor' => 'Avión 3'],
                        ['id' => '4', 'tipo' => 'texto', 'valor' => 'Avión 4'],
                        ['id' => '5', 'tipo' => 'texto', 'valor' => 'Avión 5'],
                        ['id' => '6', 'tipo' => 'texto', 'valor' => 'Avión 6'],
                    ],
                    'instruccion' => 'Ingresa los números en el orden que tendrían que salir',
                    'nota' => 'Hay 2 respuestas correctas posibles'
                ]),
                'respuesta_correcta' => json_encode([
                    ['4', '1', '3', '6', '2', '5'], // Opción 1
                    ['4', '1', '5', '2', '6', '3'], // Opción 2
                ]),
                'explicacion' => 'Hay dos peores casos posibles: 4-1-3-6-2-5 o 4-1-5-2-6-3. En ambos, se requiere el máximo número de movimientos (16 presiones de botón) para sacar todos los aviones.',
                'imagen_respuesta' => null,
                'nivel' => 'VI',
                'dificultad' => 'Alta',
                'pais_origen' => 'Alemania',
                'codigo_tarea' => '2022-DE-05',
            ],

            // PREGUNTA 26 - Tejiendo Alfombras
            [
                'numero' => '26',
                'titulo' => 'Tejiendo Alfombras',
                'descripcion' => 'Hale es una artista de Turquía que fabrica alfombras. Ella quiere hacer una alfombra cuadrada con 6 filas y 6 columnas. Está experimentando en hacer el diseño siguiendo siempre las instrucciones que se muestran en el diagrama de decisiones.',
                'imagen_descripcion' => 'preguntas/26/diagrama_decisiones.png',
                'pregunta' => '¿Cómo quedará la alfombra al final? Dibuja el símbolo que corresponde en cada celda.',
                'imagen_pregunta' => 'preguntas/26/alfombra.png',
                'tipo_interaccion' => '',
                'configuracion' => json_encode([
                    'filas' => 6,
                    'columnas' => 6,
                    'simbolos_disponibles' => ['purple', 'red', 'yellow'],
                    'reglas' => [
                        '¿Fila o columna es 1 o 6? → Morado',
                        '¿Fila = Columna? → Rojo',
                        '¿Fila > Columna? → Amarillo',
                        'De lo contrario → Verde'
                    ]
                ]),
                'respuesta_correcta' => json_encode([
                    // Grid 6x6 con la solución
                    ['M', 'M', 'M', 'M', 'M', 'M'],
                    ['M', 'R', 'V', 'V', 'V', 'M'],
                    ['M', 'A', 'R', 'V', 'V', 'M'],
                    ['M', 'A', 'A', 'R', 'V', 'M'],
                    ['M', 'A', 'A', 'A', 'R', 'M'],
                    ['M', 'M', 'M', 'M', 'M', 'M'],
                ]),
                'explicacion' => 'Siguiendo el árbol de decisiones para cada celda: El borde (fila o columna = 1 o 6) es morado, la diagonal es roja, debajo de la diagonal es amarillo, y arriba es verde.',
                'nivel' => 'VI',
                'dificultad' => 'Alta',
                'pais_origen' => 'Turquía',
                'codigo_tarea' => '2022-TR-02',
            ],

            // PREGUNTA 27 - Película favorita
            [
                'numero' => '27',
                'titulo' => 'Película favorita',
                'descripcion' => 'Un grupo de amigos, quiere ver una película juntos. Cada persona califica las 7 películas posibles con su opinión: Buena, Regular o Mala. Una película es "favorita" si todas las personas le dieron su mejor calificación. Desgraciadamente, en este momento no hay ninguna película favorita. Así que Ada quiere convencer a la menor cantidad de amigos para que cambien su calificación.',
                'imagen_descripcion' => 'preguntas/27/tabla_calificaciones.png',
                'pregunta' => 'Ayuda a Ada a cambiar la menor cantidad posible de calificaciones para lograrlo. Marca las evaluaciones que habría que cambiar.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'grid_seleccion',
                'configuracion' => json_encode([
                    'tipo' => 'tabla_calificaciones',
                    'personas' => ['Nancy', 'Niklaus', 'Grace', 'Eder', 'Rosa'],
                    'peliculas' => ['1', '2', '3', '4', '5', '6', '7'],
                    'calificaciones_iniciales' => [
                        // Nancy
                        ['B', 'B', 'B', 'M', 'M', 'B', 'B'],
                        // Niklaus
                        ['M', 'M', 'M', 'B', 'R', 'R', 'M'],
                        // Grace
                        ['M', 'R', 'R', 'R', 'M', 'B', 'M'],
                        // Eder
                        ['R', 'M', 'M', 'M', 'M', 'B', 'R'],
                        // Rosa
                        ['M', 'M', 'M', 'M', 'B', 'R', 'M'],
                    ],
                    'instruccion' => 'Haz clic en las celdas que deben cambiar'
                ]),
                'respuesta_correcta' => json_encode([
                    ['persona' => 'Niklaus', 'pelicula' => '6', 'cambio' => 'R→B o 4:B→M'],
                    ['persona' => 'Rosa', 'pelicula' => '6', 'cambio' => 'R→B o 5:B→R'],
                ]),
                'explicacion' => 'Es posible lograrlo haciendo solo 2 cambios. La película 6 es la que está más cerca de ser favorita (solo 2 personas no la calificaron como mejor). Niklaus y Rosa deben cambiar sus calificaciones.',
                'imagen_respuesta' => null,
                'nivel' => 'VI',
                'dificultad' => 'Alta',
                'pais_origen' => 'Alemania',
                'codigo_tarea' => '2022-DE-07',
            ],
        ];

        foreach ($preguntas as $pregunta) {
            DB::table('preguntas')->insert($pregunta);
        }
    }
}