<?php

// Wir holen uns das vom Template gesetzte Layout vom Core ab.
$layout = sly_Core::getLayout();

if (sly_Core::isBackend()) {
	// Backend-Ausgabe
	$layout->addCSSFile('../assets/css/moduleX.css');
}
else {
	// Frontend-Ausgabe
	$layout->addCSSFile('assets/css/moduleX.css');
}
