<?php
# vim: set fileencoding=latin1 :

$banner = <<<END
<h1>Acerca del proyecto Sumar - Ministerio de Salud Argentina</h1>
END;

$about = <<<END
    <div class="row-fluid">

            <h1 style="font-size:42px; font-weight: bold; color:#0099CC; text-shadow: 2px 2px #ccc;">La Salud en los Medios</h1>
            <p style="font-size:22px; color:#666666; line-height: 150%;">Sistema de relevamiento de notas publicadas en medios nacionales sobre el Programa Sumar, el Plan Nacer y temáticas materno - infantil, realizado por la Facultad de Periodismo y Comunicación Social de la Universidad Nacional de La Plata.</p>
    </div>  <!-- row --> 
END;

$credits = <<<END
<div class="row-fluid">
    <br>
    <h3>
        <span style="color:#757116">~ </span><span style="color:#AEBC21">~ </span><span style="color:#D9DB56">~ </span>
        <span style="color:#00477F">~ </span><span style="color:#4C88BE">~ </span><span style="color:#8DC3E9">~ </span>
        Créditos
        <span style="color:#8DC3E9"> ~</span><span style="color:#4C88BE"> ~</span><span style="color:#00477F"> ~</span>
        <span style="color:#D9DB56"> ~</span><span style="color:#AEBC21"> ~</span><span style="color:#757116"> ~</span>
    </h3>
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
</div>
END;


include 'header.php';

echo '<div style="margin-left:10%; margin-right:10%; text-align:center;">';
echo $about;
echo $credits;
echo '</div>';

echo '<br>';
echo '<br>';



include 'footer.php';


