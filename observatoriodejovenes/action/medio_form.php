<?php


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


$relevancia_select[''] = '--Seleccione--';
$relevancia_select['5'] = '5 - Muy relevante';
$relevancia_select['4'] = '4 - Relevante';
$relevancia_select['3'] = '3 - Medianamente relevante';
$relevancia_select['2'] = '2 - Algo relevante';
$relevancia_select['1'] = '1 - Poco relevante';

$cobertura_select[''] = '--Seleccione--';
$cobertura_select['Mundial'] = 'Mundial';
$cobertura_select['Mercosur'] = 'Mercosur';
$cobertura_select['Nacional'] = 'Nacional';
$cobertura_select['Provincial'] = 'Provincial';
$cobertura_select['Municipal'] = 'Municipal';
$cobertura_select['Internet'] = 'Internet';

$tipo_select[''] = '--Seleccione--';
$tipo_select['Impreso'] = 'Impreso';
$tipo_select['Digital'] = 'Digital';


$fuente_select[''] = '--Seleccione--';
$fuente_select['FA'] = 'FA';
$fuente_select['FNA'] = 'FNA';
$fuente_select['FT'] = 'FT';
$fuente_select['SF'] = 'SF';


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
    $form->addElement('text', 'medio_id', array('disabled' => 'disabled'), array('label' => 'Medio Id'))
         ->setValue($record_id);
}      
$form->addElement('text',   'new_row[nombre]', array('autofocus' => 'autofocus'))
     ->setLabel(' Nombre del medio:')
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[relevancia]')
     ->setLabel(' Relevancia:')
     ->loadOptions($relevancia_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[tipo]')
     ->setLabel(' Tipo:')
     ->loadOptions($tipo_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('text', 'new_row[web]')
     ->setLabel(' Sitio web:')
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


