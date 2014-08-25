<?php

require_once 'share/data_display.php';
include 'share/form_common.php';  
require_once 'HTML/QuickForm2.php'; 


$sql = <<<END
    select 
        *
    from 
        region
    where
        1 = 1
END;
$sql_data = array();




$form = new HTML_QuickForm2('search', 'get', array('class' => 'noprint'));

// elements
$form->addElement('hidden', 'action')
     ->setValue($action)
     ;

$form->addElement('text', 'localidad')
     ->setLabel('Localidad:')
     ;

$form->addElement('button', 'btnSubmit', array('type' => 'submit', 'value' => 'Buscar', 'class' => 'btn btn-primary'))
     ->setContent('Buscar')
     ;



include 'header.php';


echo '<div class="page-header">';
echo '<h1>Lista de regiones <small>Ordenado por pais, provincia, localidad</small></h1>';
echo '<div class="noprint">';
echo '<a href="?action=region_insert">Cargar Región</a>';
echo '</div>';
echo '</div>';

echo $form;


// procesamos la busqueda
$sql_where = '';
if ( isset($_GET['btnSubmit']) and $_GET['btnSubmit'] != '' )
{
    $sql_data = array();

    if (!empty($_GET['localidad'])) {
        $sql_where .= " and lower(localidad) like '%' || lower(?) || '%' ";
        $sql_data[] = $_GET['localidad'];
    }
}


$sql .= $sql_where . ' order by pais, provincia, localidad';


// buscamos y mostramos los datos

$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$st = $db->prepare($sql); 
$st->execute($sql_data);


unset($params);
$params['data'] = $st->fetchAll(PDO::FETCH_ASSOC);
$reg_count = count($params['data']);

echo "Un total de $reg_count registros.<br><br>";

if ($reg_count > 0) { 
    $params['primary_key'] = 'region_id';
    $params['link_view']['region_id']['label'] = 'Ver registro';
    $params['link_view']['region_id']['href'] = '?action=region';

    echo sak_display_array_list($params);
} 


include 'footer.php';


