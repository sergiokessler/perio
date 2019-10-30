<?php

include 'config.php';
include 'include/graphs.inc.php';

function params_encode($params)
{
    return(base64_encode(gzcompress(serialize($params))));
}

function params_decode($params)
{
    return(unserialize(gzuncompress(base64_decode($params))));
} 

include 'include/header.php';


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

//echo ' <br />(<a href="urna.php">Ver votos por Urna</a>)</div>';
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

include 'include/footer.php';
