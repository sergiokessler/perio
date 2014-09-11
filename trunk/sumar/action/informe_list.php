<?php


require_once 'share/data_display.php';


// <UI>
include_once 'header.php';

echo '<div class="page-header">';
echo '  <h1>Informes mensuales<small> </small></h1>';
echo '</div>';


$dir    = 'informes/';
$files1 = scandir($dir, 1);



$html  = '<table class="table table-striped">';
$html .= '<thead><tr><th>Informe SUMAR</th><th>Informe Web Social</th></tr></thead>';
$html .= '<tbody>';

foreach ($files1 as $filename) {
    if($filename === '.' || $filename === '..') {continue;}
    if (strpos($filename, 'social') === false) {
        $html .= '<tr><td><a href="informes/' . $filename . '" target="_blank">' . $filename . '</a></td>';
    } else {
        $html .= '<td><a href="informes/' . $filename . '" target="_blank">' . $filename . '</a></td></tr>';
    }
}

$html .= '</tbody>';
$html .= '</table>';

echo $html;
    
include_once 'footer.php';

