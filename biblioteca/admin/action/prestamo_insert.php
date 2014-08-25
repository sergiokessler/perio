<?php

require_once 'HTML/QuickForm2.php'; 
require_once 'share/data_utils.php';


$params['action']       = 'prestamo_insert';
$params['continue']     = 'prestamo_select';
$params['table']        = 'prestamo';
$params['primary_key']  = 'prestamo_id';
$params['seq']          = $params['table'] . '_' . $params['primary_key'] . '_seq';


$form_params = params_encode($params);

include 'share/form_common.php';
include 'action/prestamo_form.php';



/***************************************************
 * processing
 *
 */

if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar')
     and
     ($form->validate()) )
{

    $new_row = cleanup_new_row($_POST['new_row']);


    $cols = implode(', ', array_keys($new_row));
    $vals = implode(', ', array_fill(0, count($new_row), '?'));

    $sql = "insert into $params[table] ($cols) values ($vals)";
    $sql_data = array_values($new_row);

    $db = new PDO($config['db']['dsn']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st = $db->prepare($sql);
    $st->execute($sql_data);
    
    $msg = "El registro ha sido ingresado satisfactoriamente.";

    $record_id = $db->lastInsertId($params['seq']); 

/*
    echo '<pre>';
    var_dump($record_id);
    var_dump($qry);
    echo '</pre>';
    die();
*/    
    unset($params_cont);
    $params_cont['msg'] = $msg;
    $params_cont['record_id'] = $record_id;
    $params_cont = params_encode($params_cont);
    $continue = '?action=' . $params['continue'] . '&params=' . $params_cont;
    return;
}



// <UI>
include_once 'header.php';

    echo '<div class="page-header">';
    echo '  <h1>Préstamos <small>Agregar un registro</small></h1>';
    echo '</div>'; 

    // Output javascript libraries, needed by hierselect
    //echo $renderer->getJavascriptBuilder()->getLibraries(true, true);
    $form->render($renderer); 

    echo $renderer; 
 
include_once 'footer.php';


