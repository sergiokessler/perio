<?php


$sql_claustro = <<<END
    select
        l.lista_nombre,
        l.orden,
        sum(mt.votos_claustro) as votos_claustro
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
        participa_claustro = 1
    group by
        l.lista_nombre,
        l.orden
    order by
        l.orden
END;



// CLAUSTRO
$result = pg_query($db, $sql_claustro);

//$html = '<div class="table-responsive">';
$html = '<table class="table table-striped">';
// titulos !
$html .= '<thead><tr>';
$html .= '<th>' . 'Lista' . '</th>';
$html .= '<th style="text-align:right">' . 'Votos para Claustro' . '</th>';
$html .= '</tr></thead>';

$html .= '<tbody>';
$i = 0;
$votos_totales['claustro'] = 0;

while($row = pg_fetch_assoc($result))
{
	$html .= '<tr>';
	$html .= '<td>' . $row['lista_nombre'] . '</td>';
	$html .= '<td style="text-align:right">' . $row['votos_claustro'] . '</td>';
	$html .= '</tr>';
	$votos_totales['claustro'] += $row['votos_claustro'];
}

$html .= '</tbody>';
$html .= '</table>'; 
//$html .= '</div>';

$html_claustro = $html;


$title  = '<h3 style="text-align:center">';
$title .= 'Votos Totales de Claustro: ' . $votos_totales['claustro'];
$title .= '</h3>';



echo $title;

echo $html_claustro;

