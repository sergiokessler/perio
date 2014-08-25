<?php

/*

$Id: premio.php,v 1.2 2007/10/17 18:03:18 develop Exp $

*/

require_once 'share/data_display.php';

function get_fecha($new_row_arr)
{
    $fecha = $new_row_arr['Y'] . '-' . $new_row_arr['M'] . '-' . $new_row_arr['d'];
    return($fecha);
} 



// sql

$query[0] = <<<END
    select 
        n.nota_id, 
        n.area, 
        n.usuario, 
        n.fecha, 
        n.publicar, 
        n.prioridad, 
        n.volanta, 
        titulo 
    from 
        nota n 
    where
        fecha >= ?
        and
        fecha <= ?
END;
$query[1] = <<<END
    order by
        nota_id desc
END;

$params['table'] = 'nota';


$date_options = array(
    'language'  => 'es',
    'minYear'   => 2005
);
$date_defaults = array(
    'd' => date('d'),
    'M' => date('m'),
    'Y' => date('Y')
);


require_once 'HTML/QuickForm.php';
$form = new HTML_QuickForm('form', 'get');
$form->addElement('header', 'MyHeader', 'Buscar registros');
$form->addElement('hidden', 'action', 'nota');
$form->addElement('text', 'titulo', 'Titulo:');
$form->addElement('date', 'fecha_inicio_desde', 'Fecha desde:', $date_options);
$form->addElement('date', 'fecha_inicio_hasta', 'Fecha hasta:', $date_options);
$form->addElement('submit', 'btnSubmit', 'Buscar');

$form->setDefaults(array(
    'fecha_inicio_desde' => $date_defaults,
    'fecha_inicio_hasta' => $date_defaults
));



include_once 'header.php';

echo '<br>';
$form->display();
echo '<br>';

$insert_title = 'Agregar registro';
$insert_url = 'index.php?action=' . $params['table'] . '_insert';
echo "<a href=\"$insert_url\">$insert_title</a>";
echo '<br>';
echo '<br>';


if ( isset($_REQUEST['btnSubmit'])
     and ($_REQUEST['btnSubmit'] == 'Buscar') )
{
    
    $fecha_desde = get_fecha($_REQUEST['fecha_inicio_desde']) . ' 00:00:00';
    $fecha_hasta = get_fecha($_REQUEST['fecha_inicio_hasta']) . ' 23:59:59';
                   
    $query_data = array($fecha_desde, $fecha_hasta);

    $where = '';

    $db = DB::connect($config['db']);
    if (PEAR::isError($db)) die($db->getMessage());

    // buscamos a q areas pertenece el usuario
    //
    $sql = 'select area from usuario_area where usuario = ? ';
    $sql_data = array($_SESSION['u']);
    $areas = $db->getAll($sql, $sql_data, DB_FETCHMODE_ASSOC);

    
    foreach($areas as $a)
    {
        $where_area[] = ' area = ? ';
        $query_data[] = $a['area'];
    }
    $where .= ' and (' . implode(' or ', $where_area) . ') ';

    if ($_REQUEST['titulo'] != '')
    {
        $where .= " and titulo like ? ";
        $query_data[] = '%' . $_REQUEST['titulo'] . '%';
    }

    $query = $query[0] . $where . $query[1];

    //unset($params);
    $params['sql_full'] = $query;
    $params['sql_data'] = $query_data;
    $params['primary_key'] = $params['table'] . '_id';
    $params['link_view']['field_name'] = $params['primary_key'];
    $params['link_view']['action'] = $params['table'] . '_select';
    $params['display_record_count'] = true;

    echo sak_display_list($params);
}




include_once 'footer.php';


