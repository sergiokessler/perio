<?php

$date_options = array(
    'language'  => 'es',
    'format'    => 'dMY',
    'minYear'   => date('Y') - 2,
    'maxYear'   => date('Y') + 2,
);
$date_defaults = array(
    'd' => date('d'),
    'M' => date('m'),
    'Y' => date('Y'),
);

$textarea_options = array(
    'rows' => 8,
    'cols' => 32,
    'class' => 'span10'
); 

$campo_corto = array('style' => 'width: 10em;');
$campo_medio = array('style' => 'width: 20em;');
$campo_largo = array('style' => 'width: 40em;'); 

$null_select[''] = '--seleccione--';

$boolean_select[''] = '--seleccione--';
$boolean_select['SI'] = 'SI';
$boolean_select['NO'] = 'NO';


