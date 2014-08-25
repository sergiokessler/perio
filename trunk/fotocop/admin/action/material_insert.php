<?php

require_once 'share/data_utils.php';


$params['action']       = 'material_insert';
$params['continue']     = 'material_select';
$params['table']        = 'material';
$params['primary_key']  = 'material_id';
$params['seq']          = $params['table'] . '_' . $params['primary_key'] . '_seq';


include 'action/material_form.php';



/***************************************************
 * processing
 ***************************************************/


if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar')
     and
     ($form->validate()) )
{

    $new_row = cleanup_new_row($_POST['new_row']);

    $file =& $form->getElement('file');
    if ($file->isUploadedFile()) {
        $fileinfo = $file->getValue();
        $filename = md5($fileinfo['name']) . '.pdf';
        if ($file->moveUploadedFile($config['app_root'] . "/files" , $filename)) {
            $new_row['archivo'] = $filename;
        } else {
            die('Error subiendo archivo');
        }
    }


    $cols = implode(', ', array_keys($new_row));
    $vals = implode(', ', array_fill(0, count($new_row), '?'));

    $sql = "insert into $params[table] ($cols) values ($vals)";
    $sql_data = array_values($new_row);

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
    $continue = 'action=' . $params['continue'] . '&params=' . $params_cont;
    return;
}



// <UI>
include_once 'header.php';
echo '<h2>Ingreso de Material</h2>';
echo $form;
include_once 'footer.php';


