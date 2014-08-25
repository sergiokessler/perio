        <!-- comienzo del menu para usuario -->

         <?php
           if (isset($_SESSION['logged_in'])) {
         ?>
        <div class="row">

        <div class="col-xs-6 col-sm-3" id="sidebar" role="navigation">

            <ul class="well nav nav-pills nav-stacked noprint">
              <!-- <li class="active"><a href="#">Link</a></li> -->
              <?php
                $active = '';
                if (strpos($action, 'nota') !== false) $active = 'Notas';
                if (strpos($action, 'medio') !== false) $active = 'Medios';
                if (strpos($action, 'region') !== false) $active = 'Regiones';
              ?>

              <li <?php echo($active=='Notas' ? 'class="active"' : '')?>><a href="?action=material_insert">Ingresar material</a></li>

              <li <?php echo($active=='Medios' ? 'class="active"' : '')?>><a href="?action=material_search">Buscar material</a></li>

              <li <?php echo($active=='Notas' ? 'class="active"' : '')?>><a href="?action=noticia_insert">Ingresar noticias</a></li>

              <li <?php echo($active=='Notas' ? 'class="active"' : '')?>><a href="?action=noticia_search">Buscar noticias</a></li>

              <li <?php echo($active=='Regiones' ? 'class="active"' : '')?>><a href="?action=materia">Materias</a></li>
              
              <li class="nav-header">Reportes</li>
<!--
              <li <?php $o='report_pcia_medio_cant'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Res?men por Pcia y Medio</a></li>
              <li <?php $o='report_totales'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Totales</a></li>
              <li <?php $o='report_zona_norte'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Zona Norte</a></li>
              <li <?php $o='report_zona_centro'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Zona Centro</a></li>
              <li <?php $o='report_zona_bsas'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Zona Bs As</a></li>
              <li <?php $o='report_zona_sur'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Zona Sur</a></li>
              <li <?php $o='report_zona_nacional'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Zona Nacional</a></li>
-->
            </ul>
        </div><!--col-sm-3-->

        <div class="col-xs-12 col-sm-9">

        <?php
          }
        ?>
        <!-- fin del menu para usuario -->

