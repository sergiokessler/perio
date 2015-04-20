<?php
// vim: set fileencoding=utf8 :

$date_options = array(
    'language'  => 'es',
    'format'    => 'dMY',
    'minYear'   => 2007,
    'maxYear'   => date('Y') + 2, 
);

$textarea_options = array(
    'rows' => 8,
);

$campo_corto = array('style' => 'width: 10em;');
$campo_medio = array('style' => 'width: 20em;');
$campo_largo = array('style' => 'width: 40em;');

$null_select[''] = '--seleccione--';

$boolean_select[''] = '--seleccione--';
$boolean_select['SI'] = 'SI';
$boolean_select['NO'] = 'NO';

$clave_select[''] = '--Seleccione--';
$clave_select['Sección'] = 'Sección';
$clave_select['Tipo de nota'] = 'Tipo de nota';
//$clave_select['Juventud Tema'] = 'Juventud Tema';
$clave_select['Juventud Motivo 1'] = 'Juventud Motivo 1';
$clave_select['Juventud Motivo 2'] = 'Juventud Motivo 2';
//$clave_select['Seguridad Tema'] = 'Seguridad Tema';
$clave_select['Seguridad Motivo 1'] = 'Seguridad Motivo 1';
$clave_select['Voces'] = 'Voces';
$clave_select['Territorios'] = 'Territorios';



$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 


$form_params = params_encode($params);

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
    $form->addElement('text', $params['table'], array('disabled' => 'disabled'), array('label' => 'Tabulado Id'))
         ->setValue($record_id);
}      
$form->addElement('select', 'new_row[clave]', array('autofocus' => 'autofocus'))
     ->setLabel('Clave:')
     ->loadOptions($clave_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('text', 'new_row[valor]')
     ->setLabel('Valor:')
     ->addRule('required', 'Valor requerido')
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


