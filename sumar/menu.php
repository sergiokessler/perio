<!-- # vim: set fileencoding=latin1 : -->

<?php
if (isset($_SESSION['logged_in'])) {
?>
          <div class="well sidebar-nav noprint">
            <ul class="nav nav-list">
              <li class="nav-header">Notas</li>
              <!-- <li class="active"><a href="#">Link</a></li> -->
              
              <li <?php $o='nota_list'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Lista de notas</a></li>
              <?php
                  if ($_SESSION['u'] != 'consulta') {
                      echo '<li ';
                      $o='nota_insert'; 
                      echo ($action == $o ? 'class="active"' : '');
                      echo '>';
                      echo "<a href=\"?action=$o\">Cargar nota</a>";
                      echo '</li>';
                  }
              ?>
              <li <?php $o='nota_search'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Buscar notas</a></li>

              <li class="nav-header">Informes</li>
              <?php
                  if ($_SESSION['u'] != 'consulta') {
                      echo '<li ';
                      $o='informe_upload';
                      echo ($action == $o ? 'class="active"' : '');
                      echo '>';
                      echo "<a href=\"?action=$o\">Subir Informe</a>";
                      echo '</li>';
                  }
              ?>
              <li <?php $o='informe_list'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Ver informes</a></li>


              <li class="nav-header">Medios</li>
              <li <?php $o='medio_list'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Ver medios</a></li>
              <?php
                  if ($_SESSION['u'] != 'consulta') {
                      echo '<li ';
                      $o='medio_insert';
                      echo ($action == $o ? 'class="active"' : '');
                      echo '>';
                      echo "<a href=\"?action=$o\">Cargar medio</a>";
                      echo '</li>';
                  }
              ?>
              <li class="nav-header">Reportes</li>
              <li <?php $o='report_pcia_medio_cant'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Resumen por Pcia y Medio</a></li>
              <li <?php $o='report_totales'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Totales</a></li>
              <li <?php $o='report_zona_norte'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Zona Norte</a></li>
              <li <?php $o='report_zona_centro'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Zona Centro</a></li>
              <li <?php $o='report_zona_bsas'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Zona Bs As</a></li>
              <li <?php $o='report_zona_sur'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Zona Sur</a></li>
              <li <?php $o='report_zona_nacional'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Zona Nacional</a></li>
            </ul>
          </div><!--/.well -->
<?php
} else {
?>

    <form class="well" method="post">
        <input type="hidden" name="action" value="login">

        <label><i class="icon-user"></i></label>
        <input name="u" class="row-fluid" type="text" placeholder="Usuario">

        <label><i class="icon-lock"></i></label>
        <input name="p" class="row-fluid" type="password" placeholder="Clave">
      <input class="btn-primary" type="submit" value="Iniciar Sesión">
    </form>

<?php            
}
?>

