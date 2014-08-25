<?php

require_once 'share/data_display.php';


$sql = <<<END
    select 
        inventario,
        ubicacion,
        disponibilidad,
        autor,
        titulo,
        disponibilidad,
        palabras_clave,
        case when char_length(coalesce(archivo_digital, '')) > 0 then '@' else '' end as archivo
    from 
        libros
    where
        1 = 1
END;
$sql_data = array();


require_once 'HTML/QuickForm2.php'; 
include 'share/form_common.php'; 

$search = '';
if (!empty($_GET['search'])) {
    $search = $_GET['search'];
}


$form_params = params_encode($params);


$form_html = <<<END
<form class="form" method="get" id="search" action=".">
  <div style="display: none;">
    <input type="hidden" name="action" id="action-0" value="material_search" />
  </div>
  <div class="form-group">
  <div class="input-group">
    <label for="search-0">Buscar material bibliográfico:</label>
  </div>
  <div class="input-group">
    <input type="text" name="search" id="search-0" value="$search" placeholder="Escriba aqui su búsqueda..." class="form-control"/>
    <span class="input-group-btn">
    <input type="submit" value="Buscar" name="btnSubmit" id="btnSubmit-0" class="btn btn-primary" />
    </span>
  </div>
  <div class="form-group">
END;

$sf = array('autor' => 'on', 'titulo' => 'on', 'otro_titulo' => 'on', 'palabras_clave' => 'on');
if (!empty($_GET['search_field'])) {
    $sf = $_GET['search_field'];
}

//print_r($sf);

$checked = (empty($sf['autor'])) ? '' : 'checked="checked"';
$form_html .= '<label class="checkbox-inline"><input type="checkbox" ' . $checked . 'name="search_field[autor]" />Autor</label>';

$checked = (empty($sf['titulo'])) ? '' : 'checked="checked"';
$form_html .= '<label class="checkbox-inline"><input type="checkbox" ' . $checked . 'name="search_field[titulo]" />Titulo</label>';

$checked = (empty($sf['otro_titulo'])) ? '' : 'checked="checked"';
$form_html .= '<label class="checkbox-inline"><input type="checkbox" ' . $checked . 'name="search_field[otro_titulo]" />Otro Titulo</label>';

$checked = (empty($sf['palabras_clave'])) ? '' : 'checked="checked"';
$form_html .= '<label class="checkbox-inline"><input type="checkbox" ' . $checked . 'name="search_field[palabras_clave]" />Palabras clave</label>';

$checked = (empty($sf['inventario'])) ? '' : 'checked="checked"';
$form_html .= '<label class="checkbox-inline"><input type="checkbox" ' . $checked . 'name="search_field[inventario]" />Inventario</label>';

$checked = (empty($sf['ubicacion'])) ? '' : 'checked="checked"';
$form_html .= '<label class="checkbox-inline"><input type="checkbox" ' . $checked . 'name="search_field[ubicacion]" />Ubicación</label>';

$checked = (empty($sf['director'])) ? '' : 'checked="checked"';
$form_html .= '<label class="checkbox-inline"><input type="checkbox" ' . $checked . 'name="search_field[director]" />Director</label>';

$checked = (empty($sf['co_director'])) ? '' : 'checked="checked"';
$form_html .= '<label class="checkbox-inline"><input type="checkbox" ' . $checked . 'name="search_field[co_director]" />Co-Director</label>';

$checked = (empty($sf['editor'])) ? '' : 'checked="checked"';
$form_html .= '<label class="checkbox-inline"><input type="checkbox" ' . $checked . 'name="search_field[editor]" />Editor</label>';

$checked = (empty($sf['formato'])) ? '' : 'checked="checked"';
$form_html .= '<label class="checkbox-inline"><input type="checkbox" ' . $checked . 'name="search_field[formato]" />Formato</label>';

$checked = (empty($sf['serie'])) ? '' : 'checked="checked"';
$form_html .= '<label class="checkbox-inline"><input type="checkbox" ' . $checked . 'name="search_field[serie]" />Serie</label>';

$form_html .= '</div></form>';


$form = new HTML_QuickForm2('search', 'get');

// elements
$form->addElement('hidden', 'action')
     ->setValue($action)
     ;

$form->addElement('text', 'search', $campo_largo)
     ->setLabel('Buscar material bibliográfico:')
     ->addClass('form-control')
     ->addRule('required', 'Valor requerido')
     ;

$submit = $form->addSubmit('btnSubmit', array('value' => 'Buscar'))
               ->addClass(array('btn', 'btn-primary'));



include 'header.php';


echo '<div class="page-header">';
echo '  <h1>Buscar Material <small></small></h1>';
echo '</div>'; 

echo $form_html;


if (empty($_GET['search'])) {
    include 'footer.php';
    return;
}


    $sql_where = '';
    $sql_data = array();

    $q = $_GET['search'];
    $sf = $_GET['search_field'];

    if ( (ctype_digit($q)) and (!empty($sf['inventario'])) ) {
        $sql_where = " and inventario = ?";
        $sql_data[] = $q;
    }

    // buscamos por rangos
    if ( (strpos($q, '-') !== false) and (!empty($sf['inventario'])) ) {
        $q = str_replace(' ', '', $q);
        $fromto = explode('-', $q, 2);
        $from = $fromto[0];
        $to = $fromto[1];
        if (ctype_digit($from) and ctype_digit($to)) {
            $sql_where = " and inventario between ? and ?";
            $sql_data[] = $from;
            $sql_data[] = $to;
        }
    }

    $w = '';
    $ob = array();
    foreach($sf as $k => $v) {
        $w .= " || coalesce($k,'') ";
        $ob[] .= $k;
    }
    $ob = implode($ob, ',');

    if (empty($sql_where)) {
        $sql_where .= " and ('' $w) ilike ('%' || ? || '%') ";
        $sql_data[] = $q;
    }


    /*
     * mostramos los resultados
     */

    $sql .= $sql_where . ' order by ' . $ob;


    //echo $sql;

    $db = new PDO($config['db']['dsn']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st = $db->prepare($sql);
    $st->execute($sql_data);


    unset($params);
    $params['data'] = $st->fetchAll(PDO::FETCH_ASSOC);

    if (empty($params['data'])) {
        echo _('No data found');
    } else {
        $params['primary_key'] = 'inventario';
        $params['link_view']['inventario']['href'] = '?action=material_select';

        echo sak_display_array_list($params);
    }


include 'footer.php';

