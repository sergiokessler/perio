<?php

require_once 'share/pear/HTML/QuickForm2.php'; 


$date_options = array(
    'language'  => 'es',
    'format'    => 'dMY',
    'minYear'   => date('Y') - 2,
    'maxYear'   => date('Y') + 2,
);

$textarea_options = array(
    'rows' => 8,
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


$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$medio_select = array('' => '-- Seleccione --');
$sql_sel = "select medio_id as k, nombre as v from medio order by nombre";
$st = $db->query($sql_sel);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $medio_select[$row['k']] = $row['v'];
} 

$region_select = array('' => '-- Seleccione --');
$sql_sel = "select region_id as k, coalesce(localidad || ', ', '') || coalesce(provincia || ', ', '') || pais as v from region order by coalesce(localidad, provincia, pais)";
$st = $db->query($sql_sel);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $region_select[$row['k']] = $row['v'];
} 


$pais_select[''] = '-- Seleccione --';
$sql_sel = "select distinct pais as k, pais as v from region order by v";
$st = $db->query($sql_sel);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $pais_select[$row['k']] = $row['v'];
} 

$pcia_select[''] = array('' => '-- Seleccione --');
foreach($pais_select as $k => $v) {
    if ($k == '') continue;
    $tmp_select = null;
    $sql_sel = "select distinct coalesce(provincia, '') as k, coalesce(provincia, '') as v from region where pais = '$k' order by v";
    $st = $db->query($sql_sel);
    while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
        $tmp_select[$row['k']] = $row['v'];
    }
    $pcia_select[$k] = $tmp_select;
}

$loc_select[''][''] = array('' => '-- Seleccione --');
foreach($pais_select as $pk => $pv) {
    if ($pk == '') continue;
    foreach($pcia_select[$pk] as $k => $v) {
        if ($k == '') continue;
        $tmp_select = null;
        $sql_sel = "select distinct region_id as k, coalesce(localidad, '') as v from region where provincia = '$k' and pais = '$pk' order by v";
        $st = $db->query($sql_sel);
        while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
            $tmp_select[$row['k']] = $row['v'];
        }
        $loc_select[$pk][$k] = $tmp_select;
    }
}

$seccion_select = array('' => '-- Seleccione --');
$sql_sel = "select valor as k, valor as v from tabulado where clave = 'Sección' order by valor";
$st = $db->query($sql_sel);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $seccion_select[$row['k']] = $row['v'];
} 

$tipo_nota_select = array('' => '-- Seleccione --');
$sql_sel = "select valor as k, valor as v from tabulado where clave = 'Tipo de nota' order by valor";
$st = $db->query($sql_sel);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $tipo_nota_select[$row['k']] = $row['v'];
} 

$tema_select = array('' => '-- Seleccione --');
$sql_sel = "select valor as k, valor as v from tabulado where clave = 'Tema' order by valor";
$st = $db->query($sql_sel);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $tema_select[$row['k']] = $row['v'];
} 

$motivo_1_select = array('' => '-- Seleccione --');
$sql_sel = "select valor as k, valor as v from tabulado where clave = 'Motivo 1' order by valor";
$st = $db->query($sql_sel);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $motivo_1_select[$row['k']] = $row['v'];
}

$motivo_2_select = array('' => '-- Seleccione --');
$sql_sel = "select valor as k, valor as v from tabulado where clave = 'Motivo 2' order by valor";
$st = $db->query($sql_sel);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $motivo_2_select[$row['k']] = $row['v'];
}

$voces_select = array('' => '-- Seleccione --');
$sql_sel = "select valor as k, valor as v from tabulado where clave = 'Voces' order by valor";
$st = $db->query($sql_sel);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $voces_select[$row['k']] = $row['v'];
}

$territorios_select = array('' => '-- Seleccione --');
$sql_sel = "select valor as k, valor as v from tabulado where clave = 'Territorios' order by valor";
$st = $db->query($sql_sel);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $territorios_select[$row['k']] = $row['v'];
}



$five_select[''] = '--Seleccione--';
$five_select['5'] = '5';
$five_select['4'] = '4';
$five_select['3'] = '3';
$five_select['2'] = '2';
$five_select['1'] = '1';



$form_params = params_encode($params);

$form_update = false;
if (isset($record_id))
    $form_update = true;

$form = new HTML_QuickForm2('form', 'post', array('role' => 'form'));

