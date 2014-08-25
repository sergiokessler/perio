<?php

include 'header.php';

$sql = <<<END
    select 
        count(*) as cantidad
    from 
        libros
END;
$sql_data = array();

$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$st = $db->prepare($sql);
$st->execute($sql_data);
$data = $st->fetch(PDO::FETCH_ASSOC);


echo '      <div class="hero-unit">';
echo '        <h1>Biblioteca Perio UNLP</h1>';
echo '        <p>Centro de Documentacion Multimedial.</p>';
echo '        <p><br></p>';
echo '        <p>Un total de ' . $data['cantidad'] . ' materiales cargados.';
echo '        <p><br></p>';
echo '        <p><a href="?action=material_last" class="btn btn-primary btn-large">Ver último material cargado</a></p>';
echo '      </div>';
 


include 'footer.php';

