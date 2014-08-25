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

$boolean_select[''] = '';
$boolean_select['S'] = 'Si';
$boolean_select['N'] = 'No'; 

$sexo_select[''] = '';
$sexo_select['M'] = 'Masculino';
$sexo_select['F'] = 'Femenino'; 

$estado_civil_select['Soltero'] = 'Soltero';
$estado_civil_select['Casado'] = 'Casado';
$estado_civil_select['Viudo'] = 'Viudo';
$estado_civil_select['Separado'] = 'Separado';
$estado_civil_select['Divorciado'] = 'Divorciado';


$form->addElement('text',   'new_row[doc_nro]', 'Doc Nro:');
$form->addElement('text',   'new_row[cuil]', 'CUIL:');
$form->addElement('text',   'new_row[apellido_nombres]', 'Apellido, nombres:', $campo_largo);
$form->addElement('date',   'new_row[fecha_nac]', 'Fecha Nac:');
$form->addElement('select', 'new_row[estado_civil]', 'Estado Civil:', $estado_civil_select);
$form->addElement('text',   'new_row[direccion]', 'Direccion:', $campo_largo);
$form->addElement('text',   'new_row[telefono]', 'Telefono:');
$form->addElement('select', 'new_row[sexo]', 'Sexo:', $sexo_select);
$form->addElement('text',   'new_row[obra_social]', 'Obra social:', $campo_largo);
$form->addElement('select', 'new_row[res523_89]', 'res523_89:', $boolean_select);
$form->addElement('text',   'new_row[titulo]', 'Titulo:', $campo_largo);
$form->addElement('textarea',   'new_row[fam_cargo]', 'Familiares a cargo:');
$form->addElement('textarea',   'new_row[notas]', 'Notas:', $textarea_options);


$form->setRequiredNote('<span style="color:#ff0000;">*</span> = campos requeridos.');
$form->addRule('new_row[doc_nro]', 'Valor requerido', 'required'); 
$form->addRule('new_row[apellido_nombres]', 'Valor requerido', 'required'); 
$form->addRule('new_row[sexo]', 'Valor requerido', 'required'); 


// defaults del form

/*
$form->setDefaults(array(
    'agenda_fecha_hora' => $date_defaults,
));
*/

// defaults



