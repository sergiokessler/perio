<?php

/*

$Id: login.php,v 1.1 2007/10/10 17:15:47 develop Exp $

*/


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
    elseif(isset($config['user_table']))
    {
        require_once 'DB.php';
        $db = DB::connect($config['db']);
        if (PEAR::isError($db)) die($db->getMessage());

        $user_sql = 'select * from ' . $config['user_table'] 
                  . ' where ' . $config['user_name_field'] . ' = ? and ' . $config['user_passwd_field'] . ' = ? ';
        $user_row = $db->getRow($user_sql, $login, DB_FETCHMODE_ASSOC);

        if (isset($user_row[$config['user_name_field']])) {
            $login_success = true;
        }
    }

    if ($login_success)
    {
        session_regenerate_id();
        $_SESSION['logged_in'] = $config['realm'];
        $_SESSION['u'] = $_POST['u'];
        $_SESSION['p'] = $_POST['p'];
        $continue = 'action=welcome';
//        echo '<pre>'; var_dump($_SESSION); echo '</pre>';
    } else
    {
        $msg = 'Nombre de usuario o clave incorrecta.';
    }
}

if (!isset($_SESSION['logged_in']))
{
    include 'header.php';

    echo '<center>';
    if (!empty($config['title'])) {
        echo '<h1>' . $config['title'] . '</h1>';
    }

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

