<?php

// $Id: data_display.php,v 1.4 2007/05/08 16:40:06 develop Exp $

require_once 'DB.php'; 
require_once 'HTML/QuickForm.php'; 
require_once 'share/data_utils.php';



function sak_search_form($params, $field_meta)
{
    $operator['ilike'] = 'contiene';
    $operator['='] = 'igual a';
    $operator['<='] = 'menor a';
    $operator['>='] = 'mayor a';

//        echo '<pre>';
//        var_dump($params);
//        echo '</pre>';


    $params_f = $params;
    $params_f = params_encode($params_f);


    $opciones['*'] = (bool) (isset($_REQUEST['btnOptions']));
    $opciones['+'] = (bool) (isset($_REQUEST['btnOptions'])) && ($_REQUEST['btnOptions'] == '+');
    $opciones['-'] = (bool) (isset($_REQUEST['btnOptions'])) && ($_REQUEST['btnOptions'] == '-');

    $buscar = (bool) (isset($_REQUEST['btnSubmit'])) && ($_REQUEST['btnSubmit'] == 'Buscar');


    if (!$opciones['*'] and !$buscar) {
        $_SESSION['search_conditions'] = 1;
    }
    if ($opciones['+']) {
        $_SESSION['search_conditions'] += 1;
    }
    if ($opciones['-']) {
        $_SESSION['search_conditions'] -= 1;
    }


    $form = '<form name="form_search" method="get">';

    $form .= '<input type="hidden" name="action" value="' . $params['table'] . '">';
//    $form .= '<input type="hidden" name="params" value="' . $params_f . '">';
    $form .= 'Buscar donde el campo:<br>';

    $search_conditions = $_SESSION['search_conditions'];
    for ($i = 0; $i < $search_conditions; $i++)
    {
        if ($i > 0) {
            $form .= ' y <br>';
        }

        $form .= '<select name="field[]">';
        foreach($field_meta['search'] as $key => $value)
        {
            if ( isset($_GET['field'][$i]) and ($_GET['field'][$i] == $key) )
                $form .= '<option selected value="' . $key . '">' . $value . '</option>';
            else
                $form .= '<option value="' . $key . '">' . $value . '</option>';
        }
        $form .= '</select>';

        $form .= '<select name="operator[]">';
        foreach($operator as $key => $value)
        {
            if ( isset($_GET['operator'][$i]) and ($_GET['operator'][$i] == $key) )
                $form .= '<option selected value="' . $key . '">' . $value . '</option>';
            else
                $form .= '<option value="' . $key . '">' . $value . '</option>';
        }
        $form .= '</select>';

        if ( isset($_GET['value'][$i]) )
            $form .= '<input type="text" name="value[]" value="' . $_GET['value'][$i] . '">';
        else
            $form .= '<input type="text" name="value[]">';
    }

    $form .= ' <input type="submit" name="btnOptions" value="+">';
    if ($search_conditions > 1)
        $form .= ' <input type="submit" name="btnOptions" value="-">';

    $form .= '<br> ordenado por ';
    $form .= '<select name="order">';
    foreach($field_meta['search'] as $key => $value)
    {
        if ( isset($_GET['order']) and ($_GET['order'] == $key) )
            $form .= '<option selected value="' . $key . '">' . $value . '</option>';
        else
            $form .= '<option value="' . $key . '">' . $value . '</option>';
    }
    $form .= '</select>';

    $form .= ' <input type="submit" name="btnSubmit" value="Buscar">';
    $form .= '</form>';
    
    return($form);
}

function sak_search_form_process($params)
{
    $field = $_GET['field'];
    $operator = $_GET['operator'];
    $value = $_GET['value'];
    $order = $_GET['order'];

    $where = null;

    for($i = 0; $i < count($value); $i++)
    {
        if ($value[$i] != '')
        {
            $where['where_arr'][] = ' ' . $field[$i] . ' ' . $operator[$i] . ' ? ';
            if ($operator[$i] == 'ilike')
                $where['params'][] =  '%' . $value[$i] . '%';
            else
                $where['params'][] =  $value[$i];
        }
    }

    $where['where_str'] = '';
    if (isset($where['where_arr']))
    {
        $where['where_str'] = join($where['where_arr'], ' and ');
        if (strpos($params['sql_list'], 'where') === False)
            $params['sql_where'] = ' where ' . $where['where_str'];
        else
            $params['sql_where'] = ' and ' . $where['where_str'];

        $params['sql_data']  = $where['params'];
    }
    else
    {
        $params['sql_where'] = null;
        $params['sql_data']  = null;
    }

    $params['sql_order'] = ' order by ' . $order;
    $params['op'] = 'select';
    unset($params['record_id']);

    return($params);
}

