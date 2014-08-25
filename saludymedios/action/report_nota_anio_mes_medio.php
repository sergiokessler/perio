<?php


include_once 'header.php';
include_once 'share/data_display.php';


$sql = <<<END
    select 
        extract(year from fecha) as anio,
        extract(month from fecha) as mes,
        medio,
        count(*) as cantidad
    from 
        nota
    group by
        anio,
        mes,
        medio
    order by
        anio desc,
        mes desc,
        medio
END;


echo 'Cantidad de notas por a�o, por mes y por medio:';
echo '<br>';
echo '<br>'; 

unset($params_list);
$params_list['sql_list'] = $sql;
$params_list['sql_data'] = array();
$params_list['primary_key'] = '';
echo sak_display_list($params_list);




include_once 'footer.php';


