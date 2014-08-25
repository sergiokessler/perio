<?php


if ( (isset($_POST['u'])) 
      and 
     (isset($_POST['p'])) )
{

    $login = array($_POST['u'], $_POST['p']);


    if ( in_array($login, $config['auth']) )
    {
        $_SESSION['logged_in'] = true;
        $_SESSION['u'] = $_POST['u'];
        $_SESSION['p'] = $_POST['p'];
        $continue = '.';
//        echo '<pre>'; var_dump($_SESSION); echo '</pre>';
    }
    else
    {
        $msg = 'Nombre de usuario o clave incorrecta.';
        $params_cont['msg'] = $msg;
        $params_cont = params_encode($params_cont);

        $continue = '?action=home&params=' . $params_cont;
    }
}
else
{
    $continue = '.';
}

