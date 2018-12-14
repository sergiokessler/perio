<?php

/*

  $Id: index.php,v 1.1 2006/04/12 15:06:31 sak Exp $


  front controller
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
    return(unserialize(gzuncompress(base64_decode(rawurldecode($params)))));
}

require_once 'config.php';
session_name($config['session_name']);
session_start();
include 'include/login_check.php';

if(empty($action)) {
    $action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : 'home';
}


$params = '';
if (isset($_REQUEST['params'])) {
    $params = params_decode($_REQUEST['params']);
}

unset($continue);


require_once __DIR__ . '/action/' . $action . '.php';


if (isset($continue)) {
    session_write_close();
    header('Location: ' . $continue);
}


