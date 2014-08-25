<?php

/*

$Id: premio_insert.php,v 1.4 2007/10/17 18:01:25 develop Exp $

*/


require_once 'DB.php';
require_once 'HTML/QuickForm.php'; 
require_once 'share/data_utils.php';



$params['table'] = 'nota';
$params['primary_key'] = $params['table'] . '_id';
$params['op'] = 'insert';

$user = $_SESSION['u'];

// <query> 



$db = DB::connect($config['db']);
if (PEAR::isError($db)) die($db->getMessage());


$form = new HTML_QuickForm('form', 'post');
$form->addElement('header', 'MyHeader', 'Agregar registro en ' . $params['table'] . ':');
$form->addElement('hidden', 'action', $params['table'] . '_insert');
$form->addElement('hidden', 'params', $params_fa);
include 'action/nota_form.php';




if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar')
     and
     ($form->validate()) )
{

    $new_row = cleanup_new_row($_POST['new_row']);
    $new_row['usuario'] = $_SESSION['u'];

//    $new_row['fecha'] = get_fecha($new_row['fecha']);

    // ----- begin imagenes
    $prefix = date('Y') . date('m') . date('d') . '_';

    if(is_uploaded_file($_FILES['imagen1']['tmp_name']))
    {
        $tmp_name = $_FILES['imagen1']['tmp_name'];
        $name = 'img/' . $prefix . $_FILES['imagen1']['name'];
        move_uploaded_file($tmp_name, $name);
        $new_row['imagen1'] = $name;
    }

    if(is_uploaded_file($_FILES['imagen2']['tmp_name']))
    {
        $tmp_name = $_FILES['imagen2']['tmp_name'];
        $name = 'img/' . $prefix . $_FILES['imagen2']['name'];
        move_uploaded_file($tmp_name, $name);
        $new_row['imagen2'] = $name;
    }
    // ----- end imagenes


    $res = $db->autoExecute($params['table'], $new_row, DB_AUTOQUERY_INSERT);
    if (PEAR::isError($res)) die($res->getDebugInfo());
    $msg = "El registro a sido cargado satisfactoriamente.";

                                  
    unset($params_cont);
    $params_cont['msg'] = $msg;
    $params_cont = params_encode($params_cont);

    $continue = 'action=' . $params['table'] . '&params=' . $params_cont;
}
else
{
    // <UI>
    include_once 'header.php';
    if (isset($params['msg']))
        echo $params['msg'];
    echo '<br>';
    $form->display();
    include_once 'footer.php';
}


?>
