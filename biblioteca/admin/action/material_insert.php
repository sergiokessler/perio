<?php

require_once 'include/data_utils.php';


$params['action']       = 'material_insert';
$params['continue']     = 'material_select';
$params['table']        = 'libros';
$params['primary_key']  = 'inventario';
//$params['seq']          = $params['table'] . '_' . $params['primary_key'] . '_seq';


$form_params = params_encode($params);

include 'include/material_form.php';



/***************************************************
 * processing
 ***************************************************/


if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar') )
{

    $new_row = cleanup_new_row($_POST['new_row']);


    //var_dump($_FILES);
    //var_dump($_REQUEST);
    $files = array('archivo_digital', 'archivo_digital2', 'archivo_digital3', 'archivo_digital4', 'archivo_digital5');
    foreach($files as $file) {
        if (is_uploaded_file($_FILES[$file]['tmp_name']))
        {
            $filename = $new_row['autor'] . '_' . basename($_FILES[$file]['name']);
            $filename = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), $filename);
            $new_row[$file] = $filename;
            $filename = $config['app_root'] . "/../files/" . $filename;
            //$uploadfile = strtr($string, '.....ÀÂÄÇÉËÍÏÒÔÖÙÛÝáãåèêìîñóõøúü', 'SZszYAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy');
    
            if (!move_uploaded_file($_FILES[$file]['tmp_name'], $filename)) {
                die($_FILES[$file]['error']);
            }
        }    
    }


    $cols = implode(', ', array_keys($new_row));
    $vals = implode(', ', array_fill(0, count($new_row), '?'));

    $sql = "insert into $params[table] ($cols) values ($vals)";
    $sql_data = array_values($new_row);

    $db = new PDO($config['db']['dsn']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st = $db->prepare($sql);
    try {
        $st->execute($sql_data);
    } catch(PDOException $e) {
        die($e->getMessage());
    }
    $msg = "El registro ha sido ingresado satisfactoriamente.";

//    $record_id = $db->lastInsertId($params['seq']); 
    $record_id = $new_row['inventario'];


/*
    echo '<pre>';
    var_dump($record_id);
    var_dump($qry);
    echo '</pre>';
    die();
*/    
    unset($params_cont);
    $params_cont['msg'] = $msg;
    $params_cont['record_id'] = $record_id;
    $params_cont = params_encode($params_cont);
    $continue = '?action=' . $params['continue'] . '&params=' . $params_cont;
    return;
}



// <UI>
include_once 'header.php';

echo '<div class="page-header">';
echo '  <h1>Material <small>Agregar un registro</small></h1>';
echo '</div>'; 

echo $material_form;

 
include_once 'footer.php';


