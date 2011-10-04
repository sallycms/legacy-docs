<?php
/**
 * @sly name  standard
 * @sly title Standardtemplate
 * @sly slots {main: Hauptbereich}
 */

$layout = sly_Core::getLayout('Frontend');
$layout->openBuffer();

// Jetzt kann der Content ausgegeben werden.
?>
<div id="wrapper">
	<div class="content">
		<?= $article->getArticle('main') ?>
	</div>
</div>
<?

$layout->closeBuffer();
print $layout->render();
