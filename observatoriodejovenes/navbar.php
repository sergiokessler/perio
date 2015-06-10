
<div class="navbar navbar-static-top navbar-inverse" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Navegación</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="./"><?php echo $config['realm'] ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
              <li <?php $o='home'; echo($action==$o ? 'class="active"' : '')?>><a href="."><span class="glyphicon glyphicon-home"></span> </a></li>
              <li <?php $o='about'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Acerca de</a></li>
      </ul>
<?php

$q = empty($_GET['q']) ? '' : $_GET['q'];

$html_search = <<< END
      <form class="navbar-form navbar-left" role="search">
        <input type="hidden" name="action" value="nota_search">
        <div class="form-group">
          <input type="text" name="q" class="form-control" placeholder="buscar notas..." value="$q">
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
      </form>
END;

$html_login_form = <<< END
          <form class="navbar-form navbar-right" method="post" role="form">
            <input type="hidden" name="action" value="login">
            <div class="form-group">
                    <label for="u"><span class="glyphicon glyphicon-user"></span> </label>
                    <input type="text" class="form-control" name="u" placeholder="email">
            </div>
            <div class="form-group">
                    <label for="p"><span class="glyphicon glyphicon-lock"></span> </label>
                    <input type="password" class="form-control" name="p" placeholder="clave">
            </div>
            <button class="btn btn-success" type="submit">Iniciar Sesión</button>
          </form>
END;

$u = '';
if (isset($_SESSION['logged_in'])) {
    $u = $_SESSION['u'];
}

$html_logged_in = <<< END
    <ul class="nav navbar-nav navbar-right">
    <p class="navbar-text pull-right"><span class="glyphicon glyphicon-user"></span> $u &nbsp;|&nbsp; <a href="?action=logout">Salir</a></p>
    </ul>
END;


if (isset($_SESSION['logged_in'])) {
    echo $html_search;
    echo $html_logged_in;
} else {
    echo $html_login_form;
}

?>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container -->
</div><!-- /.navbar -->

