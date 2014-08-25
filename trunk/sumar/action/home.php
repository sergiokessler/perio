<?php
# vim: set fileencoding=latin1 :

include 'header.php';

$tweets_widget = <<<END
<a class="twitter-timeline" width="520" height="410" href="https://twitter.com/search?q=%23ProgramaSUMAR+OR+%22programa+sumar%22+OR+%22plan+nacer%22+OR+%22Mart%C3%ADn+Sabignoso%22+-zacatecas" data-widget-id="491266330796883968">Ultimos tweets</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
END;


/*
$tweets = include 'tweets.php';
$tweets = $tweets['statuses'];
*/

/*
echo '<pre>';
print_r($tweets);
echo '</pre>';
*/
/*
$tweets_html = 'Ultimos tweets:';
$tweets_html .= '<table class="table table-striped">';
foreach ($tweets as $t) {
    $tweets_html .= '<tr>';
    $tweets_html .= '<td>';
    $tweets_html .= '<img src="' . $t['user']['profile_image_url'] . '">';
    $tweets_html .= '</td>';
    $tweets_html .= '<td>';
    $tweets_html .= '<span style="font-weight:bold">' . $t['user']['name'] . '</span> ';
    $tweets_html .= '<span style="color: lightgray">'. $t['created_at'] . '</span> ';
    $tweets_html .= '<br>' . utf8_decode($t['text']);
    $tweets_html .= '</td>';
    $tweets_html .= '</tr>';
}
$tweets_html .= '</table>';
*/

$content = <<<END
        <div class="row-fluid">

        <div class="span6">
            <h1 style="font-size:38px; font-weight: bold; color:#0099CC; text-shadow: 2px 2px #ccc;">La Salud en los Medios</h1>
            <p style="font-size:22px; color:#666666; line-height: 150%;">Sistema de relevamiento de notas publicadas en medios nacionales sobre el Programa Sumar, el Plan Nacer y temáticas materno - infantil, realizado por la Facultad de Periodismo y Comunicación Social de la Universidad Nacional de La Plata.</p>
        </div>
        <div class="span6">
            $tweets_widget
        </div>

        </div>  <!-- row -->
END;

echo $content;



include 'footer.php';

