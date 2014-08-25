<?php

/*

$Id: premio_insert.php,v 1.4 2007/10/17 18:01:25 develop Exp $

*/



$date_options = array(
    'language'  => 'es',
    'format'    => 'dMY',
    'minYear'   => 2007,
    'maxYear'   => date('Y') + 2, 
);
$date_defaults = array(
    'd' => date('d'),
    'M' => date('m'),
    'Y' => date('Y'),
);

$textarea_options = array(
    'rows' => 8,
    'cols' => 32
);
$campo_corto = array('size' => 3);
$campo_medio = array('size' => 8);
$campo_largo = array('size' => 64);

$null_select[''] = '--seleccione--';

$boolean_select[''] = '--seleccione--';
$boolean_select['SI'] = 'SI';
$boolean_select['NO'] = 'NO';

$medio_select[''] = '--Seleccione--';
$medio_select['La Nación'] = 'La Nación';
$medio_select['Clarín'] = 'Clarín';
$medio_select['Página / 12'] = 'Página / 12';
$medio_select['El Día'] = 'El Día';
$medio_select['Hoy'] = 'Hoy';
$medio_select['Diagonales'] = 'Diagonales';

$seccion_select[''][''] = '--Seleccione--';
$seccion_select['La Nación']['Exterior'] = 'Exterior';
$seccion_select['La Nación']['Política'] = 'Política';
$seccion_select['La Nación']['Ciencia/Salud'] = 'Ciencia/Salud';
$seccion_select['La Nación']['Información General'] = 'Información General';
$seccion_select['La Nación']['Opinión'] = 'Opinión';
$seccion_select['La Nación']['Carta de Lectores'] = 'Carta de Lectores';
$seccion_select['La Nación']['Psicología/Salud'] = 'Psicología/Salud';
$seccion_select['La Nación']['Salud/Información General'] = 'Salud/Información General';
$seccion_select['La Nación']['Información General/Salud'] = 'Información General/Salud';

$seccion_select['Clarín']['El Mundo'] = 'El Mundo';
$seccion_select['Clarín']['El País'] = 'El País';
$seccion_select['Clarín']['Opinión'] = 'Opinión';
$seccion_select['Clarín']['Sociedad'] = 'Sociedad';
$seccion_select['Clarín']['Policiales'] = 'Policiales';
$seccion_select['Clarín']['La Ciudad'] = 'La Ciudad';
$seccion_select['Clarín']['Deportes'] = 'Deportes';
$seccion_select['Clarín']['Suplemento Buena Vida'] = 'Suplemento Buena Vida';
$seccion_select['Clarín']['The New York Time/El Mundo'] = 'The New York Time/El Mundo';
$seccion_select['Clarín']['The New York/C&T'] = 'The New York/C&T';
$seccion_select['Clarín']['The New York Time Salud y B'] = 'The New York Time Salud y B';
$seccion_select['Clarín']['Producción Especial'] = 'Producción Especial';
$seccion_select['Clarín']['Suplemento Espectáculos'] = 'Suplemento Espectáculos';
$seccion_select['Clarín']['Zona'] = 'Zona';
$seccion_select['Clarín']['Suplemento Mujer'] = 'Suplemento Mujer';
$seccion_select['Clarín']['Suplemento Economía'] = 'Suplemento Economía';

$seccion_select['Página / 12']['Sociedad'] = 'Sociedad';
$seccion_select['Página / 12']['El País'] = 'El País';
$seccion_select['Página / 12']['El Mundo'] = 'El Mundo';
$seccion_select['Página / 12']['Economía'] = 'Economía';
$seccion_select['Página / 12']['La Ventana'] = 'La Ventana';
$seccion_select['Página / 12']['Contratapa'] = 'Contratapa';
$seccion_select['Página / 12']['Psicología'] = 'Psicología';
$seccion_select['Página / 12']['Ciencia'] = 'Ciencia';
$seccion_select['Página / 12']['Universidad'] = 'Universidad';
$seccion_select['Página / 12']['Suplemento Futuro'] = 'Suplemento Futuro';
$seccion_select['Página / 12']['Suplemento LAS 12'] = 'Suplemento LAS 12';
$seccion_select['Página / 12']['Suplemento Claves'] = 'Suplemento Claves';
$seccion_select['Página / 12']['Suplemento Humor'] = 'Suplemento Humor';

