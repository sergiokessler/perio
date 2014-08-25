<?php

/*

$Id: export.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/


require_once 'DB.php';

if (isset($params['sql'])) {
    $sql = $params['sql'];
} else {
    echo 'Debe pasar la consulta. Presione el boton de Atras';
    exit();
}

if (isset($params['sql_data'])) {
    $sql_data = $params['sql_data'];
} else {
    echo 'Debe pasar los datos de la consulta. Presione el boton de Atras';
    exit();
}

//$data = array();

//echo '<pre>';
//var_dump ($params);
//echo '</pre>';



$db = DB::connect($config['db']) or die('Cannot connect to DB');

$db->setFetchMode(DB_FETCHMODE_ASSOC);

$res = $db->query($sql, $sql_data);
if (PEAR::isError($res)) {
    die( $res->getDebugInfo() );
}


header('Content-type: application/vnd.ms-excel');
header('Content-disposition: attachment; filename=' . date('Y-m-d_H-i-s') . '.xls');


echo '<table class="listado" border="1">';
echo '<thead><tr class="title">';

// titulos !
$row = $res->fetchRow(DB_FETCHMODE_ASSOC, 0);
foreach ($row as $key => $value)
{
    echo '<th class="listado">';
    echo html_entity_decode($key);
    echo '</th>';
}
echo "\n"; 
echo '</tr></thead>';


// data !
echo '<tbody>';

$i = 0;
while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
{
    if ($i % 2)
        $tr_style = 'f1';
    else
        $tr_style = 'f2';
    $i++;
        
    echo '<tr class="' . $tr_style . '">';
        
    foreach($row as $key => $value)
    {
        echo '<td class="listado">';
        echo $value;
        echo '</td>';
        
        echo "\t";
    }
    echo '</tr>';
    //echo "\n";
}
    
echo '</tbody>';
echo '</table>';



?>
