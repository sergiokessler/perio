<?php

/*
 * by Sak@perio
 */
# vim: set fileencoding=ISO-8859-1 


if ( (isset($_POST['u'])) 
      and 
     (isset($_POST['p'])) )
{
    $login_success = false;

    $login = array($_POST['u'], $_POST['p']);

    if ( in_array($login, $config['auth']) )
    {
        $login_success = true;
    }

    if ($login_success)
    {
        session_regenerate_id();
        $_SESSION['logged_in'] = $config['realm'];
        $_SESSION['u'] = $_POST['u'];
        $_SESSION['p'] = $_POST['p'];
        $continue = '?action=home';
//        echo '<pre>'; var_dump($_SESSION); echo '</pre>';
    } else
    {
        $msg = 'Nombre de usuario o clave incorrecta.';
    }
}

if (!isset($_SESSION['logged_in']))
{
    include 'header.php';


    echo '<div class="container">';
    echo '<div class="row">';
    echo '<div class="col-sm-6 col-md-4 col-md-offset-4">';
    echo '<br>';

    if (!empty($config['title'])) {
        echo '<h1>' . $config['title'] . '</h1>';
    }

    if (isset($msg)) {
        echo '<div class="alert alert-warning">';
        echo $msg;
        echo '</div>';
    }

    echo '<form id="login" method="post">';
    echo '<input type="hidden" name="action" value="login">';
    echo '<div class="form-group">';
    echo '<label for="u" class="cols-sm-2 control-label">Usuario:</label>';
    echo '<input type="text" name="u" value="" id="u">';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<label for="p" class="cols-sm-2 control-label">Clave:</label>';
    echo '<input type="password" name="p" value="" id="p">';
    echo '</div>';
    echo '<div class="form-group">';
    echo '<button type="submit" class="btn btn-lg btn-primary" name="submit">Entrar</button>';
    echo '</div>';
    echo '</form>';

    echo '</div>';
    echo '</div>';
    echo '</div>';


    include 'footer.php';
}

