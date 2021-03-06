<?php

require_once 'include/data_display.php';


$sql = <<<END
    select 
        inventario,
        ubicacion,
        disponibilidad,
        autor,
        titulo,
        disponibilidad,
        palabras_clave,
        archivo_digital as archivo,
        disponibilidad 
    from 
        libros
    order by
        inventario desc
    limit 10
END;
$sql_data = array();




include 'header.php';


echo '<div class="page-header">';
echo '  <h1>�ltimos 10 materiales cargados</h1>';
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
    $params['primary_key'] = 'inventario';
//    $params['link_view']['inventario']['label'] = 'Ver registro';
    $params['link_view']['inventario']['href'] = '?action=material_select';

    echo sak_display_array_list($params);
} 


include 'footer.php';

