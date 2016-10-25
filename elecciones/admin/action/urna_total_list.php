<?php

/*
 * by Sak@perio
 */
# vim: set fileencoding=ISO-8859-1

require_once 'lib/data_display.php';


//unset($params);
$this_table = 'urna_total';
$this_primary_key = 'urna_total_id';
$this_icon = '<span class="glyphicon glyphicon-folder-close"></span>';

$sql = <<<END
    select 
        u.urna_nombre || ' (' || u.urna_id || ')' as urna,
        l.lista_nombre || ' (' || l.lista_id || ')' as lista,
        mt.fecha_hora,
        mt.votos_centro,
        mt.votos_claustro,
        mt.urna_total_id
    from 
        urna_total mt,
        urna u,
        lista l
    where 
        mt.urna_id = u.urna_id 
        and 
        mt.lista_id = l.lista_id
END;


include 'header.php';

echo '<div class="page-header">';
echo '  <h1>Votos de una Urna y Lista<small></small></h1>';
echo '<a href="?action='. $this_table .'_insert" class="btn btn-default active" role="button">Agregar '. get_label($this_table) .'</a>';
echo '</div>';


$f_params['action'] = $this_table . '_list';
$f_params['sql_where'] = '';
$f_params['sql_order'] = '';
$f_params['sql_data'] = null;
//$params['enable_export'] = true;
$field_meta['search']['lista_nombre'] = 'Nombre de Lista';
$field_meta['search']['urna_nombre'] = 'Nombre de Urna';

echo sak_search_form($f_params, $field_meta);

echo '<br>';

$buscar = (bool) (isset($_REQUEST['btnSubmit'])) && ($_REQUEST['btnSubmit'] == 'Buscar');
if ($buscar)
{                            
    $f_result = sak_search_form_process($params);
    $sql = $sql . $f_result['sql_where'] . $f_result['sql_order'];
    $sql_data = $f_result['sql_data'];

    $db = new PDO($db_dsn, $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

    $st = $db->prepare($sql); 
    $st->execute($sql_data);


    unset($params);
    $params['data'] = $st->fetchAll(PDO::FETCH_ASSOC);

    if (empty($params['data'])) {
        echo ('No se encontraron datos');
    } else {
        $params['primary_key'] = $this_primary_key;
        //$params['link_view'][$this_primary_key]['label'] = 'Ver registro';
        $params['link_view'][$this_primary_key]['href'] = '?action='. $this_table;
        $params['display_record_count'] = true;

        echo sak_display_array_list($params);
    }
}


include_once 'footer.php';

