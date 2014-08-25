<?php

/*

$Id$

*/

include 'share/data_utils.php';


$sql_list = <<<END
    select 
        *    
    from 
        persona
    where
        1 = 1 
END;



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
$form->addElement('header', 'MyHeader', 'Buscar personas');
$form->addElement('hidden', 'action', 'persona_search');
$form->addElement('text', 'doc_nro', 'Doc Nro:');
$form->addElement('text', 'apellido_nombres', 'Apellido, nombres:');
$form->addElement('submit', 'btnSubmit', 'Buscar');

$form->setDefaults(array(
//    'fecha1_desde' => $date_defaults,
//    'fecha1_hasta' => $date_defaults
));


include_once 'header.php';

echo '<br>';
$form->display();


$link_url = 'index.php?action=persona_insert';
$link_label = 'Cargar una nueva persona';
echo '<br>'; 
echo "<a href=\"$link_url\">$link_label.</a>"; 
echo '<br>'; 
echo '<br>'; 



if ( isset($_REQUEST['btnSubmit']) and $_REQUEST['btnSubmit'] == 'Buscar' )
{

    $sql_where = '';
    $sql_data = array();


    if ($_REQUEST['doc_nro'] != '')
    {
        $sql_where .= ' and doc_nro = ? ';
        $sql_data[] = $_REQUEST['doc_nro'];
    }
    
    if ($_REQUEST['apellido_nombres'] != '')
    {
        $sql_where .= ' and apellido_nombres ilike ? ';
        $sql_data[] = '%' . $_REQUEST['apellido_nombres'] . '%';
    }


    unset($params_display);
    $params_display['sql_list'] = $sql_list;
    $params_display['sql_where'] = $sql_where;
    $params_display['sql_order'] = 'order by apellido_nombres';
    $params_display['sql_data'] = $sql_data;
    $params_display['primary_key'] = 'doc_nro';
    $params_display['link_view']['field_name'] = 'doc_nro';
    $params_display['link_view']['action'] = 'persona';

    include_once 'share/data_display.php';
    echo sak_display_list($params_display);
}


include_once 'footer.php';


