<!-- vim: set fileencoding=latin1 : --> 

    <div class="navbar noprint">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="."><?php echo $config['realm']; ?></a>
          <div class="nav-collapse">
            <ul class="nav">
              <li <?php $o='home'; echo($action==$o ? 'class="active"' : '')?>><a href="."><i class="icon-home"></i> Inicio</a></li>
              <li <?php $o='about'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Acerca de</a></li>
            </ul>
<?php

if (!isset($_SESSION['logged_in'])) {
} else {
    echo '<p class="navbar-text pull-right"><i class="icon-user"></i> <a href="#">'.$_SESSION['u'].'</a> &nbsp;|&nbsp; <a href="?action=logout">Salir</a></p>';
}

?>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

