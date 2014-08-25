<?php


include_once 'header.php';
include_once 'share/data_display.php';


$sql = <<<END
    select 
        extract(year from fecha) as anio,
        extract(month from fecha) as mes, 
        medio,
        seccion, 
        count(*) as cantidad
    from 
        nota
    group by
        anio,
        mes,
        medio,
        seccion
    order by
        anio desc,
        mes desc,
        medio,
        seccion
END;

echo 'Cantidad de notas por año, por mes, por medio y por sección:';
echo '<br>';
echo '<br>'; 

unset($params_list);
$params_list['sql_list'] = $sql;
$params_list['sql_data'] = array();
$params_list['primary_key'] = '';
echo sak_display_list($params_list);




include_once 'footer.php';


