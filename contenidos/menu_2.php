<?php

/*

  $Id: menu_2.php,v 1.1 2007/10/10 17:15:47 develop Exp $

*/





// armamos menu principal
unset($menu_2);

$params_r = null;
$params_r = params_encode($params_r); 


if ($_SESSION['u'] == 'admin')
{
$menu_2[] = array (
    'title' => 'Areas',
    'url' => 'index.php?action=area'
);
$menu_2[] = array (
    'title' => 'Usuarios',
    'url' => 'index.php?action=usuario'
);
$menu_2[] = array (
    'title' => 'Usuarios x Area',
    'url' => 'index.php?action=usuario_area'
);
}
else
{
$menu_2[] = array (
    'title' => 'Notas',
    'url' => 'index.php?action=nota'
);
}



echo '<br>';
echo 'Seleccione una opcion:';
echo '<br>';
echo '<br>';

echo '<div id="menucontainer">';
echo '<ul id="navlist">';
foreach ($menu_2 as $menu)
{
    echo '<li><a href="' . $menu['url'] . '">' . $menu['title'] . '</a></li>';
}
echo '</ul>';
echo '</div>';


