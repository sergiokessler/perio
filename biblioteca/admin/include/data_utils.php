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
 
/**
 * Sanitizes a filename replacing whitespace with dashes
 *
 * Removes special characters that are illegal in filenames on certain
 * operating systems and special characters requiring special escaping
 * to manipulate at the command line. Replaces spaces and consecutive
 * dashes with a single dash. Trim period, dash and underscore from beginning
 * and end of filename.
 *
 * @since 2.1.0
 *
 * @param string $filename The filename to be sanitized
 * @return string The sanitized filename
 */
function sanitize_file_name( $filename ) {
    $filename_raw = $filename;
    $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}");
    $special_chars = apply_filters('sanitize_file_name_chars', $special_chars, $filename_raw);
    $filename = str_replace($special_chars, '', $filename);
    $filename = preg_replace('/[\s-]+/', '-', $filename);
    $filename = trim($filename, '.-_');
    return apply_filters('sanitize_file_name', $filename, $filename_raw);
}


