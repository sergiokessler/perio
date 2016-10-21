<?php

# vim: set fileencoding=ISO-8859-1

if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
} 

require_once 'lib/data_utils.php';
require_once 'lib/password.php';


$params['table'] = 'urna';
$params['primary_key'] = 'urna_id';
$params['action'] = 'urna_update';
$params['continue'] = 'urna';
// <query> 


include 'action/urna_form.php';




if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar')
     and
     ($form->validate()) )
{
    $db = new PDO($db_dsn, $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

    $new_row = cleanup_new_row($_POST['new_row']);



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
    echo '  <h1>Urna ' . $record_id . ' <small>Edición</small></h1> (Puede pasar de campo usando la tecla Tab)';
    echo '</div>';

    echo '<br>';
    echo "\n\n";

 

    // Output javascript libraries, needed by hierselect
    $form->render($renderer);
    echo $renderer->getJavascriptBuilder()->getLibraries(true, true);
    echo $renderer;  
    //echo $form;

    echo '<br>';

    include_once 'footer.php';
}


