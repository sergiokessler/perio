<?php


$sql_claustro = <<<END
    select
        l.lista_nombre,
        l.orden,
        sum(mt.votos_claustro) as votos_claustro
    from
        lista l,
        urna u,
        urna_total mt
    where
        l.activa = 1
        and
        l.en_total = 1
        and
        l.lista_id = mt.lista_id
        and
        u.urna_id = mt.urna_id
        and
        u.urna_nombre ilike '%la plata%' 
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

$html = '<table class="table table-striped">';
// titulos !
$html .= '<thead><tr>';
$html .= '<th class="listado">' . 'Lista' . '</th>';
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

echo '<h2>';
echo 'Total de votos Claustro: ', $votos_totales['claustro'];
echo '</h2>';

echo $html;

