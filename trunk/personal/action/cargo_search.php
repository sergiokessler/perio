<?php

/*

$Id$

*/

include 'share/data_utils.php';


$sql_list = <<<END
    select 
        *    
    from 
        cargo
END;
$sql_primary_key = 'cargo_id';



$date_options = array(
    'language'  => 'es',
    'format'    => 'dMY',
);
$date_defaults = array(
    'd' => date('d'),
    'M' => date('m'),
    'Y' => date('Y'),
);

$textarea_options = array(
    'rows' => 2,
    'cols' => 32
);
$campo_corto = array('size' => 3);
$campo_medio = array('size' => 8);
$campo_largo = array('size' => 64); 




require_once 'HTML/QuickForm.php';
$form = new HTML_QuickForm('form', 'get');
$form->addElement('header', 'MyHeader', 'Buscar cargos');
$form->addElement('hidden', 'action', 'cargo_search');
$form->addElement('text', 'search[legajo]', 'Legajo:');
$form->addElement('text', 'search[expediente]', 'Expediente:');
$form->addElement('text', 'search[resolucion]', 'Resolucion:');
$form->addElement('text', 'search[doc_nro]', 'Doc Nro:');
$form->addElement('text', 'search[cargo]', 'Cargo:');
$form->addElement('text', 'search[dedicacion]', 'Dedicacion:');
$form->addElement('text', 'search[extension]', 'Extension:');
$form->addElement('submit', 'btnSubmit', 'Buscar');

$form->setDefaults(array(
//    'fecha1_desde' => $date_defaults,
//    'fecha1_hasta' => $date_defaults
));


include_once 'header.php';

echo '<br>';
$form->display();

/*
$link_url = 'index.php?action=cargo_insert';
$link_label = 'Cargar un nuevo cargo';
echo '<br>'; 
echo "<a href=\"$link_url\">$link_label.</a>"; 
echo '<br>'; 
echo '<br>'; 
 */


if ( isset($_REQUEST['btnSubmit']) and $_REQUEST['btnSubmit'] == 'Buscar' )
{

    $sql_where = ' where 1 = 1';
    $sql_data = array();


    foreach($_REQUEST['search'] as $key => $value)
    {
        if ($value != '')
        {
            $sql_where .= " and $key ilike ? ";
            $sql_data[] = "%$value%";
        }
    }


    unset($params_display);
    $params_display['sql_list'] = $sql_list;
    $params_display['sql_where'] = $sql_where;
    $params_display['sql_order'] = "order by $sql_primary_key";
    $params_display['sql_data'] = $sql_data;
    $params_display['primary_key'] = $sql_primary_key;
    $params_display['link_view']['field_name'] = $sql_primary_key;
    $params_display['link_view']['action'] = 'cargo';

    include_once 'share/data_display.php';
    echo sak_display_list($params_display);
}


include_once 'footer.php';


