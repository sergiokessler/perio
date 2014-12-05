<?php

include 'config.php';
include 'graphs.inc.php';

function params_encode($params)
{
    return(base64_encode(gzcompress(serialize($params))));
}

function params_decode($params)
{
    return(unserialize(gzuncompress(base64_decode($params))));
} 

include 'header.php';
echo '<div class="container">';
//echo '<center>';
echo '<div id="header">';
echo '<img src="images/logoperio.png" class="logoperio">';
echo '<h1 class="tituloh1">';
echo "Elecciones $anio<br>";
echo '</h1>';
echo '<img src="images/logosevit.png" class="logosevit">';
echo '<div class="clear"></div>';
echo '</div>';


$db = pg_connect($config['db']['pg_str']) or die(pg_last_error($db)); 


$sql = 'select count(distinct urna_id) as urnas_escrutadas from urna_total';
$result = pg_query($sql);
$row = pg_fetch_assoc($result);
$urnas_escrutadas = $row['urnas_escrutadas'];

$sql = 'select count(distinct urna_id) as urnas_total from urna';
$result = pg_query($sql);
$row = pg_fetch_assoc($result);
$urnas_total = $row['urnas_total'];

echo '<div class="urnasescrutadas">Cantidad de urnas escrutadas: ' . $urnas_escrutadas . ' / ' . $urnas_total;

echo ' <br />(<a href="urna.php">Ver votos por Urna</a>)</div>';
echo '<br>';
echo '<br>';

if ($urnas_escrutadas > 0)
{
    include 'votos_graph_centro.php';
    echo '<br>';
    include 'votos_graph_claustro.php';
    echo "\n";
    echo '<br>';
    echo '<br>';
    include 'votos_total_centro.php';
    echo '<br>';
    include 'votos_total_claustro.php';
}
else
{
    echo '<h2 class="subtitulo">No hay datos.</h2>';
}

echo '</div>';

include 'footer.php';
