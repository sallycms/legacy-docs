Assets
======

Assets sind die Dateien, die für das Layout im Frontend notwendig sind. Dazu
zählen CSS, JavaScript und Bilder wie das Logo (sowie weitere Layout-Bilder).
Ihnen ist gemein, dass sie sich nicht ändern und damit vom Backend aus nicht
zugänglich sind.

Verzeichnisstruktur
-------------------

Im Standard-Layout eines Sally-Projekts werden diese Dateien im Verzeichnis
:file:`assets` verwaltet:

::

  /
  +- assets
  |  +- css
  |  |  +- main.css
  |  |  +- forms.css
  |  |  +- ...
  |  +- images
  |  |  +- logo.jpg
  |  |  +- background.png
  |  |  +- ...
  |  +- js
  |  |  +- jquery.min.js
  |  |  +- main.js
  |  |  +- ...
  |  +- (ggf. weitere Verzeichnisse, je nach Bedarf)
  +- data
  +- develop
  +- sally
     +- backend
     +- core
     +- frontend

Assets verlinken
----------------

Idealerweise wird das Frontend über ``sly_Layout`` gerendert. Im
:doc:`Starterkit </general/starterkit>` ist dies über die Klasse
``FrontendHelper`` gelöst, die projektspezifisch das Layout anpasst und CSS/JS
verlinkt, den Seitentitel setzt usw.

Dieses Vorgehen hat u.a. den großen Vorteil, dass AddOns über einen einfachen
Weg auf den "HTML-Kopf" der Seite zugreifen und ihn verändern können. So kann
der `Deployer <https://projects.webvariants.de/projects/deployer-ng>`_ die
CSS/JS-Dateien abgreifen und minimieren oder `varilog
<https://projects.webvariants.de/projects/varilog>`_ den Pingback-Link ergänzen.

Die API dazu ist denkbar einfach:

.. sourcecode:: php

  <?
  $layout = sly_Core::getLayout(); // das zuvor irgendwo gesetzte Layout abrufen

  // CSS-Dateien
  $layout->addCSSFile('assets/css/main.css');
  $layout->addCSSFile('assets/css/print.css', 'print');
  $layout->addCSSFile('assets/css/ie.css', 'screen', 'IF LT IE7');

  // JS-Dateien
  $layout->addJavaScriptFile('assets/js/jquery.min.js');
  $layout->addJavaScriptFile('assets/js/main.js');

Natürlich ist auch Inline-Code möglich:

.. sourcecode:: php

  <?
  $layout = sly_Core::getLayout(); // das zuvor irgendwo gesetzte Layout abrufen

  // CSS
  $layout->addCSS('body { display: none }');

  // JS
  $layout->addJavaScript('$(function() { alert(1); });');

Änderungen im Backend erlauben
------------------------------

Wenn Elemente von einem Redakteur änderbar sein sollen (dies betrifft meist das
Logo einer Seite), sollten diese Dateien einfach im :doc:`Medienpool
</sallycms/mediapool>` verwaltet werden. Über eine Global Setting kann das Logo
dann auswählbar gemacht werden.
