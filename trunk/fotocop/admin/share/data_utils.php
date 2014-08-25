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
    $fecha = date('Y-m-d', strtotime($fecha));
    return($fecha);
} 

function cleanup_new_row($new_row)
{
    foreach($new_row as $key => $value)
    {
        if (is_array($value) and isset($value['d']))
            $new_row[$key] = get_date($value);

        if ($value == '')
            $new_row[$key] = null;
    }
    return($new_row);
}
 


