<?php


require_once 'share/data_utils.php';


$params['table'] = 'nota';
$params['primary_key'] = 'nota_id';
$params['action'] = 'nota_insert';
$params['continue'] = 'nota';
// <query> 


include 'action/nota_form.php';




if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar')
     and
     ($form->validate()) )
{

    $new_row = cleanup_new_row($_POST['new_row']);

    // custom
    $new_row['region_id'] = $_POST['region'][2];

    $new_row['carga_usuario'] = $_SESSION['u'];
    $new_row['carga_fecha'] = date('Y-m-d h:i');


    /****************************************************************
     * insert the record
     */
    $db = new PDO($config['db']['dsn']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $cols = implode(', ', array_keys($new_row));
    $vals = implode(', ', array_fill(0, count($new_row), '?'));

    $sql = "insert into $params[table] ($cols) values ($vals)";
    $sql_data = array_values($new_row);

    $st = $db->prepare($sql);
    $st->execute($sql_data);
    
    $msg = "El registro a sido ingresado satisfactoriamente.";

    $record_id = $db->lastInsertId();
    /*
     * end insert the record
     ****************************************************************/

    /****************************************************************
     *  FTS
     */
    $fts = implode($new_row, ' ');
    $fts .= ' ' . $medio_select[$new_row['medio_id']];
    $fts = strtr($fts, $normalizeChars);

    $sql = "insert into nota_fts (nota_id, content) values (?, ?)";
    $sql_data = array($record_id, $fts);

    $st = $db->prepare($sql);
    $st->execute($sql_data);
    /*
     * end FTS
     ****************************************************************/

    


    unset($params_cont);
    $params_cont['msg'] = $msg;
    $params_cont['record_id'] = $record_id;
    $params_cont = params_encode($params_cont);

    $continue = '?action=' . $params['continue'] . '&params=' . $params_cont;
}
else
{
    // <UI>
    include_once 'header.php';

    echo '<div class="page-header">';
    echo '  <h1>Nota <small>Agregar un registro</small></h1>';
    echo '</div>';

    echo '<p>Si el medio no se encuentra disponible aqui abajo, debe cargar el mismo haciendo click en <a href="?action=medio_insert">Cargar Medio</a></p>';
    echo '<br>';
    echo "\n\n";


    // Output javascript libraries, needed by hierselect
    $form->render($renderer);
    echo $renderer->getJavascriptBuilder()->getLibraries(true, true);
    echo $renderer;  
    //echo $form;


    include_once 'footer.php';
}


