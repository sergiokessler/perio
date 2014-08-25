<?php


//unset($params);
$params['table'] = 'materia';
$params['primary_key'] = 'materia_id';

$sql = <<<END
    select
        *
    from
        materia
    order by 
        nombre
END;
$sql_data = null;



include_once 'header.php';


$insert_title = 'Agregar registro';
$insert_url = 'index.php?action=' . $params['table'] . '_insert';
echo "<a href=\"$insert_url\">$insert_title</a>";
echo '<br>';
echo '<br>';

$db = new PDO($config['db']['dsn']); 
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$st = $db->prepare($sql); 
$st->execute($sql_data); 


$params_display['data'] = $st->fetchAll(PDO::FETCH_ASSOC);

if (count($params_display['data']) == 0) {
    echo 'No se encuentran resultados';
} else {
    $params_display['primary_key'] = $params['primary_key'];
    $params_display['link_view']['field_name'] = $params['primary_key'];
    $params_display['link_view']['label'] = 'Ver materia';
    $params_display['link_view']['action'] = 'materia_select';

    include_once 'share/data_display.php';
    echo sak_display_array_list($params_display);
}


include_once 'footer.php';


