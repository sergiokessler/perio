<?php


function params_decode($params)
{
    return(unserialize(gzuncompress(base64_decode(rawurldecode($params)))));
} 

$chart_params = params_decode($_GET['params']);

$chart_values = array();
$chart_keys = array();
foreach($chart_params['data'] as $dp) {
    $chart_values[] = $dp[$chart_params['ejey']];
    $chart_keys[] = $dp[$chart_params['ejex']] . ' ';
}


/* pChart library inclusions */ 
include("pchart/class/pData.class.php");
include("pchart/class/pDraw.class.php");
include("pchart/class/pImage.class.php");




/* Create and populate the pData object */ 
$MyData = new pData();   
$MyData->addPoints($chart_values, $chart_params['ejey']);
//$MyData->setAxisName(0,"Hits");
$MyData->addPoints($chart_keys, $chart_params['ejex']); 
$MyData->setSerieDescription($chart_params['ejex'], $chart_params['ejex']); 
$MyData->setAbscissa($chart_params['ejex']); 
//$MyData->setAbscissaName($chart_params['ejex']); 
//$MyData->setAxisDisplay(0, AXIS_FORMAT_METRIC, 1); 

/* Create the pChart object */ 
$myPicture = new pImage(760,700,$MyData); 
$myPicture->setFontProperties(array("FontName"=>"pchart/fonts/verdana.ttf","FontSize"=>10,"R"=>0,"G"=>0,"B"=>0));

/* Draw the chart scale */  
$myPicture->setGraphArea(300,30,740,680);
$myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Pos"=>SCALE_POS_TOPBOTTOM));

/* Turn on shadow computing */  
$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 

/* Draw the chart */  
$myPicture->drawBarChart(array("DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"Rounded"=>TRUE,"Surrounding"=>30)); 




/* Render the picture (choose the best way) */ 
$myPicture->stroke();