function sak_display_list($params, $field_mapping = null)
{
    global $config;

    if (isset($params['sql_full'])) {
        $sql = $params['sql_full'];
    } else
    {
        $sql = $params['sql_list'] . $params['sql_where'] . $params['sql_order'];
    }
    $sql_data = $params['sql_data'];

    if (isset($params['primary_key']))
    {
        $primary_key = $params['primary_key'];
        $link_view = $params['link_view'];
    }


    if (isset($params['db'])) {
        $db = $params['db'];
    } else {
        $db = DB::connect($config['db']) or die('Could not connect to DB');
        if (PEAR::isError($db)) {
            die( $db->getDebugInfo() );
        }
    }


    $res = $db->query($sql, $sql_data);
    if (PEAR::isError($res)) {
        die( $res->getDebugInfo() );
    }

    $html = '';
    $html .= '<table class="listado">';

    // ***********************
    // <titulos>
    $html .= '<thead><tr class="listado_title">';
    $table_info = $db->tableInfo($res);
    foreach ($table_info as $field_info)
    {
        if (isset($field_mapping[$field_info['name']])) {
            $field_label = $field_mapping[$field_info['name']];
        } else {
            $field_label = get_label($field_info['name']);
        }
        $html .= '<th class="listado">' . $field_label . '</th>';
    }
    // </titulos>
    // ***********************


    $html .= '</tr></thead>'; 

    $html .= '<tbody>';
    $i = 0;
    while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
    {
        if ($i % 2) $tr_style = 'listado_f1';
            else    $tr_style = 'listado_f2';
        $i++;
        
        $html .= '<tr class="' . $tr_style . '">';

        // recorremos toda la fila
        foreach ($row as $field_name => $field_value)
        {
            $html .= '<td class="listado">';
            $field_value = htmlentities($field_value);

            if (isset($link_view) and ($field_name == $link_view['field_name']) )
            {
                unset($params_link);
                $params_link['record_id'] = $row[$primary_key];
                $params_link = params_encode($params_link);

                if (isset($link_view['label'])) {
                    $label = $link_view['label'];
                } else {
                    $label = $field_value;
                }
                $url = "index.php?action=" . $link_view['action'] . "&amp;params=$params_link";
                $html .= "<a href=\"$url\">$label</a>";
            }
            else
                $html .= $field_value;
            $html .= '</td>';
        }

        $html .= '</tr>';

        if ($i == MAX_RECORDS_LIST)
            break;
    }

    $html .= '</tbody>';
    $html .= '</table>'; 
    
    if ($i == MAX_RECORDS_LIST)
    {
        $html .= 'Demasiados datos, solo se muestran los primeros 500 registros,<br>';
        $html .= 'utilize Exportar reporte para ver todos los datos.';
    }
    else
    {
        if (isset($params['display_record_count'])) {
            $html .= 'Un total de ' . $i . ' registros.';
        }
    }

    if (isset($params['enable_export']))
    {
        unset($params_exp);
        $params_exp['sql'] = $sql;
        $params_exp['sql_data'] = $sql_data;
        if ($field_mapping != null) {
            $params_exp['field_mapping'] = $field_mapping;
        }
        $params_exp = params_encode($params_exp);

        $title = 'Exportar reporte';
        $url = 'index.php?action=export&params=' . $params_exp;

        $html .= '<br>';
        $html .= "<a href=\"$url\">$title</a>";
        $html .= '<br>';
    }

    return($html);
}



