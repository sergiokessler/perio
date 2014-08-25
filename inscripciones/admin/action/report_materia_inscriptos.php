<?php

/*

$Id$

*/


require_once 'share/data_display.php';
require_once 'share/field_mapping.php';

$params['sql_full'] = <<<END
    select
        m.nombre as materia,
        m.codigo as materia_codigo,
        c.codigo as comision,
        a.nombre as alumno,
        a.legajo
    from
        inscripcion i,
        alumno a,
        materia m,
        comision c
    where
        i.alumno_id = a.id
        and
        i.materia_id = m.id
        and
        i.comision_id = c.id
        and
        i.materia_id = ?
    order by
        comision,
        alumno
END;

$params2['sql_full'] = <<<END
    select
        count(*) as cantidad_de_inscripciones
    from
        inscripcion i
    where
        i.materia_id = ?
END;

// <query> 


$campo_corto = array('size' => 3);
$campo_medio = array('size' => 8);
$campo_largo = array('size' => 64);



$db = DB::connect($config['db']) or die('Could connect to DB');

$select_materia = $db->getAssoc("select id, nombre from materia where habilitada = 'SI' order by nombre");

if(count($select_materia) == 0)
{
    include_once 'header.php';
    echo '<br>';
    echo 'No hay ninguna materia habilitada para consultar.';
    include_once 'footer.php';
    return;
}

//$params_f = params_encode($params);

$form = new HTML_QuickForm('form', 'get');
$form->addElement('hidden', 'action', 'report_materia_inscriptos');
$form->addElement('select', 'materia_id', 'Materia: ', $select_materia);
$form->addElement('submit', 'btnSubmit', 'Buscar');


    // <UI>
include_once 'header.php';
if (isset($params['msg']))
    echo $params['msg'];
echo '<br>';

$form->display();

echo '<br>';
if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Buscar')
   )
{
    $params['sql_data'] = $_REQUEST['materia_id'];
    $params['enable_export'] = true;
    $params2['sql_data'] = $_REQUEST['materia_id'];
    echo sak_display_list($params);
    echo '<br>';
    echo sak_display_list($params2);
}
echo '<br>';

include_once 'footer.php';

