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

require_once 'DB.php'; 
require_once 'HTML/QuickForm.php'; 
require_once 'share/data_utils.php';


$params['table'] = 'nota';
$params['primary_key'] = 'nota_id';
$params['action'] = 'nota_update';
$params['continue'] = 'nota';
// <query> 


include 'action/nota_form.php';

$form_params = params_encode($params);
$form = new HTML_QuickForm('form', 'post');
$form->addElement('header', 'MyHeader', 'Agregar registro en ' . $params['table'] . ':');
$form->addElement('hidden', 'action', $params['action']);
$form->addElement('hidden', 'params', $form_params);

$sel =& $form->addElement('hierselect', 'medioyseccion', 'Medio:', null, ' <strong>Sección: </strong>');
$sel->setOptions(array($medio_select, $seccion_select));

$form->addElement('date',   'new_row[fecha]', 'Fecha:', $date_options);
$form->addElement('text',   'new_row[palabras_clave]', 'Palabras clave:', $campo_largo);
$form->addElement('text',   'new_row[pagina]', 'Página:', $campo_corto);
$form->addElement('select', 'new_row[tapa]', 'Tapa:', $boolean_select);
$form->addElement('select', 'new_row[clasificacion]', 'Clasificacion:', $clasificacion_select);
$form->addElement('text',   'new_row[titulo]', 'Título:', $campo_largo);
$form->addElement('select', 'new_row[contenido]', 'Contenido:', $contenido_select);
$form->addElement('select', 'new_row[fuente]', 'Fuente:', $fuente_select);

$form->addElement('submit', 'btnSubmit', 'Guardar');

$form->addRule('medioyseccion', 'Valor requerido', 'required');
$form->addRule('new_row[fecha]', 'Valor requerido', 'required');
$form->addRule('new_row[palabras_clave]', 'Valor requerido', 'required');
$form->addRule('new_row[pagina]', 'Valor requerido', 'required');
$form->addRule('new_row[clasificacion]', 'Valor requerido', 'required');
$form->addRule('new_row[contenido]', 'Valor requerido', 'required');



// defaults del form

$db = DB::connect($config['db']);
if (PEAR::isError($db)) die($db->getMessage());

$edit_sql = 'select * from ' . $params['table'] . ' where ' . $params['primary_key'] . ' = ?';
$edit_sql_data = array($record_id);
$edit_row = $db->getRow($edit_sql, $edit_sql_data, DB_FETCHMODE_ASSOC);
    
foreach($edit_row as $key => $value)
{
    $defaults['new_row['.$key.']'] = stripslashes($value);
}

$defaults['medioyseccion'] = array($edit_row['medio'], $edit_row['seccion']);

$form->setDefaults($defaults);


/*
 * Un usuario solo puede modificar lo cargado por el mismo
 * excepto saludymedios
 */

if ( ($_SESSION['u'] != 'saludymedios') and ($_SESSION['u'] != $edit_row['carga_usuario']) ) {
    echo 'Ud. no puede editar este registro, fué cargado por otra persona. Presione el boton de Atras';
    exit();
}




if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar')
     and
     ($form->validate()) )
{

    $new_row = cleanup_new_row($_POST['new_row']);

    $new_row['medio'] = $_POST['medioyseccion'][0];
    $new_row['seccion'] = $_POST['medioyseccion'][1];

    $new_row['carga_usuario'] = $_SESSION['u'];
    $new_row['carga_fecha'] = date('Y-m-d h:i');


    $res = $db->autoExecute($params['table'], $new_row, DB_AUTOQUERY_UPDATE, "$params[primary_key] = $record_id");
    if (PEAR::isError($res)) die($res->getMessage());
    $msg = "El registro a sido actualizado satisfactoriamente.";

                                  
    unset($params_cont);
    $params_cont['msg'] = $msg;
    $params_cont['record_id'] = $edit_row[$params['primary_key']];
    $params_cont = params_encode($params_cont);

    $continue = 'action=' . $params['continue'] . '&params=' . $params_cont;
}
else
{
    // <UI>
    include_once 'header.php';
    $form->display();
    include_once 'footer.php';
}


?>
