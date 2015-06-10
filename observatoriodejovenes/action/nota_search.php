<?php


include 'share/data_utils.php';
include 'share/form_common.php';
require_once 'HTML/QuickForm2.php';


$sql = <<<END
    select 
        n.nota_id,
        n.fecha,
        n.titulo,
        n.link,
        m.nombre,
        n.seccion,
        n.carga_usuario,
        n.carga_fecha
    from 
        nota n,
        medio m 
    where
        n.medio_id = m.medio_id
END;


$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



$medio_select = array('' => '-- Seleccione --');
$sql_sel = "select medio_id as k, nombre as v from medio order by nombre";
$st = $db->query($sql_sel);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $medio_select[$row['k']] = $row['v'];
} 


//$form_params = params_encode($params);
 

$form = new HTML_QuickForm2('search', 'get');

// elements
$form->addElement('hidden', 'action')
     ->setValue($action)
     ;
$form->addElement('select', 'medio_id')
     ->setLabel('Medio:')
     ->loadOptions($medio_select)
     ;
$form->addElement('text', 'texto')
     ->setLabel('Texto:')
     ;

$form->addElement('date',   'fecha_carga_desde', array('class'=> 'form-control-inline'), array('addEmptyOption' => true, 'emptyOptionText' => array('Y' => 'Anio:', 'M' => 'Mes:', 'd' => 'Dia:')))
     ->setLabel('Fecha carga desde:')
     ;
$form->addElement('date',   'fecha_carga_hasta', array('class'=> 'form-control-inline'), array('addEmptyOption' => true, 'emptyOptionText' => array('Y' => 'Anio:', 'M' => 'Mes:', 'd' => 'Dia:')))
     ->setLabel('Fecha carga hasta:')
     ;

/*
$form->addElement('date', 'fecha_carga_desde', $campo_corto, array('addEmptyOption' => true, 'emptyOptionText' => array('Y' => 'Anio:', 'M' => 'Mes:', 'd' => 'Dia:')))
     ->setLabel('Fecha carga desde:')
     ;
*/
/*
$form->addElement('date', 'fecha_carga_hasta', $campo_corto, array('addEmptyOption' => true, 'emptyOptionText' => array('Y' => 'Anio:', 'M' => 'Mes:', 'd' => 'Dia:')))
     ->setLabel('Fecha carga hasta:')
     ;
*/
$submit = $form->addSubmit('btnSubmit', array('value' => 'Buscar'))
               ->addClass(array('btn', 'btn-primary'));




include_once 'header.php';

echo '<div class="page-header">';
echo '  <h1>Búsqueda de notas</h1>';
echo '</div>'; 

// Output javascript libraries, needed by hierselect
//echo $renderer->getJavascriptBuilder()->getLibraries(true, true);

echo '<div class="noprint">';
echo $form;
echo '</div>';



if (!empty($_GET['btnSubmit']) or !empty($_GET['q']))
{
    $q = isset($_GET['q']) ? strtr($_GET['q'], $normalizeChars) : '';
    if (empty($q)) {
        $q = isset($_GET['texto']) ? strtr($_GET['texto'], $normalizeChars) : '';
    }

    $sql_where = '';
    $sql_data = array();

    //$new_row = $_GET['new_row'];

//    $fecha_desde = get_date($new_row['fecha1_desde']) . ' 00:00:00';
//    $fecha_hasta = get_date($new_row['fecha1_hasta']) . ' 23:59:59'; 
//    $sql_data = array($fecha_desde, $fecha_hasta);


    if (!empty($_GET['provincia'])) {
        $sql_where .= " and lower(m.provincia) like '%' || lower(?) || '%' ";
        $sql_data[] = $_GET['provincia'];
    }
    if (!empty($_GET['medio'])) {
        $sql_where .= " and medio_id = ? ";
        $sql_data[] = $_GET['medio'];
    }

    if (!empty($_GET['fecha_carga_desde']['Y'])) {
        $sql_where .= " and n.carga_fecha >= ? ";
        $sql_data[] = get_date($_GET['fecha_carga_desde']);
    }

    if (!empty($_GET['fecha_carga_hasta']['Y'])) {
        $sql_where .= " and n.carga_fecha <= ? ";
        $sql_data[] = get_date($_GET['fecha_carga_hasta']) . ' 23:59:59';
    }

    if ($q != '') {
        $sql_where .= ' and nota_id in (select nota_id from nota_fts where nota_fts.content match ?)';
        $sql_data[] = $q;
    }


    /* 
     * mostramos los resultados
     */

    $sql .= $sql_where . ' order by n.fecha desc, n.carga_fecha desc';

    $st = $db->prepare($sql); 
    $st->execute($sql_data);


    unset($params);
    $params['data'] = $st->fetchAll(PDO::FETCH_ASSOC);
    $reg_count = count($params['data']);

    echo "Se encontraron un total de $reg_count registros.<br><br>";


    if ($reg_count > 0) {
        $params['primary_key'] = 'nota_id';
        $params['link_view']['nota_id']['label'] = 'Ver registro';
        $params['link_view']['nota_id']['href'] = '?action=nota';

        include_once 'share/data_display.php';
        echo sak_display_array_list($params);
    } 
} 


include_once 'footer.php';


