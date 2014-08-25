<?php

/*

$Id$

*/


require_once 'share/data_display.php';
require_once 'share/field_mapping.php';

$params['sql_full'] = <<<END
    select
        a.nombre as alumno,
        a.legajo
    from
        inscripcion i,
        alumno a,
        comision c
    where
        i.alumno_id = a.id
        and
        i.comision_id = c.id
        and
        i.materia_id = ?
        and
        i.comision_id = ?
    order by
        alumno
END;

$params2['sql_full'] = <<<END
    select
        count(*) as cantidad_de_inscripciones
    from
        inscripcion i
    where
        i.materia_id = ?
        and
        i.comision_id = ?
END;


// <query> 


$campo_corto = array('size' => 3);
$campo_medio = array('size' => 8);
$campo_largo = array('size' => 64);



$db = DB::connect($config['db']) or die('Could connect to DB');

$select_materia = $db->getAssoc("select id, nombre from materia where habilitada = 'SI' order by nombre");
$result = $db->query("select materia_id, id, codigo from comision_v order by materia_nombre, codigo");
if (PEAR::isError($result)) {
    die($result->getDebugInfo());
}

while ($result->fetchInto($row)) {
    $select_comision[$row[0]][$row[1]] = $row[2];
}

if(!isset($select_comision))
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
$sel =& $form->addElement('hierselect', 'materia_comision', 'Materia / Comision: ', null, ' / ');
$sel->setOptions(array($select_materia, $select_comision));

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
    $mat_com = $_REQUEST['materia_comision'];
    echo '<strong>Materia:</strong> ', $select_materia[$mat_com[0]];
    echo '<br>';
    echo '<strong>Comisión:</strong> ', $select_comision[$mat_com[0]][$mat_com[1]];
    echo '<br>';
    echo '<br>';
    $params['sql_data'] = $mat_com;
    $params['enable_export'] = true;
    $params2['sql_data'] = $mat_com;
    echo sak_display_list($params);
    echo '<br>';
    echo sak_display_list($params2);
}
echo '<br>';

include_once 'footer.php';

