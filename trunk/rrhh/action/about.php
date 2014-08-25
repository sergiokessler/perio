<?php


$banner = <<<END
<h1>Acerca del proyecto Sumar - Ministerio de Salud Argentina</h1>
END;

$about = <<<END
          <div class="hero-unit">
            <h1>$config[realm]</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>
            <br>
          </div> 
END;
//            <img src="img/logo_sumar.png">

$credits = <<<END
<div style="display: block; margin-left:10%; margin-right:10%;">
<marquee behavior="scroll" scrollamount="1" direction="up" loop="0" style="text-align:center; font-style:italic; height: 5em;">
Lineamientos generales: Paloma<br>
<br>
<br>
Desarrollo de Software: Sergio A. Kessler <sak@perio.unlp.edu.ar><br>
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


