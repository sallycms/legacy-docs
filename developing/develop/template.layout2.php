<?php

// Angabe von 'XHTML' ist nicht nötig, da nur ein Layout gleichzeitig
// existieren kann und es bereits im Template initialisiert wurde.
// Außerdem muss das Modul so nicht wissen, *welches* Layout (XHTML, HTML5, ...)
// verwendet wird. Zusätzlich kann man so auch im Backend einfach auf
// das Sally-Layout zugreifen.

$layout = sly_Core::getLayout();

if (sly_Core::isBackend()) {
	// Backend-Ausgabe
	$layout->addCSSFile('../assets/css/moduleX.css');
}
else {
	// Frontend-Ausgabe
	$layout->addCSSFile('assets/css/moduleX.css');
}
