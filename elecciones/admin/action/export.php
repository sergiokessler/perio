<?php

/*

$Id: export.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/


include_once 'share/check_invariants.php';


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

include 'share/encuesta_field_mapping.php';

$fieldnames = $encuesta_field_labels;
/*
if (isset($params['fieldnames'])) {
    $fieldnames = $params['fieldnames'];
} else {
    echo 'Debe pasar los nombres de los campos. Presione el boton de Atras';
    exit();
}
 */
//$data = array();

//echo '<pre>';
//var_dump ($params);
//echo '</pre>';



$db = DB::connect($config['db_dsn']) or die('Could connect to DB');

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
foreach($fieldnames as $field_name => $field_label)
{
    echo '<th class="listado">';
    echo html_entity_decode($field_label);
    echo '</th>';
    //echo "\t";
}
echo "\n";
echo '</tr></thead>';


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
        
    foreach($fieldnames as $field_name => $field_label)
    {
        echo '<td class="listado">';
        echo $row[$field_name];
        echo '</td>';
        
        echo "\t";
    }
    echo '</tr>';
    //echo "\n";
}
    
echo '</tbody>';
echo '</table>';



?>
