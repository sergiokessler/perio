<?php


include_once 'header.php';
include_once 'share/data_display.php';


$sql = <<<END
    select 
        extract(year from fecha) as anio,
        medio,
        seccion, 
        count(*) as cantidad
    from 
        nota
    group by
        anio,
        medio,
        seccion
    order by
        anio desc,
        medio,
        seccion
END;

echo 'Cantidad de notas por a�o, por medio y por secci�n:';
echo '<br>';
echo '<br>'; 

unset($params_list);
$params_list['sql_list'] = $sql;
$params_list['sql_data'] = array();
$params_list['primary_key'] = '';
echo sak_display_list($params_list);




include_once 'footer.php';


