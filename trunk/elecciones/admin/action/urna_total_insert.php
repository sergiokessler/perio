<?php

/*

$Id: premio_insert.php,v 1.4 2007/10/17 18:01:25 develop Exp $

*/


require_once 'share/data_manage.php';
require_once 'share/data_utils.php';

$params['table'] = 'urna_total';
$params['primary_key'] = $params['table'] . '_id';
$params['op'] = 'insert';

// <query> 



$field_meta['type']['insert'][$params['primary_key']] = 'disable';
$field_meta['type']['update'][$params['primary_key']] = 'hidden';
$field_meta['type']['insert']['fecha_hora'] = 'disable';
$field_meta['select']['lista_id']['sql'] = 'select lista_id, lista_nombre from lista order by lista_nombre';
$field_meta['select']['urna_id']['sql'] = 'select urna_id, urna_nombre from urna order by urna_nombre';

/*
$field_meta['defaults']['fecha_desde'] = $date_defaults;
$field_meta['defaults']['fecha_hasta'] = $date_defaults;
//$field_meta['type']['insert']['producto_codigo'] = 'disable';
//$field_meta['type']['update']['producto_codigo'] = 'hidden';
$field_meta['select']['activa']['data']['1'] = 'Si';
$field_meta['select']['activa']['data']['0'] = 'No';
$field_meta['select']['en_total']['data']['1'] = 'Si';
$field_meta['select']['en_total']['data']['0'] = 'No';
$field_meta['select']['en_porcentaje']['data']['1'] = 'Si';
$field_meta['select']['en_porcentaje']['data']['0'] = 'No';
 */


$form =& sak_record_form($params, $field_meta);

$header = $form->createElement('header', 'MyHeader', 'Agregar registro en ' . $params['table'] . ':');
$form->insertElementBefore($header, 'op');
$form->addElement('hidden', 'action', $params['table'] . '_insert');
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

    $db = DB::connect($config['db']);
    if (PEAR::isError($db)) die($db->getMessage());

    $res = $db->autoExecute($params['table'], $new_row, DB_AUTOQUERY_INSERT);
    if (PEAR::isError($res)) die($res->getMessage());
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
    echo '<br>';
    $form->display();
    include_once 'footer.php';
}


?>
