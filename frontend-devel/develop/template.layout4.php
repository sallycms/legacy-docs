<?php
/**
 * @sly name  standard
 * @sly slots {main: Hauptbereich}
 */

$layout = new FrontendLayout();
sly_Core::setLayout($layout);

$layout->openBuffer();

// Jetzt kann der Content ausgegeben werden.
?>
<div id="wrapper">
	<div class="content">
		<?php echo $article->getContent('main') ?>
	</div>
</div>
<?php

$layout->closeBuffer();
print $layout->render();
