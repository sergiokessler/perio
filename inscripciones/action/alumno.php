<?php

/*

$Id$

*/

require_once 'share/data_display.php';
require_once 'share/field_mapping.php';

$params['table'] = 'alumno';

//unset($params);
$query[0] = <<<END
    select
        *
    from
        alumno
    where
        1 = 1
END;
$query[1] = <<<END
    order by
        nombre
END;



require_once 'HTML/QuickForm.php';
$form = new HTML_QuickForm('form', 'get');
$form->addElement('header', 'MyHeader', 'Buscar alumnos');
$form->addElement('hidden', 'action', 'alumno');
$form->addElement('text', 'legajo', 'Legajo:');
$form->addElement('text', 'doc_nro', 'Nro Doc:');
$form->addElement('text', 'nombre', 'Nombre:');
$form->addElement('submit', 'btnSubmit', 'Buscar');



include_once 'header.php';

echo '<br>';
$form->display();
echo '<br>';


//$insert_title = 'Agregar registro';
//$insert_url = 'index.php?action=' . $params['table'] . '_insert';
//echo "<a href=\"$insert_url\">$insert_title</a>";
//echo '<br>';
//echo '<br>';


$buscar = (bool) (isset($_REQUEST['btnSubmit'])) && ($_REQUEST['btnSubmit'] == 'Buscar');
if ($buscar)
{   
    $query_data = array();
    $where = '';

    if ($_REQUEST['legajo'] != '')
    {
        $where .= " and legajo like ? ";
        $query_data[] = '%' . $_REQUEST['legajo'] . '%';
    }

    if ($_REQUEST['doc_nro'] != '')
    {
        $where .= " and doc_nro like ? ";
        $query_data[] = '%' . $_REQUEST['doc_nro'] . '%';
    }

    if ($_REQUEST['nombre'] != '')
    {
        $where .= " and upper(nombre) like upper(?) ";
        $query_data[] = '%' . $_REQUEST['nombre'] . '%';
    }

    $query = $query[0] . $where . $query[1];

    //unset($params);
    $params['sql_full'] = $query;
    $params['sql_data'] = $query_data;
    $params['primary_key'] = 'id';
    $params['link_view']['field_name'] = $params['primary_key'];
    $params['link_view']['action'] = 'alumno_select';
    $params['display_record_count'] = true;
    
    echo sak_display_list($params);
}


include_once 'footer.php';


