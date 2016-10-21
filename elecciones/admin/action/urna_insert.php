<?php

# vim: set fileencoding=ISO-8859-1 


require_once 'lib/data_utils.php';


$params['table'] = 'urna';
$params['primary_key'] = 'urna_id';
$params['action'] = 'urna_insert';
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



    /****************************************************************
     * insert the record
     */
    $cols = implode(', ', array_keys($new_row));
    $vals = implode(', ', array_fill(0, count($new_row), '?'));

    $sql = "insert into $params[table] ($cols) values ($vals)";
    $sql_data = array_values($new_row);

    $st = $db->prepare($sql);
    $st->execute($sql_data);
    
    $msg = "El registro ha sido ingresado satisfactoriamente.";
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
    include 'header.php';

    echo '<div class="page-header">';
    echo '  <h1>' . ucfirst($params['table']) . '<small>Ingresando un registro</small></h1> (Puede pasar de campo usando la tecla Tab)';
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


