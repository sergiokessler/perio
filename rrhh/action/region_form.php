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
    $form->addElement('text', $params['primary_key'], array('disabled' => 'disabled'), array('label' => 'Id'))
         ->setValue($record_id);
}      
$form->addElement('text',   'new_row[pais]', array('autofocus' => 'autofocus'))
     ->setLabel(' País:')
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('text', 'new_row[provincia]')
     ->setLabel(' Provincia:')
    ;
$form->addElement('text', 'new_row[localidad]')
     ->setLabel(' Localidad:')
    ;
    
$form->addElement('button', 'btnSubmit', array('type' => 'submit', 'value' => 'Guardar', 'class' => 'btn btn-primary'))
     ->setContent('Guardar')
     ;



