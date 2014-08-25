<?php

function get_fecha($new_row_arr)
{
    $fecha = $new_row_arr['Y'] . '-' . $new_row_arr['m'] . '-' . $new_row_arr['d'];
    return($fecha);
}


$boolean_select[''] = '';
$boolean_select['Si'] = 'Si';
$boolean_select['No'] = 'No'; 
$boolean_select['Ni'] = 'Ni (Prueba)'; 

$date_options = array(
    'language'  => 'es',
    'format'    => 'd/M/Y',
);
$date_defaults = array(
    'd' => date('d'),
    'M' => date('M'),
    'Y' => date('Y'),
);
$textarea_options = array(
    'rows' => 16,
    'cols' => 80
);
$textarea_options_mini = array(
    'rows' => 6,
    'cols' => 80
);
$campo_corto = array('size' => 3);
$campo_medio = array('size' => 8);
$campo_largo = array('size' => 80);


$area_select_sql = "select area, area from usuario_area where usuario = '$_SESSION[u]'";
$area_select = $db->getAssoc($area_select_sql, false, null, DB_FETCHMODE_ASSOC);



$form->setRequiredNote('<span style="color:#ff0000;">*</span> = campos requeridos.');

$form->addElement('select', 'new_row[area]', 'Area: ', $area_select);
$form->addElement('date',   'new_row[fecha]',  'Fecha:', $date_options);
$form->addElement('select', 'new_row[publicar]',  'Publicar: ', $boolean_select);
$form->addElement('text',   'new_row[prioridad]',  'Prioridad: ', $campo_corto);
$form->addElement('text',   'new_row[volanta]',  'Volanta: ', $campo_largo);
$form->addElement('text',   'new_row[titulo]',  'Titulo: ', $campo_largo);
$form->addElement('textarea', 'new_row[bajada]',  'Bajada: ', $textarea_options_mini);
$form->addElement('textarea', 'new_row[texto]',  'Texto: ', $textarea_options);
$form->addElement('textarea', 'new_row[nota_interna]',  'Nota interna: ', $textarea_options_mini);
$form->addElement('file', 'imagen1', 'Imagen 1:');
$form->addElement('text',   'new_row[imagen1_epigrafe]',  'Imagen 1 epigrafe: ', $campo_largo);
$form->addElement('file', 'imagen2', 'Imagen 2:');
$form->addElement('text',   'new_row[imagen2_epigrafe]',  'Imagen 2 epigrafe: ', $campo_largo);
$form->addElement('submit', 'btnSubmit', 'Guardar');


$defaults['new_row[fecha]'] = $date_defaults;
$form->setDefaults($defaults); 


