<?php

/*

$Id: base_new_from_file.php,v 1.28 2007/05/09 20:31:34 develop Exp $

*/


require_once 'DB.php';


function cleanup_phone($phone)
{
    $phone = str_replace(' ', '', $phone);
    $phone = str_replace('(', '', $phone);
    $phone = str_replace(')', '', $phone);
    $phone = str_replace('-', '', $phone);
    $phone = str_replace('.', '', $phone);
    return($phone);
}


require_once 'HTML/QuickForm.php';
$uploadForm = new HTML_QuickForm('upload_form', 'post');
$uploadForm->setRequiredNote('<span style="color:#ff0000;">*</span> = campos requeridos.');
$uploadForm->addElement('header', 'MyHeader', 'Importar alumnos desde una planilla');
$uploadForm->addElement('hidden', 'action', 'alumno_import');
$file =& $uploadForm->addElement('file', 'filename', 'Archivo:');
$uploadForm->setMaxFileSize(5120000);

$uploadForm->addRule('filename', 'Debe seleccionar un archivo', 'uploadedfile');

$uploadForm->addElement('submit', 'btnUpload', 'Cargar Base');

$field_names_ok = array (
    'legajo',
    'nombre',
    'doc_nro',
    'email',
    'telefono',
    'orientacion',
    'notas'
    );


if ($uploadForm->validate())
{
    unset($params);
    $params['time0'] = time();
    
    $uploaded_file = $_FILES['filename']['tmp_name'];
    $handle = fopen ($uploaded_file, 'r');
    if(!$handle) {
        die ('Error al abrir el archivo ' . $uploaded_file);
    }

    // get field names in the first line
    $field_names = fgetcsv ($handle, 4096, chr(9));
    
    // check field names
    $field_diff = array_diff($field_names_ok, $field_names);
    if (count($field_diff) > 0) {
        echo 'Los nombres de los campos en el archivo subido estan mal.<br>';
        print_r($field_diff);
        exit();
    }

    // seteamos estos valores antes para que no se calculen en el loop
    $rows_inserted = 0;
    $rows_totals = 0;

    $db = DB::connect($config['db']) or die('Could connect to DB');
   
    $res =& $db->query('begin transaction');
    if (PEAR::isError($res)) {
        die( $res->getDebugInfo() );
    }

    
    //echo implode(' - ', $field_names);
    //echo '<br>';
    
    while($row = fgetcsv ($handle, 4096, chr(9)))
    {
        if (implode('', $row) == '')
            continue;
            
        $rows_totals++;
        unset($new_row);
      
        foreach ($row as $field => $value)
        {
            if ($value != '')
            {
                $field_name = $field_names[$field];
                $new_row[$field_name] = $value;
            }
        }


        // si el legajo ya existe, pasamos al proximo
        if (isset($new_row['legajo'])) {
            $res =& $db->query('SELECT * FROM alumno where legajo = ?', array($new_row['legajo']));
            if ($res->numRows() > 0)
                continue;
        }

        if (isset($new_row['nombre'])) {
            $new_row['nombre'] = substr($new_row['nombre'], 0, 256);
        }
            
        // insertamos un registro en la tabla cliente
        $res = $db->autoExecute('alumno', $new_row, DB_AUTOQUERY_INSERT);
        if (PEAR::isError($res)) {
            $db->query('abort transaction');
            die( $res->getDebugInfo() );
        }
        $rows_inserted++;
        //echo 'registro insertado.<br>';
    }
    fclose ($handle);
    
    // cerramos la transaction
    if ($rows_inserted > 0) {
        $res =& $db->query('commit transaction');
    }
    else {
        $res =& $db->query('rollback transaction');
    }
    if (PEAR::isError($res)) {
        die( $res->getDebugInfo() );
    }

    $params['filename'] = $_FILES['filename']['name'];
    $params['rows_inserted'] = $rows_inserted;
    $params['rows_totals'] = $rows_totals;
    $params = params_encode($params);

    $continue = 'action=alumno_import_end&params=' . $params;        
}
else {
    // <UI>
    include_once 'header.php';
    $uploadForm->display();
    echo '<br>';
    echo '<b>Nota:</b> esta operacion carga alumnos en la base de inscripciones, si el nro de legajo de un alumno ya se encuentra cargado, no se carga, y se prosigue con el proximo.';
    echo '<br>';
    echo 'Si no cuenta con un archivo para importar,<BR>haga click aquí para bajar el: ';
	echo '<a href="modelo_alta.xls" type="application/vnd.ms-excel" target="_blank">Modelo de planilla para importar alumnos</a>';
    echo '<br><br>';
	echo '<b>Indicaciones de uso :</b><BR>';
    echo '1.- Llenar la planilla (el campo "nombre" es requerido)';
    echo '<br>';
    echo '2.- Guardar la planilla como tipo: Texto (delimitado por tabulaciones).';
    echo '<br>';
    echo '3.- Seleccionar el archivo en el formulario y subirlo.';

    include_once 'footer.php';
}


