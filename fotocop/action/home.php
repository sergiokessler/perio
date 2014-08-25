<?php


// main menu
unset($data_menu_op);

$data_menu_op[] = array (
    'title' => 'Buscar material de fotocopiadora',
    'url' => ''
);


include_once 'header.php';

echo '<br>';
echo '<br>';

echo '      <div class="hero-unit">';
echo '        <h1>La Walsh Conducción</h1>';
echo '        <p>Somos una agrupacion politica estudiantil que se conformo hace 28 años con un objetivo: refundar lo que en aquel entonces era la escuelita de Periodismo y transfromarla en una Facultad Nacional, Popular e inclusiva.</p>';
echo '        <p><a href="?action=material_search" class="btn btn-primary btn-large">Buscar material de fotocopiadora &raquo;</a></p>';
echo '      </div>';


// mostramos las ultimas noticias

$sql = 'select * from noticia order by noticia_id desc limit 3';

$db = new PDO($config['db']['dsn']); 
$st = $db->query($sql); 
if ($st === false) {
    die(print_r($st->errorInfo()));
} 

$data = $st->fetchAll(PDO::FETCH_ASSOC);

echo '<div class="row">';

foreach ($data as $rec)
{
    echo '<div class="span4">';
    echo '<h2>' . htmlentities($rec['titulo']) . '</h2>';
    echo '<p>';
    echo '<i>' . $rec['fecha_registro'] . '</i> - ';
    echo nl2br(htmlentities($rec['texto']));
    echo '</p>';
    echo '</div>';
}

echo '</div>';


include_once 'footer.php';

