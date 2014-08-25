<?php

require_once 'HTML/QuickForm.php'; 
require_once 'share/data_utils.php';


$params['action']       = 'noticia_insert';
$params['continue']     = 'noticia_select';
$params['table']        = 'noticia';
$params['primary_key']  = 'noticia_id';
$params['seq']          = $params['table'] . '_' . $params['primary_key'] . '_seq';


$form_params = params_encode($params);

include 'share/form_common.php';

$form = new HTML_QuickForm('form', 'post');
$form->addElement('hidden', 'action', $params['action']);
$form->addElement('hidden', 'params', $form_params);
$form->addElement('text',   'new_row[titulo]', ' Título:', $campo_largo);
$form->addElement('textarea',   'new_row[texto]', ' Texto:', $textarea_options);

$form->addRule('new_row[titulo]', 'Valor requerido', 'required');
$form->addRule('new_row[texto]', 'Valor requerido', 'required');


$form->setDefaults(array(
//    'new_row[fecha]' => $date_defaults,
));

$form->addElement('submit', 'btnSubmit', 'Guardar');



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
echo '<h2>Ingreso de Noticias</h2>';
$form->display();
include_once 'footer.php';


