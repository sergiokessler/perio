<?php


$data_sql = <<<END
    select
        l.lista_nombre,
        l.orden,
        sum(mt.votos_centro) as votos_centro,
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
    group by
        l.lista_nombre,
        l.orden
    order by
        l.orden
END;
$result = pg_query($db, $data_sql); 
$data = pg_fetch_all($result);
// calculamos los totales antes para luego computar los % 

$votos_totales['centro'] = 0;
$votos_totales['claustro'] = 0;
foreach ($data as $row)
{
    $votos_totales['centro'] += $row['votos_centro'];
    $votos_totales['claustro'] += $row['votos_claustro'];
}



$html = '<table class="listado">';
// titulos !
$html .= '<thead><tr class="title">';
$html .= '<th class="listado">' . 'Lista' . '</th>';
$html .= '<th class="listado">' . 'Votos Centro' . '</th>';
$html .= '<th class="listado">' . '% Centro' . '</th>';
$html .= '<th class="listado">' . 'Votos Claustro' . '</th>';
$html .= '<th class="listado">' . '% Claustro' . '</th>';
$html .= '</tr></thead>';

$html .= '<tbody>';
$i = 0;
foreach ($data as $row)
{
    if ($i % 2) $tr_style = 'f1';
        else    $tr_style = 'f2';
    $i++;
    
    $html .= '<tr class="' . $tr_style . '">';
    $html .= '<td class="listado">' . $row['lista_nombre'] . '</td>';
    $html .= '<td class="listado_number">' . $row['votos_centro'] . '</td>';
    if ($votos_totales['centro'] > 0) {
        $porc_centro = number_format($row['votos_centro'] * 100 / $votos_totales['centro'], 1);
    } else {
        $porc_centro = 0;
    }
    $html .= '<td class="listado_number">' . $porc_centro . '</td>';
    $html .= '<td class="listado_number">' . $row['votos_claustro'] . '</td>';
    if ($votos_totales['claustro'] > 0) {
        $porc_claustro = number_format($row['votos_claustro'] * 100 / $votos_totales['claustro'], 1);
    } else {
        $porc_claustro = 0;
    }
    $html .= '<td class="listado_number">' . $porc_claustro . '</td>';
    $html .= '</tr>';
}

$html .= '<tr class="title">';
$html .= '<th class="listado">' . '<strong>Totales<strong>' . '</th>';
$html .= '<th class="listado_number">' . $votos_totales['centro'] . '</th>';
$html .= '<th class="listado_number">' . 100 . '</th>';
$html .= '<th class="listado_number">' . $votos_totales['claustro'] . '</th>';
$html .= '<th class="listado_number">' . 100 . '</th>';
$html .= '</tr>';

$html .= '</tbody>';

$html .= '</table>'; 

echo $html;


