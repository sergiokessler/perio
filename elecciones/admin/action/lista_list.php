<?php

/*
 * by Sak@perio
 */
# vim: set fileencoding=ISO-8859-1

require_once 'lib/data_display.php';

include 'header.php';


$this_table = 'lista';
$this_table_label = 'Listas';
$this_primary_key = 'lista_id';
$this_icon = '<i class="fa fa-list"></i>';


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
        lista_id
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


echo '<div class="page-header">';
echo '  <h1>Listado de '. $this_table_label .' <small></small></h1>';
echo '<a href="?action='. $this_table .'_insert" class="btn btn-primary" role="button">Agregar '. $this_table_label .'</a>';
//echo '<span style="color:lightgray"> &nbsp;|&nbsp; </span>';
//echo '<a href="?action=nota_search">Buscar Notas</a>';
echo '</div>';


if (empty($params['data'])) {
    echo ('No se encontraron datos');
} else {
    $params['primary_key'] = $this_primary_key;
    //$params['link_view'][$this_primary_key]['label'] = 'Ver registro';
    $params['link_view']['lista_nombre']['href'] = '?action='. $this_table;
    $params['display_record_count'] = true; 
        
    echo sak_display_array_list($params);
} 

 //$params['enable_export'] = true;


include_once 'footer.php';

