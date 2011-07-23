Module
======

Module werden in Sally im Verzeichnis :file:`/develop/modules` verwaltet. Es
handelt sich dabei um einfache PHP-Dateien mit einem Header zur Konfiguration.

Jedes Modul besteht aus bis zu zwei Dateien. Eine definiert die Modul-Eingabe
und somit das Formular, welches im Backend angezeigt wird, die andere definiert
die Modul-Ausgabe und somit den HTML-Code, der zur Ausgabe im Frontend der
Website genutzt wird.

Naming Convention
-----------------

Damit die Modulfiles entsprechend erkannt werden, müssen sie folgender Naming
Convention folgen:

* Modul-Input: Dateiname endet mit :file:`.input.php`
* Modul-Output: Dateiname endet mit :file:`.output.php`

*Beispiel für eine Modul-Eingabe:*

.. literalinclude:: module.input.php
   :language: php

*Beispiel für eine Modul-Ausgabe:*

.. literalinclude:: module.output.php
   :language: php

Es ist ausreichend, Parameter (außer ``name``) nur in einer der Module-Files
zu definieren. Allerdings ist es oft übersichtlicher, wenn man sie in beiden
Files definiert.

Mögliche Parameter
------------------

Folgende Parameter können bei Modulen genutzt werden:

``name``
^^^^^^^^

Eindeutiger Modulbezeichner zur internen Identifizierung. Der ``name`` wird
genutzt, um ein Modul bspw. über die API zu identifizieren. Sobald ein Modul
in Benutzung ist, sollte der ``name`` nicht mehr geändert werden, da das Modul
im System über diesen Namen referenziert wird.

``title`` (optional)
^^^^^^^^^^^^^^^^^^^^

Titel des Moduls zur Anzeige im Backend. (Default ist der Modulname)

``actions`` (optional)
^^^^^^^^^^^^^^^^^^^^^^

Liste mit Actions, die im Rahmen dieses Templates ausgeführt werden sollen.

``templates`` (optional)
^^^^^^^^^^^^^^^^^^^^^^^^

Über eine Liste können die Templates angegeben werden, in denen dieses Modul
angezeigt werden darf.

*Beispiel:* In Diesem Beispiel ist eine einfache Liste mit Templates definiert.

::

  * @sly  templates  [homepage, landing]

In den Modulen ist es zur Zeit nicht möglich die Anzeige auf einzelne Slots
einzuschränken. Für diese Einschränkung steht die leistungsfähige
Konfigurationsoption ``modules`` in der :doc:`Template <templates>`\ definition
zur Verfügung.

Conditions
----------

.. literalinclude:: condition.module.php
   :language: php
   :lines: 1-8

Die Condition *mobile* kann wie folgt ausgewertet werden:

.. literalinclude:: condition.module.php
   :language: php
   :lines: 10-
