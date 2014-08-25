<?php

include 'config.php';

$sql = 'select nota_id, fecha from nota';

$sql_upd = "update nota set fecha = ? where nota_id = ?";


$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$st = $db->prepare($sql); 
$st->execute(); 

$data = $st->fetchAll(PDO::FETCH_ASSOC); 

foreach ($data as $r) {

    echo $r['fecha'];

    $fecha = date('Y-m-d', strtotime($r['fecha']));


    /***********************************************************
     * update the record
     **/

    $sql_data = array();
    $sql_data[] = $fecha;
    $sql_data[] = $r['nota_id'];

    $st = $db->prepare($sql_upd);
    $st->execute($sql_data);

    /**
     ***********************************************************/

    echo ' => ';
    echo $fecha;
    echo '<br>';
}


