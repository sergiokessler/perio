<?php

/*

$Id$

*/



$table = $params['table'];
$table_pk = $params['primary_key'];
$sql = $params['sql_list'];


$params_insert = $params;
$params_insert['op'] = 'insert';
$params_insert = params_encode($params_insert);
$title_insert = 'Agregar registro';
$url_insert = 'index.php?action=table&params=' . $params_insert;

$params_update = $params;
$params_update['op'] = 'update';
$params_update = params_encode($params_update);
$title_update = 'Editar registro';
$url_update = 'index.php?action=table&params=' . $params_update;




if ( ($params['op'] == 'insert') or
     ($params['op'] == 'update') )
{
    require_once 'share/data_manage.php';

    $form_record =& sak_record_form($params);

    if ( (isset($_REQUEST['btnSubmit']))
         and
         ($_REQUEST['btnSubmit'] == 'Guardar')
         and
         ($form_record->validate()) )
    {
        $msg = $form_record->process('sak_record_form_process', false);
                                  
        $params['msg'] = $msg;
        $params['op'] = 'select';
        unset($params['record_id']);
        $params = params_encode($params);

        $continue = 'action=table&params=' . $params;

        return;
    }
    else
    {
        if ($params['op'] == 'insert')
            $params['msg'] = 'Insertando un registro en la tabla "' . $params['table'] . '"';
        if ($params['op'] == 'update')
            $params['msg'] = 'Editando un registro en la tabla "' . $params['table'] . '"';
    }
}

if ( ($params['op'] == 'delete') )
{
    if ( (isset($_REQUEST['btnSubmit']))
         and
         ($_REQUEST['btnSubmit'] == 'Eliminar registro') )
    {
        require_once 'share/data_manage.php';

        $msg = sak_record_form_process();
                      
        $params['msg'] = $msg;
        $params['op'] = 'select';
        unset($params['record_id']);
        $params = params_encode($params);

        $continue = 'action=table&params=' . $params;

        return;
    }
}



//if ( (!isset($_REQUEST['btnSubmit']))
//      or
//     ($_REQUEST['btnSubmit'] != 'Guardar') )
//{
    include_once 'header.php';
    require_once 'share/data_display.php';

    

    unset($params['sql_where']);
    unset($params['sql_data']);
    $params_fs = $params;
    unset($params_fs['msg']);
    if ( (isset($_REQUEST['btnSubmit']))
        and
         ($_REQUEST['btnSubmit'] == 'Mas opciones') )
    {                            
        $params_fs['conditions'] += 1;
    }
    $form_search = sak_search_form($params_fs);

    if ($params['conditions'] > 0)
        echo $form_search;


    echo "<a href=\"$url_insert\">$title_insert</a>";
    echo '<br>';     

    if (isset($params['msg']))
    {
        echo $params['msg'];
        unset($params['msg']);
    }
    echo '<br>';

    if ( (isset($_REQUEST['btnSubmit']))
         and
         ($_REQUEST['btnSubmit'] == 'Buscar') )
    {                            
        $params = sak_search_form_process($params);
        echo sak_display_list($params);
    }

    if (($params['op'] == 'select') and (isset($params['record_id'])))
    {
        echo "<a href=\"$url_update\">$title_update</a>";
        echo '<br>';

        echo 'Visualizando un registro de la tabla "' . $params['table'] . '"';
        echo '<br>';
        echo sak_display_record($params);
        echo '<br>';
        echo sak_record_delete_form($params);
    }

if ( ($params['op'] == 'insert') or
     ($params['op'] == 'update') )
{
        $form_record->display();
//        include_once 'footer.php';
}


include_once 'footer.php';






