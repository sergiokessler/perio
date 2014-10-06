<?php

include 'config.php';



$sql_urnas = <<<END
    select 
        urna_id,
        urna_nombre
    from
        urna
    where
        urna_id in (select distinct urna_id from urna_total)
END;

$sql_centro = <<<END
    select
        l.lista_nombre,
        mt.*
    from
        lista l,
        urna_total mt
    where
        l.activa = 1
        and
        mt.urna_id = ?
        and
        mt.lista_id = l.lista_id
        and
        l.participa_centro = 1
    order by
        l.orden
END;

$sql_claustro = <<<END
    select
        l.lista_nombre,
        mt.*
    from
        lista l,
        urna_total mt
    where
        l.activa = 1
        and
        mt.urna_id = ?
        and
        mt.lista_id = l.lista_id
        and
        l.participa_claustro = 1
    order by
        l.orden
END;

include 'header.php';

echo '<div class="container">'; 

//echo '<center>';
echo '<div id="header">';
echo '<img src="images/logoperio.png" class="logoperio">';
echo '<h1 class="tituloh1">';
echo "Elecciones $anio<br>";
echo '</h1>';
echo '<img src="images/logosevit.png" class="logosevit">';
echo '<div class="clear"></div>';
echo '</div>';
echo '<div class="volver"><a href=".">Volver a inicio</a></div>';


$db = new PDO($config['db']['dsn']); 
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$sql = 'select count(distinct urna_id) as urnas_escrutadas from urna_total';
$st = $db->query($sql); 
$row = $st->fetch(PDO::FETCH_ASSOC); 
//$row = $data[0];
$urnas_escrutadas = $row['urnas_escrutadas'];

$sql = 'select count(distinct urna_id) as urnas_total from urna';
$st = $db->query($sql); 
$row = $st->fetch(PDO::FETCH_ASSOC); 
//$row = $data[0];
$urnas_total = $row['urnas_total'];

echo '<br>';
echo '<div class="urnasescrutadas">Cantidad de urnas escrutadas: ' . $urnas_escrutadas . ' / ' . $urnas_total . '</div>';
echo '<br>';
echo '<br>';


$form_select = '';
$st = $db->query($sql_urnas);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $form_select .= '<option value="' . $row['urna_id'] . '">' . $row['urna_nombre'] . '</option>' . "\n";
    $urna_select[$row['urna_id']] = $row['urna_nombre'];
}


$form = <<<END
<form role="form">
  <div class="form-group">
    <label for="urna_id">Urna: </label>
    <select class="form-control" name="urna_id">
      $form_select
    </select>
  </div>
  <button type="submit" name="btnSubmit" class="btn btn-primary">Ver datos</button>
</form>
END;

echo $form;


if (isset($_REQUEST['urna_id']))
{
    $urna_id = $_REQUEST['urna_id'];

    $st = $db->prepare($sql_centro); 
    $st->execute(array($urna_id));
    $data_values = $st->fetchAll(PDO::FETCH_ASSOC);

//    echo '<pre>';
//    var_dump($data_values);
//    echo '</pre>';

    // CENTRO
    echo '<h3>' . $urna_select[$urna_id] . ' - Centro</h3>';

    $html = '<table class="table table-striped">';
    // titulos !
    $html .= '<thead><tr>';
    $html .= '<th>' . 'Lista' . '</th>';
    $html .= '<th style="text-align:right">' . 'Votos para Centro' . '</th>';
    $html .= '</tr></thead>'; 

    $i = 0;
    $totales['centro'] = 0;

    foreach ($data_values as $row)
    {
		$html .= '<tr>';
		$html .= '<td>' . $row['lista_nombre'] . '</td>';
		$html .= '<td style="text-align:right">' . $row['votos_centro'] . '</td>';
		$html .= '</tr>';

		$totales['centro'] += $row['votos_centro'];
    }

    $html .= '<thead><tr>';
    $html .= '<th>' . 'Totales' . '</th>';
    $html .= '<th style="text-align:right">' . $totales['centro'] . '</th>';
    $html .= '</tr></thead>'; 

    $html .= '</tbody>';
    $html .= '</table>'; 

    $html_centro = $html;


    // CLAUSTRO
    $st = $db->prepare($sql_claustro); 
    $st->execute(array($urna_id));
    $data_values = $st->fetchAll(PDO::FETCH_ASSOC);

    $html = '<br /><br /><h3>' . $urna_select[$urna_id] . ' - Claustro</h3>';
    $html .= '<table class="table table-striped">';
    $html .= '<thead><tr>';
    $html .= '<th>' . 'Lista' . '</th>';
    $html .= '<th style="text-align:right">' . 'Votos para Claustro' . '</th>';
    $html .= '</tr></thead>'; 

    $i = 0;
    $totales['claustro'] = 0;
	
    foreach ($data_values as $row)
    {
		$html .= '<tr>';
		$html .= '<td>' . $row['lista_nombre'] . '</td>';
		$html .= '<td style="text-align:right">' . $row['votos_claustro'] . '</td>';
		$html .= '</tr>';

		$totales['claustro'] += $row['votos_claustro'];
    }

    $html .= '<thead><tr>';
    $html .= '<th>' . 'Totales' . '</th>';
    $html .= '<th style="text-align:right">' . $totales['claustro'] . '</th>';
    $html .= '</tr></thead>'; 

    $html .= '</tbody>';
    $html .= '</table>';

    $html_claustro = $html;


    echo $html_centro;
    echo $html_claustro;
}

echo '<br>';
echo '<br>';


//echo '</center>';
echo '<a href=".">Volver a inicio</a>';
echo '<br>';

include 'footer.php';

