<?php

if (empty($params['record_id'])) {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    die();
} else {
    $record_id = $params['record_id'];
}  

require_once 'lib/data_display.php';

$this_table = 'urna';
$this_primary_key = 'urna_id';
$this_icon = '<span class="glyphicon glyphicon-folder-close"></span>'; 

$sql = <<<END
    select 
        urna_nombre,
        urna_id
    from 
        urna 
    where
        urna_id = ?
END;
$sql_params = array($record_id);




include 'header.php';

unset($params_cont);
$params_cont['record_id'] = $record_id;
$params_cont['continue'] = 'urna';
$params_cont = params_encode($params_cont);

$action1 = "?action=$this_table" . '_update&params=' . $params_cont;
$action2 = "?action=$this_table" . '_delete&params=' . $params_cont; 

echo '<div>';
echo '<h1>' . $this_icon . ' Datos de la ' . $this_table . ' <i><span class="alert alert-warning">' . $record_id . '</i></span></h1>';
echo '<br>';
//echo '<a href="?action=user_change_pass" class="btn btn-default active" role="button">Agregar Usuario</a>'; 
echo '<a href="' . $action1 . '" class="btn btn-default active" role="button">Editar ' . $this_table . '</a> ';
echo '<a href="' . $action2 . '" class="btn btn-default active" role="button">Eliminar ' . $this_table . '</a> ';
echo '<br>';
echo '<br>';
echo '</div>';


$db = new PDO($db_dsn, $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

$st = $db->prepare($sql); 
$st->execute($sql_params);


unset($params);
$params['data'] = $st->fetch(PDO::FETCH_ASSOC);

if (empty($params['data'])) {
    echo ('No se encontraron datos');
} else {
    echo sak_display_array_record($params);
} 


include 'footer.php';


