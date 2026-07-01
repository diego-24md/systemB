<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AlumnasSeeder extends Seeder
{
    /**
     * Devuelve un valor de $pool, garantizando que ningún elemento se use
     * más de $maxRepeticiones veces en total (controlado por $usos).
     */
    private function pickLimited(array $pool, array &$usos, int $maxRepeticiones): string
    {
        // Baraja los índices para no recorrer siempre en el mismo orden
        $indices = array_keys($pool);
        shuffle($indices);

        foreach ($indices as $idx) {
            $valor = $pool[$idx];
            if (($usos[$valor] ?? 0) < $maxRepeticiones) {
                $usos[$valor] = ($usos[$valor] ?? 0) + 1;
                return $valor;
            }
        }

        // Si TODOS llegaron al límite (no debería pasar si el pool es suficientemente grande),
        // se reinicia el conteo y se elige de nuevo para no romper la ejecución.
        $usos = [];
        $valor = $pool[array_rand($pool)];
        $usos[$valor] = 1;
        return $valor;
    }

    public function run()
    {
        $apellidos = [
            'APAZA', 'CASTILLO', 'CCALLO', 'CCAMA', 'CCORI', 'FLORES', 'GARCIA', 'HUAMANI',
            'HUANCA', 'HUARI', 'INCA', 'LEON', 'MAMANI', 'MENDOZA', 'PALOMINO', 'PAREDES',
            'PAUCAR', 'PIZARRO', 'PUMACAHUA', 'QUISPE', 'RAMIREZ', 'RAMOS', 'RIVERA', 'ROJAS',
            'SALAS', 'SALINAS', 'SANCHEZ', 'TAIPE', 'TORRES', 'VALDIVIA', 'VARGAS', 'VEGA',
            'VILCA', 'ZARATE', 'ZEVALLOS',
            'ALIAGA', 'ALVARADO', 'ANAYA', 'ASTO', 'AYALA', 'BENDEZU', 'BAUTISTA', 'CACERES',
            'CARBAJAL', 'CARDENAS', 'CHAVEZ', 'CONDORI', 'CORDOVA', 'CRUZ', 'CUYUBAMBA',
            'DELGADO', 'DIAZ', 'ESPINO', 'ESPINOZA', 'FERNANDEZ', 'GOMEZ', 'GONZALES',
            'GUERRERO', 'GUTIERREZ', 'GUZMAN', 'HERRERA', 'HUAMAN', 'HUAMANCHUMO', 'HUARCAYA',
            'JIMENEZ', 'LAURA', 'LOPEZ', 'LOZANO', 'LUJAN', 'MACHACA', 'MALDONADO', 'MARTINEZ',
            'MEDINA', 'MEZA', 'MOLINA', 'MONTES', 'MORALES', 'MUNOZ', 'NAVARRO', 'OCHOA',
            'ORTEGA', 'ORTIZ', 'PACHECO', 'PACSI', 'PALACIOS', 'PARIONA', 'PEÑA', 'PEREZ',
            'PONCE', 'PUMA', 'QUEA', 'QUINTANA', 'REYES', 'RIOS', 'RIVAS', 'RODRIGUEZ',
            'ROMERO', 'ROSALES', 'RUIZ', 'SAAVEDRA', 'SALAZAR', 'SALVATIERRA', 'SANTOS',
            'SEGURA', 'SILVA', 'SOTO', 'SUAREZ', 'TICONA', 'TITO', 'TRUJILLO', 'VALDEZ',
            'VALENCIA', 'VALVERDE', 'VASQUEZ', 'VELASQUEZ', 'VELIZ', 'VENTURA', 'VERA',
            'VILLANUEVA', 'VILLEGAS', 'YAURI', 'YUPANQUI', 'ZAMBRANO', 'ZAPATA', 'ZUÑIGA',
            'ACOSTA', 'AGUILAR', 'AGUIRRE', 'ALARCON', 'ALEGRE', 'ALTAMIRANO', 'AMES', 'ANGULO',
            'ARANDA', 'ARAUJO', 'ARCE', 'ARIAS', 'ARROYO', 'BARRIOS', 'BAZAN', 'BECERRA',
            'BENITES', 'BERNAL', 'BLAS', 'BRAVO', 'BRICEÑO', 'BUENO', 'CABALLERO', 'CABRERA',
            'CALDERON', 'CAMPOS', 'CANO', 'CARBAJO', 'CARRASCO', 'CARRILLO', 'CASTAÑEDA',
            'CENTENO', 'CHACON', 'CHAVARRIA', 'CHIRINOS', 'CHUQUILLANQUI', 'COAQUIRA', 'COLLAZOS',
            'CONTRERAS', 'CORONADO', 'CUEVA', 'DAVILA', 'DE LA CRUZ', 'DEL AGUILA', 'DURAND',
            'ESCOBAR', 'ESQUIVEL', 'FALCON', 'FARFAN', 'FIGUEROA', 'FLOREZ', 'FRANCO', 'GALINDO',
            'GALLARDO', 'GAMARRA', 'GIL', 'GONZALEZ', 'GRANADOS', 'GUEVARA', 'HINOJOSA', 'HUAMANTUMA',
            'HUANCAS', 'IPARRAGUIRRE', 'JAIMES', 'JARA', 'LARA', 'LAZO', 'LINARES', 'LLANOS',
            'LOAYZA', 'MARIN', 'MEZONES', 'MOGOLLON', 'MONTOYA', 'MOSCOSO', 'MOSTACERO', 'NAVARRETE',
            'NOA', 'NOLASCO', 'OLIVERA', 'OLIVOS', 'ORELLANA', 'OSORIO', 'PACHAS', 'PADILLA',
            'PALMA', 'PANTOJA', 'PAREJA', 'PASTOR', 'PEÑALOZA', 'PINEDA', 'PORTILLO', 'PRADO',
            'QUEZADA', 'QUIROZ', 'RETAMOZO', 'REYNOSO', 'RIVERO', 'ROBLES', 'ROSAS', 'RUELAS',
            'SAENZ', 'SALDAÑA', 'SANDOVAL', 'SARMIENTO', 'SERNA', 'SOLIS', 'SOSA', 'TAFUR',
            'TAPIA', 'TELLO', 'TORIBIO', 'TRIVEÑO', 'URIBE', 'VALLEJOS', 'VILLAR', 'ZAVALETA',
        ];

        $nombresF = [
            'GENESIS MIRIAM', 'DIANA LUCIA', 'ROSA ELENA', 'KARINA ISABEL', 'NELLY MARIBEL',
            'KAREN PAOLA', 'LUCIA ESPERANZA', 'MARIA FERNANDA', 'ANA SOFIA', 'ROSA ANDREA',
            'PATRICIA ELENA', 'VALERIA NICOL', 'JANET MILAGROS', 'CARMEN ROSA', 'JESSICA PAOLA',
            'ELIZABETH ANA', 'CYNTHIA BELEN', 'MARLENI SUSAN', 'WENDY ESTHER', 'FIORELA MILAGROS',
            'STEFANY BELEN', 'INGRID SOFIA', 'FIORELLA ISABEL', 'LESLY YANETH', 'SHEYLA MILAGROS',
            'BRENDA KARINA', 'RUTH ESTHER', 'XIOMARA STEFANY', 'PATRICIA SOLEDAD', 'MELISSA JHOANA',
            'YULEISY BRIGITTE', 'ANGIE ROSMERY', 'DAYANA LUCERO', 'NICOLE ALEXANDRA', 'KIMBERLY NOEMI',
            'ROSSMERY ANDREA', 'LEYDI CAROLINA', 'FIORELLA NICOL', 'MARIA BELEN', 'KATHERINE YOSELIN',
            'ESTEFANY MILAGROS', 'ALEXANDRA NICOLE', 'ANGELA LUCERO', 'ANTONELLA VALERIA',
            'ARIANA SOFIA', 'BEATRIZ ELENA', 'CAMILA FERNANDA', 'CARLA MISHELL', 'CLAUDIA PATRICIA',
            'DANIELA ALEXANDRA', 'DAYSI KATHERINE', 'DIANA CAROLINA', 'ESTHER MILAGROS',
            'EVELYN NICOLE', 'FLOR DE MARIA', 'GABRIELA ISABEL', 'GERALDINE PAOLA', 'GRECIA NICOL',
            'HEIDY MARIBEL', 'IRIS ANGELICA', 'ITALO ROSA', 'JACKELINE ROSMERY', 'JHOANA LIZBETH',
            'JULISSA ESTEFANY', 'KAROL ANDREA', 'KATIA VANESSA', 'LADY DIANA', 'LIZBETH NOEMI',
            'LUZ MARINA', 'MARIA ALEJANDRA', 'MARIA JOSE', 'MARJORIE LUCIA', 'MAYRA ALEJANDRA',
            'MELANY ROSMERY', 'MICHELLE ANDREA', 'MILAGROS ESPERANZA', 'MIRELLA CAROLINA',
            'NAYELI FERNANDA', 'NOEMI ALEXANDRA', 'PAMELA ANDREA', 'PIERINA MILAGROS',
            'PRISCILA NICOLE', 'RAQUEL ESPERANZA', 'REBECA MILAGROS', 'RENATA VALENTINA',
            'ROSMERY KATHERINE', 'SANDRA MILAGROS', 'SHIRLEY ANDREA', 'SOLEDAD ESPERANZA',
            'TATIANA BELEN', 'VALENTINA SOFIA', 'VANESSA MICHELLE', 'YAJAIRA NICOLE',
            'YESENIA CAROLINA', 'ZOILA ESPERANZA',
        ];

        $secciones = ['A', 'B', 'C', 'D'];
        $data      = [];
        $usosApellidos = [];
        $usosNombres   = [];
        $dnisUsados    = [];

        for ($grado = 1; $grado <= 5; $grado++) {
            $turno = ($grado <= 3) ? 'manana' : 'tarde';

            foreach ($secciones as $secIndex => $letra) {
                $seccionId = ($grado - 1) * 4 + ($secIndex + 1);

                for ($i = 0; $i < 25; $i++) {
                    $apellido1 = $this->pickLimited($apellidos, $usosApellidos, 6);
                    do {
                        $apellido2 = $this->pickLimited($apellidos, $usosApellidos, 6);
                    } while ($apellido2 === $apellido1);

                    $nombre = $this->pickLimited($nombresF, $usosNombres, 6);

                    // DNI aleatorio de 8 dígitos (rango realista de DNIs peruanos), sin repetir
                    do {
                        $dni = (string) random_int(60000000, 79999999);
                    } while (isset($dnisUsados[$dni]));
                    $dnisUsados[$dni] = true;

                    $data[] = [
                        'nombre'     => "{$apellido1} {$apellido2}, {$nombre}",
                        'dni'        => $dni,
                        'grado_id'   => $grado,
                        'seccion_id' => $seccionId,
                        'turno'      => $turno,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];

                    // Insertar en lotes de 100 para no saturar la query
                    if (count($data) === 100) {
                        $this->db->table('alumnas')->insertBatch($data);
                        $data = [];
                    }
                }
            }
        }

        if (! empty($data)) {
            $this->db->table('alumnas')->insertBatch($data);
        }
    }
}