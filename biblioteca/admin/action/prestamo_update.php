<?php


if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
}

require_once 'HTML/QuickForm2.php'; 
require_once 'share/data_utils.php';


$params['table'] = 'prestamo';
$params['primary_key'] = 'prestamo_id';
$params['action'] = 'prestamo_update';
$params['continue'] = 'prestamo_select';
// <query> 



include 'action/prestamo_form.php';





if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar')
     and
     ($form->validate()) )
{

    $new_row = cleanup_new_row($_POST['new_row']);

    //$new_row['carga_fecha'] = date('Y-m-d H:i');


    /***********************************************************
     * update the record
     **/
    $set = implode('=?, ', array_keys($new_row));
    $set .= '=?';

    $sql = "update $params[table] set $set where $params[primary_key] = ?";

    $sql_data = array_values($new_row);
    $sql_data[] = $record_id;

    $st = $db->prepare($sql);
    $st->execute($sql_data);
    /**
     ***********************************************************/
    
    
    $msg = "El registro a sido actualizado satisfactoriamente.";

                                  
    $params_cont = null;
    $params_cont['msg'] = $msg;
    $params_cont['record_id'] = $record_id;

    $continue = '?action=' . $params['continue'] . '&params=' . params_encode($params_cont);
}
else
{
    // <UI>
    include_once 'header.php';

    echo '<div class="page-header">';
    echo '  <h1>Nota <small>Editando un registro</small></h1>';
    echo '</div>';

    // Output javascript libraries, needed by hierselect
    //echo $renderer->getJavascriptBuilder()->getLibraries(true, true);
    $form->render($renderer);
    echo $renderer;


    include_once 'footer.php'; 
}


