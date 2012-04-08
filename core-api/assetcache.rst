Asset Cache
===========

Sally bringt ab Version 0.4.2 eine Infrastruktur zum automatischen statischen
Cachen von Assets (u.a. CSS/JS-Dateien). Das Caching wird über
mod_rewrite-Regeln umgesetzt und löst die bis dahin verwendete :file:`gzip.php`
ab. Ziel ist, die notwendigen PHP-Instanzen (bei einem Server mit FastCGI)
drastisch zu reduzieren, ohne den Vorteil der gzip/deflate-Komprimierung zu
verlieren.

Die zentralen Features sind:

* Statisches Caching aller Assets (Bilder, Dokumente, Flash-Animationen, ...)
* Cache files in den benötigten Formaten (gzip, deflate und plain) vorhalten um
  den Server optimal zu entlasten
* Setzen der von expires Headern
* Möglichkeit für Addons Einfluss auf das Caching zu nehmen, z.B. zum Caching
  der verschiedenen Image Resize Bilder
* Support für das Ausliefern von geschützten Dateien (z.B. für interne Bereiche
  im Frontend, bei denen Dateien nur an eingeliggte Nutzer ausgeliefert werden
  dürfen)
* Caching von Assets aus dem Frontend sowie aus dem Backend

Konzept
-------

Die Idee hinter dem Asset-Cache ist, dass der Sally-Core ein performantes und
erweiterbares Caching-System mitbringt, dass es für Addons überflüssig macht,
sich selbst um das Asset-Caching zu kümmern.

Auslieferung
^^^^^^^^^^^^

Über eine RewriteRule werden zu cachende Assets beim ersten Zugriff durch einen
Client durch Sally verarbeitet und gecached. Diese Verarbeitung beinhaltet für
CSS-Dateien eine Verarbeitung mit :doc:`Scaffold </frontend-devel/scaffold>`.
Alle weiteren Dateien werden standardmäßig nur entsprechend des
``Accept-Encoding``-Headers des Clients komprimiert und in einem dynamisch
angelegten Verzeichnis abgelegt. Von dort aus werden die Dateien bei jedem
weiteren Zugriff direkt durch den Apache ausgeliefert, ohne dass PHP zum Einsatz
kommt.

Die Cache-Dateien werden in :file:`data/dyn/public/sally/static-cache`
abgelegt. Sally wird die ursprüngliche Verzeichnisstruktur der Dateien dort
widerspiegeln, sodass eine Datei :file:`assets/css/main.css` zum Beispiel in
:file:`data/dyn/public/sally/static-cache/[encoding]/assets/css/main.css`
abgelegt wird. ``encoding`` ist hierbei ``gzip``, ``deflate`` oder ``plain``,
jenachdem, was der Client anfordert (d.h. die jeweiligen Varianten werden erst
bei Bedarf erzeugt).

Invalidierung
^^^^^^^^^^^^^

Die gecacheten Assets werden je nach Konfiguration vom System automatisch
invalidiert. Dabei werden die Erstellungszeiten aller Cachefiles mit ihren
Originalen verglichen und alle varianten des Cachefiles entfernt, die älter
sind, als ihr Original. Beim nächsten Zugriff auf die Datei wird die Cache-File
wieder neu generiert und entsprechend ausgeliefert.

Produktivmodus
""""""""""""""

Sofern sich das System im Produktivmodus befindet, wird der Asset-Cache im
Sally-Core bei Änderungen im Medienpool invalidiert. Addons können das
Invalidieren per API-Call explizit auslösen. Außerdem wird der Cache beim
expliziten Cache-Leeren über das Backend auf der System-Seite durch den
Backend-Nutzer geleert.

Entwicklermodus
"""""""""""""""

Falls sich das System im Entwicklermodus befindet, wird der Cache bei jedem
Aufruf des Backends sowie des Frontends invalidiert. Bei der Arbeit am CSS-Code
der Seite würde also ein einfacher Reload der CSS-Datei nicht helfen, um an die
aktuelle Datei zu kommen, sondern der Cache würde nach wie vor die veraltete
Datei ausliefern. Erst durch einen Aufruf des Back- oder Frontends der Seite
werden die Cache-Files revalidiert.

Konfiguration
-------------

In der :file:`.htaccess`-Datei im Projekt-Hauptverzeichnis gibt es eine
Rewrite-Rule, mit der die Assets an den Cache weitergeleitet werden.

.. sourcecode:: apache

  ...

  # Assets Cache
  RewriteCond %{REQUEST_FILENAME}  \.(css|js|gif|jpg|jpeg|png|swf|ico|pdf)$
  RewriteCond %{REQUEST_URI}       !wym_styles.css$
  RewriteRule ^(.*)$               data/dyn/public/sally/static-cache/$1 [L]

  ...

In der ersten ``RewriteCond`` wird entschieden, welche Dateitypen durch den
Cache ausgeliefert werden sollen. Wenn in einem Projekt auch Word-Dokumente,
o.ä. über den Medienpool ausgeliefert werden sollen, ist es sinnvoll, diese
hier ebenfalls hinzuzufügen.

Erweiterung / Nutzung in Addons
-------------------------------

.. note::

  TODO

Probleme
--------

Scaffold CSS-Includes
^^^^^^^^^^^^^^^^^^^^^

Dieses Konzept wird problematisch, wenn mehrere CSS-Dateien in einer
"Importdatei" über ``@include file.css`` eingebunden wird. Wird nun nur die
Importdatei im HTML-Kopf verlinkt, so wird auch nur sie vom Server verarbeitet
und gecached. Dabei wird Scaffold alle Includes auflösen. Ändert sich nun eine
eingebundene Datei (:file:`file.css`), wird dies vom Sally-Cache nicht bemerkt,
da dieser nur auf Änderungen der :file:`import.css` prüft.

Um dieses Problem zu umgehen, sollten **keine @include-Direktiven benutzt** und
alle CSS-Dateien **einzeln** in den HTML-Kopf eingefügt werden. Ein AddOn wie
der Deployer kann die Dateien dann zusammenfassen und so doch nur eine einzelne
CSS-Datei im HTML-Kopf verlinken.

Zugriffsbeschränkungen
----------------------

.. note::

  TODO

Events
------

.. note::

  TODO
