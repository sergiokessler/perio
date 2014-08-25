<?php

/*

$Id$

*/


require_once 'share/data_display.php';
require_once 'share/data_manage.php';
require_once 'share/field_mapping.php';

$params['table'] = 'inscripcion';
$params['primary_key'] = 'id';

// <query> 


$campos_cortos = array('size' => 3);
$campos_medios = array('size' => 8);
$campos_largos = array('size' => 64);


$field_meta['type']['insert']['id'] = 'disable';
$field_meta['type']['update']['id'] = 'hidden';



$db = DB::connect($config['db']) or die('Could connect to DB');

$qry_materia = <<<END
    select 
        id, 
        nombre
    from 
        materia 
    where 
        habilitada = 'SI' 
    order by 
        nombre
END;


$select_materia = $db->getAssoc($qry_materia);

//$params_f = params_encode($params);

$form = new HTML_QuickForm('form', 'get');
//$form->addElement('hidden', 'params', $params_f);
$form->addElement('hidden', 'action', $params['table'] . '_insert');
$form->addElement('select', 'materia_id', 'Materia:', $select_materia);
$form->addElement('submit', 'btnSubmit', 'Seleccionar Materia');


if (isset($_REQUEST['btnSubmit'])
    and
    ($_REQUEST['btnSubmit'] == 'Seleccionar Materia'))
{

    $materia_id = $_REQUEST['materia_id'];

    // cyn no quiere que el operador vea los cupos aqui...
    $comisiones = $db->getAssoc("select id, codigo from comision where cupos > 0 and materia_id = ? order by codigo", null, array($materia_id));
    if (PEAR::isError($comisiones)) {   
        die($comisiones->getDebugInfo());
    }

    $msg_comis = '';
    if(count($comisiones) > 0 )
    {
        foreach ($comisiones as $id => $codigo) {
            $comis[] = &HTML_QuickForm::createElement('advcheckbox', $id, null, $codigo, null, $id);
        }

        $materia = $db->getRow("select nombre, notas from materia where id = ? ", array($materia_id), DB_FETCHMODE_ASSOC);
        if (PEAR::isError($materia)) {
            die($materia->getDebugInfo());
        }

        $form_comis = new HTML_QuickForm('form', 'post');
        $form_comis->addElement('hidden', 'action', $params['table'] . '_insert');
        $form_comis->addElement('hidden', 'materia_id', $materia_id);
        $form_comis->addElement('static', null, 'Materia seleccionada:', $materia['nombre']);
        $form_comis->addElement('static', null, 'Observaciones:', $materia['notas']);
        $form_comis->addGroup($comis, 'comisiones', 'Seleccione comisiones:', '<br>');
        $form_comis->addElement('submit', 'btnSubmit', 'Inscribir');
    }
    else
    {
        $msg_comis = '<br>Esa materia no tiene cupos disponible en ninguna comision.';
        unset($materia_id);
    }
}


if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Inscribir')
   )
{
    unset($new_row);

    $new_row['alumno_id'] = $_SESSION['alumno_id'];
    $new_row['materia_id'] = $_POST['materia_id'];

    $comisiones = $_POST['comisiones'];

//    echo '<pre>';
//    print_r($new_row);
//    echo '</pre>';


    $msg = '';


    foreach($comisiones as $key => $comision_id)
    {
        if ($comision_id == '')
            continue;

        $new_row['comision_id'] = $comision_id;
        $res = $db->autoExecute($params['table'], $new_row, DB_AUTOQUERY_INSERT);
        if (PEAR::isError($res)) {
            $msg = 'Ha ocurrido un error. El alumno ya se encuentra inscripto en alguna de las comisiones o se terminaron los cupos ?';
            break;
        } else {
            $msg = "El registro a sido cargado satisfactoriamente.";
        }
    }


    unset($params_cont);
    $params_cont['msg'] = $msg;
    $params_cont = params_encode($params_cont);

    $continue = 'action=' . $params['table'] . '&params=' . $params_cont;
    return;
}




    // <UI>
    include_once 'header.php';
    if (isset($params['msg']))
        echo $params['msg'];
    echo '<br>';

    $params_alumno['sql_list'] = 'select * from alumno';
    $params_alumno['sql_where'] = ' where id = ?';
    $params_alumno['sql_order'] = '';
    $params_alumno['sql_data'] = $_SESSION['alumno_id'];

    echo sak_display_list($params_alumno);
    echo '<br>';

    $form->display();
    echo '<br>';
    

    if(isset($materia_id))
    {
        echo '<hr width="60%">';
        echo $msg_comis;
        $form_comis->display();
    }

    include_once 'footer.php';

?>
