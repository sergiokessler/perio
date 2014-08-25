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
$medio_select['La Naci�n'] = 'La Naci�n';
$medio_select['Clar�n'] = 'Clar�n';
$medio_select['P�gina / 12'] = 'P�gina / 12';
$medio_select['El D�a'] = 'El D�a';
$medio_select['Hoy'] = 'Hoy';
$medio_select['Diagonales'] = 'Diagonales';

$seccion_select[''][''] = '--Seleccione--';
$seccion_select['La Naci�n']['Exterior'] = 'Exterior';
$seccion_select['La Naci�n']['Pol�tica'] = 'Pol�tica';
$seccion_select['La Naci�n']['Ciencia/Salud'] = 'Ciencia/Salud';
$seccion_select['La Naci�n']['Informaci�n General'] = 'Informaci�n General';
$seccion_select['La Naci�n']['Opini�n'] = 'Opini�n';
$seccion_select['La Naci�n']['Carta de Lectores'] = 'Carta de Lectores';
$seccion_select['La Naci�n']['Psicolog�a/Salud'] = 'Psicolog�a/Salud';
$seccion_select['La Naci�n']['Salud/Informaci�n General'] = 'Salud/Informaci�n General';
$seccion_select['La Naci�n']['Informaci�n General/Salud'] = 'Informaci�n General/Salud';

$seccion_select['Clar�n']['El Mundo'] = 'El Mundo';
$seccion_select['Clar�n']['El Pa�s'] = 'El Pa�s';
$seccion_select['Clar�n']['Opini�n'] = 'Opini�n';
$seccion_select['Clar�n']['Sociedad'] = 'Sociedad';
$seccion_select['Clar�n']['Policiales'] = 'Policiales';
$seccion_select['Clar�n']['La Ciudad'] = 'La Ciudad';
$seccion_select['Clar�n']['Deportes'] = 'Deportes';
$seccion_select['Clar�n']['Suplemento Buena Vida'] = 'Suplemento Buena Vida';
$seccion_select['Clar�n']['The New York Time/El Mundo'] = 'The New York Time/El Mundo';
$seccion_select['Clar�n']['The New York/C&T'] = 'The New York/C&T';
$seccion_select['Clar�n']['The New York Time Salud y B'] = 'The New York Time Salud y B';
$seccion_select['Clar�n']['Producci�n Especial'] = 'Producci�n Especial';
$seccion_select['Clar�n']['Suplemento Espect�culos'] = 'Suplemento Espect�culos';
$seccion_select['Clar�n']['Zona'] = 'Zona';
$seccion_select['Clar�n']['Suplemento Mujer'] = 'Suplemento Mujer';
$seccion_select['Clar�n']['Suplemento Econom�a'] = 'Suplemento Econom�a';

$seccion_select['P�gina / 12']['Sociedad'] = 'Sociedad';
$seccion_select['P�gina / 12']['El Pa�s'] = 'El Pa�s';
$seccion_select['P�gina / 12']['El Mundo'] = 'El Mundo';
$seccion_select['P�gina / 12']['Econom�a'] = 'Econom�a';
$seccion_select['P�gina / 12']['La Ventana'] = 'La Ventana';
$seccion_select['P�gina / 12']['Contratapa'] = 'Contratapa';
$seccion_select['P�gina / 12']['Psicolog�a'] = 'Psicolog�a';
$seccion_select['P�gina / 12']['Ciencia'] = 'Ciencia';
$seccion_select['P�gina / 12']['Universidad'] = 'Universidad';
$seccion_select['P�gina / 12']['Suplemento Futuro'] = 'Suplemento Futuro';
$seccion_select['P�gina / 12']['Suplemento LAS 12'] = 'Suplemento LAS 12';
$seccion_select['P�gina / 12']['Suplemento Claves'] = 'Suplemento Claves';
$seccion_select['P�gina / 12']['Suplemento Humor'] = 'Suplemento Humor';

