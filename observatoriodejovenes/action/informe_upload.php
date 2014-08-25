<?php


require_once 'share/data_utils.php';


$form = <<<END
<form method="post" enctype="multipart/form-data">
    Archivo del informe: <br />
    <input type="file" name="informe" size="25" />
    <br />
    <div class="form-actions"><input type="submit" value="Guardar" name="btnSubmit" id="btnSubmit-0" class="btn btn-primary" /></div>
</form>
END;




if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar')
   )
{

    $target_path = "informes/";

    $target_path = $target_path . basename( $_FILES['informe']['name']); 

    if(move_uploaded_file($_FILES['informe']['tmp_name'], $target_path)) {
       $msg = "El archivo " . basename( $_FILES['informe']['name']) . " ha siso subido.";
    } else{
       $msg = "Hubo un error subiendo el archivo, por favor, intente nuevamente.";
       $msg.= '<br />' . $_FILES['informe']['tmp_name'];
       $msg.= '<br />' . $_FILES['informe']['error'];
    }
    

    unset($params_cont);
    $params_cont['msg'] = $msg;
    $params_cont['record_id'] = $record_id;
    $params_cont = params_encode($params_cont);

    $continue = '?action=informe_upload' . '&params=' . $params_cont;
}
else
{
    // <UI>
    include_once 'header.php';

    echo '<div class="page-header">';
    echo '  <h1>Medio<small> Agregar un informe</small></h1>';
    echo '  <img class="pull-right" src="img/logo_sumar_small.png">';
    echo '</div>';


    echo $form;
    
    include_once 'footer.php';
}


