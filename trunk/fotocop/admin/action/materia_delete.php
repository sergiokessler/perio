<?php


if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
}

require_once 'share/data_utils.php';
include_once 'share/data_display.php';


$params['action']       = 'materia_delete';
$params['continue']     = 'materia';
$params['table']        = 'materia';
$params['primary_key']  = 'materia_id';
$params['seq']          = $params['table'] . '_' . $params['primary_key'] . '_seq';
 
// <query> 

$sql_record1 = <<<END
    select
        *
    from
        $params[table]
    where
        $params[primary_key] = ?
END;




if ( (isset($_POST['btnSubmit']))
     and
     ($_POST['btnSubmit'] == 'Confirmar borrado') )
{
    $sql = "delete from $params[table] where $params[primary_key] = ?";
    $sql_data = array($record_id);
    
    $db = new PDO($config['db']['dsn']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

    $st = $db->prepare($sql);
    $st->execute($sql_data);
    
    $msg = 'El registro a sido borrado satisfactoriamente.'; 
    
    unset($params_cont);
    $params_cont['msg'] = $msg;
    $params_cont = params_encode($params_cont);

    $continue = 'action=' . $params['continue'] . '&params=' . $params_cont;
    return;
}

// <UI>
include_once 'header.php';


$link_title = 'Volver';
$link_url = 'javascript:history.go(-1)';
echo '<br>';
echo '<br>';
echo "<a href=\"$link_url\">$link_title</a>";
echo '<br>';

unset($params_rec);

$db = new PDO($config['db']['dsn']); 
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$st = $db->prepare($sql_record1); 
$st->execute(array($record_id));

$params_rec['data'] = $st->fetch(PDO::FETCH_ASSOC);
echo sak_display_array_record($params_rec);

echo '<form method="post">';
echo '<input type="hidden" name="record_id" value="'.$record_id.'">';
echo '<input type="submit" name="btnSubmit" value="Confirmar borrado">';
echo '</form>';

include_once 'footer.php';


