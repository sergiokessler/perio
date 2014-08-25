<?php


include_once 'share/data_display.php';


$sql = <<<END
    select 
        cargo,
        count(*) as cantidad
    from 
        cargo
    where
        vigente = 'S'
    group by
        cargo
    order by
        cantidad
END;


unset($params_list);
$params_list['sql_full'] = $sql;
$params_list['sql_data'] = null;


include_once 'header.php';
echo '<br>';
echo '<br>';
echo sak_display_list($params_list);

include_once 'footer.php';


