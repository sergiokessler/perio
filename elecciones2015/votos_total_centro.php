<?php


$sql_centro = <<<END
    select
        l.lista_nombre,
        l.orden,
        sum(mt.votos_centro) as votos_centro
    from
        lista l,
        urna_total mt
    where
        l.activa = 1
        and
        l.en_total = 1
        and
        l.lista_id = mt.lista_id
        and
        participa_centro = 1
    group by
        l.lista_nombre,
        l.orden
    order by
        l.orden
END;


$result = pg_query($db, $sql_centro);

// CENTRO
//$html = '<div class="table-responsive">';
$html = '<table class="table table-striped">';
// titulos !
$html .= '<thead><tr>';
$html .= '<th>' . 'Lista' . '</th>';
$html .= '<th style="text-align:right">' . 'Votos para Centro' . '</th>';
$html .= '</tr></thead>';

$html .= '<tbody>';
$i = 0;
$votos_totales['centro'] = 0;

while($row = pg_fetch_assoc($result))
{
	$html .= '<tr>';
	$html .= '<td>' . $row['lista_nombre'] . '</td>';
	$html .= '<td style="text-align:right">' . $row['votos_centro'] . '</td>';
	$html .= '</tr>';
	$votos_totales['centro'] += $row['votos_centro'];
}


//$html .= '<tr class="title">';
//$html .= '<th class="listado">' . '<strong>Totales<strong>' . '</th>';
//$html .= '<th class="listado_number">' . $votos_totales['centro'] . '</th>';
//$html .= '</tr>';

$html .= '</tbody>';
$html .= '</table>';

$html_centro = $html;


$title  = '<h3 style="text-align:center">';
$title .= 'Votos Totales de Centro: ' . $votos_totales['centro'];
$title .= '</h3>';



echo $title;

echo $html_centro;


