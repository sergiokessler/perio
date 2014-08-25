<?php

/*

$Id$

*/


require_once 'DB.php';



function get_fecha($new_row_arr)
{
    $fecha = $new_row_arr['Y'] . '-' . $new_row_arr['M'] . '-' . $new_row_arr['d'];
    return($fecha);
}


// <query>


// </query>




$db = DB::connect($config['db']) or die('Could connect to DB');

$table = 'urna_total';

// datos de las urnas

$urna_sql = <<<END
    select 
        urna_id, 
        urna_nombre 
    from 
        urna 
    where
        urna_id not in (select distinct urna_id from urna_total)
    order by 
        urna_nombre
END;
$urna_select = $db->getAssoc($urna_sql);

// datos de las listas

$lista_sql = "select lista_id, lista_nombre from lista order by orden";
$lista_select = $db->getAssoc($lista_sql);



$campos_cortos = array('size' => 4);
$campos_medios = array('size' => 8);
$campos_largos = array('size' => 64);

$votos_attr = array('size' => 8, 'pattern' => '\d*');

$textarea_attr = array('cols="64"');

$date_options = array(
    'language'  => 'es',
    'minYear'   => 2005,
    'maxYear'   => 2020
);

$date_options_fc = array(
    'language'  => 'es',
    'minYear'   => 1930,
    'maxYear'   => 2000
);


require_once 'HTML/QuickForm.php';
$form = new HTML_QuickForm('form', 'post');


// fields


$form->addElement('header', 'MyHeader', 'Carga de votos por urna');
$form->addElement('hidden', 'action', 'carga');
//$form->addElement('hidden', 'params', $params_fa);

$form->addElement('select', 'new_urna', 'Urna:', $urna_select);
$form->addRule('new_urna', 'Debe especificar una urna', 'required');
$form->addElement('static', 'info', '', 'Centro &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Claustro');
//$form->addElement('static', 'info', '', 'Claustro');

foreach($lista_select as $lista_id => $lista_nombre)
{
    unset($votos);
    $votos[] = &HTML_QuickForm::createElement('text', 'votos_centro', '', $votos_attr);
    $votos[] = &HTML_QuickForm::createElement('text', 'votos_claustro', '', $votos_attr);
    $form->addGroup($votos, "new_lista[$lista_id]", $lista_nombre . ':', '&nbsp;');
    $form->addGroupRule("new_lista[$lista_id]", 'Debe cargar los datos correctamente', 'numeric');
}

$form->addElement('static', 'info', '<div style="color:red">Por Favor, verifique los datos antes de guardar</div>', '');
$form->addElement('submit', 'btnSubmit', 'Guardar');


// rules



if (isset($_REQUEST['btnSubmit'])
    and
    $_REQUEST['btnSubmit'] == 'Guardar'
    and
    $form->validate())
{
    $new_urna = $_REQUEST['new_urna'];

    $new_lista = $_REQUEST['new_lista'];


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

        $res = $db->autoExecute($table, $new_row, DB_AUTOQUERY_INSERT);
        if (PEAR::isError($res)) {
            die( $res->getDebugInfo() );
        }
//    echo '<pre>';
//    var_dump($new_row);
//    echo '</pre>';
    }

    $action_continue = 'carga';
    $params['msg'] = 'Los datos han sido guardados satisfactoriamente.';
    $params = params_encode($params);

    $continue = "action=$action_continue&params=$params";

    return;
}


// <UI>




include_once 'header.php';

echo '<br>';
$form->display();

include_once 'footer.php';


?>
