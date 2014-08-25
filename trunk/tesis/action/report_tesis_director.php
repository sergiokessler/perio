<?php


include_once 'header.php';
include_once 'share/data_display.php';


$sql = <<<END
    select 
        director,
        estado, 
        count(*) as cantidad
    from 
        tesis
    group by
        director,
        estado
END;


unset($params_list);
$params_list['sql_list'] = $sql;
$params_list['sql_data'] = array();
$params_list['primary_key'] = '';
echo sak_display_list($params_list);




include_once 'footer.php';


