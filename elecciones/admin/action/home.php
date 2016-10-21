<?php

/*
 * by Sak@perio
 */
# vim: set fileencoding=ISO-8859-1 


include_once 'header.php';


if (isset($_SESSION['logged_in'])) {
    include 'menu_in.php';
} else {
    include 'menu_out.php';
}


include_once 'footer.php';


