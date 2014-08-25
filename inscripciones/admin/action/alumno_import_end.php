<?php

/*

$Id: base_new_from_file_end.php,v 1.3 2005/10/11 21:32:37 sergio.kessler Exp $

*/



// <UI>


include_once 'header.php';

echo '<br>';
echo "El archivo $params[filename] ha sido procesado, y se insertaron $params[rows_inserted] registros.";
echo '<br>';
echo 'Tiempo empleado: ' . (time() - $params['time0']) . ' segundos.';
echo '<br>';
echo '<br>';

echo '<br>';
echo '<br>';

echo '<a href="index.php">ir al Inicio</a>';


include_once 'footer.php';

