<?php


function get_label($name)
{
    $label = str_replace('_', ' ', $name);
    $label = ucwords($label);
    return($label);
}

function get_date($new_row_arr)
{
    $fecha = $new_row_arr['Y'] . '-' . $new_row_arr['M'] . '-' . $new_row_arr['d'];
    if ($fecha == '--') {
        return(null);
    }
    $fecha = date('d/m/Y', strtotime($fecha));
    return($fecha);
} 

function get_datetime($new_row_arr)
{
    $fecha = $new_row_arr['Y'] . '-' . $new_row_arr['M'] . '-' . $new_row_arr['d'] . ' ' . $new_row_arr['H'] . ':' . $new_row_arr['i'];
    $fecha = date('d/m/Y H:i', strtotime($fecha));
    return($fecha);
} 

function cleanup_new_row($new_row)
{
    foreach($new_row as $key => $value)
    {
        if (is_array($value) and isset($value['i'])) {
            $new_row[$key] = get_datetime($value);
        }
        else
        if (is_array($value) and isset($value['d'])) {
            $new_row[$key] = get_date($value);
        }
        else
        if ($value == '') {
            $new_row[$key] = null;
        }
    }
    return($new_row);
}
 


