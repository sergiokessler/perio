<?php

/*

$Id$

*/


require_once 'share/data_display.php';
require_once 'share/field_mapping.php';

$params['sql_full'] = <<<END
    select
        materia,
        materia_codigo,
        comision,
        count (id) as cantidad_inscriptos
    from
        inscripcion_v
    group by
        materia,
        materia_codigo,
        comision
    order by
        materia,
        materia_codigo,
        comision
END;
$params['sql_data'] = null;

// <query> 



    // <UI>
include_once 'header.php';
if (isset($params['msg']))
    echo $params['msg'];
echo '<br>';

echo sak_display_list($params);

echo '<br>';

include_once 'footer.php';

