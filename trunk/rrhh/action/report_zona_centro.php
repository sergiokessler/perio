<?php

/*
if (isset($_GET['zona'])) {
    $zona = $_GET['zona'];
} else {
    echo 'Debe para el parametro. Presione el boton de Atras';
    exit();
} 
*/

$zona = 'Centro';

include_once 'share/data_display.php';


$sql = <<<END
    select 
        m.provincia,
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
        m.zona = '$zona'
    group by
        provincia
    order by
        cantidad desc
END;

// notas de salud en general
$sql_b = <<<END
    select 
        m.provincia,
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
        m.zona = '$zona'
        and
        n.mencion_escala <> 'NSP'
    group by
        provincia
    order by
        cantidad desc
END;
$sql_data = array();


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
        m.zona = '$zona'
        and
        n.mencion_escala = 'NSP'
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
        m.zona = '$zona'
        and
        n.mencion_escala <> 'NSP'
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
        and
        m.zona = '$zona'
END;


$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


include 'header.php';

echo '<div class="page-header">';
echo '  <img class="pull-right" src="img/logo_sumar_small.png">';
echo "  <h1>Notas zona $zona</h1>";
echo '</div>';


echo '<div class="row-fluid">';

echo '<h2>Cantidad por provincia</h2>';
unset($params);
$params['data'] = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
echo sak_display_array_list($params);

$chart_params['data'] = $params['data'];
$chart_params['ejex'] = 'provincia';
$chart_params['ejey'] = 'cantidad';
echo '<img src="share/chart_3dpie.php?params=' . params_encode($chart_params) . '">';

echo '<p>Cantidad total de notas: ';
$row = $db->query($sql_count)->fetch();
echo $row[0];
echo '</p>';


echo '<br>';
echo '<div class="page-break"></div>';
echo '<br>';

/*
echo '<h2>Cantidad por provincia (notas sobre salud en general)</h2>';

unset($params);
$params['data'] = $db->query($sql_b)->fetchAll(PDO::FETCH_ASSOC);
echo sak_display_array_list($params);

$chart_params['data'] = $params['data'];
$chart_params['ejex'] = 'provincia';
$chart_params['ejey'] = 'cantidad';
echo '<img src="share/chart_3dpie.php?params=' . params_encode($chart_params) . '">';


echo '<br>';
echo '<div class="page-break"></div>';
echo '<br>';
*/

echo '<h2>Valoración de notas de Plan Nacer</h2>';
unset($params);
$params['data'] = $db->query($sql2)->fetchAll(PDO::FETCH_ASSOC);
echo sak_display_array_list($params);

$chart_params['data'] = $params['data'];
$chart_params['ejex'] = 'valoracion';
$chart_params['ejey'] = 'cantidad';
echo '<img src="share/chart_3dpie.php?params=' . params_encode($chart_params) . '">';


echo '<br>';
echo '<div class="page-break"></div>';
echo '<br>';


echo '<h2>Valoración de notas de salud en general</h2>';
unset($params);
$params['data'] = $db->query($sql2_b)->fetchAll(PDO::FETCH_ASSOC);
echo sak_display_array_list($params);

$chart_params['data'] = $params['data'];
$chart_params['ejex'] = 'valoracion';
$chart_params['ejey'] = 'cantidad';
echo '<img src="share/chart_3dpie.php?params=' . params_encode($chart_params) . '">';


echo '</div>';

include 'footer.php'; 

