<?php

/*

$Id: export_raw.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/


function is_form_field($field)
{
    $posicion = strpos($field, 'form_');
    
    if ($posicion === false)
        return false;
       
    if ($posicion == 0)
        return true;
    else
        return false;
}



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

if (isset($params['only_form_data'])) {
    $only_form_data = true;
} else {
    $only_form_data = false;
}

//$data = array();




$db = DB::connect($config['db_dsn']) or die('Could connect to DB');


$db->setFetchMode(DB_FETCHMODE_ASSOC);

$res = $db->query($sql, $sql_data);
if (PEAR::isError($res)) {
    die( $res->getDebugInfo() );
}


header('Content-type: application/vnd.ms-excel');
header('Content-disposition:  attachment; filename=' . date('Y-m-d') . '.txt');


// titulos !

$row = $res->fetchRow(DB_FETCHMODE_ASSOC, 0);
foreach ($row as $key => $value)
{
    if (($only_form_data) and (! is_form_field($key))) {
    }
    else {
        echo $key;
        echo "\t";
    }
}
echo "\n";


// data

$i = 0;
while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC, $i)) 
{
    foreach($row as $key => $value)
    {
        if (($only_form_data) and (! is_form_field($key))) {
        }
        else {
            echo $value;
            echo "\t";
        }
    }
    echo "\n";
    $i++;
}
    



?>
