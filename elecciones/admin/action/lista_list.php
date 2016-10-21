<?php

/*
 * by Sak@perio
 */
# vim: set fileencoding=ISO-8859-1

require_once 'lib/data_display.php';

$sql = <<<END
    select 
        *
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

if (empty($params['data'])) {
    echo ('No se encontraron datos');
} else {
    $params['primary_key'] = 'lista_id';
    $params['link_view']['lista_id']['label'] = 'Ver registro';
    $params['link_view']['lista_id']['href'] = '?action=lista';
    $params['display_record_count'] = true;

    echo sak_display_array_list($params, $field_mapping);
} 

 //$params['enable_export'] = true;


include_once 'footer.php';

