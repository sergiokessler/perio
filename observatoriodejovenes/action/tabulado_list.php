<?php

require_once 'share/data_display.php';

$table = 'tabulado';

$sql = <<<END
    select 
        *
    from 
        $table
    where
        1 = 1
END;
$sql_data = array();


include 'header.php';


echo '<div class="page-header">';
echo '<h1>Lista de tabulados <small>Ordenado por nombre</small></h1>';
echo '<a href="?action=tabulado_insert">Cargar Tabulado</a>';
echo '</div>';



// procesamos la busqueda
$sql_where = '';
if ( isset($_GET['btnSubmit']) and $_GET['btnSubmit'] != '' )
{
    $sql_data = array();

    if ($_GET['zona'] != '') {
        $sql_where .= " and lower(zona) like '%' || lower(?) || '%' ";
        $sql_data[] = $_GET['zona'];
    }
    if ($_GET['provincia'] != '') {
        $sql_where .= " and lower(provincia) like '%' || lower(?) || '%' ";
        $sql_data[] = $_GET['provincia'];
    }
}


$sql .= $sql_where . ' order by clave';


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
    $pk = 'tab_id';
    $params['primary_key'] = $pk;
    $params['link_view'][$pk]['label'] = 'Ver registro';
    $params['link_view'][$pk]['href'] = '?action=' . $table;

    echo sak_display_array_list($params);
} 


include 'footer.php';


