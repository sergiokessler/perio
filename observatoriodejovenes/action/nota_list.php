<?php

require_once 'share/data_display.php';


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
    order by
        n.fecha desc,
        n.carga_fecha desc
    limit 100
END;
$sql_data = array();




include 'header.php';


echo '<div class="page-header">';
echo '  <h1>Lista de notas <small>Solo se muestran las últimas 100 (orden cronológico)</small></h1>';
echo '<a href="?action=nota_insert">Cargar Nota</a>';
echo '<span style="color:lightgray"> &nbsp;|&nbsp; </span>';
echo '<a href="?action=nota_search">Buscar Notas</a>';
echo '</div>';


$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$st = $db->prepare($sql); 
$st->execute($sql_data);


unset($params);
$params['data'] = $st->fetchAll(PDO::FETCH_ASSOC);

if (empty($params['data'])) {
    echo ('No se encontraron datos');
} else {
    $params['primary_key'] = 'nota_id';
    $params['link_view']['nota_id']['label'] = 'Ver registro';
    $params['link_view']['nota_id']['href'] = '?action=nota';

    echo sak_display_array_list($params);
} 


include 'footer.php';


