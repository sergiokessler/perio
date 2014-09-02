<?php

// $Id: data_display.php,v 1.4 2007/05/08 16:40:06 develop Exp $

require_once 'share/data_utils.php';



function sak_display_array_list($params, $field_mapping = null)
{
    global $config;

    if (empty($params['data'])) {
        return _('No data found');
    }

    if (isset($params['primary_key']))
    {
        $primary_key = $params['primary_key'];
        $link_view = $params['link_view'];
    }

    $list_data = $params['data'];

    $html = '<div class="table-responsive">';
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
            $html .= '<td class="listado">';
            $field_value = htmlentities($field_value, null, $encoding = 'ISO-8859-1');

            if (isset($link_view) and (isset($link_view[$field_name])) )
            {
                unset($params_link);
                $params_link['record_id'] = $row[$primary_key];
                $params_link = params_encode($params_link);

                if (!empty($field_value)) {
                    $label = isset($link_view[$field_name]['label']) ? $label = $link_view[$field_name]['label'] : $field_value;
                }
                if (!empty($link_view[$field_name]['href'])) {
                    $url = $link_view[$field_name]['href'] . "&amp;params=$params_link";
                    $html .= "<a href=\"$url\">$label</a>";
                } else {
                    $html .= $label;
                }
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
    $html .= '</div>'; 
    
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

function sak_display_array_record($params, $field_mapping = null)
{
    global $config;

    // get the record
    $row = $params['data'];

    $html[] = '<div class="table-responsive">';
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
                $html[] = nl2br(htmlentities(stripslashes($value), null, $encoding = 'ISO-8859-1'));
            }
            $html[] = '</td>';
            $html[] = '</tr>';
//        }
    } 
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';

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

