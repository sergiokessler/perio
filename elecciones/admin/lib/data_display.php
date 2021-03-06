<?php

// $Id: data_display.php,v 1.4 2007/05/08 16:40:06 develop Exp $

require_once 'lib/data_utils.php';



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


    $buscar = (bool) (isset($_REQUEST['btnSubmit'])) && ($_REQUEST['btnSubmit'] == 'Buscar');

    if (empty($_GET['search_conditions'])) {
        $search_conditions = 1;
    } else {
        $search_conditions = $_GET['search_conditions'];
    }

    if (($search_conditions < 1) or ($search_conditions > 10)) {
        $search_conditions = 1;
    }


    $form = '<form class="form-inline" name="form_search" method="get">';

    $form .= '<input type="hidden" name="action" value="' . $params['action'] . '">';

    // para que agarre este submit al presionar Enter
    $form .= '<input style="overflow: visible !important; height: 0 !important; width: 0 !important; margin: 0 !important; border: 0 !important; padding: 0 !important; display: block !important;" type="submit" name="btnSubmit" value="Buscar"/>';

//    $form .= '<input type="hidden" name="params" value="' . $params_f . '">';
    $form .= 'Buscar donde el campo:<br>';

    for ($i = 0; $i < $search_conditions; $i++)
    {
        if ($i > 0) {
            $form .= '<br> y <br>';
        }

        $form .= '<div class="form-group">';
        $form .= '<label class="sr-only" for="field[]">Campo</label>';
        $form .= '<select name="field[]">';
        foreach($field_meta['search'] as $key => $value)
        {
            if ( isset($_GET['field'][$i]) and ($_GET['field'][$i] == $key) )
                $form .= '<option selected value="' . $key . '">' . $value . '</option>';
            else
                $form .= '<option value="' . $key . '">' . $value . '</option>';
        }
        $form .= '</select>';
        $form .= '</div>';

        $form .= '<div class="form-group">';
        $form .= '<label class="sr-only" for="operator[]">Operador</label>';
        $form .= '<select name="operator[]">';
        foreach($operator as $key => $value)
        {
            if ( isset($_GET['operator'][$i]) and ($_GET['operator'][$i] == $key) )
                $form .= '<option selected value="' . $key . '">' . $value . '</option>';
            else
                $form .= '<option value="' . $key . '">' . $value . '</option>';
        }
        $form .= '</select>';
        $form .= '</div>';

        $form .= '<div class="form-group">';
        $form .= '<label class="sr-only" for="value[]">Valor</label>';
        if ( isset($_GET['value'][$i]) )
            $form .= '<input type="text" name="value[]" value="' . $_GET['value'][$i] . '">';
        else
            $form .= '<input type="text" name="value[]">';
        $form .= '</div>';
    }

    $form .= ' <button class="btn btn-default" type="submit" name="search_conditions" value="'. ($search_conditions+1) .'"> + </button>';
    if ($search_conditions > 1) {
        $form .= ' <button class="btn btn-default" type="submit" name="search_conditions" value="'. ($search_conditions-1) .'"> - </button>';
    }

    $form .= '<br>';

    $form .= 'Ordenado por: ';
    $form .= '<div class="form-group">';
//    $form .= '<label class="sr-only" for="field[]">Campo</label>';
    $form .= '<label class="sr-only" for="order">Orden</label>';
    $form .= '<select name="order">';
    foreach($field_meta['search'] as $key => $value)
    {
        if ( isset($_GET['order']) and ($_GET['order'] == $key) )
            $form .= '<option selected value="' . $key . '">' . $value . '</option>';
        else
            $form .= '<option value="' . $key . '">' . $value . '</option>';
    }
    $form .= '</select>';
    $form .= '</div>';

    $form .= '<br>';

    $form .= ' <button class="btn btn-primary" type="submit" name="btnSubmit" value="Buscar">Buscar</button>';
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




function sak_display_array_list($params, $field_mapping = null)
{
    global $db_charset;

    if (empty($params['data'])) {
        return _('No data found');
    }

    if (isset($params['primary_key'])) {
        $primary_key = $params['primary_key'];
    }
    if (isset($params['link_view'])) {
        $link_view = $params['link_view'];
    }

    $list_data = $params['data'];

    $html = '';
    $html .= '<table class="table table-striped">';

    // ***********************
    // <titulos>
    $html .= '<thead><tr>';

    $titulos = $list_data[0];
    foreach ($titulos as $key => $value)
    {
        if (isset($field_mapping[$key])) {
            $field_label = $field_mapping[$key];
        } else {
            $field_label = get_label($key);
        }
        $html .= '<th>' . $field_label . '</th>';
    }
    // </titulos>
    // ***********************


    $html .= '</tr></thead>'; 

    $html .= '<tbody>';
    $i = 0;
    foreach($list_data as $row)
    {
        $i++;
        
        $html .= '<tr>';

        // recorremos toda la fila
        foreach ($row as $field_name => $field_value)
        {
            $attr_td = '';
            if (!empty($params['attr_td'][$field_name])) {
                $attr_td = $params['attr_td'][$field_name];
            }
            $html .= "<td class=\"listado\" $attr_td>";
            $field_value = htmlentities($field_value, ENT_COMPAT, $db_charset);

            if (isset($link_view) and (isset($link_view[$field_name])) )
            {
                $params_link = array();

                if (isset($primary_key)) {
                    $params_link['record_id'] = $row[$primary_key];
                }

                $label = isset($link_view[$field_name]['label']) ? $label = $link_view[$field_name]['label'] : $field_value;

                $url_params = '';
                if(isset($link_view[$field_name]['url_params'])) {
                    foreach ($link_view[$field_name]['url_params'] as $p) {
                        $url_params .= '&amp;' . $p . '=' . urlencode($row[$p]);
                    }
                }
                $url_params_const = '';
                if(isset($link_view[$field_name]['url_params_const'])) {
                    foreach ($link_view[$field_name]['url_params_const'] as $k => $v) {
                        $url_params_const .= '&amp;' . $k . '=' . urlencode($v);
                    }
                }

                $params_link = params_encode($params_link);
                $url = $link_view[$field_name]['href'] . "&amp;params=$params_link" . $url_params . $url_params_const;

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
        $html .= 'Demasiados datos, solo se muestran los primeros ' . MAX_RECORDS_LIST . ' registros,<br>';
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

function sak_display_array_record($params, $field_mapping = null)
{
    global $db_charset;

    // get the record
    $row = $params['data'];

    $html[] = '<table class="table table-striped table-bordered table-condensed">';
    $html[] = '<tbody>';

    foreach($row as $field => $value)
    {
//        if ($value != '')
//        {
            $html[] =  '<tr>';
            $html[] = '<td>';
            if (isset($field_mapping[$field]))
                $html[] = $field_mapping[$field];
            else
                $html[] = get_label($field);
            $html[] = '</td>';
            $html[] = '<td>';
            // setup the link, if any
            if (isset($params['link_view'][$field])
                and 
                (!empty($value)) )
            {
                $label = !empty($params['link_view'][$field]['label']) ? $params['link_view'][$field]['label'] : $value;
                $href = $params['link_view'][$field]['href'];
                $html[] = "<a href=\"$href\">$label</a>";
            }
            else {
                $html[] = nl2br(htmlentities($value, ENT_COMPAT, $db_charset));
            }
            $html[] = '</td>';
            $html[] = '</tr>';
//        }
    } 
    $html[] = '</tbody>';
    $html[] = '</table>';

    return(implode($html));
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

