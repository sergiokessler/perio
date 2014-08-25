<?php

/*

$Id: premio_insert.php,v 1.4 2007/10/17 18:01:25 develop Exp $

*/



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



$form->addElement('text',   'new_row[expte]', 'Expediente:'); 
$form->addElement('date',   'new_row[fecha_entrada]', 'Fecha de entrada:'); 
$form->addElement('text',   'new_row[nro_resolucion]', 'nro_resolucion:'); 
$form->addElement('text',   'new_row[universidad]', 'universidad:'); 
$form->addElement('text',   'new_row[causante]', 'causante:'); 
$form->addElement('textarea',   'new_row[tema]', 'Tema:', $textarea_options); 




// defaults del form

/*
$form->setDefaults(array(
    'agenda_fecha_hora' => $date_defaults,
));
*/

// defaults



