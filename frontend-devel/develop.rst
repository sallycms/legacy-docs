Develop-System
==============

Das Develop-System umfasst alle Teile eines Projekts, die spezifisch für das
Projekt entwickelt werden (ausgenommen AddOns und :doc:`Assets <assets>`). Dazu
zählen **Templates**, **Module** und die **Projekt-Konfiguration**.

.. toctree::
   :hidden:

   develop/articletypes
   develop/templates
   develop/layouts
   develop/modules
   develop/slicehelper

Unterseiten
-----------

* :doc:`Artikeltypen <develop/articletypes>` bestimmen, welche verschiedenen
  Typen von Artikeln (zum Beispiel "Homepage", "Stellenangebot",
  "Pressemitteilung" etc.) dem Redakteur zur Verfügung stehen.
* :doc:`Templates <develop/templates>` & :doc:`Layouts <develop/layouts>`
  steuern die Ausgabe der Artikel im Frontend.
* :doc:`Module <develop/modules>` & :doc:`Slice-Helper <develop/slicehelper>`
  dienen dazu, die eigentliche Inhalte (Texte, Bilder etc.) zu verwalten.

Verzeichnisstruktur
-------------------

Alle Dateien, die serverseitig für das Frontend relevant sind, werden in
:file:`develop/` gespeichert. Das Verzeichnis liegt direkt im Root des Projekts.

::

  /
  +- assets/
  +- data/
  +- develop/
     +- config/        Konfiguration
     +- lib/           projektspez. Bibliotheken, Controller und Helfer-Klassen
     +- modules/       Module
     +- templates/     Templates
  +- sally/
  +- index.php

Wie auf dem Schema zu erkennen ist, werden Templates und Module noch einmal in
gesonderten Verzeichnissen angelegt.

Tipp
^^^^

Natürlich muss man sich bei der Entwicklung komplexer Projekte nicht auf diese
beiden Verzeichnisse beschränken. Je nach Bedarf können weitere Verzeichnisse
auf Wunsch ergänzt werden.

Es ist auch problemlos möglich, Klassen mit in Templates/Modulen zu notieren
oder Dateien, die keine Templates/Module sein sollen, in den entsprechenden
Verzeichnissen mit abzulegen. Dazu im folgenden Abschnitt mehr.

Metainformationen
-----------------

Sally benötigt neben den eigentlichen Code-Dateien noch weitere Informationen,
um die Dateien korrekt verwenden zu können. So müssen die anzuzeigenden Namen
(z.B. "Startseite" oder "Texteditor") angegeben werden, ebenso wie Slots und
andere Informationen. Da die Dateien nicht in einer Datenbank liegen, müssen
diese Angaben direkt in den Dateien selbst notiert werden. Zu diesem Zweck liest
Sally den ersten DocBlock (Kommentar, der mit ``/**`` beginnt) aus und scant ihn
nach speziellen Tags ab. Dies könnte wie im folgenden Beispiel-Template
aussehen:

.. literalinclude:: develop/template.demo.php
   :language: php

In dem obigen Template wurden 3 (na ja, eigentlich 4) Werte notiert: **title**,
**slots**, **modules** und **param**. Dabei gelten die folgenden Regeln:

* Es wird der erste PHP-Kommentar der Form ``/** ... */`` ausgewertet. Jeder
  weitere wird ignoriert.
* Innerhalb dieses Kommentars können beliebig viele Werte notiert werden.
* Die Werte (``@sly``-Angaben) müssen nicht in einer Gruppe notiert werden (wie
  oben zu sehen).
* Zwischen ``@sly`` und Namen sowie zwischen dem Namen und dem Wert muss
  mindestens ein Leerzeichen stehen. Alle weiteren Leerzeichen werden ignoriert.

Die Werte werden automatisch als
`YAML <http://de.wikipedia.org/wiki/YAML>`_ angesehen und entsprechend
geparsed. Das bedeutet, dass auf PHP-Seite der Wert für **slots** nicht der
String ``'[links, rechts]'`` erscheint, sondern das Array
``array('links', 'rechts')``. Neben Arrays sind auch Hashes (assoziative
Arrays), boolesche Werte und Zahlen möglich.

Sollte ein Wert nicht als YAML geparst werden können, wird er einfach als
normaler String angesehen.

Besondere Metainformationen
^^^^^^^^^^^^^^^^^^^^^^^^^^^

Sally wird einige der Werte als besonders betrachten (und diese zum Teil auch
als Pflichtangabe voraussetzen). Das bedeutet allerdings nicht, dass man nicht
beliebig viele, eigene Daten in dieser Form in einem Template notieren kann. Je
nach Einsatz können so bestimmte Variablen-Konstrukte einfach ersetzt werden.

Genauere Informationen über diese Pflichtangaben sind in den Detail-Seiten zu
:doc:`Templates <develop/templates>` und :doc:`Modulen <develop/modules>`
enthalten.

Alle Metainformationen stehen über den entsprechenden
:doc:`Service </core-api/services>` auf PHP-Seite bereit.

.. sourcecode:: php

  <?php
  $service = sly_Service_Factory::getTemplateService();
  $slots   = $service->get('startseite', 'slots', 'default-value'); // array('links', 'rechts')

  $service = sly_Service_Factory::getModuleService();
  $myParam = $service->get('mein-modul', 'myparam', 'default-value', 'input');

Neben diesen generischen Methoden stehen für die "besonderen" Metainformationen
auch Shortcuts bereit:

.. sourcecode:: php

  <?php
  $service = sly_Service_Factory::getTemplateService();
  $title   = $service->getTitle('startseite');
  $cl      = $service->getClass('startseite');
  $slots   = $service->getSlots('startseite');

  // entsprechend auch für Module

Für alle Dateien gilt, dass ein Wert für **name** gesetzt werden muss. Dieser
dient dazu, ein Template/Modul im Code anzusprechen. Es ist also möglich, ein
Template als Datei :file:`foo.php` zu speichern, es aber dennoch über
**startseite** anzusprechen, wenn ``@sly name startseite`` im Template notiert
ist.

.. note::

  Der interne Name muss jeweils eindeutig sein (d.h. es kann durchaus ein
  Template **foo** und ein Modul **foo** geben, niemals aber zwei Templates
  mit dem Namen **foo**).

Develop-Dateien, die diese Anforderung nicht erfüllen, führen zur Ausgabe einer
PHP-Warning im Backend.

Refresh
-------

Sally wird im :doc:`Entwicklermodus </arch/environments>` bei jedem Seitenaufruf
(sowohl Frontend als auch Backend) die Develop-Inhalte durchsuchen und
Änderungen synchronisieren. Dazu ist es nicht nötig, das Backend aufzurufen,
eingeloggt zu sein oder den Cache manuell zu leeren.

Im **Produktivmodus** hingegen wird Sally annehmen, dass keine Änderungen an
den Develop-Inhalten stattfinden und daher keine Synchronisation durchführen.
Seit :doc:`Version 0.6.3 </appendix/0.6/changelog>` findet jedoch immerhin noch
dann eine Synchronisation statt, wenn ein Administrator im Backend eingeloggt
ist oder der Cache von Hand geleert wird. Alternativ kann auch kurzzeitig der
Entwicklermodus aktiviert werden.