// check if update
if ($form_update)
{
    $st = $db->prepare('select * from ' . $params['table'] . ' where ' . $params['primary_key'] . ' = ?'); 
    $st->execute(array($record_id));
    $edit_row = $st->fetch(PDO::FETCH_ASSOC);
    
    $defaults['new_row'] = $edit_row;

    // custom {
    $st = $db->prepare('select * from region where region_id = ?'); 
    $st->execute(array($edit_row['region_id']));
    $edit_row = $st->fetch(PDO::FETCH_ASSOC);

    $defaults['region'] = array($edit_row['pais'], $edit_row['provincia'], $edit_row['region_id']);
    // }

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

// elements
$form->addElement('hidden', 'action')
     ->setValue($params['action'])
     ;
$form->addElement('hidden', 'params')
     ->setValue($form_params)
     ;
if ($form_update) {
    $form->addElement('text', 'nota_id', array('disabled' => 'disabled'), array('label' => 'Nota Id'))
         ->setValue($record_id);
}
$form->addElement('select', 'new_row[medio_id]', array('autofocus' => 'autofocus'))
     ->setLabel('Medio:')
     ->loadOptions($medio_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('date',   'new_row[fecha]', array('class'=> 'form-control-inline'), $date_options)
     ->setLabel('Fecha:')
     ->addRule('required', 'Valor requerido')
     ;

$form->addElement('hierselect', 'region')
     ->setLabel('Pais:')
     ->setSeparator(array('Provincia:', 'Localidad'))
     ->loadOptions(array($pais_select, $pcia_select, $loc_select))
     ;
/*
$form->addElement('select', 'new_row[territorio_id]')
     ->setLabel('Territorio:')
     ->loadOptions($territorio_select)
     ->addRule('required', 'Valor requerido')
     ;
*/
$form->addElement('text',   'new_row[titulo]')
     ->setLabel('Título:')
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('text',   'new_row[link]')
     ->setLabel('Link:')
     ;
$form->addElement('select', 'new_row[seccion]')
     ->setLabel('Sección:')
     ->loadOptions($seccion_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[tipo_de_nota]')
     ->setLabel('Tipo de nota:')
     ->loadOptions($tipo_nota_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[tema]')
     ->setLabel('Tema:')
     ->loadOptions($tema_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[motivo_1]')
     ->setLabel('Motivo 1:')
     ->loadOptions($motivo_1_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[motivo_2]')
     ->setLabel('Motivo 2:')
     ->loadOptions($motivo_2_select)
     ;
$form->addElement('select', 'new_row[voz_1]')
     ->setLabel('Voz 1:')
     ->loadOptions($voces_select)
     ;
$form->addElement('select', 'new_row[voz_2]')
     ->setLabel('Voz 2:')
     ->loadOptions($voces_select)
     ;
$form->addElement('select', 'new_row[voz_3]')
     ->setLabel('Voz 3:')
     ->loadOptions($voces_select)
     ;
$form->addElement('select', 'new_row[territorio_1]')
     ->setLabel('Territorio 1:')
     ->loadOptions($territorios_select)
     ;
$form->addElement('select', 'new_row[territorio_2]')
     ->setLabel('Territorio 2:')
     ->loadOptions($territorios_select)
     ;
$form->addElement('select', 'new_row[territorio_3]')
     ->setLabel('Territorio 3:')
     ->loadOptions($territorios_select)
     ;
$form->addElement('select', 'new_row[imagen]')
     ->setLabel('Imagen:')
     ->loadOptions($boolean_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[video]')
     ->setLabel('Video:')
     ->loadOptions($boolean_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('textarea', 'new_row[texto]', $textarea_options)
     ->setLabel('Nota completa:')
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('button', 'btnSubmit', array('type' => 'submit', 'value' => 'Guardar', 'class' => 'btn btn-primary'))
     ->setContent('Guardar')
     ;


$form->addRecursiveFilter('trim');


require_once 'HTML/QuickForm2/Renderer.php';
require_once 'HTML/QuickForm2/JavascriptBuilder.php';
$renderer = HTML_QuickForm2_Renderer::factory('default');
$renderer->setJavascriptBuilder(new HTML_QuickForm2_JavascriptBuilder(null, __DIR__ . '/../share/pear/data/HTML_QuickForm2/js')); 

    


/*
$renderer->setOption(array(
    'errors_prefix' => 'El formulario contiene errores:',
    'required_note' => '<div><span class="required">*</span> denota campos requeridos</div>',
));
*/

