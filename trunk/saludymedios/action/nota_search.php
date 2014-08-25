<?php

/*

$Id$

*/

include 'share/data_utils.php';


$sql_list = <<<END
    select 
        *    
    from 
        nota
    where
        fecha between ? and ?
END;



$date_options = array(
    'language'  => 'es',
    'format'    => 'dMY',
    'minYear' => 2001,
    'maxYear' => date('Y') + 2,
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
include 'action/nota_form.php';

$form = new HTML_QuickForm('form', 'get');
$form->addElement('header', 'MyHeader', 'Buscar notas:');
$form->addElement('hidden', 'action', 'nota_search');

$sel =& $form->addElement('hierselect', 'medioyseccion', 'Medio:', null, ' <strong>Sección: </strong>');
$sel->setOptions(array($medio_select, $seccion_select));

$form->addElement('date',   'new_row[fecha1_desde]', 'Fecha desde:', $date_options);
$form->addElement('date',   'new_row[fecha1_hasta]', 'Fecha hasta:', $date_options);
$form->addElement('text',   'new_row[palabras_clave]', 'Palabras clave:', $campo_largo);
$form->addElement('text',   'new_row[pagina]', 'Página:', $campo_corto);
$form->addElement('select', 'new_row[clasificacion]', 'Clasificacion:', $clasificacion_select);
$form->addElement('select', 'new_row[contenido]', 'Contenido:', $contenido_select);

$form->setDefaults(array(
    'new_row[fecha1_desde]' => $date_defaults,
    'new_row[fecha1_hasta]' => $date_defaults
));

$form->addElement('submit', 'btnSubmit', 'Buscar');



include_once 'header.php';

$form->display();


$link_url = 'index.php?action=nota_insert';
$link_label = 'Cargar una nueva nota';
echo '<br>'; 
echo "<a href=\"$link_url\">$link_label</a>"; 
echo '<br>'; 
echo '<br>'; 



if ( isset($_REQUEST['btnSubmit']) and $_REQUEST['btnSubmit'] == 'Buscar' )
{

    $sql_where = '';
    $sql_data = array();

    $new_row = $_GET['new_row'];

    $new_row['medio'] = $_GET['medioyseccion'][0];
    $new_row['seccion'] = $_GET['medioyseccion'][1]; 

    $fecha_desde = get_date($new_row['fecha1_desde']) . ' 00:00:00';
    $fecha_hasta = get_date($new_row['fecha1_hasta']) . ' 23:59:59'; 
    $sql_data = array($fecha_desde, $fecha_hasta);


    if ($new_row['medio'] != '')
    {
        $sql_where .= ' and medio ilike ? ';
        $sql_data[] = '%' . $new_row['medio'] . '%';
    }
    
    if ($new_row['seccion'] != '')
    {
        $sql_where .= ' and seccion ilike ? ';
        $sql_data[] = '%' . $new_row['seccion'] . '%';
    }

    if ($new_row['palabras_clave'] != '')
    {
        $sql_where .= ' and palabras_clave ilike ? ';
        $sql_data[] = '%' . $new_row['palabras_clave'] . '%';
    }

    if ($new_row['clasificacion'] != '')
    {
        $sql_where .= ' and clasificacion ilike ? ';
        $sql_data[] = '%' . $new_row['clasificacion'] . '%';
    }

    if ($new_row['contenido'] != '')
    {
        $sql_where .= ' and contenido ilike ? ';
        $sql_data[] = '%' . $new_row['contenido'] . '%';
    }

    unset($params);
    $params['sql_list'] = $sql_list;
    $params['sql_where'] = $sql_where;
    $params['sql_order'] = 'order by fecha';
    $params['sql_data'] = $sql_data;
    $params['primary_key'] = 'nota_id';
    $params['link_view']['field_name'] = $params['primary_key'];
    $params['link_view']['label'] = 'Ver nota';
    $params['link_view']['action'] = 'nota';

    include_once 'share/data_display.php';
    echo sak_display_list($params);
}


include_once 'footer.php';



?>
