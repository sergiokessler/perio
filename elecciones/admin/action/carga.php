<?php

/*
 * by Sak@perio
 */
# vim: set fileencoding=ISO-8859-1



$this_table = 'urna_total';
$this_action = 'carga';

// <query>


// </query>


$db = new PDO($db_dsn, $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);



$lista_select = array();
$lista_select_sql = 'select lista_id as k, lista_nombre as v from lista order by orden';
$lista_select_sql_data = array();
$st = $db->prepare($lista_select_sql);
$st->execute($lista_select_sql_data);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $lista_select[$row['k']] = htmlentities($row['v'], ENT_COMPAT, $db_charset);
}

$urna_select = array('' => '-- seleccione --');
$urna_select_sql = 'select urna_id as k, urna_nombre as v from urna where urna_id not in (select distinct urna_id from urna_total) order by urna_nombre';
$urna_select_sql_data = array();
$st = $db->prepare($urna_select_sql);
$st->execute($urna_select_sql_data);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $urna_select[$row['k']] = htmlentities($row['v'], ENT_COMPAT, $db_charset);
}



require_once 'lib/pear/HTML/QuickForm2.php';

$form = new HTML_QuickForm2('form', 'post', array('role' => 'form'));


// fields

// elements
$form->addElement('hidden', 'action')
     ->setValue($this_action)
     ;

$form->addElement('select', 'new_urna]', array('autofocus' => 'autofocus'))
     ->setLabel('Urna:')
     ->loadOptions($urna_select)
     ->addRule('required', 'Valor requerido')
     ;

$votos_attr_centro = array(
    'class' => 'form-inline col-xs-3',
    'maxlength' => 3, 
    'pattern' => '\d*', 
    'title' => 'Debe introducir solo numeros', 
    'placeholder' => 'Votos Centro'
);
$votos_attr_claustro = array(
    'class' => 'form-inline col-xs-3', 
    'maxlength' => 3, 
    'pattern' => '\d*', 
    'title' => 'Debe introducir solo numeros',
    'placeholder' => 'Votos Claustro'
);

foreach($lista_select as $lista_id => $lista_nombre)
{
    unset($votos);
    $form->addElement('static', null)
         ->setContent('<label for="votos" class="col-xs-6 text-right control-label">'.$lista_nombre.':</label>')
    ;
    //$form->addElement('static', null)
    //       ->setContent('<div class="col-xs-8 titus">')
    //;
    $form->addText("new_lista[$lista_id][votos_centro]", $votos_attr_centro);
    $form->addText("new_lista[$lista_id][votos_claustro]", $votos_attr_claustro);
    //$form->addElement('static', null)
    //       ->setContent('</div>')
    //;
}


$form->addElement('button', 'btnSubmit', array('type' => 'submit', 'value' => 'Guardar', 'class' => 'btn btn-lg btn-primary'))
     ->setContent('Guardar')
     ;

require_once 'HTML/QuickForm2/Renderer.php';
require_once 'HTML/QuickForm2/JavascriptBuilder.php';
$renderer = HTML_QuickForm2_Renderer::factory('default');
//$renderer->setJavascriptBuilder(new HTML_QuickForm2_JavascriptBuilder(null, __DIR__ . '/../lib/pear/data/HTML_QuickForm2/js')); 

$renderer->setOption(array(
    'errors_prefix' => 'El formulario contiene errores:',
    'required_note' => '<div><span class="required">*</span> denota campos requeridos</div>',
));



if (isset($_REQUEST['btnSubmit'])
    and
    $_REQUEST['btnSubmit'] == 'Guardar'
    and
    $form->validate())
{
    $new_urna = $_REQUEST['new_urna'];

    $new_lista = $_REQUEST['new_lista'];

    $db->beginTransaction();
    $inserted = 0;
    foreach ($new_lista as $lista_id => $votos)
    {
        unset($new_row);
        $new_row['urna_id'] = $new_urna;
        $new_row['lista_id'] = $lista_id;

        if (isset($votos['votos_centro']))
            $new_row['votos_centro'] = $votos['votos_centro'];
        else
            $new_row['votos_centro'] = 0;

        $new_row['votos_claustro'] = $votos['votos_claustro'];

        /****************************************************************
         * insert the record
         */
        $cols = implode(', ', array_keys($new_row));
        $vals = implode(', ', array_fill(0, count($new_row), '?'));

        $sql = "insert into $this_table ($cols) values ($vals)";
        $sql_data = array_values($new_row);

        $st = $db->prepare($sql);
        $st->execute($sql_data);

        $inserted++;
        /*
         * end insert the record
         ****************************************************************/ 
    }
    
    if (count($new_lista) == $inserted) {
        $db->commit();
        $params['msg'] = 'Los datos han sido guardados satisfactoriamente.';
    } else {
        $db->rollback();
        $params['msg'] = 'Los datos NO han sido guardados.';
    }

    $action_continue = 'carga';
    $params = params_encode($params);
    $continue = "?action=$action_continue&params=$params";

    return;
}


// <UI>




include_once 'header.php';

echo '<br>';
if (empty($lista_select)) {
    echo '<br>';
    echo '<div class="alert alert-warning">';
    echo 'No hay Listas para carga de votos';
    echo '</div>';
} elseif (count($urna_select) == 1) {
    echo '<br>';
    echo '<div class="alert alert-warning">';
    echo 'No hay Urnas disponibles para carga de votos';
    echo '</div>';
} else {
    $form->render($renderer);
    //echo $renderer->getJavascriptBuilder()->getLibraries(true, true);
    echo $renderer;
}


include_once 'footer.php';

