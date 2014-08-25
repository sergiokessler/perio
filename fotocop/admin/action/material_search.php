<?php

require_once 'HTML/QuickForm.php';
include 'share/data_utils.php';


$sql_list = <<<END
    select 
        material_id,
        materia,
        autor,
        titulo,
        cant_hojas,
        carpeta,
        folio,
        archivo,
        costo,
        fecha_registro
    from 
        material
END;

include 'share/form_common.php';

$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$materia_select = array('' => '-- Select --');
$sql_sel = "select materia_id, nombre from materia order by nombre";
$st = $db->query($sql_sel);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $materia_select[$row['nombre']] = $row['nombre'];
}

$form = new HTML_QuickForm('form', 'get');
$form->addElement('hidden', 'action', 'material_search');
$form->addElement('select', 'new_row[materia]', ' Materia:', $materia_select);
$form->addElement('text',   'new_row[titulo]', ' Título:', $campo_largo);
$form->addElement('text',   'new_row[autor]', ' Autor:', $campo_largo);
$form->addElement('text',   'new_row[carpeta]', ' Carpeta:', $campo_medio);
$form->addElement('text',   'new_row[folio]', ' Folio:', $campo_medio); 

$form->addRule('new_row[materia]', 'Valor requerido', 'required'); 


$form->addElement('submit', 'btnSubmit', 'Buscar');



include_once 'header.php';

echo '<h2>Buscar material</h2>';
$form->display();


$link_url = 'index.php?action=material_insert';
$link_label = 'Ingresar material nuevo';
echo '<br>'; 
echo "<a href=\"$link_url\">$link_label</a>"; 
echo '<br>'; 
echo '<br>'; 



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
    
    if ($new_row['carpeta'] != '')
    {
        $sql_where .= ' and carpeta ilike ? ';
        $sql_data[] = '%' . $new_row['carpeta'] . '%';
    }

    if ($new_row['folio'] != '')
    {
        $sql_where .= ' and folio ilike ? ';
        $sql_data[] = '%' . $new_row['folio'] . '%';
    }

    $sql = $sql_list . ' where 1 = 1 ' . $sql_where . ' order by autor';
//    var_dump($sql);
//    var_dump($sql_data);

    $db = new PDO($config['db']['dsn']); 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st = $db->prepare($sql); 
    $st->execute($sql_data);


    unset($params);
    $params['data'] = $st->fetchAll(PDO::FETCH_ASSOC);
//    var_dump($params['data']);

    if (count($params['data']) == 0) {
        echo 'No se encuentran resultados';
    } else {
        $params['primary_key'] = 'material_id';
        $params['link_view']['field_name'] = $params['primary_key'];
        $params['link_view']['label'] = 'Ver material';
        $params['link_view']['action'] = 'material_select';

        include_once 'share/data_display.php';
        echo sak_display_array_list($params);
    }
}


include_once 'footer.php';


