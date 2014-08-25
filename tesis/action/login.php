<?php

/*

$Id: login.php,v 1.2 2006/06/26 14:27:20 sak Exp $

*/


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
        $continue = 'action=welcome';
//        echo '<pre>'; var_dump($_SESSION); echo '</pre>';
    }
    else
    {
        $msg = 'Nombre de usuario o clave incorrecta.';
    }
}

if (!isset($_SESSION['logged_in']))
{
    include 'header.php';

    echo '<center>';
    echo '<h1>' . $config['realm'] . '</h1>';

    if (isset($msg))
    {
        echo $msg . '<br><br>';
    }

    echo '<form id="login" method="post">';
    echo '<input type="hidden" name="action" value="login">';
    echo 'Usuario: <input name="u" value="" id="u">';
    echo ' Clave: <input type="password" name="p" value="" id="p">';
    echo ' <input type="submit" name="submit" value="Entrar">';
    echo '</form>';

    echo '</center>';

    include 'footer.php';
}

?>
