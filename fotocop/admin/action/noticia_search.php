<?php

include 'share/data_utils.php';


$sql_list = <<<END
    select 
        *    
    from 
        noticia
END;

require_once 'HTML/QuickForm.php';
include 'share/form_common.php';

$form = new HTML_QuickForm('form', 'get');
$form->addElement('hidden', 'action', 'noticia_search');
$form->addElement('text',   'new_row[titulo]', ' Título:', $campo_largo);


$form->addElement('submit', 'btnSubmit', 'Buscar');



include_once 'header.php';

echo '<h2>Buscar noticias</h2>';
$form->display();


$link_url = 'index.php?action=noticia_insert';
$link_label = 'Ingresar noticia nueva';
echo '<br>'; 
echo "<a href=\"$link_url\">$link_label</a>"; 
echo '<br>'; 
echo '<br>'; 



if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Buscar')
     and
     ($form->validate()) ) 
{

    $sql_where = '';
    $sql_data = array();

    $new_row = $_GET['new_row'];

    if ($new_row['titulo'] != '')
    {
        $sql_where .= ' and titulo ilike ? ';
        $sql_data[] = '%' . $new_row['titulo'] . '%';
    }

    $sql = $sql_list . ' where 1 = 1 ' . $sql_where . ' order by fecha_registro desc';
//    var_dump($sql);
//    var_dump($sql_data);

    $db = new PDO($config['db']['dsn']); 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st = $db->prepare($sql); 
    $st->execute($sql_data);

    unset($params);
    $params['data'] = $st->fetchAll(PDO::FETCH_ASSOC);
//    var_dump($params['data']);

    if (count($params['data']) == 0) {
        echo 'No se encuentran resultados';
    } else {
        $params['primary_key'] = 'noticia_id';
        $params['link_view']['field_name'] = $params['primary_key'];
        $params['link_view']['label'] = 'Ver noticia';
        $params['link_view']['action'] = 'noticia_select';

        include_once 'share/data_display.php';
        echo sak_display_array_list($params);
    }
}


include_once 'footer.php';


