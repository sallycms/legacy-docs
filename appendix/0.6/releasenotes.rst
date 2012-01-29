Release-Notes
=============

Eine Übersicht über die neuen Features und Verbesserungen gibt der `News-Beitrag
im Sally-Wiki <https://projects.webvariants.de/news/48>`_.

.. note::

  Aufgrund der geänderten :doc:`Verzeichnisstruktur <birdseye>` empfehlen wir,
  bestehende 0.5-Projekte neu anzulegen, anstatt in alten Projekten zu
  versuchen, die Strukturänderungen nachzuahmen. Dies betrifft natürlich nicht
  die Inhalte des Projekts.

Der grobe :doc:`Ablauf eines Updates auf 0.6 <migrate>` wird auf einer extra
Seite beschrieben.

API-Änderungen
--------------

Im Folgenden werden soweit möglich alle API-Änderungen zwischen dem 0.5- und dem
0.6-Branch beschrieben.

Konfiguration
"""""""""""""

* ``RELOGINDELAY``, ``BLOCKED_EXTENSIONS`` und ``START_PAGE`` wurden in
  statische Konfiguration des Backends überführt (sind aber weiterhin auf die
  gleiche Weise abrufbar).
* ``MEDIAPOOL/BLOCKED_EXTENSIONS`` wurde in statische Konfiguration des Backends
  überführt und in ``BLOCKED_EXTENSIONS`` umbenannt.
* ``USE_MD5`` wurde entfernt.

Globale Variablen
"""""""""""""""""

.. note::

  TODO

Datei(system)
"""""""""""""

.. note::

  Siehe dazu auch die :doc:`Verzeichnisstruktur </general/birdseye>`.

.. note::

  TODO

Datenbank
"""""""""

.. note::

  TODO

JavaScript
""""""""""

Die in 0.5 eingeführten Erweiterungen wurden noch einmal verfeinert und wie
folgt geändert:

* ``sly.openMediapool(subpage, value, callback)`` nimmt zwei weitere Parameter
  zum Einschränken der Dateitypen und Kategorien entgegen. Beide sind optional.
* ``sly.openLinkmap(subpage, value, callback)`` nimmt zwei weitere Parameter
  zum Einschränken der Artikeltypen und Kategorien entgegen. Beide sind
  optional.
* ``sly.inherit(subClass, baseClass)`` ist nun ein öffentlicher Helper, um zwei
  Prototypen zu verketten (also eine Klasse in JavaScript abzuleiten).
* ``sly.initWidgets(context)`` kann dazu verwendet werden, nachträglich via
  DOM-Operationen eingefügte Widgets zu initialisieren.

Globale Funktionen
""""""""""""""""""

.. note::

  TODO

Klassen
"""""""

.. note::

  TODO

Backend
"""""""

* Alle CSS-Klassen, die noch ``rex-`` im Namen hatten, wurde in ``sly-``
  umbenannt. Viele Klassen wurden auch entfernt und durch neue ersetzt.
* Assets müssen aufgrund der geänderten Verzeichnisstruktur nun wieder via
  ``../data/dyn/......`` verlinkt werden.
* Das mitgelieferte jQuery UI-Theme wurde mehr an das Backenddesign angepasst.
* jQuery wurde auf 1.7.1 aktualisiert, jQuery UI auf 1.8.16.
* Es wurden einige Icons aus den Assets entfernt.

Events
""""""

.. note::

  TODO

rex_vars
""""""""

.. note::

  TODO
