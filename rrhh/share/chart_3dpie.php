<?php


function params_decode($params)
{
    return(unserialize(gzuncompress(base64_decode(rawurldecode($params)))));
} 

$chart_params = params_decode($_GET['params']);



/* pChart library inclusions */ 
include("pchart/class/pData.class.php"); 
include("pchart/class/pDraw.class.php"); 
include("pchart/class/pPie.class.php"); 
include("pchart/class/pImage.class.php"); 

/* Create and populate the pData object */
$MyData = new pData();

foreach($chart_params['data'] as $dp) {
    $MyData->addPoints($dp[$chart_params['ejex']], "ejex");
    $MyData->addPoints($dp[$chart_params['ejey']], "ejey");
}

$MyData->setSerieDescription("ejey", $chart_params['ejey']);

/* Define the absissa serie */ 
$MyData->setAbscissa("ejex");

//$MyData->loadPalette("pchart/palettes/navy.color", TRUE);


/* Create the pChart object */ 
$myPicture = new pImage(720,380,$MyData,TRUE); 

/* Set the default font properties */  
$myPicture->setFontProperties(array("FontName"=>"pchart/fonts/verdana.ttf","FontSize"=>16,"R"=>0,"G"=>0,"B"=>200));

/* Create the pPie object */  
$PieChart = new pPie($myPicture,$MyData); 

/* Enable shadow computing */  
$myPicture->setShadow(TRUE,array("X"=>3,"Y"=>3,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 

/* Draw a splitted pie chart */  
$PieChart->draw3DPie(290,200,array("WriteValues"=>PIE_VALUE_PERCENTAGE,"Radius"=>240,"DataGapAngle"=>12,"DataGapRadius"=>10,"Border"=>TRUE,"ValueR"=>10,"ValueG"=>10,"ValueB"=>10));

/* Write the legend box */  
$myPicture->setFontProperties(array("FontName"=>"pchart/fonts/verdana.ttf","FontSize"=>12,"R"=>0,"G"=>0,"B"=>0)); 
$PieChart->drawPieLegend(520,15,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_VERTICAL)); 

/* Render the picture (choose the best way) */ 
$myPicture->stroke();


