<?php




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
    
    $edit_row['fecha_devolucion'] = time();

    $defaults['new_row'] = $edit_row;

    $form->addDataSource(new HTML_QuickForm2_DataSource_Array(
        $defaults
    ));
}
else
{
    // defaults
    $form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
        'new_row' => array('fecha_devolucion' => time()),
    )));
}

// elements
$form->addElement('hidden', 'action')
     ->setValue($params['action'])
     ;
$form->addElement('hidden', 'params')
     ->setValue($form_params)
     ;


$form->addElement('text',   'new_row[inventario]', $campo_corto)
     ->setLabel('Inventario:')
     ->toggleFrozen(true);
     ;
$form->addElement('date', 'new_row[fecha_prestamo]', $campo_corto, $datetime_options)
     ->setLabel('Fecha préstamo:')
     ->toggleFrozen(true);
     ; 
$form->addElement('date', 'new_row[fecha_devolucion]', $campo_corto, $date_options)
     ->setLabel('Fecha devolución:')
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('text', 'new_row[telefono]', $campo_medio)
     ->setLabel('Telefono:')
     ->toggleFrozen(true);
     ;
$form->addElement('text', 'new_row[apellido_nombre]', $campo_largo)
     ->setLabel('Apellido, Nombre:')
     ->toggleFrozen(true);
     ;
$form->addElement('text', 'new_row[nro_documento]', $campo_medio + array('placeholder' => 'sin puntos'))
     ->setLabel('Documento Nro:')
     ->toggleFrozen(true);
     ;
$form->addElement('text', 'new_row[direccion]', $campo_largo)
     ->setLabel('Dirección:')
     ->toggleFrozen(true);
     ; 
     
$submit = $form->addSubmit('btnSubmit', array('value' => 'Guardar'))
               ->addClass(array('btn', 'btn-primary'));




// renderer fixes

function renderSubmit($renderer, $submit) 
{
    return '<div class="form-actions">'.$submit.'</div>';
}


require_once 'HTML/QuickForm2/Renderer.php';
$renderer = HTML_QuickForm2_Renderer::factory('callback');
$renderer->setCallbackForId($submit->getId(), 'renderSubmit');



$renderer->setOption(array(
    'errors_prefix' => 'El formulario contiene errores:',
    'required_note' => '<span class="required">*</span> denota campos requeridos',
));


