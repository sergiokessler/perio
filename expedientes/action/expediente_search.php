<?php

/*

$Id$

*/

include 'share/data_utils.php';


$sql_list = <<<END
    select 
        *    
    from 
        exptes
    where
        fecha_entrada between ? and ?
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
$form->addElement('header', 'MyHeader', 'Buscar expedientes');
$form->addElement('hidden', 'action', 'expediente_search');
$form->addElement('text', 'causante', 'Causante:');
$form->addElement('text', 'tema', 'Tema:');
$form->addElement('text', 'expte', 'Expediente:', $campo_medio);
$form->addElement('text', 'nro_resolucion', 'Resolucion Nro:', $campo_medio);
$form->addElement('text', 'universidad', 'Universidad:');
$form->addElement('date', 'fecha1_desde', 'Fecha entrada desde:', $date_options);
$form->addElement('date', 'fecha1_hasta', 'Fecha entrada hasta:', $date_options);
$form->addElement('submit', 'btnSubmit', 'Buscar');

$form->setDefaults(array(
    'fecha1_desde' => $date_defaults,
    'fecha1_hasta' => $date_defaults
));


include_once 'header.php';

echo '<br>';
$form->display();


$link_url = 'index.php?action=expediente_insert';
$link_label = 'Cargar un nuevo expediente';
echo '<br>'; 
echo "<a href=\"$link_url\">$link_label.</a>"; 
echo '<br>'; 
echo '<br>'; 



if ( isset($_REQUEST['btnSubmit']) and $_REQUEST['btnSubmit'] == 'Buscar' )
{

    $sql_where = '';
    $sql_data = array();

    $fecha_desde = get_date($_REQUEST['fecha1_desde']) . ' 00:00:00';
    $fecha_hasta = get_date($_REQUEST['fecha1_hasta']) . ' 23:59:59'; 
    $sql_data = array($fecha_desde, $fecha_hasta);


    if ($_REQUEST['causante'] != '')
    {
        $sql_where .= ' and causante ilike ? ';
        $sql_data[] = '%' . $_REQUEST['causante'] . '%';
    }
    
    if ($_REQUEST['tema'] != '')
    {
        $sql_where .= ' and tema ilike ? ';
        $sql_data[] = '%' . $_REQUEST['tema'] . '%';
    }

    if ($_REQUEST['nro_resolucion'] != '')
    {
        $sql_where .= ' and nro_resolucion ilike ? ';
        $sql_data[] = '%' . $_REQUEST['nro_resolucion'] . '%';
    }

    if ($_REQUEST['universidad'] != '')
    {
        $sql_where .= ' and universidad ilike ? ';
        $sql_data[] = '%' . $_REQUEST['universidad'] . '%';
    }


    unset($params);
    $params['sql_list'] = $sql_list;
    $params['sql_where'] = $sql_where;
    $params['sql_order_by'] = 'order by fecha_entrada';
    $params['sql_data'] = $sql_data;
    $params['primary_key'] = 'expte';
    $params['link_view']['field_name'] = $params['primary_key'];
    $params['link_view']['action'] = 'expediente';

    include_once 'share/data_display.php';
    echo sak_display_list($params);
}


include_once 'footer.php';



?>
