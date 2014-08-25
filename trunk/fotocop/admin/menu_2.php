<?php



// main menu
unset($data_menu_op);

$params_r = null;
$params_r = params_encode($params_r); 

$data_menu_op[] = array (
    'title' => 'Ingresar Material',
    'url' => 'index.php?action=material_insert'
);

$data_menu_op[] = array (
    'title' => 'Buscar material',
    'url' => 'index.php?action=material_search'
);

$data_menu_op[] = array (
    'title' => 'Ingresar Noticias',
    'url' => 'index.php?action=noticia_insert'
);

$data_menu_op[] = array (
    'title' => 'Buscar noticia',
    'url' => 'index.php?action=noticia_search'
);

$data_menu_op[] = array (
    'title' => 'Ver materias',
    'url' => 'index.php?action=materia'
);


echo _('Seleccione una opcion:');
echo '<br>';
echo '<br>';

echo '<div class="menucontainer">';
echo '<ul class="navlist">';
foreach ($data_menu_op as $menu)
{
    echo '<li><a href="' . $menu['url'] . '">' . $menu['title'] . '</a></li>';
}
echo '</ul>';
echo '</div>';


