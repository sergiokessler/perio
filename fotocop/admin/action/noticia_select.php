<?php


if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
} 


$sql_record1 = <<<END
    select 
        *
    from 
        noticia
    where
        noticia_id = ?
END;



$params['table'] = 'noticia';


include_once 'share/data_display.php';
include_once 'header.php';

$link_url = 'index.php?action=noticia_insert';
$link_label = 'Ingresar noticia';
echo "<a href=\"$link_url\">$link_label</a>"; 
echo ' | ';
$link_url = 'index.php?action=noticia_search';
$link_label = 'Búsqueda de noticias';
echo "<a href=\"$link_url\">$link_label</a>"; 


echo '<br>'; 
echo '<br>';

unset($params_upd);
$params_upd['record_id'] = $params['record_id'];
$params_upd = params_encode($params_upd); 

if ((isset($params['record_id'])))
{
    $update_title = 'Editar este registro';
    $update_url = 'index.php?action=' . $params['table'] . '_update&params=' . $params_upd;
    echo "<a href=\"$update_url\">$update_title</a>";
    echo '<br>';

    unset($params_rec);
    
    $db = new PDO($config['db']['dsn']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st = $db->prepare($sql_record1);
    $st->execute(array($record_id));

    $params_rec['data'] = $st->fetch(PDO::FETCH_ASSOC);
    echo sak_display_array_record($params_rec);

    $delete_title = 'Borrar este registro';
    $delete_url = 'index.php?action=' . $params['table'] . '_delete&params=' . $params_upd;
    echo "<a href=\"$delete_url\">$delete_title</a>";
    echo '<br>';
}


include_once 'footer.php';


