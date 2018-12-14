<?php


if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
}

require_once 'include/data_utils.php';


$params['table'] = 'libros';
$params['primary_key'] = 'inventario';
$params['action'] = 'material_update';
$params['continue'] = 'material_select';
// <query> 



include 'include/material_form.php';





if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar') )
{

    $new_row = cleanup_new_row($_POST['new_row']);

    //var_dump($_FILES);
    $files = array('archivo_digital', 'archivo_digital2', 'archivo_digital3', 'archivo_digital4', 'archivo_digital5');
    foreach($files as $file) {
        if (is_uploaded_file($_FILES[$file]['tmp_name']))
        {
            $filename = $new_row['autor'] . '_' . basename($_FILES[$file]['name']);
            $filename = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), $filename);
            $new_row[$file] = $filename;
            $filename = $config['app_root'] . "/../files/" . $filename;
            //$uploadfile = strtr($string, '.....ŔÂÄÇÉËÍĎŇÔÖŮŰÝáăĺčęěîńóőřúü', 'SZszYAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy');
    
            if (!move_uploaded_file($_FILES[$file]['tmp_name'], $filename)) {
                die($_FILES[$file]['error']);
            }
        }    
    }


    /***********************************************************
     * update the record
     **/
    $set = implode('=?, ', array_keys($new_row));
    $set .= '=?';

    $sql = "update $params[table] set $set where $params[primary_key] = ?";
    //var_dump($sql);
    //die();

    $sql_data = array_values($new_row);
    $sql_data[] = $record_id;

    $st = $db->prepare($sql);
    $st->execute($sql_data);
    /**
     ***********************************************************/
    
    
    $msg = "El registro a sido actualizado satisfactoriamente.";

                                  
    $params_cont = null;
    $params_cont['msg'] = $msg;
    $params_cont['record_id'] = $record_id;

    $continue = '?action=' . $params['continue'] . '&params=' . params_encode($params_cont);
}
else
{
    // <UI>
    include_once 'header.php';

    echo '<div class="page-header">';
    echo '  <h1>Material <small>Editando un registro</small></h1>';
    echo '</div>';

    echo $material_form;

    include_once 'footer.php'; 
}


