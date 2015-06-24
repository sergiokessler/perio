<?php

include 'share/form_common.php';
include 'share/data_display.php';
require_once 'HTML/QuickForm2.php';



$form = new HTML_QuickForm2('search', 'get');

// elements
$form->addElement('hidden', 'action')
     ->setValue($action)
     ;

$form->addElement('date',   'fecha_carga_desde', array('class'=> 'form-control-inline'), array('addEmptyOption' => true, 'emptyOptionText' => array('Y' => 'Anio:', 'M' => 'Mes:', 'd' => 'Dia:')))
     ->setLabel('Fecha carga desde:')
     ;
$form->addElement('date',   'fecha_carga_hasta', array('class'=> 'form-control-inline'), array('addEmptyOption' => true, 'emptyOptionText' => array('Y' => 'Anio:', 'M' => 'Mes:', 'd' => 'Dia:')))
     ->setLabel('Fecha carga hasta:')
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


$sql_where = '';
$sql_data = array();


if (!empty($_GET['btnSubmit']))
{
    if (!empty($_GET['fecha_carga_desde']['Y'])) {
        $sql_where .= " and n.carga_fecha >= ? ";
        $sql_data[] = get_date($_GET['fecha_carga_desde']);
    }
    if (!empty($_GET['fecha_carga_hasta']['Y'])) {
        $sql_where .= " and n.carga_fecha <= ? ";
        $sql_data[] = get_date($_GET['fecha_carga_hasta']) . ' 23:59:59';
    }
}

$sql = <<<END
    select 
        m.nombre,
        count(*) as cantidad
    from 
        nota n,
        medio m
    where
        n.medio_id = m.medio_id
        $sql_where
    group by
        m.nombre
    order by
        cantidad desc
END;

$sql_count = <<<END
    select 
        count(*) as cantidad
    from 
        nota n,
        medio m
    where
        n.medio_id = m.medio_id
        $sql_where
END;



$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


include 'header.php';

echo '<div class="page-header">';
echo '  <h1>Reporte de notas por medio</h1>';
echo '</div>';


echo '<div class="row-fluid">';

$form->render($renderer);

echo '<div class="noprint">';
echo $renderer;
echo '</div>';


$st = $db->prepare($sql);
$st->execute($sql_data);

unset($params);
$params['data'] = $st->fetchAll(PDO::FETCH_ASSOC);
echo '<br>';
echo sak_display_array_list($params);


$chart_params['data'] = $params['data'];
$chart_params['ejex'] = 'nombre';
$chart_params['ejey'] = 'cantidad';
echo '<img src="share/chart_3dpie.php?params=' . params_encode($chart_params) . '">'; 


foreach($params['data'] as $d) {
    $labels[] = "'" . $d['nombre'] . "'";
    $values[] = $d['cantidad'];
}

$labels = implode(', ', $labels);
$values = implode(', ', $values);


//var_dump($params['data']);

$chart = <<<END
<script>
var data = {
  labels: [$labels],
  series: [$values]
};

var options = {
  labelInterpolationFnc: function(value) {
    return value[0]
  }
};

var responsiveOptions = [
  ['screen and (min-width: 640px)', {
    chartPadding: 30,
    labelOffset: 100,
    labelDirection: 'explode',
    labelInterpolationFnc: function(value) {
      return value;
    }
  }],
  ['screen and (min-width: 1024px)', {
    labelOffset: 80,
    chartPadding: 20
  }]
];

new Chartist.Pie('.ct-chart', data, options, responsiveOptions);

</script>
END;

//echo '<link href="share/chartist.min.css" rel="stylesheet">';
echo '<script src="share/chartist.min.js"></script>';
echo '<div class="ct-chart ct-golden-section"></div>';
echo $chart;

echo '<p>Cantidad total de notas: ';
$st = $db->prepare($sql_count);
$st->execute($sql_data);
$row = $st->fetch();
echo $row[0];
echo '</p>';




echo '</div>';


include 'footer.php'; 

