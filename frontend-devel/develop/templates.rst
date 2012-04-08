Templates
=========

Templates werden in Sally im Verzeichnis :file:`/develop/templates` verwaltet.
Es handelt sich dabei um einfache PHP-Dateien mit einem Header zur
Konfiguration.

*Beispiel:*

.. literalinclude:: template.sample.php
   :language: php

Dateinamen
----------

Jede Datei, die als Template erkannt und im Backend verfügbar sein soll, muss
auf ``.php`` enden (zum Beispiel :file:`startseite.php`). Sie sollten sich
regulär über einen PHP ``include`` einbinden lassen.

Mögliche Parameter
------------------

Folgende Parameter können bei Templates genutzt werden:

``name``
^^^^^^^^

Eindeutiger Templatebezeichner zur internen Identifizierung. Der ``name`` wird
genutzt, um ein Template bspw. über die API zu identifizieren. Sobald ein
Template in Benutzung ist, sollte der ``name`` nicht mehr geändert werden, da
das Template im System über diesen Namen referenziert wird.

``title`` (optional)
^^^^^^^^^^^^^^^^^^^^

Titel des Templates zur Anzeige im Backend. Seit Sally 0.4 ist dieser Wert nicht
mehr von direkter Bedeutung, da der Systemkern und die Backend-App an keiner
Stelle den Namen von Templates anzeigen. Die API unterstützt diesen Parameter
allerdings weiterhin direkt (über eine ``->getTitle()``-Methode), da Templates
von Modulen oder AddOns im Backend angezeigt werden könnten.

.. note::

  ``getTitle()`` könnte in einem späteren Release entfernt werden.

``slots`` (optional)
^^^^^^^^^^^^^^^^^^^^

Array mit Bereichen, in die das Template Inhalte einfügen kann. Slots ist ein
assoziatives Array und es gibt zwei Optionen es zu definieren.

* Einfache Liste von Titeln: ``[Hauptbereich, Seitenleiste]`` - Die Titel werden
  im Backend angezeigt und der Zugriff auf die Slots erfolgt über ihre
  impliziten numerischen IDs (``0``, ``1``, ``2``, ...).
* Benannte Slots: ``{main: Hauptbereich, sidebar: Seitenleiste}`` - Die Titel
  werden ebenfalls im Backend angezeigt. Der Zugriff auf die Slots erfolgt über
  die Bezeichner (*name*, *sidebar*, ...). Wir empfehlen diese Variante, da sie
  den Code lesbarer macht.

.. warning::

  Die einfache Slotdefinition kann zu Konflikten bei der Einschränkung der
  Module führen (siehe folgenden Abschnitt ``modules``). Die Verwendung
  benannter Slots wird daher empfohlen.

Der Parameter ist optional. Werden keine Slots angegeben, erhält das Template
einen Slot mit dem Namen 'default'. Hat ein Template nur einen Slot, wird er im
Backend nicht angezeigt.

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

``modules`` (optional)
^^^^^^^^^^^^^^^^^^^^^^

.. note::

  Seit Version 0.6 werden die erlaubten Module nicht mehr im Template, sondern
  direkt am :doc:`Artikeltyp <articletypes>` definiert.

``class`` (optional)
^^^^^^^^^^^^^^^^^^^^

Mit diesem Parameter können Templates klassifiziert werden, um sie später per
API gefiltert abzurufen. Zum Filtern dient
``sly_Service_Template::getTemplates($class)``.

Conditions
----------

Das Template, das beim Anzeigen eines Artikels zum Einsatz kommt, kann dynamisch
festgelegt werden. So kann beispielsweise zur Anzeige auf Mobilgeräten
automatisch ein anderes Template als für die Desktopversion verwendet werden.

Um diese Technik anzuwenden, müssen sog. **Conditions** in Template verwendet
werden. Eine Condition ist per se erstmal nichts weiter als ein normaler
Parameter im Dateikopf, ebenso wie ``slots`` oder ``name``. Der Parameter wird
nur dadurch zu einer Condition, dass jemand für ihn einen Evaluator registriert
hat.

Die Templates, zwischen denen anhand einer Condition unterschieden werden soll,
müssen den gleichen internen Namen verwenden (ohne Conditions wäre dies nicht
erlaubt).

Beispiel
^^^^^^^^

Zu Demo-Zwecken wollen wir ein anderes Template für Mobilseiten verwenden. Dazu
legen wir zwei Templates an, :file:`desktop.php` und :file:`mobile.php`. Beide
Templates verwenden den internen Namen ``default`` (dieser Wert wird dann auch
beim Artikeltyp als Template angegeben).

.. literalinclude:: condition.template.php
   :language: php
   :lines: 1-9

.. literalinclude:: condition.template.php
   :language: php
   :lines: 10-17

Die Condition **mobile** kann wie folgt ausgewertet werden:

.. literalinclude:: condition.template.php
   :language: php
   :lines: 19-39

Dieser Evaluator muss nun noch beim Sally-Core registriert werden, damit er
aufgerufen wird, wenn Sally das Template eines Artikels im Frontend benötigt.
Dazu genügt ein einzelner Aufruf zum Template-Service, dem der Name der
Condition und der Callback übergeben wird.

.. literalinclude:: condition.template.php
   :language: php
   :lines: 41-

Das Registrieren des Evaluators muss erfolgen, **bevor** Artikel angezeigt
werden sollen. Im Template oder in Modulen ist es also bereits zu spät. AddOns
können Evaluatoren direkt in ihrer :file:`config.inc.php` registrieren,
Frontends können einen Listener auf ``ADDONS_INCLUDED`` registrieren und im
Callback die Registrierung durchführen.
