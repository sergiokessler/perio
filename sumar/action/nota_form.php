<?php
# vim: set fileencoding=latin1 :

require_once 'HTML/QuickForm2.php'; 


$date_options = array(
    'language'  => 'es',
    'format'    => 'd / M / Y',
    'minYear'   => date('Y') - 2,
    'maxYear'   => date('Y') + 2,
);

$textarea_options = array(
    'rows' => 8,
    'cols' => 32,
    'class' => 'span6'
);
$submit_options = array (
    'class' => 'btn btn-primary',
);
$campo_corto = array('class' => 'span2');
$campo_medio = array('class' => 'span4');
$campo_largo = array('class' => 'span6');

$null_select[''] = '--seleccione--';

$boolean_select[''] = '--seleccione--';
$boolean_select['SI'] = 'SI';
$boolean_select['NO'] = 'NO';


$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$medio_select = array('' => '-- Seleccione --');
$sql_sel = "select medio_id as k, nombre as v from medio order by nombre";
$st = $db->query($sql_sel);
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $medio_select[$row['k']] = $row['v'];
} 
 

$mencion_escala[''] = '--Seleccione--';
$mencion_escala['NSP'] = 'Nota sobre el programa (NSP)';
$mencion_escala['MP'] = 'Menci�n del programa (MP)';
$mencion_escala['TR'] = 'Tema relacionado (TR)';


$valoracion_select[''] = '--Seleccione--';
$valoracion_select['+1'] = 'Positiva (+1)';
$valoracion_select['0']  = 'Neutra (0)';
$valoracion_select['-1'] = 'Negativa (-1)';
$valoracion_select['-2'] = 'Denuncia (-2)';

$five_select[''] = '--Seleccione--';
$five_select['5'] = '5';
$five_select['4'] = '4';
$five_select['3'] = '3';
$five_select['2'] = '2';
$five_select['1'] = '1';


$asignacion_select[''] = '--Seleccione--';
$asignacion_select['AUH'] = 'AUH';
$asignacion_select['AXE'] = 'AXE';
$asignacion_select['AUH y AXE'] = 'AUH y AXE';
$asignacion_select['NO'] = 'NO';



$form_params = params_encode($params);

$form_update = false;
if (isset($record_id))
    $form_update = true;

$form = new HTML_QuickForm2('form', 'post');

// check if update
if ($form_update)
{
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
    $form->addElement('text', 'nota_id', array('disabled' => 'disabled'), array('label' => 'Nota Id'))
         ->setValue($record_id);
}
$form->addElement('select', 'new_row[medio_id]')
     ->setLabel('Medio:')
     ->loadOptions($medio_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('date',   'new_row[fecha]', $campo_corto, $date_options)
     ->setLabel('Fecha:')
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('text',   'new_row[titulo]', $campo_largo)
     ->setLabel('T�tulo:')
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('text',   'new_row[link]', $campo_largo)
     ->setLabel('Link:')
     ;
$form->addElement('select', 'new_row[mencion_escala]')
     ->setLabel('Escala de menci�n del Plan Nacer / Sumar:')
     ->loadOptions($mencion_escala)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[valoracion]')
     ->setLabel('Valoraci�n:')
     ->loadOptions($valoracion_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[mencion_grupos]')
     ->setLabel('Menci�n de grupos:')
     ->loadOptions($boolean_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[mencion_resultados_inscriptos]')
     ->setLabel('Menci�n de resultados de Inscriptos:')
     ->loadOptions($boolean_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[mencion_resultados_inversiones]')
     ->setLabel('Menci�n de resultados de Inversiones:')
     ->loadOptions($boolean_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[mencion_resultados_transferencia]')
     ->setLabel('Menci�n de resultados de Transferencia:')
     ->loadOptions($boolean_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[mencion_resultados_practicas]')
     ->setLabel('Menci�n de resultados de Pr?cticas/prestaciones:')
     ->loadOptions($boolean_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[mencion_resultados_entrega]')
     ->setLabel('Menci�n de resultados de Entrega de bienes:')
     ->loadOptions($boolean_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[mencion_0800]')
     ->setLabel('Menci�n de 0800:')
     ->loadOptions($boolean_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[mencion_cobertura_efectiva]')
     ->setLabel('Menci�n de cobertura efectiva:')
     ->loadOptions($boolean_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[mencion_card_cong]')
     ->setLabel('Menci�n Cardiopat?as Cong?nitas:')
     ->loadOptions($boolean_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[ppac]')
     ->setLabel('PPAC (Paquete Perinatal de Alta Complejidad):')
     ->loadOptions($boolean_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[mencion_pueblos_orig]')
     ->setLabel('Menci�n de pueblos originarios:')
     ->loadOptions($boolean_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[mencion_asignaciones]')
     ->setLabel('Menci�n de asignaciones:')
     ->loadOptions($asignacion_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[mencion_progresar]')
     ->setLabel('Menci�n de PROGRESAR:')
     ->loadOptions($boolean_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('textarea', 'new_row[texto]', $textarea_options)
     ->setLabel('Nota completa:')
     ->addRule('required', 'Valor requerido')
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


