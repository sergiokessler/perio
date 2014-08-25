<?php

/*

$Id$

*/



$sql_record1 = <<<END
    select 
        *
    from 
        tesis
    where
        tesis_id = ?
END;


$sql_record2 = <<<END
    select 
        persona.*,
        integrante.rol
    from 
        persona,
        integrante
    where
        persona.persona_id = integrante.persona_id
        and
        integrante.tesis_id = ?
END;



include_once 'header.php';
include_once 'share/data_display.php';

echo '<br>';

unset($params_rec);
$params_rec['sql_record'] = $sql_record1;
$params_rec['record_id'] = $params['record_id'];
echo sak_display_record($params_rec);

unset($params_list);
$params_list['sql_list'] = $sql_record2;
$params_list['sql_data'] = array($params['record_id']);
$params_list['primary_key'] = '';
echo sak_display_list($params_list);



include_once 'footer.php';



?>
