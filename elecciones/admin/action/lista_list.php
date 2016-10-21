<?php

/*
 * by Sak@perio
 */
# vim: set fileencoding=ISO-8859-1

require_once 'lib/data_display.php';

$sql = <<<END
    select 
        orden,
        lista_nombre,
        lista_nombre_corto as nombre_corto,
        activa,
        en_total,
        en_porcentaje,
        participa_centro,
        participa_claustro,
        color,
        lista_id as info
    from 
        lista
    order by
        orden
END;
$sql_data = array(); 


$db = new PDO($db_dsn, $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

$st = $db->prepare($sql); 
$st->execute($sql_data);


unset($params);
$params['data'] = $st->fetchAll(PDO::FETCH_ASSOC);

include 'header.php';

echo '<div class="page-header">';
echo '  <h1>Listado de Listas <small></small></h1>';
echo '<a href="?action=lista_insert" class="btn btn-default active" role="button">Agregar Lista</a>';
//echo '<span style="color:lightgray"> &nbsp;|&nbsp; </span>';
//echo '<a href="?action=nota_search">Buscar Notas</a>';
echo '</div>';


if (empty($params['data'])) {
    echo ('No se encontraron datos');
} else {
    $params['primary_key'] = 'lista_id';
    $params['link_view']['lista_id']['label'] = 'Ver registro';
    $params['link_view']['lista_id']['href'] = '?action=lista';
    $params['display_record_count'] = true;

    echo sak_display_array_list($params);
} 

 //$params['enable_export'] = true;


include_once 'footer.php';

