<?php
# vim: set fileencoding=latin1 : 

require_once 'share/data_display.php';


$sql = <<<END
    select 
        n.nota_id,
        m.zona,
        m.nombre,
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
    order by
        n.fecha desc,
        n.carga_fecha desc
    limit 100
END;
$sql_data = array();




include 'header.php';


echo '<div class="page-header">';
echo '  <img class="pull-right" src="img/logo_sumar_small.png">';
echo '  <h1>Lista de notas <small>Solo se muestran las últimas 100 (orden cronológico)</small></h1>';
echo '</div>';


$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$st = $db->prepare($sql); 
$st->execute($sql_data);


unset($params);
$params['data'] = $st->fetchAll(PDO::FETCH_ASSOC);

if (empty($params['data'])) {
    echo _('No data found');
} else {
    $params['primary_key'] = 'nota_id';
    $params['link_view']['nota_id']['label'] = 'Ver registro';
    $params['link_view']['nota_id']['href'] = '?action=nota';

    echo sak_display_array_list($params);
} 


include 'footer.php';


