Develop-System
==============

In SallyCMS Version 0.3 haben wir eine Kernfunktion von REDAXO geändert:
Templates und Module liegen nicht mehr in der Datenbank, sondern werden aus
regulären PHP-Dateien ausgelesen.

.. toctree::
   :hidden:

   articletypes
   templates
   layouts
   modules
   slicehelper

Unterseiten
-----------

* :doc:`Artikeltypen <articletypes>`
* :doc:`Templates <templates>` & :doc:`Layouts <layouts>`
* :doc:`Module <modules>` & :doc:`Slice-Helper <slicehelper>`

Einführung
----------

Templates und Module enthielten schon immer nicht mehr als normale PHP-Dateien:
HTML-Code gemischt mit PHP-Tags. Der Umweg über die Datenbank bringt außer der
Möglichkeit, das "Frontend" einer Website in einem SQL-Export zu sichern, keine
ersichtlichen Vorteile. Im Gegenteil: Er verleitet dazu, unnötig viele Daten aus
der Datenbank abzurufen, diese auch noch mit ``eval()`` auszuführen und umgeht
so zielsicher einen möglichen `Opcode-Cache
<http://de.wikipedia.org/wiki/Alternative_PHP_Cache>`_.

Die Gründe für eine Speicherung in normalen Dateien sind eindeutig:

* Der Opcode-Cache kann verwendet werden.
* Weniger Daten müssen zu jedem Slice / Artikel in der Datenbank gehalten
  werden.
* Templates und Module können einfacher in `Versionskontrollsystemen
  <http://de.wikipedia.org/wiki/Mercurial>`_ verwaltet werden.
* Das Deployment von Projekten ist einfacher; nachträgliche Updates erfordern
  keinen Datenbank-Import.

Aufbau
------

Schauen wir uns einmal an, wie Templates und Module organisiert werden müssen,
um von SallyCMS als solche erkannt zu werden.

Verzeichnisstruktur
^^^^^^^^^^^^^^^^^^^

Alle Dateien, die serverseitig für das Frontend relevant sind (das schließt
:doc:`Assets </developing/assets>` wie CSS/JS/Images aus), werden in
:file:`develop/` gespeichert. Das Verzeichnis liegt direkt im Root einer
Website.::

  /
  +- assets/
  +- data/
  +- develop/
     +- config/
     +- modules/
     +- templates/

Wie auf dem Schema zu erkennen ist, werden Templates und Module noch einmal in
gesonderten Verzeichnissen angelegt.

Tipp
""""

Natürlich muss man sich bei der Entwicklung komplexer Projekte nicht auf diese
beiden Verzeichnisse beschränken. So kann es durchaus ratsam sein, auch noch ein
:file:`develop/lib`-Verzeichnis anzulegen, wenn im Frontend projektspezifische
Klassen benötigt werden. Tatsächlich ist es so, dass das Verzeichnis
:file:`develop/lib` standardmäßig dem :doc:`Autoloader </sallycms/autoloading>`
von Sally bekannt ist, also keine weitere Konfiguration nötig ist, um es zu
nutzen.

Es ist auch problemlos möglich, Klassen mit in Templates/Modulen zu notieren
oder Dateien, die keine Templates/Module sein sollen, in den entsprechenden
Verzeichnissen mit abzulegen. Dazu im folgenden Abschnitt mehr.

Dateinamen: Templates
^^^^^^^^^^^^^^^^^^^^^

Jede Datei, die als Template erkannt und im Backend verfügbar sein soll, muss
auf ``.php`` enden (zum Beispiel :file:`startseite.php`). In den Dateien können
die Templates wie sie auch in REDAXO im Backend gepflegt wurden, eingetragen
werden. Sie sollten sich regulär über einen PHP ``include`` einbinden lassen.

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

.. literalinclude:: template.demo.php
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
:doc:`Templates <templates>` und :doc:`Modulen <modules>` enthalten.

Alle Metainformationen stehen über den entsprechenden
:doc:`Service </sallycms/services/index>` auf PHP-Seite bereit.

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
