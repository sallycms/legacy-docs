<?php
/**
 * @sly name  standard
 * @sly title Standardtemplate
 * @sly slots {main: Hauptbereich}
 */

// zuerst benötigen wir die Layout-Instanz
$layout = sly_Core::getLayout('XHTML');

// Nun kann der Kopf über die verfügbare API initialisiert werden.
// Alle Werte werden automatisch HTML-kodiert!
$layout->setTitle('Mein Seitentitel > Unterseite');

// CSS
$layout->addCSSFile('assets/css/main.css'); // media = screen
$layout->addCSSFile('assets/css/ie.css', 'screen', 'IF lt IE 7'); // erzeugt autom. die Conditional Comments

// Inline-CSS kann ebenfalls gesetzt werden
// (werden zusammen in einem <style>-Tag ausgegeben)
$layout->addCSS('.selector { color: red; }');
$layout->addCSS('.selector2 { color: blue; }');

// JavaScript verläuft analog
$layout->addJavaScriptFile('http://code.jquery.com/jquery-1.6.1.min.js');
$layout->addJavaScriptFile('assets/js/main.js');

$layout->addJavaScript('alert("foo");');

// Für weitere Tags gibt es ebenfalls Methoden.
$layout->addMeta('robots', 'index, follow, noodp');
$layout->addHttpMeta('Content-Type', 'text/html; charset=UTF-8');
$layout->setFavIcon('data/mediapool/favicon.ico');
$layout->addLink('rel', 'href', 'type', 'title');
$layout->addFeedFile('myfeed.xml', 'rss1'); // rss, rss1, rss2 oder atom

// Das <body>-Tag kann auch geändert werden.
$layout->setBodyAttr('class', 'mybodyclass');

// Nun ist der Kopf initialisiert. Wir können den Buffer öffnen.
// (Das hätten wir auch schon zu einem beliebigen früheren Zeitpunkt tun können.)
$layout->openBuffer();

// Jetzt kann der Content ausgegeben werden.
?>
<div id="wrapper">
	<div class="content">
		<?= $article->getArticle('main') ?>
	</div>
</div>
<?

// Nun schließen wir den Buffer und printen alles raus.
$layout->closeBuffer();
print $layout->render();

// Done!