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

* :doc:`Artikeltypen <develop/articletypes>`
* :doc:`Templates <develop/templates>` & :doc:`Layouts <develop/layouts>`
* :doc:`Module <develop/modules>` & :doc:`Slice-Helper <develop/slicehelper>`

Verzeichnisstruktur
-------------------

Alle Dateien, die serverseitig für das Frontend relevant sind, werden in
:file:`develop/` gespeichert. Das Verzeichnis liegt direkt im Root einer
Website.::

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

Dateinamen: Templates
^^^^^^^^^^^^^^^^^^^^^

Jede Datei, die als Template erkannt und im Backend verfügbar sein soll, muss
auf ``.php`` enden (zum Beispiel :file:`startseite.php`). Sie sollten sich
regulär über einen PHP ``include`` einbinden lassen.

Dateinamen: Module
^^^^^^^^^^^^^^^^^^

Module bestehen aus zwei Komponenten: **Eingabe** und **Ausgabe**. Beide sind
optional. Sie müssen in separaten Dateien gepflegt werden:

* Eingabe: :file:`.input.php`
* Ausgabe: :file:`.output.php`

Für Module gelten die gleichen Regeln wie für Templates, was ihren Inhalt
betrifft.

Metainformationen
-----------------

Da die Daten nicht mehr in der Datenbank liegen, fällt die Möglichkeit, weitere
Informationen wie den angezeiten Titel im Backend oder die ctypes, weg. Diese
Daten werden nun direkt in den entsprechenden Dateien gepflegt und müssen in
einem regulären PHP-Kommentar auf eine spezielle Weise notiert werden.

.. literalinclude:: develop/template.demo.php
   :language: php

In dem obigen Template wurden 3 (na ja, eigentlich 4) Werte notiert: **title**,
**slots** (entsprechen den REDAXO ctypes), **modules** und **param**. Dabei
gelten die folgenden Regeln:

* Es wird der erste PHP-Kommentar der Form ``/** ... */`` ausgewertet. Jeder
  weitere wird ignoriert.
* Innerhalb dieses Kommentars können beliebig viele Werte notiert werden.
* Die Werte (``@sly``-Angaben) müssen nicht in einer Gruppe notiert werden (wie
  oben zu sehen).
* Zwischen ``@sly`` und Namen sowie zwischen dem Namen und dem Wert muss
  mindestens ein Leerzeichen stehen. Alle weiteren Leerzeichen werden ignoriert.

Die Werte werden automatisch als
`YAML-Daten <http://de.wikipedia.org/wiki/YAML>`_ angesehen und entsprechend
geparsed. Das bedeutet, dass auf PHP-Seite der Wert für **slots** nicht der
String ``'[links, rechts]'`` erscheint, sondern das Array
``array('links', 'rechts')``. Neben Arrays sind auch Hashes (assoziative
Arrays), boolesche Werte und Zahlen möglich.

Sollte ein Wert nicht als YAML geparsed werden können, wird er einfach als
normaler String angesehen.

Besondere Metainformationen
^^^^^^^^^^^^^^^^^^^^^^^^^^^

SallyCMS wird einige der Werte als besonders betrachten (und diese zum Teil auch
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

Der interne Name muss jeweils eindeutig sein (d.h. es kann durchaus ein Template
**foo** und ein Modul **foo** geben).

Develop-Dateien, die diese Anforderung nicht erfüllen, führen zur Ausgabe einer
PHP-Warning im Backend. Womit wir bei der Frage werden, wann Änderungen an den
Dateien erkannt werden.

Refresh
-------

SallyCMS wird bei jedem Request auf das **Backend** die Verzeichnisse in
:file:`develop/` durchsuchen und geänderte Dateien (geändert = aktueller
Timestamp als im Cache) neu einlesen. Der Aufwand, den Zeitpunkt der letzten
Änderung einer Datei zu ermitteln, ist verschwindend gering und wird die
Performance nicht stören.

Während der Entwicklung ist es hilfreich, auf der Systemseite den
**Entwicklermodus** einzuschalten. Dies wird dazu führen, dass Templates und
Module auch im Frontend erkannt und synchronisiert werden.

Wenn ein Template oder Modul hinzugefügt wird, muss die Seite zumindest
kurzzeitig in den **Entwicklermodus** geschaltet werden, damit die neuen Dateien
erkannt und hinzugefügt werden.

Mögliche Probleme
^^^^^^^^^^^^^^^^^

Ein Beispiel soll diesen Punkt erklären: Man lege ein Template mit drei Spalten
(slots) an: links, mitte, rechts. Dieses Template wird nun im Backend Artikeln
zugewiesen und der Redakteur (oder die QA) pflegt schon einmal Blindtexte ein.
Wenn nun im Template die Liste der Spalten reduziert wird, sind die entfernten
Spalten im Backend nicht mehr zugänglich.

SallyCMS wird dabei allerdings bestehende Slices in "unbekannten" Spalten nicht
aus der Datenbank entfernen. Wenn die Liste der Spalten im Template wieder
korrigiert wird, sind die Daten wieder zugänglich und können im Backend
bearbeitet werden.

In einem späteren Release könnte eine Cleanup-Funktion implementiert werden, die
in der Luft hängende Slices findet und entweder eine existierenden Spalte
zuordnen oder löschen kann. Vorerst sollte nur auf diesen Umstand hingewiesen
sein.
