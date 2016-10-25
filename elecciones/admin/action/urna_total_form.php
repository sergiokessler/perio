<?php

# vim: set fileencoding=ISO-8859-1

require_once 'lib/pear/HTML/QuickForm2.php'; 


$date_options = array(
    'language'  => 'es',
    'format'    => 'dMY',
    'minYear'   => date('Y') - 2,
    'maxYear'   => date('Y') + 2,
);

$datebirth_options = array(
    'language'  => 'es',
    'format'    => 'dMY',
    'minYear'   => date('Y') - 99,
    'maxYear'   => date('Y'),
    'addEmptyOption' => true
);

$datetime_options = array(
    'language'  => 'es',
    'format'    => 'dMY H:i',
    'minYear'   => date('Y') - 2,
    'maxYear'   => date('Y') + 2,
);

$textarea_options = array(
    'rows' => 8,
    'maxlength' => 300
);
$submit_options = array (
    'class' => 'btn btn-primary',
);
$campo_corto = array('class' => 'col-sm-3');
$campo_medio = array('class' => 'col-xs-6');
$campo_largo = array('class' => 'col-xs-9');

$null_select[''] = '--seleccione--';

$boolean_select[''] = '--seleccione--';
$boolean_select['SI'] = 'SI';
$boolean_select['NO'] = 'NO';

$boolean2_select[''] = '--seleccione--';
$boolean2_select['1'] = 'SI';
$boolean2_select['0'] = 'NO';


$name_pattern = "[a-zA-Z0-9ñÑáéíóúü\-_çÇ&,.' ]+";


$lista_select = array('' => '-- Seleccione --');
$lista_select_sql = 'select lista_id, lista_nombre from lista order by lista_nombre';
$lista_select_sql_data = array();
$st = $db->prepare($lista_select_sql);
$st->execute($lista_select_sql_data);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $lista_select[$row['k']] = $row['v'];
}

$urna_select = array('' => '-- seleccione --');
$urna_select_sql = 'select urna_id, urna_nombre from urna order by urna_nombre';
$urna_select_sql_data = array();
$st = $db->prepare($urna_select_sql);
$st->execute($urna_select_sql_data);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $urna_select[$row['k']] = $row['v'];
}


$form_params = params_encode($params);

$form_update = false;
if (isset($record_id))
    $form_update = true;

$form = new HTML_QuickForm2('form', 'post', array('role' => 'form'));

if ($form_update and empty($_POST))
{
    $db = new PDO($db_dsn, $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
    
    $st = $db->prepare("select * from $this_table where $this_primary_key = ?"); 
    $st->execute(array($record_id));
    $edit_row = $st->fetch(PDO::FETCH_ASSOC);

    $defaults['new_row'] = $edit_row;

    $form->addDataSource(new HTML_QuickForm2_DataSource_Array(
        $defaults
    ));
} 

// elements
$form->addElement('hidden', 'action')
     ->setValue($this_action)
     ;
$form->addElement('hidden', 'params')
     ->setValue($form_params)
     ;

$form->addElement('select', 'new_row[urna_id]')
     ->setLabel('Urna:')
     ->loadOptions($urna_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[lista_id]')
     ->setLabel('Lista:')
     ->loadOptions($lista_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('text',   'new_row[votos_centro]', array('autofocus' => 'autofocus', 'maxlength' => '3'))
     ->setLabel('Votos Centro:')
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('text',   'new_row[votos_claustro]', array('maxlength' => '3'))
     ->setLabel('Votos Claustro:')
     ->addRule('required', 'Valor requerido')
     ;

$form->addElement('button', 'btnSubmit', array('type' => 'submit', 'value' => 'Guardar', 'class' => 'btn btn-lg btn-primary'))
     ->setContent('Guardar')
     ;

// validaciones

//$form->addRule('each', 'Phones should be numeric', $form->createRule('regex', '', '/^\\d+([ -]\\d+)*$/'));

// defaults
$form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
    'new_row' => array(
        'fecha_atencion_inicial' => time(),
    )
)));


$form->addRecursiveFilter('trim');


require_once 'HTML/QuickForm2/Renderer.php';
require_once 'HTML/QuickForm2/JavascriptBuilder.php';
$renderer = HTML_QuickForm2_Renderer::factory('default');
$renderer->setJavascriptBuilder(new HTML_QuickForm2_JavascriptBuilder(null, __DIR__ . '/../lib/pear/data/HTML_QuickForm2/js')); 


$renderer->setOption(array(
    'errors_prefix' => 'El formulario contiene errores:',
    'required_note' => '<div><span class="required">*</span> denota campos requeridos</div>',
));

