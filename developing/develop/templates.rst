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

Hierüber können die zulässigen Module für dieses Template definiert werden.
Dabei ist es möglich die Module auch auf einzelne Slots eines Templates
festzulegen. Folgende Bepiele sollen die Nutzung verdeutlichen.

Beispiel 1 - Einfache Modulliste
""""""""""""""""""""""""""""""""

In Diesem Beispiel ist eine einfache Liste mit Modulen definiert.

::

  * @sly modules [wymeditor, gallery]

Beispiel 2 - Komplexe Modulliste
""""""""""""""""""""""""""""""""

In diesem Beispiel stehen die Module ``wymeditor`` und ``image`` für alle Slots
zur Verfügung. Für den Slot ``main`` steht außerdem das Modul ``gallery`` zur
Verfügung und für den Slot ``sidebar`` die Module ``teaserbox`` und
``quickcontact``.

::

  * @sly modules { _ALL_: [wymeditor, image], main: gallery, sidebar: [teaserbox, quickcontact] }

.. warning::

  Sollte ein Slot des Templates zufällig ``_ALL_`` heißen, müssen Module, die
  für alle Slots zur Verfügung stehen sollen auch für alle Slots eingetragen
  werden. ``_ALL_`` wird dann wie ein normaler Slot behandelt.

.. warning::

  Es kann bei der Definition der Modulliste zu einem Konflikt kommen, wenn die
  komplexe Modulliste (z.B. auf Grund der Slotdefinitionen) in der Form
  ``@sly modules {0: wymeditor, 1: gallery, 2: teaserbox}`` definiert wird. Sie
  wird dann wie die einfache Modulliste interpretiert:
  ``[wymeditor, gallery, teaserbox]``

.. hint::

  Spätestens bei dieser Benutzung ist es ausgesprochen hilfreich, benannte Slots
  zu benutzen, da man sonst leicht durcheinander kommt.

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
