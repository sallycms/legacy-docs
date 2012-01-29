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

Modul-Eingabe
-------------

Der Eingabe-Teil eines Moduls ist dafür zuständig, ein Formular zum Eingeben des
jeweiligen Inhalts (was auch immer das Modul verwalten soll) anzuzeigen. Dieses
Formular kann über ``sly_Form`` zusammengesetzt oder auch in reinem HTML
geschrieben werden (ebenso wie die Modul-Ausgabe reines HTML sein kann). Die
Eingabe wird immer im Backend dargestellt, eine Unterscheidung auf Frontend /
Backend ist daher nicht nötig.

Zu beachten ist, dass nur diejenigen Formularfelder, die ``slicevalue[XXX]``
heißen, in dem Slice abgespeichert werden. Wird das vorgegebene ``$form``-Objekt
verwendet, werden Formularelemente automatisch umbenannt.

Die gespeicherten Werte können über den ``$values``-Helper abgerufen werden.

HTML-only
^^^^^^^^^

.. literalinclude:: module.html.input.php
   :language: php

sly_Form
^^^^^^^^

.. literalinclude:: module.form.input.php
   :language: php

Modul-Ausgabe
-------------

Die Modul-Ausgabe zeigt die eingegebenen Werte in dem gewünschten Markup an. Die
Anzeige findet sowohl im Backend als auch im Frontend statt, sodass die meisten
Module zwischen den beiden Umgebungen unterscheiden und beispielsweise im
Backend statt des vollständigen Inhalts nur einen Auszug an.

Die Modul-Ausgabe kann frei implementiert werden. Es gibt keine Vorgaben, wie
das Markup erzeugt werden sollte. Der ``$values``-Helper steht hier ebenfalls
zur Verfügung.

.. warning::

  Module sollten so fehlertolerant wie möglich sein, um bei Eingabefehlern
  keinesfalls Exceptions zu werfen oder andere Fehler zu produzieren.
  Es ist allgemein besser, im Frontend gar nichts (oder falls jemand eingeloggt
  ist, eine Hinweismeldung) anzuzeigen, anstatt blind auf unfehlbare Benutzer zu
  vertrauen.

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
