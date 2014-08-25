<?php

include 'share/form_common.php';
include 'share/data_display.php';
require_once 'HTML/QuickForm2.php';



$form = new HTML_QuickForm2('search', 'get');

// elements
$form->addElement('hidden', 'action')
     ->setValue($action)
     ;

$form->addElement('date', 'fecha_carga_desde', $campo_corto, array('addEmptyOption' => true, 'emptyOptionText' => array('Y' => 'Anio:', 'M' => 'Mes:', 'd' => 'Dia:')))
     ->setLabel('Fecha carga desde:')
     ;

$form->addElement('date', 'fecha_carga_hasta', $campo_corto, array('addEmptyOption' => true, 'emptyOptionText' => array('Y' => 'Anio:', 'M' => 'Mes:', 'd' => 'Dia:')))
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
        m.zona,
        count(*) as cantidad,
        sum(case when cast(n.valoracion as integer) > 0 then n.valoracion else 0 end) as val_positiva,
        sum(case when cast(n.valoracion as integer) < 0 then n.valoracion else 0 end) as val_negativa
--        sum(n.valoracion) as val_acumulada,
--        cast(round((sum(n.valoracion) * 100) / count(*), 2) as text) || ' %' as val_factor
    from 
        nota n,
        medio m
    where
        n.medio_id = m.medio_id
        $sql_where
    group by
        zona
    order by
        cantidad desc
END;

// notas de salud en general
$sql_b = <<<END
    select 
        m.zona,
        count(*) as cantidad,
        sum(case when cast(n.valoracion as integer) > 0 then n.valoracion else 0 end) as val_positiva,
        sum(case when cast(n.valoracion as integer) < 0 then n.valoracion else 0 end) as val_negativa
--        sum(n.valoracion) as val_acumulada,
--        cast(round((sum(n.valoracion) * 100) / count(*), 2) as text) || ' %' as val_factor
    from 
        nota n,
        medio m
    where
        n.medio_id = m.medio_id
        and
        n.mencion_escala <> 'NSP'
        $sql_where
    group by
        zona
    order by
        cantidad desc
END;

$sql2 = <<<END
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
        $sql_where
    group by
        valoracion
    order by
        cantidad desc
END;

$sql2_b = <<<END
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
        $sql_where
    group by
        valoracion
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
echo '  <img class="pull-right" src="img/logo_sumar_small.png">';
echo '  <h1>Reporte total de notas</h1>';
echo '</div>';


echo '<div class="row-fluid">';

$form->render($renderer);

echo '<div class="noprint">';
echo $renderer;
echo '</div>';


echo '<h2>Totales por zona</h2>';
$st = $db->prepare($sql);
$st->execute($sql_data);

unset($params);
$params['data'] = $st->fetchAll(PDO::FETCH_ASSOC);
echo sak_display_array_list($params);

$chart_params['data'] = $params['data'];
$chart_params['ejex'] = 'zona';
$chart_params['ejey'] = 'cantidad';
echo '<img src="share/chart_3dpie.php?params=' . params_encode($chart_params) . '">';

echo '<p>Cantidad total de notas: ';
$st = $db->prepare($sql_count);
$st->execute($sql_data);
$row = $st->fetch();
echo $row[0];
echo '</p>';


echo '<br>';
echo '<div class="page-break"></div>';
echo '<br>';


echo '<h2>Valoración de notas de Plan Nacer</h2>';
$st = $db->prepare($sql2);
$st->execute($sql_data);
unset($params);
$params['data'] = $st->fetchAll(PDO::FETCH_ASSOC);
echo sak_display_array_list($params);

$chart_params['data'] = $params['data'];
$chart_params['ejex'] = 'valoracion';
$chart_params['ejey'] = 'cantidad';
echo '<img src="share/chart_3dpie.php?params=' . params_encode($chart_params) . '">';


echo '<br>';
echo '<div class="page-break"></div>';
echo '<br>';


echo '<h2>Valoración de notas de salud en general</h2>';
$st = $db->prepare($sql2_b);
$st->execute($sql_data);
unset($params);
$params['data'] = $st->fetchAll(PDO::FETCH_ASSOC);
echo sak_display_array_list($params);

$chart_params['data'] = $params['data'];
$chart_params['ejex'] = 'valoracion';
$chart_params['ejey'] = 'cantidad';
echo '<img src="share/chart_3dpie.php?params=' . params_encode($chart_params) . '">';



echo '</div>';


include 'footer.php'; 

