<?php




$mencion_escala[''] = '--Seleccione--';
$mencion_escala['NSP'] = 'Nota sobre el programa (NSP)';
$mencion_escala['MP'] = 'Mención del programa (MP)';
$mencion_escala['TR'] = 'Tema relacionado (TR)';




$form_params = params_encode($params);

$form_update = false;
if (isset($record_id)) {
    $form_update = true;
}

$material_form = <<<END
<form method="post" enctype="multipart/form-data">
  <input type="hidden" id="action" name="action" value="$params[action]">
  <input type="hidden" id="params" name="params" value="$form_params">

  <div class="form-group">
    <label for="new_row[inventario]">Inventario:</label>
    <input type="number" id="new_row[inventario]" name="new_row[inventario]" min="1" max="99999" required class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[titulo]">Título:</label>
    <input type="text" id="new_row[titulo]" name="new_row[titulo]" maxlength="200" required class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[otro_titulo]">Otro Título:</label>
    <input type="text" id="new_row[otro_titulo]" name="new_row[otro_titulo]" maxlength="200" class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[autor]">Autor:</label>
    <input type="text" id="new_row[autor]" name="new_row[autor]" maxlength="200" required class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[director]">Director:</label>
    <input type="text" id="new_row[director]" name="new_row[director]" maxlength="200" class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[co_director]">Co-Director:</label>
    <input type="text" id="new_row[co_director]" name="new_row[co_director]" maxlength="100" class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[edicion]">Edición:</label>
    <input type="text" id="new_row[edicion]" name="new_row[edicion]" maxlength="128" class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[lugar]">Lugar:</label>
    <input type="text" id="new_row[lugar]" name="new_row[lugar]" maxlength="128" class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[editor]">Editor:</label>
    <input type="text" id="new_row[editor]" name="new_row[editor]" maxlength="128" class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[fecha_publicacion]">Año publicacion:</label>
    <input type="number" id="new_row[fecha_publicacion]" name="new_row[fecha_publicacion]" min="1900" max="9999" required class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[volumen_nro]">Volumen:</label>
    <input type="text" id="new_row[volumen_nro]" name="new_row[volumen_nro]" maxlength="10" class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[paginas]">Páginas:</label>
    <input type="text" id="new_row[paginas]" name="new_row[paginas]" min="0" max="65535" required class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[serie]">Serie:</label>
    <input type="text" id="new_row[serie]" name="new_row[serie]" maxlength="150" class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[subserie]">SubSerie:</label>
    <input type="text" id="new_row[subserie]" name="new_row[subserie]" maxlength="100" class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[serie_nro]">Serie Nro:</label>
    <input type="text" id="new_row[serie_nro]" name="new_row[serie_nro]" maxlength="6" class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[frecuencia]">Frecuencia de publicación:</label>
    <input type="text" id="new_row[frecuencia]" name="new_row[frecuencia]" maxlength="20" class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[fecha_de_inicio]">Fecha de inicio:</label>
    <input type="date" class="form-control" id="new_row[fecha_de_inicio]" name="new_row[fecha_de_inicio]">
  </div>

  <div class="form-group">
    <label for="new_row[fecha_de_cierre]">Fecha de cierre:</label>
    <input type="date" class="form-control" id="new_row[fecha_de_cierre]" name="new_row[fecha_de_cierre]">
  </div>

  <div class="form-group">
    <label for="new_row[existencias]">Existencias:</label>
    <input type="text" class="form-control" id="new_row[existencias]" name="new_row[existencias]" maxlength="256">
  </div>

  <div class="form-group">
    <label for="new_row[issn]">ISSN:</label>
    <input type="text" class="form-control" id="new_row[issn]" name="new_row[issn]" maxlength="20">
  </div>

  <div class="form-group">
    <label for="new_row[isbn]">ISBN:</label>
    <input type="text" class="form-control" id="new_row[isbn]" name="new_row[isbn]" maxlength="20">
  </div>

  <div class="form-group">
    <label for="new_row[descripcion]">Descripción:</label>
    <input type="text" id="new_row[descripcion]" name="new_row[descripcion]" maxlength="20" class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[fuente]">Fuente:</label>
    <input type="text" id="new_row[fuente]" name="new_row[fuente]" maxlength="150" class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[pais]">Pais:</label>
    <select name="new_row[pais]" id="new_row[pais]" class="form-control">
      <option value="ar">ar</option>
      <option value="br">br</option>
      <option value="fr">fr</option>
      <option value="it">it</option>
      <option value="mx">mx</option>
      <option value="sp">sp</option>
      <option value="uk">uk</option>
      <option value="us">us</option>
    </select>
  </div> 

  <div class="form-group">
    <label for="new_row[idioma]">Idioma:</label>
    <select name="new_row[idioma]" id="new_row[idioma]" class="form-control">
      <option value="es">es</option>
      <option value="en">en</option>
      <option value="fr">fr</option>
      <option value="it">it</option>
      <option value="pt">pt</option>
    </select>
  </div> 
  
  <div class="form-group">
    <label for="new_row[ubicacion]">Ubicación:</label>
    <input type="text" id="new_row[ubicacion]" name="new_row[ubicacion]" maxlength="35" class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[palabras_clave]">Palabras clave:</label>
    <input type="text" id="new_row[palabras_clave]" name="new_row[palabras_clave]" maxlength="256" class="form-control">
  </div>

  <!--
  // se sacan estos campos por pedido de Blanca
  <div class="form-group">
    <label for="new_row[descriptor_geografico]">Descriptor Geografico:</label>
    <input type="text" id="new_row[descriptor_geografico]" name="new_row[descriptor_geografico]" class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[descriptor_temporal]">Descriptor Temporal:</label>
    <input type="text" id="new_row[descriptor_temporal]" name="new_row[descriptor_temporal]" class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[descriptor_personal]">Descriptor Personal:</label>
    <input type="text" id="new_row[descriptor_personal]" name="new_row[descriptor_personal]" class="form-control">
  </div>
  -->

  <div class="form-group">
    <label for="new_row[resumen]">Resumen/Notas:</label>
    <input type="textarea" id="new_row[resumen]" name="new_row[resumen]" maxlength="4096" class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[doc_analizado_por]">Doc analizado por:</label>
    <select name="new_row[doc_analizado_por]" id="new_row[doc_analizado_por]" class="form-control">
      <option value="C.D.M. Facultad de Periodismo y Comunicación Social">C.D.M. Facultad de Periodismo y Comunicación Social</option>
    </select>
  </div> 

  <div class="form-group">
    <label for="new_row[operador]">Operador:</label>
    <input type="text" id="new_row[operador]" name="new_row[operador]" maxlength="10" class="form-control">
  </div>

  <div class="form-group">
    <label for="new_row[disponibilidad]">Disponibilidad:</label>
    <select name="new_row[disponibilidad]" id="new_row[disponibilidad]" class="form-control">
      <option value="prestamo">Domicilio</option>
      <option value="restringido">Sala</option>
    </select>
  </div> 
  
  <div class="form-group">
    <label for="new_row[formato]">Formato:</label>
    <select name="new_row[formato]" id="new_row[formato]" class="form-control">
      <option value="">--Seleccione--</option>
      <option value="Libro">Libro</option>
      <option value="Revista">Revista</option>
      <option value="Diario">Diario</option>
      <option value="Periódico">Periódico</option>
      <option value="Folleto">Folleto</option>
      <option value="Manual">Manual</option>
      <option value="Diccionario">Diccionario</option>
      <option value="Enciclopedia">Enciclopedia</option>
      <option value="Tesis de grado">Tesis de grado</option>
      <option value="Tesis de posgrado">Tesis de posgrado</option>
      <option value="Artículo de revista">Artículo de revista</option>
      <option value="Capítulo de libro">Capítulo de libro</option>
      <option value="Anuario">Anuario</option>
      <option value="Plan de estudio">Plan de estudio</option>
      <option value="Programas">Programas</option>
      <option value="TIF">TIF</option>
      <option value="CD">CD</option>
      <option value="DVD">DVD</option>
      <option value="Pagina Web">Pagina Web</option>
    </select>
  </div> 
  
  <div class="form-group">
    <label for="new_row[soporte_no_convencional]">Soporte no convencional:</label>
    <input type="text" id="new_row[soporte_no_convencional]" name="new_row[soporte_no_convencional]" maxlength="20" class="form-control">
  </div>

  <div class="form-group">
    <label for="archivo_digital">Archivo digital 1:</label>
    <input type="file" id="archivo_digital" name="archivo_digital" class="form-control">
  </div>

  <!--
  // se sacan estos campos por pedido de Blanca
  <div class="form-group">
    <label for="new_row[descriptores]">Descriptores:</label>
    <input type="text" id="new_row[descriptores]" name="new_row[descriptores]" class="form-control">
  </div>
  -->

  <div class="form-group">
    <label for="archivo_digital2">Archivo digital 2:</label>
    <input type="file" id="archivo_digital2" name="archivo_digital2" class="form-control">
  </div>
  
  <div class="form-group">
    <label for="archivo_digital3">Archivo digital 3:</label>
    <input type="file" id="archivo_digital3" name="archivo_digital3" class="form-control">
  </div>

  <div class="form-group">
    <label for="archivo_digital4">Archivo digital 4:</label>
    <input type="file" id="archivo_digital4" name="archivo_digital4" class="form-control">
  </div>

  <div class="form-group">
    <label for="archivo_digital5">Archivo digital 5:</label>
    <input type="file" id="archivo_digital5" name="archivo_digital5" class="form-control">
  </div>

  <button type="submit" name="btnSubmit" value="Guardar" class="btn btn-primary">Guardar</button>
</form>
END;




// check if update
if ($form_update)
{
    $db = new PDO($config['db']['dsn']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st = $db->prepare('select * from ' . $params['table'] . ' where ' . $params['primary_key'] . ' = ?');
    $st->execute(array($record_id));
    $result = $st->fetch(PDO::FETCH_ASSOC);
    if(count($result) == 0) {
        die('No se encuentra el $record_id');
    }
    $edit_row = $result;
    
    //$mfh = date_create_from_format('d/m/Y H:i', $medicion_fecha_hora);
    //$medicion_fecha_hora = date_format($mfh, 'Y-m-d\TH:i');
    //$script_set = "document.getElementById('medicion_fecha_hora').value='$medicion_fecha_hora'; ";
    $script_set = "document.getElementById('new_row[inventario]').readOnly=true;";
    foreach($edit_row as $key => $value) {
        $script_set .= "document.getElementById('new_row[$key]').value='$value'; ";
    }
    $material_form .= '<script>' . $script_set . '</script>';

}

