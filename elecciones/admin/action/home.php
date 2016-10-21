<?php

/*

 $Id: welcome.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/


include_once 'header.php';


if ($_SESSION['logged_in']) {
    include 'menu_in.php';
} else {
    include 'menu_out.php';
}


include_once 'footer.php';


