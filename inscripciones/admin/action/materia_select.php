<?php

/*

$Id$

*/


$params['table'] = 'materia';

$params_sel['sql_record'] = <<<END
    select
        *
    from
        materia
    where
        id = ?
END;
$params_sel['record_id'] = $params['record_id'];


include_once 'header.php';
require_once 'share/data_display.php';

unset($params_upd);
$params_upd['record_id'] = $params['record_id'];
$params_upd = params_encode($params_upd); 

unset($params_del);
$params_del['record_id'] = $params['record_id'];
$params_del['action'] = $params['table'] . '_delete';

if ((isset($params['record_id'])))
{
    $update_title = 'Editar este registro';
    $update_url = 'index.php?action=' . $params['table'] . '_update&params=' . $params_upd;
    echo "<a href=\"$update_url\">$update_title</a>";
    echo '<br>';

    echo '<br>';
    echo sak_display_record($params_sel);
    echo '<br>';
    echo sak_record_delete_form($params_del);
}



include_once 'footer.php';