function sak_display_array_list($params, $field_mapping = null)
{
    global $config;

    if (isset($params['primary_key']))
    {
        $primary_key = $params['primary_key'];
        $link_view = $params['link_view'];
    }

    $list_data = $params['data'];

    $html = '';
    $html .= '<table class="listado">';

    // ***********************
    // <titulos>
    $html .= '<thead><tr class="listado_title">';

    $titulos = $list_data[0];
    foreach ($titulos as $key => $value)
    {
        if (isset($field_mapping[$key])) {
            $field_label = $field_mapping[$key];
        } else {
            $field_label = get_label($key);
        }
        $html .= '<th class="listado">' . $field_label . '</th>';
    }
    // </titulos>
    // ***********************


    $html .= '</tr></thead>'; 

    $html .= '<tbody>';
    $i = 0;
    foreach($list_data as $row)
    {
        if ($i % 2) $tr_style = 'listado_f1';
            else    $tr_style = 'listado_f2';
        $i++;
        
        $html .= '<tr class="' . $tr_style . '">';

        // recorremos toda la fila
        foreach ($row as $field_name => $field_value)
        {
            $html .= '<td class="listado">';
            $field_value = htmlentities($field_value);

            if (isset($link_view) and ($field_name == $link_view['field_name']) )
            {
                unset($params_link);
                $params_link['record_id'] = $row[$primary_key];
                $params_link = params_encode($params_link);

                if (isset($link_view['label'])) {
                    $label = $link_view['label'];
                } else {
                    $label = $field_value;
                }
                $url = "index.php?action=" . $link_view['action'] . "&amp;params=$params_link";
                $html .= "<a href=\"$url\">$label</a>";
            }
            else
                $html .= $field_value;
            $html .= '</td>';
        }

        $html .= '</tr>';

        if ($i == MAX_RECORDS_LIST)
            break;
    }

    $html .= '</tbody>';
    $html .= '</table>'; 
    
    if ($i == MAX_RECORDS_LIST)
    {
        $html .= 'Demasiados datos, solo se muestran los primeros 500 registros,<br>';
        $html .= 'utilize Exportar reporte para ver todos los datos.';
    }
    else
    {
        if (isset($params['display_record_count'])) {
            $html .= 'Un total de ' . $i . ' registros.';
        }
    }

    if (isset($params['enable_export']))
    {
        unset($params_exp);
        $params_exp['sql'] = $sql;
        $params_exp['sql_data'] = $sql_data;
        if ($field_mapping != null) {
            $params_exp['field_mapping'] = $field_mapping;
        }
        $params_exp = params_encode($params_exp);

        $title = 'Exportar reporte';
        $url = 'index.php?action=export&params=' . $params_exp;

        $html .= '<br>';
        $html .= "<a href=\"$url\">$title</a>";
        $html .= '<br>';
    }

    return($html);
}



function sak_display_record($params, $field_mapping = null)
{
    global $config;

    $sql = $params['sql_record'];
    $sql_data = array($params['record_id']);


    if (isset($params['db'])) {
        $db = $params['db'];
    } else {
        $db = DB::connect($config['db']);
        if (PEAR::isError($db)) {
            die( $db->getDebugInfo() );
        }
    }

    // get the record
    $row = $db->getRow($sql, $sql_data, DB_FETCHMODE_ASSOC);
    if (PEAR::isError($row)) {
        die($row->getDebugInfo());
    }

    $html  = '<table class="record">';
    $html .= '<tbody>';

    $i = 0;
    foreach($row as $field => $value)
    {
        if ($i % 2) $tr_style = 'record_f1';
            else    $tr_style = 'record_f2';
        $i++;

//        if ($value != '')
//        {
            $html .=  '<tr class="' . $tr_style . '">';
            $html .= '<td class="record_field_name">';
            if (isset($field_mapping[$field]))
                $html .= $field_mapping[$field];
            else
                $html .= get_label($field);
            $html .= '</td>';
            $html .= '<td class="record_field_value">';
            $html .= nl2br(htmlentities(stripslashes($value)));
            $html .= '</td>';
            $html .= '</tr>';
//        }
    } 
    $html .= '</tbody>';
    $html .= '</table>'; 

    return($html);
}

function sak_display_array_record($params, $field_mapping = null)
{
    global $config;

    // get the record
    $row = $params['data'];

    $html  = '<table class="record">';
    $html .= '<tbody>';

    $i = 0;
    foreach($row as $field => $value)
    {
        if ($i % 2) $tr_style = 'record_f1';
            else    $tr_style = 'record_f2';
        $i++;

//        if ($value != '')
//        {
            $html .=  '<tr class="' . $tr_style . '">';
            $html .= '<td class="record_field_name">';
            if (isset($field_mapping[$field]))
                $html .= $field_mapping[$field];
            else
                $html .= get_label($field);
            $html .= '</td>';
            $html .= '<td class="record_field_value">';
            $html .= nl2br(htmlentities(stripslashes($value)));
            $html .= '</td>';
            $html .= '</tr>';
//        }
    } 
    $html .= '</tbody>';
    $html .= '</table>'; 

    return($html);
}



function sak_record_delete_form($params)
{
    $params['op'] = 'delete';
    $params_f = params_encode($params);
    
    $delete_form  = '<form method="post" name="delete_record">';
    $delete_form .= '<input type="hidden" name="action" value="' . $params['action'] . '">';
    $delete_form .= '<input type="hidden" name="params" value="' . $params_f . '">';
    $delete_form .= '<input type="submit" name="btnSubmit" value="Eliminar registro">';
    $delete_form .= '</form>';

    return($delete_form);
}

