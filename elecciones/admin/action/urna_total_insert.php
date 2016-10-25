<?php

# vim: set fileencoding=ISO-8859-1 


require_once 'lib/data_utils.php';


$this_table = 'urna_total';
$this_table_label = 'Votos de una Urna y Lista';
$this_primary_key = 'urna_total_id';
$this_seq = 'urna_total_urna_total_id_seq';
$this_action = 'urna_total_insert';
$this_continue = 'urna_total_list';
$this_icon = '<i class="fa fa-envelope-open"></i>';

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



    /****************************************************************
     * insert the record
     */
    $cols = implode(', ', array_keys($new_row));
    $vals = implode(', ', array_fill(0, count($new_row), '?'));

    $sql = "insert into $this_table ($cols) values ($vals)";
    $sql_data = array_values($new_row);

    $st = $db->prepare($sql);
    $st->execute($sql_data);
    
    $msg = "El registro ha sido ingresado satisfactoriamente.";
    $record_id = $db->lastInsertId($this_seq);
    /*
     * end insert the record
     ****************************************************************/


    unset($params_cont);
    $params_cont['msg'] = $msg;
    $params_cont['record_id'] = $record_id;
    $params_cont = params_encode($params_cont);

    $continue = '?action=' . $this_continue . '&params=' . $params_cont;
}
else
{
    // <UI>
    include 'header.php';

    echo '<div class="page-header">';
    echo '  <h1>' . $this_table_label . ' <small>Ingresando un registro</small></h1> (Puede pasar de campo usando la tecla Tab)';
    echo '</div>';

    echo '<br>';
    echo "\n\n";


    // Output javascript libraries, needed by hierselect
    $form->render($renderer);
    echo $renderer->getJavascriptBuilder()->getLibraries(true, true);
    echo $renderer;  
    //echo $form;

    echo '<br>';

    include 'footer.php';
}

