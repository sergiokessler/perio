<?php

include 'share/data_utils.php';


$sql_list = <<<END
    select 
        material_id,
        materia,
        autor,
        titulo
    from 
        material
END;

require_once 'HTML/QuickForm2.php';
include 'share/form_common.php';

$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//$materia_select = array('' => '-- Seleccionar --');
$sql_sel = "select materia_id, nombre from materia order by nombre";
$st = $db->query($sql_sel);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $materia_select[$row['nombre']] = $row['nombre'];
} 


$form = new HTML_QuickForm2('form', 'get');

// elements
$form->addElement('hidden', 'action')
     ->setValue('material_search')
     ;
$form->addElement('select', 'new_row[materia]')
     ->setLabel('Materia:')
     ->loadOptions($materia_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('text',   'new_row[titulo]', $campo_largo)
     ->setLabel('Título:')
     ;
$form->addElement('text',   'new_row[autor]', $campo_largo)
     ->setLabel('Autor:')
     ;


$submit = $form->addSubmit('btnSubmit', array('value' => 'Buscar'))
               ->addClass(array('btn', 'btn-primary')); 


// renderer fixes

function renderSubmit($renderer, $submit) 
{
    return '<div class="form-actions">'.$submit->__toString().'</div>';
}


require_once 'HTML/QuickForm2/Renderer.php';
$renderer = HTML_QuickForm2_Renderer::factory('callback');
$renderer->setCallbackForId($submit->getId(), 'renderSubmit'); 

$renderer->setOption(array(
    'errors_prefix' => 'El formulario contiene errores:',
    'required_note' => '',
));
 



// =========================================================
// GUI

include_once 'header.php';



echo '<div class="alert alert-info">';
echo '<h3>Buscar material de fotocopiadora</h3>';
echo '</div>';

$form->render($renderer); 

echo $renderer;  



if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Buscar')
     and
     ($form->validate()) ) 
{

    $sql_where = '';
    $sql_data = array();

    $new_row = $_GET['new_row'];

    if ($new_row['materia'] != '')
    {
        $sql_where .= ' and materia ilike ? ';
        $sql_data[] = $new_row['materia'];
    }

    if ($new_row['titulo'] != '')
    {
        $sql_where .= ' and titulo ilike ? ';
        $sql_data[] = '%' . $new_row['titulo'] . '%';
    }

    if ($new_row['autor'] != '')
    {
        $sql_where .= ' and autor ilike ? ';
        $sql_data[] = '%' . $new_row['autor'] . '%';
    }
    

    $sql = $sql_list . ' where 1 = 1 ' . $sql_where . ' order by autor';
//    var_dump($sql);
//    var_dump($sql_data);

    $st = $db->prepare($sql); 
    $st->execute($sql_data);

    unset($params);
    $params['data'] = $st->fetchAll(PDO::FETCH_ASSOC);
//    var_dump($params['data']);

    if (count($params['data']) == 0) {
        echo 'No se encuentran resultados';
    } else {
        $params['primary_key'] = 'material_id';
        $params['link_view']['material_id']['label'] = 'Ver material';
        $params['link_view']['material_id']['href'] = '?action=material_select';


/*
        $params['primary_key'] = 'material_id';
        $params['link_view']['field_name'] = 'Ver registro';
        $params['link_view']['label'] = 'Ver material';
        $params['link_view']['action'] = 'material_select';
*/
        include_once 'share/data_display.php';
        echo sak_display_array_list($params);
    }
}


include_once 'footer.php';


