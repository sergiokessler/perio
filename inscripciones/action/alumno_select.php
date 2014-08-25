<?php

/*

$Id$

*/


$params['table'] = 'alumno';

$params_sel['sql_record'] = <<<END
    select
        *
    from
        alumno
    where
        id = ?
END;
$params_sel['record_id'] = $params['record_id'];


include_once 'header.php';
require_once 'share/data_display.php';

unset($params_upd);
$params_upd['record_id'] = $params['record_id'];
$params_upd = params_encode($params_upd);

unset($params_ins);
$params_ins['record_id'] = $params['record_id'];
$params_ins['action'] = $params['table'] . '_inscripcion';

if ((isset($params['record_id'])))
{
    $update_title = 'Editar este registro';
    $update_url = 'index.php?action=' . $params['table'] . '_update&params=' . $params_upd;
    echo "<a href=\"$update_url\">$update_title</a>";
    echo '<br>';

    echo '<br>';
    echo sak_display_record($params_sel);
    echo '<br>';
    $_SESSION['alumno_id'] = $params['record_id'];
    echo 'Este alumno ha sido seleccionado para inscripcion.<br>';
    $update_title = 'Ir a sus inscripciones';
    $update_url = 'index.php?action=inscripcion';
    echo "<a href=\"$update_url\">$update_title</a>";
}



include_once 'footer.php';


