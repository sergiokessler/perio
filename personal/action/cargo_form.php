<?php

/*

$Id: premio_insert.php,v 1.4 2007/10/17 18:01:25 develop Exp $

*/



$date_defaults = array(
    'd' => date('d'),
    'M' => date('m'),
    'Y' => date('Y'),
);

$date_options = array(
    'language'  => 'es',
    'format'    => 'dMY',
); 

$date_options2 = array(
    'language'  => 'es',
    'format'    => 'dMY',
    'addEmptyOption'   => true, 
); 

$textarea_options = array(
    'rows' => 8,
    'cols' => 32
);
$campo_corto = array('size' => 3);
$campo_medio = array('size' => 8);
$campo_largo = array('size' => 64);

$null_select[''] = '--seleccione--'; 

$boolean_select[''] = '';
$boolean_select['S'] = 'Si';
$boolean_select['N'] = 'No'; 

$materia_id_select = $null_select + $db->getAssoc("select mat_codigo, mat_nombre from materia order by 2");

$cargo_select[''] = '--Seleccione--';
$cargo_select['Prof. Titular'] = 'Prof. Titular';
$cargo_select['Prof. Adjunto'] = 'Prof. Adjunto';
$cargo_select['JTP'] = 'JTP';
$cargo_select['Ayte. Diplomado'] = 'Ayte. Diplomado';
$cargo_select['Ayte. Alumno'] = 'Ayte. Alumno';
$cargo_select['Decano'] = 'Decano';
$cargo_select['Secretario'] = 'Secretario';
$cargo_select['No Docente'] = 'No Docente';
$cargo_select['Contratado'] = 'Contratado';

$licencia_select['Ninguna'] = 'Ninguna';
$licencia_select['C/Sueldo'] = 'C/Sueldo';
$licencia_select['S/Sueldo'] = 'S/Sueldo';

$dedicacion_select[''] = '--Seleccione--';
$dedicacion_select['Simple'] = 'Simple';
$dedicacion_select['Semi-Excl'] = 'Semi-Excl';
$dedicacion_select['Exclusiva'] = 'Exclusiva';
$dedicacion_select['Ad-Honorem'] = 'Ad-Honorem';

$extension_select['Ninguna'] = 'Ninguna';
$extension_select['Exclusiva'] = 'Exclusiva';
$extension_select['Ad-Honorem'] = 'Ad-Honorem';

$caracter_select['Ordinario'] = 'Ordinario';
$caracter_select['Interino'] = 'Interino';



$form->addElement('text',   'new_row[legajo]', 'Legajo:');
$form->addElement('text',   'new_row[expediente]', 'Expediente:');
$form->addElement('text',   'new_row[resolucion]', 'Resolución:');
//$form->addElement('text',   'new_row[doc_nro]', 'Doc Nro:');
$form->addElement('select', 'new_row[cargo]', 'Cargo:', $cargo_select);
$form->addElement('select', 'new_row[dedicacion]', 'Dedicación:', $dedicacion_select);
$form->addElement('select', 'new_row[extension]', 'Extensión:', $extension_select);
$form->addElement('select', 'new_row[caracter]', 'Caracter:', $caracter_select);
$form->addElement('select', 'new_row[mat_codigo]', 'Materia:', $materia_id_select);
$form->addElement('date',   'new_row[fecha_alta]', 'Fecha de alta:', $date_options);
$form->addElement('date',   'new_row[fecha_baja]', 'Fecha de baja:', $date_options2);
$form->addElement('select', 'new_row[vigente]', 'Vigente:', $boolean_select);
$form->addElement('select', 'new_row[licencia]', 'Licencia:', $licencia_select);
$form->addElement('date',   'new_row[licencia_desde]', 'Licencia desde:', $date_options2);
$form->addElement('date',   'new_row[licencia_hasta]', 'Licencia hasta:', $date_options2);
$form->addElement('textarea',   'new_row[notas]', 'Notas:', $textarea_options);


$form->setRequiredNote('<span style="color:#ff0000;">*</span> = campos requeridos.');
$form->addRule('new_row[legajo]', 'Valor requerido', 'required');  
$form->addRule('new_row[expediente]', 'Valor requerido', 'required');  
$form->addRule('new_row[cargo]', 'Valor requerido', 'required');  
$form->addRule('new_row[dedicacion]', 'Valor requerido', 'required');  
$form->addRule('new_row[extension]', 'Valor requerido', 'required');  
$form->addRule('new_row[caracter]', 'Valor requerido', 'required');  
$form->addRule('new_row[mat_codigo]', 'Valor requerido', 'required');  
$form->addRule('new_row[fecha_alta]', 'Valor requerido', 'required');  




// defaults del form

$form->setDefaults(array(
    'new_row[fecha_alta]' => $date_defaults,
));


// defaults



