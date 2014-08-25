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
    return($fecha);
} 



