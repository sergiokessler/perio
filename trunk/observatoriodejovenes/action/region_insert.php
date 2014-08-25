<?php


require_once 'HTML/QuickForm2.php'; 
require_once 'share/data_utils.php';


$params['table'] = 'region';
$params['primary_key'] = 'region_id';
$params['action'] = 'region_insert';
$params['continue'] = 'region_list';



include 'action/region_form.php';



if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar')
     and
     ($form->validate()) )
{

    $new_row = cleanup_new_row($_POST['new_row']);

    $new_row['carga_usuario'] = $_SESSION['u'];
    $new_row['carga_fecha'] = date('Y-m-d h:i');


    /****************************************************************
     * insert the record
     */
    $cols = implode(', ', array_keys($new_row));
    $vals = implode(', ', array_fill(0, count($new_row), '?'));

    $sql = "insert into $params[table] ($cols) values ($vals)";
    $sql_data = array_values($new_row);

    echo $config['db']['dsn'];
    $db = new PDO($config['db']['dsn']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st = $db->prepare($sql);
    $st->execute($sql_data);
    
    $msg = "El registro a sido ingresado satisfactoriamente.";

    $record_id = $db->lastInsertId();  
    /*
     * end insert the record
     ****************************************************************/


    unset($params_cont);
    $params_cont['msg'] = $msg;
    $params_cont['record_id'] = $record_id;
    $params_cont = params_encode($params_cont);

    $continue = '?action=' . $params['continue'] . '&params=' . $params_cont;
}
else
{
    // <UI>
    include_once 'header.php';

    echo '<div class="page-header">';
    echo '  <h1>Región<small> Agregar un registro</small></h1>';
    echo '</div>';


    echo $form;
    
    include_once 'footer.php';
}


