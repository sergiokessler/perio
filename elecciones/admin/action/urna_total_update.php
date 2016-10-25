<?php

# vim: set fileencoding=ISO-8859-1

if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
} 

require_once 'lib/data_utils.php';


$this_table = 'urna_total';
$this_table_label = 'Votos de una Urna y Lista';
$this_primary_key = 'urna_total_id';
$this_seq = 'urna_total_urna_total_id_seq';
$this_action = 'urna_total_update';
$this_continue = 'urna_total_list';
$this_icon = '<span class="glyphicon glyphicon-folder-close"></span>'; 

// <query> 


include 'action/urna_total_form.php';




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

    $sql = "update $this_table set $set where $this_primary_key = ?";

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

    $continue = '?action=' . $this_continue . '&params=' . $params_cont;
}
else
{
    // <UI>
    include_once 'header.php';

    echo '<div class="page-header">';
    echo '  <h1>' . ucfirst($this_table) . ' ' . $record_id . ' <small>Edición</small></h1> (Puede pasar de campo usando la tecla Tab)';
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


