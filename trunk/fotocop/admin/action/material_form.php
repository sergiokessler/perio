<?php

require_once 'HTML/QuickForm2.php'; 
require_once 'share/form_common.php';

$form_params = params_encode($params);

/*
$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$materia_select = array('' => '-- Select --');
$sql_sel = "select materia_id, nombre from materia order by nombre";
$st = $db->query($sql_sel);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $materia_select[$row['nombre']] = $row['nombre'];
}
*/

$materia_select = $boolean_select;

$form_update = false;
if (isset($record_id))
    $form_update = true; 

$form = new HTML_QuickForm2('form', 'post');

if ($form_update and empty($_POST))
{
    $st = $db->prepare('select * from ' . $params['table'] . ' where ' . $params['primary_key'] . ' = ?'); 
    $st->execute(array($record_id));
    $edit_row = $st->fetch(PDO::FETCH_ASSOC);

    $defaults['new_row'] = $edit_row;

    $form->addDataSource(new HTML_QuickForm2_DataSource_Array(
        $defaults
    ));
}
else
{
    // defaults
    $form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
        'new_row' => array('fecha' => time()),
    )));
} 

$form->addElement('hidden', 'action')
     ->setValue($params['action'])
     ;
$form->addElement('hidden', 'params')
     ->setValue($form_params)
     ;
if ($form_update) {
    $form->addElement('text', 'material_id', array('disabled' => 'disabled'), array('label' => 'Material Id'))
         ->setValue($record_id);
}      

$form->addElement('select', 'new_row[materia]', array('autofocus' => 'autofocus'))
     ->setLabel(' Materia:')
     ->loadOptions($materia_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('text', 'new_row[titulo]')
     ->setLabel('Titulo:')
     ->addRule('required', 'Valor requerido')
    ;
$form->addElement('text', 'new_row[autor]')
     ->setLabel('Autor:')
     ->addRule('required', 'Valor requerido')
    ;
$form->addElement('text', 'new_row[cant_hojas]')
     ->setLabel('Cant de hojas:')
     ->addRule('required', 'Valor requerido')
    ;
$form->addElement('text', 'new_row[carpeta]')
     ->setLabel('Carpeta:')
     ->addRule('required', 'Valor requerido')
    ;
$form->addElement('text', 'new_row[folio]')
     ->setLabel('Folio:')
     ->addRule('required', 'Valor requerido')
    ;
$form->addElement('text', 'new_row[costo]')
     ->setLabel('Costo:')
     ->addRule('required', 'Valor requerido')
    ;
$form->addElement('file', 'file')
     ->setLabel('Archivo PDF:')
     ->addRule('mimetype', 'Valor requerido', 'application/pdf')
    ;


    
$form->addElement('button', 'btnSubmit', array('type' => 'submit', 'value' => 'Guardar', 'class' => 'btn btn-primary'))
     ->setContent('Guardar')
     ;


// renderer fixes


require_once 'HTML/QuickForm2/Renderer.php';
require_once 'HTML/QuickForm2/JavascriptBuilder.php';
$renderer = HTML_QuickForm2_Renderer::factory('callback');
$renderer->setJavascriptBuilder(new HTML_QuickForm2_JavascriptBuilder(null, __DIR__ . '/../share/pear/data/HTML_QuickForm2/js'));



$renderer->setOption(array(
    'errors_prefix' => 'El formulario contiene errores:',
    'required_note' => '<span class="required">*</span> denota campos requeridos',
));


