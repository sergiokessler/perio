<?php

require_once 'include/data_display.php';


$sql = <<<END
    select 
        *
    from 
        prestamo
    where
        1 = 1
END;
$sql_data = array();



$form_params = params_encode($params);
 

$form = new HTML_QuickForm2('search', 'get');

// elements
$form->addElement('hidden', 'action')
     ->setValue($action)
     ;

$form->addElement('text', 'search', $campo_largo)
     ->setLabel('Buscar préstamos:')
     ->addClass('form-control')
     ;
$form->addElement('checkbox', 'sindevolucion', array('id' => 'sinDevoId', 'checked' => 'checked'))
//     ->setLabel('Sin Devolución')
     ->setContent('Sin Devolución')
     ;

$submit = $form->addSubmit('btnSubmit', array('value' => 'Buscar'))
               ->addClass(array('btn', 'btn-primary'));

////////////////////////////////////////////////////////////
// renderer fixes
//
function renderSubmit($renderer, $submit) {
    return '<div class="form-actions">'.$submit.'</div>';
}

require_once 'HTML/QuickForm2/Renderer.php';
$renderer = HTML_QuickForm2_Renderer::factory('callback');
$renderer->setCallbackForId($submit->getId(), 'renderSubmit');

$renderer->setOption(array(
    'errors_prefix' => 'El formulario contiene errores:',
    'required_note' => '<span class="required">*</span> denota campos requeridos',
)); 
////////////////////////////////////////////////////////////

 


include 'header.php';


echo '<div class="page-header">';
echo '  <h1>Listado de préstamos <small></small></h1>';
echo '</div>'; 

// Output javascript libraries, needed by hierselect
//echo $renderer->getJavascriptBuilder()->getLibraries(true, true);
$form->render($renderer); 

echo $renderer;  



if ( (!empty($_REQUEST['btnSubmit']))
     and
     ($form->validate()) ) 
{
    //$q = strtr($_GET['q'], $normalizeChars);

    $sql_where = '';
    $sql_data = array();


    if (!empty($_GET['search'])) {
        $sql_where .= " and inventario || telefono || apellido_nombre || nro_documento || direccion ilike '%' || ? || '%' ";
        $sql_data[] = $_GET['search'];
    }

    if (!empty($_GET['sindevolucion'])) {
        $sql_where .= " and fecha_devolucion is null";
    }

    /*
     * mostramos los resultados
     */

    $sql .= $sql_where . ' order by fecha_prestamo';

    //echo $sql;

    $db = new PDO($config['db']['dsn']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st = $db->prepare($sql);
    $st->execute($sql_data);


    unset($params);
    $params['data'] = $st->fetchAll(PDO::FETCH_ASSOC);

    if (empty($params['data'])) {
        echo _('No data found');
    } else {
        $params['primary_key'] = 'prestamo_id';
        $params['link_view']['prestamo_id']['label'] = 'Ver';
        $params['link_view']['prestamo_id']['href'] = '?action=prestamo_select';

        echo sak_display_array_list($params);
    }
}


include 'footer.php';