$seccion_select['El Día']['El Mundo'] = 'El Mundo';
$seccion_select['El Día']['Política Provincial y Local'] = 'Política Provincial y Local';
$seccion_select['El Día']['Información General'] = 'Información General';
$seccion_select['El Día']['La Ciudad'] = 'La Ciudad';
$seccion_select['El Día']['El País'] = 'El País';
$seccion_select['El Día']['Opinión'] = 'Opinión';
$seccion_select['El Día']['Sumario y El Mundo'] = 'Sumario y El Mundo';
$seccion_select['El Día']['Suplemento Salud'] = 'Suplemento Salud';
$seccion_select['El Día']['Suplemento Espectáculo'] = 'Suplemento Espectáculo';
$seccion_select['El Día']['Suplemento Especial'] = 'Suplemento Especial';
$seccion_select['El Día']['Suplemento Estética'] = 'Suplemento Estética';


$seccion_select['Hoy']['Trama Urbana'] = 'Trama Urbana';
$seccion_select['Hoy']['Revista Tiempos'] = 'Revista Tiempos';
$seccion_select['Hoy']['Suplemento Mujer'] = 'Suplemento Mujer';


$seccion_select['Diagonales']['Sociedad'] = 'Sociedad';
$seccion_select['Diagonales']['Política/Economía'] = 'Política/Economía';
$seccion_select['Diagonales']['Página dos'] = 'Página dos';
$seccion_select['Diagonales']['Mundo'] = 'Mundo';
$seccion_select['Diagonales']['Espectáculos'] = 'Espectáculos';
$seccion_select['Diagonales']['Cultura'] = 'Cultura';
$seccion_select['Diagonales']['Disparador'] = 'Disparador';
$seccion_select['Diagonales']['Nuestros'] = 'Nuestros';
$seccion_select['Diagonales']['Negocios'] = 'Negocios';
$seccion_select['Diagonales']['Contratapa'] = 'Contratapa';
$seccion_select['Diagonales']['Suplemento Desarrollo Social'] = 'Suplemento Desarrollo Social';

$clasificacion_select[''] = '--Seleccione--';
$clasificacion_select['Título Noticia Principal'] = 'Título Noticia Principal';
$clasificacion_select['Título Secundario'] = 'Título Secundario';


$contenido_select[''] = '--Seleccione--';
$contenido_select['Sistema de salud'] = 'Sistema de salud';
$contenido_select['Investigación en salud/Educación/Capacitación'] = 'Investigación en salud/Educación/Capacitación';
$contenido_select['Enfermedades no Transmisibles'] = 'Enfermedades no Transmisibles';
$contenido_select['Enfermedades genéticas/congénitas'] = 'Enfermedades genéticas/congénitas';
$contenido_select['Emergencias y Desastre'] = 'Emergencias y Desastre';
$contenido_select['Discapacidad'] = 'Discapacidad';
$contenido_select['Salud sexual y Reproductiva'] = 'Salud sexual y Reproductiva';
$contenido_select['Tratamientos'] = 'Tratamientos';
$contenido_select['Medicamentos'] = 'Medicamentos';
$contenido_select['Patologías emergentes en Argentina'] = 'Patologías emergentes en Argentina';
$contenido_select['Salud Materno-Infantil'] = 'Salud Materno-Infantil';
$contenido_select['Comportamiento/Hábito/Estilo de vida'] = 'Comportamiento/Hábito/Estilo de vida';
$contenido_select['Vejez/Problemas Vinculados'] = 'Vejez/Problemas Vinculados';
$contenido_select['Legislación de temas de salud'] = 'Legislación de temas de salud';

$fuente_select[''] = '--Seleccione--';
$fuente_select['FA'] = 'FA';
$fuente_select['FNA'] = 'FNA';
$fuente_select['FT'] = 'FT';
$fuente_select['SF'] = 'SF';




