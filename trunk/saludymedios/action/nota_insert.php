<?php

/*

$Id: premio_insert.php,v 1.4 2007/10/17 18:01:25 develop Exp $

*/


require_once 'DB.php'; 
require_once 'HTML/QuickForm.php'; 
require_once 'share/data_utils.php';


$params['table'] = 'nota';
$params['primary_key'] = 'nota_id';
$params['action'] = 'nota_insert';
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


$form->setDefaults(array(
    'new_row[fecha]' => $date_defaults,
));


$form->addRule('medioyseccion', 'Valor requerido', 'required');
$form->addRule('new_row[fecha]', 'Valor requerido', 'required');
$form->addRule('new_row[palabras_clave]', 'Valor requerido', 'required');
$form->addRule('new_row[pagina]', 'Valor requerido', 'required');
$form->addRule('new_row[clasificacion]', 'Valor requerido', 'required');
$form->addRule('new_row[contenido]', 'Valor requerido', 'required');


$form->addElement('submit', 'btnSubmit', 'Guardar');


// defaults del form

/*
$form->setDefaults(array(
    'agenda_fecha_hora' => $date_defaults,
));
*/

// defaults



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


    $db = DB::connect($config['db']);

    $res = $db->autoExecute($params['table'], $new_row, DB_AUTOQUERY_INSERT);
    $msg = "El registro a sido cargado satisfactoriamente.";

    $lastval = $db->getRow('select lastval() as record_id'); 
    $record_id = $lastval[0];

    unset($params_cont);
    $params_cont['msg'] = $msg;
    $params_cont['record_id'] = $record_id;
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
