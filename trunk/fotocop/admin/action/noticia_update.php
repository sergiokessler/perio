<?php


if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
}

require_once 'share/data_utils.php';


$params['table'] = 'noticia';
$params['primary_key'] = 'noticia_id';
$params['action'] = 'noticia_update';
$params['continue'] = 'noticia_select';

// <query> 

$sql_record1 = <<<END
    select
        *
    from
        $params[table]
    where
        $params[primary_key] = ?
END;


require_once 'HTML/QuickForm.php'; 
include 'action/form_common.php';

$form_params = params_encode($params);
$form = new HTML_QuickForm('form', 'post');
$form->addElement('hidden', 'action', $params['action']);
$form->addElement('hidden', 'params', $form_params);
$form->addElement('text',   'new_row[titulo]', ' Título:', $campo_largo);
$form->addElement('textarea',   'new_row[texto]', ' Texto:', $textarea_options);

$form->addRule('new_row[titulo]', 'Valor requerido', 'required');
$form->addRule('new_row[texto]', 'Valor requerido', 'required');

$form->addElement('submit', 'btnSubmit', 'Guardar');
 


// defaults del form

$db = new PDO($config['db']['dsn']); 
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$st = $db->prepare($sql_record1); 
$st->execute(array($record_id));

$edit_row = $st->fetch(PDO::FETCH_ASSOC);
    
foreach($edit_row as $key => $value)
{
    $defaults['new_row['.$key.']'] = stripslashes($value);
}

$form->setDefaults($defaults);


/*
 * Un usuario solo puede modificar lo cargado por el mismo
 * excepto saludymedios
 */
/*
if ( ($_SESSION['u'] != 'saludymedios') and ($_SESSION['u'] != $edit_row['carga_usuario']) ) {
    echo 'Ud. no puede editar este registro, fué cargado por otra persona. Presione el boton de Atras';
    exit();
}
*/



if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar')
     and
     ($form->validate()) )
{

    $new_row = cleanup_new_row($_POST['new_row']);

    $set = implode('=?, ', array_keys($new_row));
    $set .= '=?';

    $sql = "update $params[table] set $set where $params[primary_key] = ?";

    $sql_data = array_values($new_row);
    $sql_data[] = $record_id;

    $db = new PDO($config['db']['dsn']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st = $db->prepare($sql);
    $st->execute($sql_data);

    
    $msg = "El registro ha sido actualizado satisfactoriamente.";

                                  
    unset($params_cont);
    $params_cont['msg'] = $msg;
    $params_cont['record_id'] = $edit_row[$params['primary_key']];
    $params_cont = params_encode($params_cont);

    $continue = 'action=' . $params['continue'] . '&params=' . $params_cont;
    return;
}


// <UI>
include_once 'header.php';
echo '<h2>Editanto la Noticia</h2>';
$form->display();
include_once 'footer.php';


