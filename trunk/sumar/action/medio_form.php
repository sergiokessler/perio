<?php


$date_options = array(
    'language'  => 'es',
    'format'    => 'dMY',
    'minYear'   => 2007,
    'maxYear'   => date('Y') + 2, 
);

$textarea_options = array(
    'rows' => 8,
    'cols' => 32,
    'class' => 'span12'
);

$campo_corto = array('style' => 'width: 10em;');
$campo_medio = array('style' => 'width: 20em;');
$campo_largo = array('style' => 'width: 40em;');

$null_select[''] = '--seleccione--';

$boolean_select[''] = '--seleccione--';
$boolean_select['SI'] = 'SI';
$boolean_select['NO'] = 'NO';

$zona_select = array(
    ''                      => '--Seleccione--',
    'Norte'                 => 'Norte',
    'Centro'                => 'Centro',
    'Buenos Aires'          => 'Buenos Aires',
    'Sur'                   => 'Sur',
    'Nacional y Agencias'   => 'Nacional y Agencias',
);

$pcia_select[''] = array(
    ''                      => '--Seleccione--',
);

$pcia_select['Norte'] = array(
    null                      => '--Seleccione--',
    'Chaco'                 => 'Chaco',
    'Jujuy'                 => 'Jujuy',
    'Corrientes'            => 'Corrientes',
    'Misiones'              => 'Misiones',
    'Salta'                 => 'Salta',
    'Catamarca'             => 'Catamarca',
    'Formosa'               => 'Formosa',
    'Santiago del Estero'   => 'Santiago del Estero',
    'Tucuman'               => 'Tucuman',
);


$pcia_select['Centro'] = array(
    ''                      => '--Seleccione--',
    'Santa Fe'              => 'Santa Fe',
    'Cordoba'               => 'Cordoba',
    'Entre Rios'            => 'Entre Rios',
    'San Juan'              => 'San Juan',
    'Mendoza'               => 'Mendoza',
    'San Luis'              => 'San Luis',
    'La Pampa'              => 'La Pampa',
    'La Rioja'              => 'La Rioja',
);

$pcia_select['Buenos Aires'] = array (
//    ''                      => '--Seleccione--',
    'Buenos Aires'          => 'Buenos Aires',
);

$pcia_select['Sur'] = array (
    ''                      => '--Seleccione--',
    'Rio Negro'             => 'Rio Negro',
    'Neuquen'               => 'Neuquen',
    'Chubut'                => 'Chubut',
    'Santa Cruz'            => 'Santa Cruz',
    'Tierra del Fuego'      => 'Tierra del Fuego',
);

$pcia_select['Nacional y Agencias'] = array(
    'N/A'                   => 'N/A',
);



$relevancia_select[''] = '--Seleccione--';
$relevancia_select['5'] = '5 - Muy relevante';
$relevancia_select['4'] = '4 - Relevante';
$relevancia_select['3'] = '3 - Medianamente relevante';
$relevancia_select['2'] = '2 - Algo relevante';
$relevancia_select['1'] = '1 - Poco relevante';

$cobertura_select[''] = '--Seleccione--';
$cobertura_select['Mundial'] = 'Mundial';
$cobertura_select['Mercosur'] = 'Mercosur';
$cobertura_select['Nacional'] = 'Nacional';
$cobertura_select['Provincial'] = 'Provincial';
$cobertura_select['Municipal'] = 'Municipal';
$cobertura_select['Internet'] = 'Internet';

$tipo_select[''] = '--Seleccione--';
$tipo_select['Impreso'] = 'Impreso';
$tipo_select['Digital'] = 'Digital';


$fuente_select[''] = '--Seleccione--';
$fuente_select['FA'] = 'FA';
$fuente_select['FNA'] = 'FNA';
$fuente_select['FT'] = 'FT';
$fuente_select['SF'] = 'SF';


$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 


$form_params = params_encode($params);

$form_update = false;
if (isset($record_id))
    $form_update = true; 


$form = new HTML_QuickForm2('form', 'post');

if ($form_update and empty($_POST))
{
    $st = $db->prepare('select * from ' . $params['table'] . ' where ' . $params['primary_key'] . ' = ?'); 
    $st->execute(array($record_id));
    $edit_row = $st->fetch(PDO::FETCH_ASSOC);

    $defaults['new_row'] = $edit_row;
    $defaults['zona_pcia'] = array($edit_row['zona'], $edit_row['provincia']);

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


$form->addElement('hidden', 'action')
     ->setValue($params['action'])
     ;
$form->addElement('hidden', 'params')
     ->setValue($form_params)
     ;
if ($form_update) {
    $form->addElement('text', 'medio_id', array('disabled' => 'disabled'), array('label' => 'Medio Id'))
         ->setValue($record_id);
}      
$form->addElement('text',   'new_row[nombre]', $campo_largo)
     ->setLabel(' Nombre del medio:')
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('hierselect', 'zona_pcia')
     ->setLabel(' Zona:')
     ->setSeparator(' Provincia: ')
     ->loadOptions(array($zona_select, $pcia_select))
     ->addRule('required', 'Valor requerido', 2)
     ;
$form->addElement('select', 'new_row[relevancia]')
     ->setLabel(' Relevancia:')
     ->loadOptions($relevancia_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('select', 'new_row[tipo]')
     ->setLabel(' Tipo:')
     ->loadOptions($tipo_select)
     ->addRule('required', 'Valor requerido')
     ;
$form->addElement('text', 'new_row[web]', $campo_largo)
     ->setLabel(' Sitio web:')
    ;
    
$submit = $form->addSubmit('btnSubmit', array('value' => 'Guardar'))
               ->addClass(array('btn', 'btn-primary'));



// renderer fixes

function renderSubmit($renderer, $submit) 
{
    return '<div class="form-actions">'.$submit.'</div>';
}


require_once 'HTML/QuickForm2/Renderer.php';
require_once 'HTML/QuickForm2/JavascriptBuilder.php';
$renderer = HTML_QuickForm2_Renderer::factory('callback');
$renderer->setJavascriptBuilder(new HTML_QuickForm2_JavascriptBuilder(null, __DIR__ . '/../share/pear/data/HTML_QuickForm2/js'));
$renderer->setCallbackForId($submit->getId(), 'renderSubmit');



$renderer->setOption(array(
    'errors_prefix' => 'El formulario contiene errores:',
    'required_note' => '<span class="required">*</span> denota campos requeridos',
));


