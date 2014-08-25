<?php

/*

  $Id: youarehere.php,v 1.1 2006/04/12 15:11:44 sak Exp $
  
  este script le indica al usuario donde esta parado.

*/

echo '<div align="right">';
echo 'Usuario: <b>';
if (isset($_SESSION['u']))
    echo $_SESSION['u'];
echo '</b>';
echo '&nbsp;&nbsp;&nbsp;';


?>
