<?php

/*

$Id$

*/


require_once 'share/field_mapping.php';
require_once 'share/data_manage.php';

$params['table'] = 'tpm';
$params['primary_key'] = 'id';
$params['op'] = 'insert';

// <query> 


$date_options = array(
    'language'  => 'es',
    'format'    => 'dMY',
    'minYear'   => 2005,
    'maxYear'   => 2009
);
$date_defaults = array(
    'd' => date('d'),
    'M' => date('m'),
    'Y' => date('Y'),
);

$textarea_options = array(
    'rows' => 2,
    'cols' => 32
);
$campos_cortos = array('size' => 3);
$campos_medios = array('size' => 8);
$campos_largos = array('size' => 64);



$field_meta['options']['fecha_inicio'] = $date_options;
$field_meta['defaults']['fecha_inicio'] = $date_defaults;
$field_meta['type']['insert']['id'] = 'disable';
$field_meta['type']['update']['id'] = 'hidden';

$field_meta['options']['organizacion']['Empresa Chica (PyMe)'] = 'Empresa Chica (PyMe)';
$field_meta['options']['organizacion']['Empresa Mediana (PyMe)'] = 'Empresa Mediana (PyMe)';
$field_meta['options']['organizacion']['Comercio'] = 'Comercio';
$field_meta['options']['organizacion']['ONG'] = 'ONG';
$field_meta['options']['organizacion']['Educación'] = 'Educación';
$field_meta['options']['organizacion']['Estatal'] = 'Estatal';
$field_meta['options']['organizacion']['Otra'] = 'Otra';

$form =& sak_record_form($params, $field_meta, $field_mapping['tpm']);

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
    $msg = $form->process('sak_record_form_process', false);
                                  
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
