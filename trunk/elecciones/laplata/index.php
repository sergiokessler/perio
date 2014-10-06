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
echo '<img src="../images/logoperio.png" class="logoperio">';
echo '<h1 class="tituloh1">';
echo "Elecciones $anio<br>";
echo '</h1>';
echo '<img src="../images/logosevit.png" class="logosevit">';
echo '<div class="clear"></div>';
echo '</div>';
echo '(Solo urnas de La Plata)';

$db = pg_connect($config['db']['pg_str']) or die(pg_last_error($db)); 


$sql = <<<END
    select 
    	count(distinct mt.urna_id) as urnas_escrutadas 
    from
        urna u,
        urna_total mt
    where
        u.urna_id = mt.urna_id
        and
        u.urna_nombre ilike '%la plata%'
END;
$result = pg_query($sql);

$row = pg_fetch_assoc($result);
echo '<div class="urnasescrutadas">Cantidad de urnas escrutadas: ' . $row['urnas_escrutadas'];

echo '<br />(<a href="urna.php">Ver votos por Urna</a>)</div>';
echo '<br>';
echo '<br>';

if ($row['urnas_escrutadas'] > 0)
{
    echo '<h2 class="subtitulo">Participación en % - Votos Positivos (sin nulos, blancos e impugnados)</h2>';
    echo '<br>';
    include 'votos_graph_centro.php';
    echo '<br>';
    include 'votos_graph_claustro.php'; 
    echo '<br>';
    echo '<br>';
    echo "\n";
    include 'votos_total_centro.php';
    echo '<br>';
    include 'votos_total_claustro.php';
}
else
{
    echo '<h2 class="subtitulo">No hay datos.</h2>';
}

//echo '</center>';

echo '</div>';

include 'footer.php';