$seccion_select['El D�a']['El Mundo'] = 'El Mundo';
$seccion_select['El D�a']['Pol�tica Provincial y Local'] = 'Pol�tica Provincial y Local';
$seccion_select['El D�a']['Informaci�n General'] = 'Informaci�n General';
$seccion_select['El D�a']['La Ciudad'] = 'La Ciudad';
$seccion_select['El D�a']['El Pa�s'] = 'El Pa�s';
$seccion_select['El D�a']['Opini�n'] = 'Opini�n';
$seccion_select['El D�a']['Sumario y El Mundo'] = 'Sumario y El Mundo';
$seccion_select['El D�a']['Suplemento Salud'] = 'Suplemento Salud';
$seccion_select['El D�a']['Suplemento Espect�culo'] = 'Suplemento Espect�culo';
$seccion_select['El D�a']['Suplemento Especial'] = 'Suplemento Especial';
$seccion_select['El D�a']['Suplemento Est�tica'] = 'Suplemento Est�tica';


$seccion_select['Hoy']['Trama Urbana'] = 'Trama Urbana';
$seccion_select['Hoy']['Revista Tiempos'] = 'Revista Tiempos';
$seccion_select['Hoy']['Suplemento Mujer'] = 'Suplemento Mujer';


$seccion_select['Diagonales']['Sociedad'] = 'Sociedad';
$seccion_select['Diagonales']['Pol�tica/Econom�a'] = 'Pol�tica/Econom�a';
$seccion_select['Diagonales']['P�gina dos'] = 'P�gina dos';
$seccion_select['Diagonales']['Mundo'] = 'Mundo';
$seccion_select['Diagonales']['Espect�culos'] = 'Espect�culos';
$seccion_select['Diagonales']['Cultura'] = 'Cultura';
$seccion_select['Diagonales']['Disparador'] = 'Disparador';
$seccion_select['Diagonales']['Nuestros'] = 'Nuestros';
$seccion_select['Diagonales']['Negocios'] = 'Negocios';
$seccion_select['Diagonales']['Contratapa'] = 'Contratapa';
$seccion_select['Diagonales']['Suplemento Desarrollo Social'] = 'Suplemento Desarrollo Social';

$clasificacion_select[''] = '--Seleccione--';
$clasificacion_select['T�tulo Noticia Principal'] = 'T�tulo Noticia Principal';
$clasificacion_select['T�tulo Secundario'] = 'T�tulo Secundario';


$contenido_select[''] = '--Seleccione--';
$contenido_select['Sistema de salud'] = 'Sistema de salud';
$contenido_select['Investigaci�n en salud/Educaci�n/Capacitaci�n'] = 'Investigaci�n en salud/Educaci�n/Capacitaci�n';
$contenido_select['Enfermedades no Transmisibles'] = 'Enfermedades no Transmisibles';
$contenido_select['Enfermedades gen�ticas/cong�nitas'] = 'Enfermedades gen�ticas/cong�nitas';
$contenido_select['Emergencias y Desastre'] = 'Emergencias y Desastre';
$contenido_select['Discapacidad'] = 'Discapacidad';
$contenido_select['Salud sexual y Reproductiva'] = 'Salud sexual y Reproductiva';
$contenido_select['Tratamientos'] = 'Tratamientos';
$contenido_select['Medicamentos'] = 'Medicamentos';
$contenido_select['Patolog�as emergentes en Argentina'] = 'Patolog�as emergentes en Argentina';
$contenido_select['Salud Materno-Infantil'] = 'Salud Materno-Infantil';
$contenido_select['Comportamiento/H�bito/Estilo de vida'] = 'Comportamiento/H�bito/Estilo de vida';
$contenido_select['Vejez/Problemas Vinculados'] = 'Vejez/Problemas Vinculados';
$contenido_select['Legislaci�n de temas de salud'] = 'Legislaci�n de temas de salud';

$fuente_select[''] = '--Seleccione--';
$fuente_select['FA'] = 'FA';
$fuente_select['FNA'] = 'FNA';
$fuente_select['FT'] = 'FT';
$fuente_select['SF'] = 'SF';




