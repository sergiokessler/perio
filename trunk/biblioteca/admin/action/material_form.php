<?php

require_once 'HTML/QuickForm2.php'; 
include 'share/form_common.php';

 

$pais_edicion['ar'] = 'ar';
$pais_edicion['br'] = 'br';
$pais_edicion['fr'] = 'fr';
$pais_edicion['it'] = 'it';
$pais_edicion['mx'] = 'mx';
$pais_edicion['sp'] = 'sp';
$pais_edicion['uk'] = 'uk';
$pais_edicion['us'] = 'us';


$idioma['es'] = 'es';
$idioma['en'] = 'en';
$idioma['fr'] = 'fr';
$idioma['it'] = 'it';
$idioma['pt'] = 'pt';

$doc_analizado_por['C.D.M. Facultad de Periodismo y Comunicación Social'] = 'C.D.M. Facultad de Periodismo y Comunicación Social';

$disponibilidad['prestamo'] = 'Domicilio';
$disponibilidad['restringido'] = 'Sala';


$doc_tipo[''] = '--Seleccione--';
$doc_tipo['Libro'] = 'Libro';
$doc_tipo['Revista'] = 'Revista';
$doc_tipo['Diario'] = 'Diario';
$doc_tipo['Periódico'] = 'Periódico';
$doc_tipo['Folleto'] = 'Folleto';
$doc_tipo['Manual'] = 'Manual';
$doc_tipo['Diccionario'] = 'Diccionario';
$doc_tipo['Enciclopedia'] = 'Enciclopedia';
$doc_tipo['Tesis de grado'] = 'Tesis de grado';
$doc_tipo['Tesis de posgrado '] = 'Tesis de posgrado ';
$doc_tipo['Artículo de revista'] = 'Artículo de revista';
$doc_tipo['Capítulo de libro'] = 'Capítulo de libro';
$doc_tipo['CD'] = 'CD';
$doc_tipo['DVD'] = 'DVD';
$doc_tipo['Pagina Web'] = 'Pagina Web';


$mencion_escala[''] = '--Seleccione--';
$mencion_escala['NSP'] = 'Nota sobre el programa (NSP)';
$mencion_escala['MP'] = 'Mención del programa (MP)';
$mencion_escala['TR'] = 'Tema relacionado (TR)';




$form_params = params_encode($params);

$form_update = false;
if (isset($record_id))
    $form_update = true;

$form = new HTML_QuickForm2('form', 'post');


// check if update
if ($form_update)
{
    $db = new PDO($config['db']['dsn']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st = $db->prepare('select * from ' . $params['table'] . ' where ' . $params['primary_key'] . ' = ?'); 
    $st->execute(array($record_id));
    $edit_row = $st->fetch(PDO::FETCH_ASSOC);
    
    $defaults['new_row'] = $edit_row;

    $form->addDataSource(new HTML_QuickForm2_DataSource_Array(
        $defaults
    ));
}
else
{
    // defaults
    $form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
        'new_row' => array('fecha' => time()),
    )));
}

// elements
$form->addElement('hidden', 'action')
     ->setValue($params['action'])
     ;
$form->addElement('hidden', 'params')
     ->setValue($form_params)
     ;
if ($form_update) {
    $form->addElement('text', 'inventario', array('disabled' => 'disabled'), array('label' => 'Inventario'))
         ->setValue($record_id);
} else {
    $form->addElement('text',   'new_row[inventario]', $campo_corto)
         ->setLabel('Inventario:')
         ->addClass('form-control')
         ->addRule('required', 'Valor requerido')
         ;
}


$form->addElement('text', 'new_row[titulo]', $campo_largo)
     ->setLabel('Título:')
     ->addClass('form-control')
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('text', 'new_row[otro_titulo]', $campo_largo)
     ->setLabel('Otro Título:')
     ->addClass('form-control')
     ;
$form->addElement('text', 'new_row[autor]', $campo_largo)
     ->setLabel('Autor:')
     ->addClass('form-control')
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('text', 'new_row[director]', $campo_largo)
     ->setLabel('Director:')
     ->addClass('form-control')
     ;
$form->addElement('text', 'new_row[co_director]', $campo_largo)
     ->setLabel('Co-Director:')
     ->addClass('form-control');
     ;
$form->addElement('text', 'new_row[edicion]', $campo_corto)
     ->setLabel('Edicion:')
     ->addClass('form-control');
     ;
$form->addElement('text', 'new_row[lugar]', $campo_largo)
     ->setLabel('Lugar:')
     ->addClass('form-control')
     ;
$form->addElement('text', 'new_row[editor]', $campo_largo)
     ->setLabel('Editor:')
     ->addClass('form-control')
     ;
