<?php

/*

$Id$

*/


require_once 'share/data_display.php';


$params1['sql_full'] = <<<END
    select
        fecha_hora::date as fecha,
        count(distinct(alumno_id)) as cantidad
    from
        inscripcion
    group by
        fecha_hora::date
    order by
        fecha
END;
$params1['sql_data'] = null;
$params1['enable_export'] = true;

$params2['sql_full'] = <<<END
    select
        fecha_hora::date as fecha,
        count(*) as cantidad
    from
        inscripcion
    group by
        fecha_hora::date
    order by
        fecha
END;
$params2['sql_data'] = null;


// <query> 



    // <UI>
include_once 'header.php';
if (isset($params['msg']))
    echo $params['msg'];
echo '<br>';

echo 'Cantidad de alumnos con inscripcion por dia:';
echo '<br>';
echo sak_display_list($params1);

echo '<br>';
echo '<br>';

echo 'Cantidad de inscripciones por dia:';
echo '<br>';
echo sak_display_list($params2);
echo '<br>';

include_once 'footer.php';

