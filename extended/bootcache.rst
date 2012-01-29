BootCache
=========

SallyCMS enthält einen Mechanismus um häufig benötigte Klassen und Funktionen zu
cachen. Dabei wird eine Sammeldatei erstellt, die alle Klassen enthält, die für
Requests immer benötigt werden (``sly_Core``, ``sly_Loader``, ...). Damit muss
PHP nicht immer wieder einzelne Dateien parsen, wenn ein Request stattfindet.

.. note::

  Der Cache wirkt sich umso mehr aus, wenn das System keinen Opcode-Cache
  besitzt oder eine generell geringe I/O-Leistung aufweist.

Funktionsweise
--------------

Der Cache ist in der Klasse ``sly_Util_BootCache`` implementiert. Diese legt
beim Leeren des Caches im Backend (auf der Systemseite) zwei Cache-Dateien an:
eine für das Frontend und eine für das Backend.

Die Core-Klassen, die im Cache enthalten sind, sind in der Datei
:file:`sally/core/config/bootcache.yml` konfiguriert.

.. note::

  Der Cache wird nur erzeugt, wenn sich Sally im *Produktivmodus* befindet. Im
  Entwicklermodus wird eine ggf. vorhandene Cache-Datei *gelöscht*. Wenn ein
  Projekt deployed wird, muss also nach dem Aktivieren des Produktivmodus noch
  einmalig der Cache geleert werden, um den BootCache zu erzeugen.

Die erzeugten Dateien liegen in :file:`sally/data/dyn/internal/sally` und können
gefahrlos gelöscht werden. Dies ist beispielsweise nötig, wenn eine fehlerhafte
Datei erzeugt wurde und Sally gar nicht mehr startet.

AddOn-Schnittstelle
-------------------

AddOns können dafür sorgen, dass ihre Klassen auch im Cache abgelegt werden.
Dazu wird der BootCache pro Umgebung (1x für das Backend und 1x für das
Frontend) ein Event feuern, das Listeners dazu auffordert, über die unten
gezeigte API-Methode ihre Klassen zum Cache hinzuzufügen.

.. sourcecode:: php

  <?
  function myCacheWarmer(array $params) {
    sly_Util_BootCache::addClass('Myaddon_Class1');
    sly_Util_BootCache::addClass('Myaddon_Class2');
    sly_Util_BootCache::addClass('AnotherImportantClass');
  }

  sly_Core::dispatcher()->register('SLY_BOOTCACHE_CLASSES_FRONTEND', 'myCacheWarmer');
  sly_Core::dispatcher()->register('SLY_BOOTCACHE_CLASSES_BACKEND', 'myCacheWarmer');

Dabei müssen einige Punkte beachtet werden:

* Es sollten nur diejenigen Dateien im Cache liegen, die wirklich immer oder
  sehr häufig benötigt werden. Keinesfalls sollte ein AddOn blind sämtliche
  Klassen zum Cache hinzufügen.
* Die über ``::addClass()`` angegebenen Dateien müssen vom Autoloader geladen
  werden können, wenn der Cache erzeugt werden.
* Der Cache kann im Moment noch nicht mit PHP-Namespaces umgehen. Klassen dürfen
  also in keinem speziellen Namespace liegen.
* Alle Abhängigkeiten müssen erfüllt sein. Leitet sich eine Klasse ``A`` von
  einer Klasse ``B`` ab, so müssen **beide** im Cache enthalten sein, wenn ``A``
  im Cache liegen soll. Die Reihenfolge ist dabei irrelevant.
* Klassendateien müssen mit einem PHP-Marker (``<?php``) beginnen (ohne
  Whitespace davor) und **ohne** PHP-Marker enden (kein ``?>``). Whitespace am
  Ende der Datei wird automatisch entfernt.
* Klassen, die einen speziellen Initialisierungscode erfordern (im Moment
  betrifft dies nur ``sly_Log``, dessen Ziel-Verzeichnis nach dem Laden
  einmalig gesetzt werden muss), sollten nicht im Cache liegen.

.. note::

  Der Cache wird beim Deaktivieren/Deinstallieren von AddOns **nicht**
  automatisch neu generiert. Wird in einem Produktivsystem also ein AddOn
  entfernt, sollte der Cache neu generiert werden, damit nicht weiterhin
  ungenutzte AddOn-Klassen geladen werden.
