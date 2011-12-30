Templates
=========

Templates werden in Sally im Verzeichnis :file:`/develop/templates` verwaltet.
Es handelt sich dabei um einfache PHP-Dateien mit einem Header zur
Konfiguration.

*Beispiel:*

.. literalinclude:: template.sample.php
   :language: php

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

Titel des Templates zur Anzeige im Backend. (Nur nötig bei Templates, die im
Backend gelistet werden.) (Default ist der Templatename)

``active`` (optional)
^^^^^^^^^^^^^^^^^^^^^

``true`` oder ``false``. ``true``, wenn das Template im Backend zur Auswahl
stehen soll. ``false``, wenn es nur intern über die API genutzt wird. Default
ist ``false``.

*Hinweis:* Ab Sally 0.4 ist dieser Wert bedeutungslos, da im Backend keine
Templates mehr zur Auswahl stehen. Er kann jedoch weiterhin über die API
abgerufen werden.

``slots`` (optional)
^^^^^^^^^^^^^^^^^^^^

Array mit Bereichen, in die das Template Inhalte einfügen kann (Im
REDAXO-Jargon: ctypes). Slots ist ein assoziatives Array und es gibt zwei
Optionen es zu definieren.

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

``modules`` (optional)
^^^^^^^^^^^^^^^^^^^^^^

.. note::

  Seit Version 0.6 werden die erlaubten Module nicht mehr im Template, sondern
  direkt am Artikeltyp definiert.

``class`` (optional)
^^^^^^^^^^^^^^^^^^^^

Mit diesem Parameter können Templates klassifiziert werden, um sie später per
API gefiltert abzurufen. Zum Filtern dient
``sly_Service_Template::getTemplates($class)``.

Conditions
----------

.. literalinclude:: condition.template.php
   :language: php
   :lines: 1-9

Die Condition *mobile* kann wie folgt ausgewertet werden:

.. literalinclude:: condition.template.php
   :language: php
   :lines: 11-
