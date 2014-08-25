<?php

include_once 'share/data_display.php';
include 'share/form_common.php';  
require_once 'HTML/QuickForm2.php';  


$sql = <<<END
    select 
        m.zona,
        m.provincia,
        m.nombre as medio,
        count(*) as cantidad,
        sum(case when cast(n.valoracion as integer) > 0 then n.valoracion else 0 end) as val_positiva,
        sum(case when cast(n.valoracion as integer) < 0 then n.valoracion else 0 end) as val_negativa 
    from 
        nota n,
        medio m
    where
        n.medio_id = m.medio_id
END;

$sql_data = array();


$zona_select = array(
    ''                      => '--Todas--',
    'Norte'                 => 'Norte',
    'Centro'                => 'Centro',
    'Buenos Aires'          => 'Buenos Aires',
    'Sur'                   => 'Sur',
    'Nacional y Agencias'   => 'Nacional y Agencias',
); 

$pcia_select = array(
    null                    => '--Todas--',
    'N/A'                   => 'Nacional y Agencias',
    'Chaco'                 => 'Chaco',
    'Jujuy'                 => 'Jujuy',
    'Corriente'             => 'Corrientes',
    'Misiones'              => 'Misiones',
    'Salta'                 => 'Salta',
    'Catamarca'             => 'Catamarca',
    'Formosa'               => 'Formosa',
    'Santiago del Estero'   => 'Santiago del Estero',
    'Tucuman'               => 'Tucuman',
    'Santa Fe'              => 'Santa Fe',
    'Cordoba'               => 'Cordoba',
    'Entre Rios'            => 'Entre Rios',
    'San Juan'              => 'San Juan',
    'Mendoza'               => 'Mendoza',
    'San Luis'              => 'San Luis',
    'La Pampa'              => 'La Pampa',
    'La Rioja'              => 'La Rioja',
    'Buenos Aires'          => 'Buenos Aires',
    'Rio Negro'             => 'Rio Negro',
    'Neuquen'               => 'Neuquen',
    'Chubut'                => 'Chubut',
    'Santa Cruz'            => 'Santa Cruz',
    'Tierra del Fuego'      => 'Tierra del Fuego',
);



$form = new HTML_QuickForm2('search', 'get');

// elements
$form->addElement('hidden', 'action')
     ->setValue($action)
     ;

$form->addElement('select', 'zona', $campo_corto)
     ->setLabel('Zona:')
     ->loadOptions($zona_select)
     ;
$form->addElement('select', 'provincia', $campo_medio)
     ->setLabel('Provincia:')
     ->loadOptions($pcia_select)
     ;

$submit = $form->addSubmit('btnSubmit', array('value' => 'Buscar'))
               ->addClass(array('btn', 'btn-primary'));

////////////////////////////////////////////////////////////
// renderer fixes

function renderSubmit($renderer, $submit) 
{
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


// procesamos la busqueda
$sql_where = '';
if ( isset($_GET['btnSubmit']) and $_GET['btnSubmit'] != '' )
{
    $sql_data = array();

    if ($_GET['zona'] != '') {
        $sql_where .= " and lower(m.zona) like '%' || lower(?) || '%' ";
        $sql_data[] = $_GET['zona'];
    }
    if ($_GET['provincia'] != '') {
        $sql_where .= " and lower(m.provincia) like '%' || lower(?) || '%' ";
        $sql_data[] = $_GET['provincia'];
    }
} 

$sql .= $sql_where . ' group by m.provincia, m.nombre order by zona, provincia, nombre'; 


$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


include 'header.php';

echo '<div class="page-header">';
echo '  <img class="pull-right" src="img/logo_sumar_small.png">';
echo '  <h1>Resúmen de notas por Provincia y Medio <small>(Ordenado por Zona, Pcia y Medio)<small></h1>';
echo '</div>';


echo '<div class="noprint">';
// Output javascript libraries, needed by hierselect
//echo $renderer->getJavascriptBuilder()->getLibraries(true, true);
$form->render($renderer); 

echo $renderer;   
echo '</div>';


// buscamos y mostramos los datos

$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$st = $db->prepare($sql); 
$st->execute($sql_data);


unset($params);
$params['data'] = $st->fetchAll(PDO::FETCH_ASSOC);
$reg_count = count($params['data']);

echo "Un total de $reg_count registros.<br><br>";

if ($reg_count > 0) { 
//    $params['primary_key'] = 'medio_id';
    $params['link_view']['cantidad']['href'] = '?action=nota_search';
    $params['link_view']['cantidad']['url_params'][] = 'provincia';
    $params['link_view']['cantidad']['url_params'][] = 'medio';
    $params['link_view']['cantidad']['url_params_const']['_qf__search'] = '';
    $params['link_view']['cantidad']['url_params_const']['btnSubmit'] = 'Buscar';

    echo sak_display_array_list($params);
} 


include 'footer.php'; 

