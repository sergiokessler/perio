<?php

/*

$Id: export.php,v 1.1 2007/10/10 17:15:47 develop Exp $

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

if (isset($params['field_mapping'])) {
    $fieldnames = $params['field_mapping'];
}
//$data = array();

//echo '<pre>';
//var_dump ($params);
//echo '</pre>';



$db = DB::connect($config['db']) or die('Could not connect to DB');
//$db->setFetchMode(DB_FETCHMODE_ASSOC);

$res = $db->query($sql, $sql_data);
if (PEAR::isError($res)) {
    die( $res->getDebugInfo() );
}


header('Content-type: application/vnd.ms-excel');
header('Content-disposition: attachment; filename=' . date('Y-m-d_H-i-s') . '.xls');



$i = 0;
while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
{
    // titulos ---------------------
    if ($i == 0)
    {
        echo '<table class="listado" border="1">';
        echo '<thead><tr class="title">';
        foreach ($row as $key => $value)
        {
            echo '<th class="listado">';
            if (isset($fieldnames[$key])) {
                $field_label = $fieldnames[$key];
            } else {
                $field_label = $key;
            }
            echo html_entity_decode($field_label);
            echo '</th>';
            //echo "\t";
        }
        echo "\n";
        echo '</tr></thead>';
        echo '<tbody>';
    }
    // end titulos ------------------

    if ($i % 2)
        $tr_style = 'f1';
    else
        $tr_style = 'f2';
    $i++;
    
    echo '<tr class="' . $tr_style . '">';
        
    foreach ($row as $key => $value)
    {
        echo '<td class="listado">';
        echo $value;
        echo '</td>';        
    }
    echo '</tr>';
    //echo "\n";
}
    
echo '</tbody>';
echo '</table>';



?>
