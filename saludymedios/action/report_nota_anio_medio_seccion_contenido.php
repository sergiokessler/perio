<?php


include_once 'header.php';
include_once 'share/data_display.php';


$sql = <<<END
    select 
        extract(year from fecha) as anio,
        medio,
        seccion, 
        contenido,
        count(*) as cantidad
    from 
        nota
    group by
        anio,
        medio,
        seccion,
        contenido
    order by
        anio desc,
        medio,
        seccion,
        contenido
END;

echo 'Cantidad de notas por a�o, por medio, por secci�n y por contenido:';
echo '<br>';
echo '<br>'; 

unset($params_list);
$params_list['sql_list'] = $sql;
$params_list['sql_data'] = array();
$params_list['primary_key'] = '';
echo sak_display_list($params_list);




include_once 'footer.php';


