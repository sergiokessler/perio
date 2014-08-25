<?php


$config['db']['phptype']  = 'pgsql';
$config['db']['hostspec'] = 'localhost';
$config['db']['database'] = 'contenido';
$config['db']['username'] = 'contenido';
$config['db']['password'] = 'contenido';


$config['db']['pg_str'] = 'host=' . $config['db']['hostspec'] . ' dbname=' . $config['db']['database'] . ' user=' . $config['db']['username'] . ' password=' . $config['db']['password']; 


$db = pg_connect($config['db']['pg_str']) or die(pg_last_error($db)); 

// seleccionamos las ultimas 3 notas
$sql = "select * from nota where area = 'Instantaneas' and publicar = 'Si' order by prioridad, fecha limit 3";
$result = pg_query($sql);


// ****************************************************
// modificar desde acá para abajo


// esta es la nota 1
$row = pg_fetch_assoc($result);

echo 'Esta es la nota 1:';
echo '<br>';
echo 'usuario: ', $row['usuario'];
echo '<br>';
echo 'Volanta: ', $row['volanta'];
echo '<br>';
echo 'Titulo: ', $row['titulo'];
echo '<br>';
echo 'bajada: ', $row['bajada'];
echo '<br>';
echo 'texto: ', $row['texto'];
echo '<br>';
echo 'nota_interna: ', $row['nota_interna'];
echo '<br>';
echo 'imagen1: ', $row['imagen1'];
echo '<br>';
echo 'imagen1_epigrafe: ', $row['imagen1_epigrafe'];
echo '<br>';
echo 'imagen2: ', $row['imagen2'];
echo '<br>';
echo 'imagen2_epigrafe: ', $row['imagen2_epigrafe'];
echo '<br>';
echo '<br>';
echo '<br>';




// esta es la nota 2
$row = pg_fetch_assoc($result);

echo 'Esta es la nota 2:';
echo '<br>';
echo 'usuario: ', $row['usuario'];
echo '<br>';
echo 'Volanta: ', $row['volanta'];
echo '<br>';
echo 'Titulo: ', $row['titulo'];
echo '<br>';
echo 'bajada: ', $row['bajada'];
echo '<br>';
echo 'texto: ', $row['texto'];
echo '<br>';
echo 'nota_interna: ', $row['nota_interna'];
echo '<br>';
echo 'imagen1: ', $row['imagen1'];
echo '<br>';
echo 'imagen1_epigrafe: ', $row['imagen1_epigrafe'];
echo '<br>';
echo 'imagen2: ', $row['imagen2'];
echo '<br>';
echo 'imagen2_epigrafe: ', $row['imagen2_epigrafe'];
echo '<br>';
echo '<br>';
echo '<br>';


// esta es la nota 3
$row = pg_fetch_assoc($result);

echo 'Esta es la nota 3:';
echo '<br>';
echo 'usuario: ', $row['usuario'];
echo '<br>';
echo 'Volanta: ', $row['volanta'];
echo '<br>';
echo 'Titulo: ', $row['titulo'];
echo '<br>';
echo 'bajada: ', $row['bajada'];
echo '<br>';
echo 'texto: ', $row['texto'];
echo '<br>';
echo 'nota_interna: ', $row['nota_interna'];
echo '<br>';
echo 'imagen1: ', $row['imagen1'];
echo '<br>';
echo 'imagen1_epigrafe: ', $row['imagen1_epigrafe'];
echo '<br>';
echo 'imagen2: ', $row['imagen2'];
echo '<br>';
echo 'imagen2_epigrafe: ', $row['imagen2_epigrafe'];
echo '<br>';


