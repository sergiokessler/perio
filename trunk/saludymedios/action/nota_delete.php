<?php

/*

$Id: premio_insert.php,v 1.4 2007/10/17 18:01:25 develop Exp $

*/

if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
}

$sql_record1 = <<<END
    select 
        *
    from 
        nota
    where
        nota_id = ?
END;


require_once 'DB.php';
require_once 'HTML/QuickForm.php';
require_once 'share/data_utils.php';
include_once 'share/data_display.php';


$params['table'] = 'nota';
$params['primary_key'] = 'nota_id';
$params['action'] = 'nota_delete';
$params['continue'] = 'nota_search';
// <query> 


include 'action/nota_form.php';

$form_params = params_encode($params);
$form = new HTML_QuickForm('form', 'post');
//$form->addElement('header', 'MyHeader', 'Borrar registro en ' . $params['table'] . ':');
$form->addElement('hidden', 'action', $params['action']);
$form->addElement('hidden', 'params', $form_params);

$form->addElement('submit', 'btnSubmit', 'Confirmar borrado');



// defaults del form

$db = DB::connect($config['db']);
if (PEAR::isError($db)) die($db->getMessage());



if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Confirmar borrado')
     and
     ($form->validate()) )
{

    $new_row = cleanup_new_row($_POST['new_row']);

    $res = $db->query("delete from $params[table] where $params[primary_key] = ?", array($record_id));
    if (PEAR::isError($res)) die($res->getMessage());

    $params_cont['msg'] = "El registro a sido borrado satisfactoriamente.";
    $params_cont = params_encode($params_cont);

    $continue = 'action=' . $params['continue'] . '&params=' . $params_cont;
}
else
{
    // <UI>
    include_once 'header.php';
    $link_url = 'index.php?action=nota_search';
    $link_label = 'Volver a búsqueda de notas';
    echo "<a href=\"$link_url\">$link_label</a>"; 
    echo '<br />';
    echo '<br />';

    unset($params_rec);
    $params_rec['sql_record'] = $sql_record1;
    $params_rec['record_id'] = $params['record_id'];
    echo sak_display_record($params_rec);

    $form->freeze();
    $form->display();
    include_once 'footer.php';
}


?>
