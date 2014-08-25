<?php


include 'share/data_utils.php';
include 'share/form_common.php';
require_once 'HTML/QuickForm2.php';


$sql = <<<END
    select
        n.nota_id,
        m.zona,
        m.provincia,
        m.nombre medio,
        n.titulo,
        n.fecha,
        n.mencion_escala,
        n.valoracion,
        n.carga_fecha
    from 
        nota n,
        medio m 
    where
        n.medio_id = m.medio_id
END;


$sql_group_zona_1 = <<<END
    select
        m.zona,
        count(*) as cantidad
    from
        nota n,
        medio m
    where
        n.medio_id = m.medio_id

END;

$sql_group_zona_2 = <<<END

    group by
        zona
    order by
        cantidad desc
END;

$sql_group_nsp_1 = <<<END
    select
        n.valoracion,
        count(*) as cantidad
    from
        nota n,
        medio m
    where
        n.medio_id = m.medio_id
        and
        n.mencion_escala = 'NSP'
END;

$sql_group_nsp_2 = <<<END
    group by
        valoracion
    order by
        cantidad desc
END;

$sql_group_no_nsp_1 = <<<END
    select
        n.valoracion,
        count(*) as cantidad
    from
        nota n,
        medio m
    where
        n.medio_id = m.medio_id
        and
        n.mencion_escala <> 'NSP'
END;

$sql_group_no_nsp_2 = <<<END
    group by
        valoracion
    order by
        cantidad desc
END;


$zona_select = array(
    ''                      => '--Todas--',
    'Norte'                 => 'Norte',
    'Centro'                => 'Centro',
    'Buenos Aires'          => 'Buenos Aires',
    'Sur'                   => 'Sur',
    'Nacional y Agencias'   => 'Nacional y Agencias',
); 

$mencion_escala[''] = '--Todas--';
$mencion_escala['NSP'] = 'Nota sobre el programa (NSP)';
$mencion_escala['MP'] = 'Menci?n del programa (MP)';
$mencion_escala['TR'] = 'Tema relacionado (TR)'; 

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

$valoracion_select[''] = '--Seleccione--';
$valoracion_select['+1'] = 'Positiva (+1)';
$valoracion_select['0']  = 'Neutra (0)';
$valoracion_select['-1'] = 'Negativa (-1)';
$valoracion_select['-2'] = 'Denuncia (-2)';
 



//$form_params = params_encode($params);
 

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
$form->addElement('text', 'medio', $campo_medio)
     ->setLabel('Medio:')
     ;
$form->addElement('select', 'mencion')
     ->setLabel('Menci?n:')
     ->loadOptions($mencion_escala) 
     ;
$form->addElement('select', 'valoracion')
     ->setLabel('Valoraci?n:')
     ->loadOptions($valoracion_select) 
     ;
$form->addElement('text', 'texto', $campo_largo)
     ->setLabel('Texto:')
     ;

$form->addElement('date', 'fecha_carga_desde', $campo_corto, array('addEmptyOption' => true, 'emptyOptionText' => array('Y' => 'Anio:', 'M' => 'Mes:', 'd' => 'Dia:')))
     ->setLabel('Fecha carga desde:')
     ;

$form->addElement('date', 'fecha_carga_hasta', $campo_corto, array('addEmptyOption' => true, 'emptyOptionText' => array('Y' => 'Anio:', 'M' => 'Mes:', 'd' => 'Dia:')))
     ->setLabel('Fecha carga hasta:')
     ;

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



if ( isset($_GET['btnSubmit']) and $_GET['btnSubmit'] != '' )
{
    $q = isset($_GET['texto']) ? strtr($_GET['texto'], $normalizeChars) : '';

    $sql_where = '';
    $sql_data = array();

    //$new_row = $_GET['new_row'];

//    $fecha_desde = get_date($new_row['fecha1_desde']) . ' 00:00:00';
//    $fecha_hasta = get_date($new_row['fecha1_hasta']) . ' 23:59:59'; 
//    $sql_data = array($fecha_desde, $fecha_hasta);


    if (!empty($_GET['zona'])) {
        $sql_where .= " and lower(m.zona) like '%' || lower(?) || '%' ";
        $sql_data[] = $_GET['zona'];
    }
    if (!empty($_GET['provincia'])) {
        $sql_where .= " and lower(m.provincia) like '%' || lower(?) || '%' ";
        $sql_data[] = $_GET['provincia'];
    }
    if (!empty($_GET['medio'])) {
        $sql_where .= " and lower(medio) like '%' || lower(?) || '%' ";
        $sql_data[] = $_GET['medio'];
    }
    if (!empty($_GET['mencion'])) {
        $sql_where .= " and mencion_escala = ? ";
        $sql_data[] = $_GET['mencion'];
    }
    if (!empty($_GET['valoracion'])) {
        $sql_where .= " and valoracion = ? ";
        $sql_data[] = $_GET['valoracion'];
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

    $db = new PDO($config['db']['dsn']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st = $db->prepare($sql); 
    $st->execute($sql_data);


    unset($params);
    $params['data'] = $st->fetchAll(PDO::FETCH_ASSOC);
    $reg_count = count($params['data']);

    echo "Se encontraron un total de $reg_count registros.<br><br>";

    // mostramos los graficos

    echo '<h2>Chart por zona</h2>';
    $sql_chart = $sql_group_zona_1 . $sql_where . $sql_group_zona_2;
    //echo '<pre>'; var_dump($sql_group_zona); echo '</pre>';
    $st_chart = $db->prepare($sql_chart); 
    $st_chart->execute($sql_data);

    $chart_params['data'] = $st_chart->fetchAll(PDO::FETCH_ASSOC);
    $chart_params['ejex'] = 'zona';
    $chart_params['ejey'] = 'cantidad';
    echo '<img src="share/chart_3dpie.php?params=' . params_encode($chart_params) . '">';

    echo '<h2>Chart por Valoraci&oacute;n de notas de Plan Nacer</h2>';
    $sql_chart = $sql_group_nsp_1 . $sql_where . $sql_group_nsp_2;
    $st_chart = $db->prepare($sql_chart);
    $st_chart->execute($sql_data);

    $chart_params['data'] = $st_chart->fetchAll(PDO::FETCH_ASSOC);
    $chart_params['ejex'] = 'valoracion';
    $chart_params['ejey'] = 'cantidad';
    echo '<img src="share/chart_3dpie.php?params=' . params_encode($chart_params) . '">';

    echo '<h2>Chart por Valoraci&oacute;n de notas de salud en general</h2>';
    $sql_chart = $sql_group_no_nsp_1 . $sql_where . $sql_group_no_nsp_2;
    $st_chart = $db->prepare($sql_chart);
    $st_chart->execute($sql_data);

    $chart_params['data'] = $st_chart->fetchAll(PDO::FETCH_ASSOC);
    $chart_params['ejex'] = 'valoracion';
    $chart_params['ejey'] = 'cantidad';
    echo '<img src="share/chart_3dpie.php?params=' . params_encode($chart_params) . '">';

    // end graficos

    if ($reg_count > 0) {
        $params['primary_key'] = 'nota_id';
        $params['link_view']['nota_id']['label'] = 'Ver registro';
        $params['link_view']['nota_id']['href'] = '?action=nota';

        include_once 'share/data_display.php';
        echo sak_display_array_list($params);
    } 
} 


include_once 'footer.php';


