<?php
# vim: set fileencoding=latin1 :

$banner = <<<END
<h1>Acerca del proyecto Sumar - Ministerio de Salud Argentina</h1>
END;

$about = <<<END
          <div class="hero-unit">
            <h1>La Salud en los Medios</h1>
            <p>Sistema de relevamiento de notas publicadas en medios nacionales sobre el Plan Nacer y temáticas materno - infantil relacionadas</p>
            <br>
            <img src="img/logo_sumar.png">
          </div> 
END;

$credits = <<<END
<div style="display: block; margin-left:10%; margin-right:10%;">
<marquee behavior="scroll" scrollamount="1" direction="up" loop="0" style="text-align:center; font-style:italic; height: 5em;">
Lineamientos generales: Cristian Scarpetta<br>
<br>
<br>
Desarrollo de Software: Sergio A. Kessler (sergio@kessler.com.ar)<br>
<br>
<br>
</marquee>
</div>
END;


include 'header.php';

echo '<div style="margin-left:10%; margin-right:10%; text-align:center;">';
echo $about;
echo '<br>';
echo '<h2>';
echo '<span style="color:#757116">~ </span><span style="color:#AEBC21">~ </span><span style="color:#D9DB56">~ </span>';
echo '<span style="color:#00477F">~ </span><span style="color:#4C88BE">~ </span><span style="color:#8DC3E9">~ </span>';
echo 'Créditos';
echo '<span style="color:#8DC3E9"> ~</span><span style="color:#4C88BE"> ~</span><span style="color:#00477F"> ~</span>';
echo '<span style="color:#D9DB56"> ~</span><span style="color:#AEBC21"> ~</span><span style="color:#757116"> ~</span>';
echo '</h2>';
echo $credits;
echo '</div>';

echo '<br>';
echo '<br>';



include 'footer.php';


