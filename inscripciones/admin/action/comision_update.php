<?php

/*

$Id$

*/


require_once 'share/data_manage.php';

$params['table'] = 'comision';
$params['primary_key'] = 'id';
$params['op'] = 'update';

// <query> 

$field_meta['type']['update']['id'] = 'hidden';

$field_meta['lookup']['materia_id']['sql'] = "select id, nombre from materia where habilitada = 'SI' order by nombre";

$field_meta['options']['dia']['Lunes'] = 'Lunes';
$field_meta['options']['dia']['Martes'] = 'Martes';
$field_meta['options']['dia']['Miercoles'] = 'Miercoles';
$field_meta['options']['dia']['Jueves'] = 'Jueves';
$field_meta['options']['dia']['Viernes'] = 'Viernes';
$field_meta['options']['dia']['Sabado'] = 'Sabado';

$form =& sak_record_form($params, $field_meta);

$header = $form->createElement('header', 'MyHeader', 'Editando registro en ' . $params['table'] . ':');
$form->insertElementBefore($header, 'op');
$form->addElement('hidden', 'action', $params['table'] . '_update');
$form->addElement('submit', 'btnSubmit', 'Guardar');




if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar')
     and
     ($form->validate()) )
{                            
    $msg = $form->process('sak_record_form_process', false);
                                  
    unset($params_cont);
    $params_cont['msg'] = $msg;
    $params_cont['record_id'] = $params['record_id'];
    $params_cont = params_encode($params_cont);

    $continue = 'action=' . $params['table'] . '_select&params=' . $params_cont;
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
