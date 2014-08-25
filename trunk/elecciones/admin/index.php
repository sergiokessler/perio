<?php

/*

  $Id: index.php,v 1.1 2007/10/10 17:15:47 develop Exp $


  dispatcher del callcenter2
  la idea es que el dispatcher sea lo mas simple posible
  a la vez que sea flexible y facil de mantener y entender

  variables a usar:

  $action: esto representa la acción a realizar
           segun la accion se invoca al codigo php
           que corresponda

  $params: aqui nos llega todos los parametros para realizar
           la accion.
           $params es un array asociativo
           para pasarlo por url, primero se lo serializa y luego 
           se lo encodea en base64, de esa manera garantizamos
           que funcione siempre.

  $continue: esta variable, si existe, indica la url a seguir 
             luego del procesamiento de una accion.
             es muy util en el caso de los formularios,
             ya que hace un redirect 303 al url, que es la 
             forma correcta de procesar un form,
             esto evita los problemas de presionar 'Actualizar' o 'Atras'
             en el navegador y que el form sea procesado nuevamente.
           

*/

function params_encode($params)
{
    return(rawurlencode(base64_encode(gzcompress(serialize($params)))));
}

function params_decode($params)
{
//    echo 'normal: ' . strlen(gzuncompress(base64_decode($params)));
//    echo '<br>';
//    echo 'compress: ' . strlen((base64_decode($params)));
    return(unserialize(gzuncompress(base64_decode(rawurldecode($params)))));
}

session_start();
require_once 'config.php';
include 'share/login_check.php';

if(!isset($action))
{
    $action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : 'welcome';
}



$params = '';
if (isset($_REQUEST['params']))
{
    $params = params_decode($_REQUEST['params']);
}

unset($continue);


require_once 'action/' . $action . '.php';


if (isset($continue))
{
    session_write_close();
    header('Location: index.php?' . $continue);
}


?>
