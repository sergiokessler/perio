<?php

/*

  $Id: youarehere.php,v 1.1 2007/10/10 17:15:47 develop Exp $
  
  este script le indica al usuario donde esta parado.

*/

echo '<div align="right">';
echo 'Usuario: <b>';
if (isset($_SESSION['u']))
    echo $_SESSION['u'];
echo '</b>';
echo '&nbsp;&nbsp;&nbsp;';


?>