$form->addElement('text', 'new_row[fecha_publicacion]', $campo_corto)
     ->setLabel('Año publicacion:')
     ->addClass('form-control')
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('text', 'new_row[volumen_nro]', $campo_corto)
     ->setLabel('Volumen:')
     ->addClass('form-control')
     ;
$form->addElement('text', 'new_row[paginas]', $campo_corto)
     ->setLabel('Páginas:')
     ->addClass('form-control')
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('text', 'new_row[serie]', $campo_largo)
     ->setLabel('Serie:')
     ->addClass('form-control')
     ;
$form->addElement('text', 'new_row[subserie]', $campo_largo)
     ->setLabel('SubSerie:')
     ->addClass('form-control')
     ;
$form->addElement('text', 'new_row[serie_nro]', $campo_medio)
     ->setLabel('Serie Nro:')
     ->addClass('form-control')
     ;
$form->addElement('text', 'new_row[frecuencia]', $campo_corto)
     ->setLabel('Frecuencia de publicación:')
     ->addClass('form-control')
     ;
$form->addElement('date', 'new_row[fecha_de_inicio]')
     ->setLabel('Fecha de inicio:')
//     ->addClass('form-control')
     ;
$form->addElement('date', 'new_row[fecha_de_cierre]')
     ->setLabel('Fecha de cierre:')
//     ->addClass('form-control')
     ;
$form->addElement('text', 'new_row[existencias]', $campo_corto)
     ->setLabel('Existencias:')
     ->addClass('form-control')
     ;
$form->addElement('text', 'new_row[issn]', $campo_medio)
     ->setLabel('ISSN:')
     ->addClass('form-control')
     ;
$form->addElement('text', 'new_row[isbn]', $campo_medio)
     ->setLabel('ISBN:')
     ->addClass('form-control')
     ;
$form->addElement('text', 'new_row[descripcion]', $campo_largo)
     ->setLabel('Descripcion:')
     ->addClass('form-control')
     ;
$form->addElement('text', 'new_row[fuente]', $campo_largo)
     ->setLabel('Fuente:')
     ->addClass('form-control')
     ;
$form->addElement('select', 'new_row[pais]', $campo_corto)
     ->setLabel('Pais:')
     ->addClass('form-control')
     ->loadOptions($pais_edicion) 
     ;
$form->addElement('select', 'new_row[idioma]', $campo_corto)
     ->setLabel('Idioma:')
     ->addClass('form-control')
     ->loadOptions($idioma) 
     ;
$form->addElement('text', 'new_row[ubicacion]', $campo_largo)
     ->setLabel('Ubicación:')
     ->addClass('form-control')
     ;
$form->addElement('text', 'new_row[palabras_clave]', $campo_largo)
     ->setLabel('Palabras Clave:')
     ->addClass('form-control')
     ;
/*
$form->addElement('text', 'new_row[descriptor_geografico]', $campo_largo)
     ->setLabel('Descriptor Geografico:')
     ->addClass('form-control')
     ;
$form->addElement('text', 'new_row[descriptor_temporal]', $campo_largo)
     ->setLabel('Descriptor Temporal:')
     ->addClass('form-control')
     ;
$form->addElement('text', 'new_row[descriptor_personal]', $campo_largo)
     ->setLabel('Descriptor Personal:')
     ->addClass('form-control')
     ;
*/
$form->addElement('textarea', 'new_row[resumen]', $textarea_options)
     ->setLabel('Resumen/Notas:')
     ->addClass('form-control')
     ;
$form->addElement('select', 'new_row[doc_analizado_por]', $campo_largo)
     ->setLabel('Doc analizado por:')
     ->addClass('form-control')
     ->loadOptions($doc_analizado_por)
     ;
$form->addElement('text', 'new_row[operador]', $campo_medio)
     ->setLabel('Operador:')
     ->addClass('form-control')
     ;
$form->addElement('select', 'new_row[disponibilidad]', $campo_medio)
     ->setLabel('Disponibilidad:')
     ->addClass('form-control')
     ->loadOptions($disponibilidad)
     ;
$form->addElement('select', 'new_row[formato]', $campo_medio)
     ->setLabel('Formato:')
     ->addClass('form-control')
     ->loadOptions($doc_tipo)
     ;
$form->addElement('text', 'new_row[soporte_no_convencional]', $campo_medio)
     ->setLabel('Soporte no convencional:')
     ->addClass('form-control')
     ;
$form->addElement('file', 'archivo_digital')
     ->setLabel('Archivo digital:')
     ;

$submit = $form->addSubmit('btnSubmit', array('value' => 'Guardar'))
               ->addClass(array('btn', 'btn-primary'));




// renderer fixes


require_once 'HTML/QuickForm2/Renderer.php';
$renderer = HTML_QuickForm2_Renderer::factory('callback');

$renderer->setOption(array(
    'errors_prefix' => 'El formulario contiene errores:',
    'required_note' => '<span class="required">*</span> denota campos requeridos',
));


