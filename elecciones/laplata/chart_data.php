<?php

//*********************************
// graficos
//********************************

include 'config.php';

$data_sql = <<<END
    select
        l.lista_nombre,
        l.lista_nombre_corto,
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
        and
        mt.urna_id in (20,21,22,23,26,27,28,29,32,57,58,59)
    group by
        l.lista_nombre,
        l.lista_nombre_corto,
        l.orden
    order by
        votos_centro desc
END;

if (!isset($db))
    $db = pg_connect($config['db']['pg_str']) or die(pg_last_error($db));

$result = pg_query($db, $data_sql); 
$data_values = pg_fetch_all($result);


// Elecciones de Centro
//
/*
unset($legend);
unset($data);
$total_votos = 0;
foreach($data_values as $d)
{
    $legend[] = $d['lista_nombre_corto'];
    $data[] = $d['votos_centro'];
    $total_votos += $d['votos_centro'];
}

unset($params);
$params['legend'] = $legend;
$params['data'] = $data;
$params['total_votos'] = $total_votos;
$params['title'] = "Elecciones de Centro - $total_votos votos";
*/

//echo '<pre>';
//var_dump($params);
//echo '</pre>';

/* este anio las elecciones de centro no van
$params = params_encode($params);
echo "\n";
echo '<img src="chart_draw.php?params=' . $params . '">';
echo "\n";


echo '<br>';
echo '<br>';
echo '<br>';
 */


// Elecciones de Claustro
//
unset($legend);
unset($data);
$total_votos = 0;
foreach($data_values as $d)
{
    $legend[] = $d['lista_nombre_corto'];
    $data[] = $d['votos_claustro'];
    $total_votos += $d['votos_claustro'];
}

$data1['legend'] = $legend;
$data1['data'] = $data;
$data1['total_votos'] = $total_votos;
$data1['title'] = "Elecciones de Claustro - $total_votos votos";

//echo '<pre>';
//print_r($params);
//echo '</pre>';



include_once 'jpgraph/src/jpgraph.php';
include_once 'jpgraph/src/jpgraph_bar.php';


$title       = $data1['title'];
$legend      = $data1['legend'];
$data        = $data1['data'];
$total_votos = $data1['total_votos'];

// Callback function
// Get called with the actual value and should return the
// value to be displayed as a string
function cbFmtPercentage($aVal) {
    global $total_votos;
    return sprintf("%.1f%%",100*$aVal/$total_votos); // Convert to string
}


// Size of graph
$width=800; 
$height=650;

// Set the basic parameters of the graph 
$graph = new Graph($width,$height,'auto');
$graph->SetScale("textlin");

// Rotate graph 90 degrees and set margin
$graph->Set90AndMargin(150,20,50,30);

// Nice shadow
$graph->SetShadow();
// Don't display the border
//$graph->SetFrame(false);

//// Set A title for the plot
$graph->title->Set($title);
$graph->title->SetFont(FF_FONT2,FS_BOLD);

// Setup X-axis
$graph->xaxis->SetTickLabels($legend);
$graph->xaxis->SetFont(FF_FONT2);

// Some extra margin looks nicer
//$graph->xaxis->SetLabelMargin(10);

// Label align for X-axis
$graph->xaxis->SetLabelAlign('right','center');

// Add some grace to y-axis so the bars doesn't go
// all the way to the end of the plot area
$graph->yaxis->scale->SetGrace(20);

// Create
$bplot = new BarPlot($data);
$bplot->SetFillColor( "navy"); 
$bplot->SetShadow();
// Label font and color setup
//$p1->value->Show(False);
$bplot->value->SetFont(FF_FONT2);
//$p1->value->SetColor('white');
//$p1->SetLabelType(PIE_VALUE_ABS);
//$p1->SetHeight(5);
//$p1->SetTheme("sand"); 

// We want to display the value of each bar at the top
$bplot->value->Show();
// Setup the callback function
$bplot->value->SetFormatCallback("cbFmtPercentage");
$bplot->value->SetAlign('left','center');
$bplot->value->SetColor("black","darkred");


$graph->Add($bplot);
$graph->Stroke();

