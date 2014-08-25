<?php


// main menu
unset($data_menu_op);


include_once 'header.php';

echo '      <div class="jumbotron">';
echo '        <h2>Biblioteca de la Facultad de Periodismo y Comunicación Social de la UNLP</h2>';
echo '        <p></p>';
echo '        <p><a href="?action=material_search" class="btn btn-lg btn-success">Buscar material del CDM</a></p>';
echo '      </div>';


// mostramos los ultimos ingresos

$sql = 'select * from libros order by inventario desc limit 5';

$db = new PDO($config['db']['dsn']); 
$st = $db->query($sql); 
if ($st === false) {
    die(print_r($st->errorInfo()));
} 

$data = $st->fetchAll(PDO::FETCH_ASSOC);

//echo '<div class="row">';


echo '<h2>Ultimos ingresos:</h2>';

foreach ($data as $rec)
{
    $params['record_id'] = $rec['inventario'];
//    echo '<div class="span4">';
    echo  htmlentities($rec['autor']);
    echo '<p>';
    echo '<i>';
    echo '<a href="?action=material_select&amp;params=' . params_encode($params) . '">';
    echo $rec['inventario'];
    echo '</a>';
    echo '</i> - ';
    echo nl2br(htmlentities($rec['titulo']));
    echo '</p>';
//    echo '</div>';
}

//echo '</div>';


include_once 'footer.php';

