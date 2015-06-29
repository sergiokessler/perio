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
                if (strpos($action, 'tabulado') !== false) $active = 'Tabulado';
                if (strpos($action, 'report') !== false) $active = 'Reportes';
              ?>

              <li <?php echo($active=='Notas' ? 'class="active"' : '')?>><a href="?action=nota_list">Notas</a></li>

              <li <?php echo($active=='Medios' ? 'class="active"' : '')?>><a href="?action=medio_list">Medios</a></li>

              <li <?php echo($active=='Regiones' ? 'class="active"' : '')?>><a href="?action=region_list">Regiones</a></li>
              
              <li <?php echo($active=='Tabulado' ? 'class="active"' : '')?>><a href="?action=tabulado_list">Tabulado</a></li>

              <li <?php echo($active=='Reportes' ? 'class="active"' : '')?>><a href="?action=report">Reportes</a></li>

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

