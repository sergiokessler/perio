<?php

/*

$Id: login.php,v 1.2 2006/06/26 14:27:20 sak Exp $

*/


if ( (isset($_POST['u'])) 
      and 
     (isset($_POST['p'])) )
{

    $login = array($_POST['u'], $_POST['p']);
    //var_dump($login);
    //die();

    if ( in_array($login, $config['auth']) ) {
        $_SESSION['logged_in'] = true;
        $_SESSION['u'] = $_POST['u'];
        $_SESSION['p'] = $_POST['p'];
        $continue = '?action=home';
        //echo '<pre>'; var_dump($_SESSION); echo '</pre>';
        //die();
    } else {
        $msg = 'Nombre de usuario o clave incorrecta.';
    }
}

$login_form = <<<END
<div class="well noprint">
    <form class="form" method="post" role="form">
        <input type="hidden" name="action" value="login">
        <div class="form-group">
            <label for="u">Usuario:</label>
            <input type="text" name="u" id="u" placeholder="Usuario" class="form-control">
        </div>
        <div class="form-group">
            <label for="p"">Clave:</label>
            <input type="password" name="p" id="p" placeholder="Clave" class="form-control">
        </div>
        <input class="btn btn-primary" type="submit" value="Iniciar Sesión">
    </form>
</div>
END;



if (!isset($_SESSION['logged_in']))
{
    include 'header.php';

    echo '<center>';
    echo '<h1>' . $config['realm'] . '</h1>';

    echo $login_form;
    if (isset($msg)) {
        echo $msg . '<br><br>';
    }


    echo '</center>';

    include 'footer.php';
}
