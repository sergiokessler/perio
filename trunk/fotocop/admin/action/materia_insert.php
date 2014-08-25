<?php

require_once 'HTML/QuickForm.php'; 
require_once 'share/data_utils.php'; 


$params['action']       = 'materia_insert';
$params['continue']     = 'materia_select';
$params['table']        = 'materia';
$params['primary_key']  = 'materia_id';
$params['seq']          = $params['table'] . '_' . $params['primary_key'] . '_seq';


$form_params = params_encode($params);

include 'share/form_common.php';

$form = new HTML_QuickForm('form', 'post');
$form->addElement('hidden', 'action', $params['action']);
$form->addElement('hidden', 'params', $form_params);
$form->addElement('text',   'new_row[nombre]', ' Nombre:', $campo_largo);
$form->addElement('submit', 'btnSubmit', 'Guardar');

$form->addRule('new_row[nombre]', 'Valor requerido', 'required');



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


    unset($params_cont);
    $params_cont['msg'] = $msg;
    $params_cont['record_id'] = $record_id;
    $params_cont = params_encode($params_cont);
    $continue = 'action=' . $params['continue'] . '&params=' . $params_cont;
    return;
}



// <UI>
include_once 'header.php';
echo '<h2>Ingreso de Materia</h2>';
$form->display();
include_once 'footer.php';
 

