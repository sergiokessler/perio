<?php

/*

$Id$

*/



$sql_record1 = <<<END
    select 
        *
    from 
        exptes
    where
        expte = ?
END;


$sql_record2 = <<<END
    select 
        *
    from 
        estados
    where
        expte = ? 
END;

$params['table'] = 'expediente';


include_once 'header.php';
include_once 'share/data_display.php';

echo '<br>';

unset($params_upd);
$params_upd['record_id'] = $params['record_id'];
$params_upd = params_encode($params_upd); 

if ((isset($params['record_id'])))
{
    $update_title = 'Editar este registro';
    $update_url = 'index.php?action=' . $params['table'] . '_update&params=' . $params_upd;
    echo "<a href=\"$update_url\">$update_title</a>";
    echo '<br>';

    echo '<br>';
    unset($params_rec);
    $params_rec['sql_record'] = $sql_record1;
    $params_rec['record_id'] = $params['record_id'];
    echo sak_display_record($params_rec);

    $delete_title = 'Borrar este registro';
    $delete_url = 'index.php?action=' . $params['table'] . '_delete&params=' . $params_upd;
    echo "<a href=\"$delete_url\">$delete_title</a>";
    echo '<br>';
}



echo '<br>Estados del expediente<br>';

unset($params_list);
$params_list['sql_list'] = $sql_record2;
$params_list['sql_data'] = array($params['record_id']);
$params_list['primary_key'] = 'id_estado';
echo sak_display_list($params_list);



include_once 'footer.php';


