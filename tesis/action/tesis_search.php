<?php

/*

$Id$

*/



$sql_list = <<<END
    select 
        tesis.tesis_id,
        tesis.titulo,
        persona.apellido_nombre,
        integrante.rol
    from 
        tesis,
        persona,
        integrante
    where
        tesis.tesis_id = integrante.tesis_id
        and
        integrante.persona_id = persona.persona_id
END;



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



$field_meta['fecha_inicio']['options'] = $date_options;
$field_meta['fecha_inicio']['defaults'] = $date_defaults;
$field_meta['tesis_id']['insert']['type'] = 'disable';
$field_meta['tesis_id']['update']['type'] = 'hidden';



require_once 'HTML/QuickForm.php';
$form = new HTML_QuickForm('form', 'get');
$form->addElement('header', 'MyHeader', 'Busqueda de Tesis');
$form->addElement('hidden', 'action', 'tesis_search');
$form->addElement('text', 'titulo', 'Titulo:');
//$form->addElement('text', 'programa', 'Programa:');
$form->addElement('text', 'integrante', 'Integrante:');
/*
$options = array(
    'language'  => 'es',
    'minYear'   => 2005,
    'maxYear'   => 2009
);
$date_defaults = array(
    'd' => date('d'),
    'M' => date('m'),
    'Y' => date('Y')
);
$form->addElement('date', 'fecha_inicio_desde', 'Fecha desde:', $options);
$form->addElement('date', 'fecha_inicio_hasta', 'Fecha hasta:', $options);

$form->setDefaults(array(
    'fecha_inicio_desde' => $date_defaults,
    'fecha_inicio_hasta' => $date_defaults
));
 */
$form->addElement('submit', 'btnSubmit', 'Buscar');



include_once 'header.php';

echo '<br>';
$form->display();



if ( isset($_REQUEST['btnSubmit']) and $_REQUEST['btnSubmit'] == 'Buscar' )
{

    $sql_where = '';
    $sql_data = array();

/*    $fecha_desde = get_fecha($_REQUEST['fecha_inicio_desde']) . ' 00:00:00';
    $fecha_hasta = get_fecha($_REQUEST['fecha_inicio_hasta']) . ' 23:59:59'; 
 */

    if ($_REQUEST['titulo'] != '')
    {
        $sql_where .= ' and tesis.titulo ilike ? ';
        $sql_data[] = '%' . $_REQUEST['titulo'] . '%';
    }
    
    if ($_REQUEST['integrante'] != '')
    {
        $sql_where .= ' and persona.apellido_nombre ilike ? ';
        $sql_data[] = '%' . $_REQUEST['integrante'] . '%';
    }


    unset($params);
    $params['sql_list'] = $sql_list;
    $params['sql_where'] = $sql_where;
    $params['sql_order_by'] = 'order by tesis.titulo';
    $params['sql_data'] = $sql_data;
    $params['primary_key'] = 'tesis_id';
    $params['primary_key_action'] = 'tesis';

    include_once 'share/data_display.php';
    echo sak_display_list($params);
    //echo 'despues de sak_display_list';
}


include_once 'footer.php';



?>
