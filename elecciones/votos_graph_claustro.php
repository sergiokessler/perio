<?php

//*********************************
// graficos
//********************************


$data_sql = <<<END
    select
        l.lista_nombre,
        l.lista_nombre_corto,
        l.orden,
        sum(mt.votos_claustro) as votos_claustro
    from
        lista l,
        urna_total mt
    where
        l.activa = 1
        and
        l.en_porcentaje = 1
        and
        l.lista_id = mt.lista_id
        and
        participa_claustro = 1
    group by
        l.lista_nombre,
        l.lista_nombre_corto,
        l.orden
    order by
        l.orden
END;

if (!isset($db))
    $db = pg_connect($config['db']['pg_str']) or die(pg_last_error($db));

$result = pg_query($db, $data_sql); 
$data_values = pg_fetch_all($result);



// Elecciones de Claustro
//
$total_votos = 0;
foreach($data_values as $d) {
	$total_votos += $d['votos_claustro'];
}
$title = "Elecciones de Claustro - $total_votos votos";

//$html = '<div class="table-responsive">';
$html = '<table class="table table-striped">';

$html .= '<thead><tr>';
$html .= '<th>' . 'Lista' . '</th>';
$html .= '<th style="text-align:right">' . 'Votos' . '</th>';
$html .= '<th style="text-align:right">' . '%' . '</th>';
$html .= '</tr></thead>';

$html .= '<tbody>';

foreach($data_values as $d)
{
    $perc = number_format($d['votos_claustro'] * 100 / $total_votos, 2);
    $html .= '<tr>';
    $html .= '<td>';
    $html .= $d['lista_nombre'];
    $html .= '<div class="progress progress-striped">';
    $html .= '<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="'.$perc.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$perc.'%">';
    $html .= '<span class="sr-only">'.$perc.'% </span>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</td>';
    $html .= '<td style="text-align:right">' . $d['votos_claustro'] . '</td>';
    $html .= '<td style="text-align:right">' . $perc . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody>';
$html .= '</table>';
//$html .= '</div>';

$title = "<h3 class='subtitulo'>Votos de Claustro: $total_votos votos</h3>";

//echo '<pre>';
//print_r($params);
//echo '</pre>';

echo $title;

echo $html;

