<?php

/*

  $Id: youarehere.php,v 1.1 2006/04/12 15:11:44 sak Exp $
  
  este script le indica al usuario donde está parado.

*/

echo '<div align="right">';
if (isset($_SESSION['u'])) {
    echo 'Usuario: <b>' . $_SESSION['u']. '</b>';
}
echo '&nbsp;&nbsp;&nbsp;';


?>
