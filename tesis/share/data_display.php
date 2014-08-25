<?php

// $Id$

require_once 'DB.php'; 
require_once 'HTML/QuickForm.php'; 
require_once 'share/data_utils.php';



function sak_search_form($params)
{
    $field_meta['search'] = $params['search'];

    $operator['ilike'] = 'contiene';
    $operator['='] = '=';
    $operator['<='] = '<=';
    $operator['>='] = '>=';

//        echo '<pre>';
//        var_dump($params);
//        echo '</pre>';


    $params_f = $params;
    $params_f = params_encode($params_f);

    $form = '<form name="form_search" method="get">';

    $form .= '<input type="hidden" name="action" value="table">';
    $form .= '<input type="hidden" name="params" value="' . $params_f . '">';
    $form .= 'Buscar donde el campo ';

    for ($i = 0; $i < $params['conditions']; $i++)
    {
        $form .= '<select name="field[]">';
        foreach($field_meta['search'] as $key => $value)
        {
            $form .= '<option value="' . $key . '">' . $value . '</option>';
        }
        $form .= '</select>';

        $form .= '<select name="operator[]">';
        foreach($operator as $key => $value)
        {
            $form .= '<option value="' . $key . '">' . $value . '</option>';
        }
        $form .= '</select>';

        $form .= '<input type="text" name="value[]">';
    }

    $form .= ' <input type="submit" name="btnSubmit" value="Buscar">';
    $form .= ' <input type="button" name="btnSubmit" value="Mas Opciones">';
    $form .= '</form>';
    
    return($form);
}

function sak_search_form_process($params)
{
    $field = $_GET['field'];
    $operator = $_GET['operator'];
    $value = $_GET['value'];

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

        
    $params['op'] = 'select';
    unset($params['record_id']);

    return($params);
}

function sak_display_list($params, $field_mapping = null)
{
    global $config;

    $sql = $params['sql_list'];
    $sql_data = $params['sql_data'];
    if (isset($params['sql_where'])) {
        $sql .= ' ' . $params['sql_where'];
    }
    if (isset($params['sql_order_by'])) {
        $sql .= ' ' . $params['sql_order_by'];
    }
    if (isset($params['primary_key'])) {
        $primary_key = $params['primary_key'];
    }
    if (isset($params['primary_key_action'])) {
        $primary_key_action = $params['primary_key_action'];
    }



    unset($params_exp);
    $params_exp['sql'] = $params['sql_list'];
    $params_exp['sql_data'] = $params['sql_data'];
//    $params_exp['field_mapping'] = $params['field_mapping'];
    $params_exp = params_encode($params_exp);

    $title = 'Exportar reporte';
    $url = 'index.php?action=export&params=' . $params_exp;
    $html  = "<a href=\"$url\">$title</a>";
    $html .= '<br>'; 


    $db = DB::connect($config['db']) or die('Could connect to DB');
    if (PEAR::isError($db)) {
        die( $db->getDebugInfo() );
    }


    $res = $db->query($sql, $sql_data);
    if (PEAR::isError($res)) {
        die( $res->getDebugInfo() );
    }

    $html .= '<table class="listado">';

    // titulos !
    $html .= '<thead><tr class="title">';
    if (isset($field_mapping))
    {
        foreach($field_mapping as $field_name => $field_label)
        {
            $html .= '<th class="listado">' . $field_label . '</th>';
        }
    }
    else
    {
        $table_info = $db->tableInfo($res);
//        echo '<pre>';
//        var_dump($res);
//        echo '</pre>';
        foreach ($table_info as $field_info)
        {
            $field_label = get_label($field_info['name']);
            $html .= '<th class="listado">' . $field_label . '</th>';
        }

    }


    $html .= '</tr></thead>';

    $html .= '<tbody>';
    $i = 0;
    while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
    {
        if ($i % 2) $tr_style = 'f1';
            else    $tr_style = 'f2';
        $i++;
        
        $html .= '<tr class="' . $tr_style . '">';
        if (isset($field_mapping))
        {
            foreach($field_mapping as $field_name => $field_label)
            {
                $html .= '<td class="listado">' . $row[$field_name] . '</td>';
            }
        }
        else
        {
            foreach ($table_info as $field_info)
            {
                $html .= '<td class="listado">';
                $field_value = nl2br($row[$field_info['name']]);

                if ($field_info['name'] == $primary_key)
                {
                    $params['record_id'] = $field_value;
                    $params_id = params_encode($params);

                    $title = $field_value;
                    if (isset($primary_key_action))
                    {
                        $url = "index.php?action=$primary_key_action&params=$params_id";
                    } else
                    {
                        $url = "index.php?action=table&params=$params_id";
                    }
                    $html .= "<a href=\"$url\">$title</a>";
                }
                else
                    $html .= $field_value;
                $html .= '</td>';
            }
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
        $html .= 'Un total de ' . $i . ' registros.';
    }
    $html .= '<br>';

    return($html);
}



function sak_display_record($params, $field_mapping = null)
{
    global $config;

    $sql = $params['sql_record'];
    $sql_data = array($params['record_id']);


    $db = DB::connect($config['db']) or die('Could connect to DB');

    // get the record
    $row = $db->getRow($sql, $sql_data, DB_FETCHMODE_ASSOC);
    if (PEAR::isError($row)) {
        die($row->getDebugInfo());
    }
 
    
    $html  = '<table class="listado">';
    $html .= '<tbody>';

    $i = 0;
    foreach($row as $field => $value)
    {
        if ($i % 2) $tr_style = 'f1';
            else    $tr_style = 'f2';
        $i++;

//        if ($value != '')
//        {
            $html .=  '<tr class="' . $tr_style . '">';
            $html .= '<td class="listado">';
            $html .= get_label($field);
            $html .= '</td>';
            $html .= '<td class="listado">';
            $html .= nl2br(stripslashes($value));
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
    $delete_form .= '<input type="hidden" name="action" value="table">';
    $delete_form .= '<input type="hidden" name="params" value="' . $params_f . '">';
    $delete_form .= '<input type="submit" name="btnSubmit" value="Eliminar registro">';
    $delete_form .= '</form>';

    return($delete_form);
}

