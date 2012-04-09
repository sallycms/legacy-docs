Module
======

Module werden in Sally im Verzeichnis :file:`/develop/modules` verwaltet. Es
handelt sich dabei um einfache PHP-Dateien mit einem Header zur Konfiguration.

Module werden vom Redakteur in Artikel eingefügt. Sie können grundsätzlich
beliebig oft in Artikel eingefügt und beliebig sortiert werden. Innerhalb der
Module werden die eigentlichen Inhalte der Website verwaltet, sodass sie in den
meisten Fällen projektspezifisch erstellt werden, um die redaktionelle Arbeit
möglichst optimal zu unterstützen.

Wird ein Modul mit Werten befüllt und im Backend abgespeichert, entsteht ein
sog. "Slice". Dieses Slice kann jederzeit wieder bearbeitet, verschoben oder
gelöscht werden.

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

Titel des Moduls zur Anzeige im Backend. Titel sollten **immer** angegeben
werden und können mittels ``translate:...`` übersetzt werden.

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

Module können ebenso wie Templates zur Anzeigezeit dynamisch ausgewählt werden.
Der Vorgang gestaltet sich identisch wie bei
:doc:`Template-Conditions <templates>` (nur dass der Evaluator natürlich beim
Modul-Service registriert werden muss).


Modul-Eingabe
-------------

Der Eingabe-Teil eines Moduls ist dafür zuständig, ein Formular zum Eingeben des
jeweiligen Inhalts (was auch immer das Modul verwalten soll) anzuzeigen. Dieses
Formular kann (und sollte) über ``sly_Form`` zusammengesetzt oder auch in reinem
HTML geschrieben werden (ebenso wie die Modul-Ausgabe reines HTML sein kann).
Die Eingabe wird immer nur im Backend dargestellt, eine Unterscheidung auf
Frontend / Backend ist daher nicht nötig.

Jeder Modul-Eingabe steht dazu ein sog. :doc:`Formular-Helper <slicehelper>` zur
Verfügung. Dabei handelt es sich um eine Instanz von ``sly_Slice_Form``, die mit
den gewünschten Formularelementen befüllt werden kann. Die Instanz ist über
``$form`` zu erreichen.

Sally wird alle Formularfelder, die ``slicevalue[....]`` heißen, in der
Datenbank im Slice abspeichern und beim Wiederanzeigen des Formulars
wiederherstellen. Es können auch Arrays übertragen werden, da die Daten immer
JSON-kodiert in die Datenbank geschrieben werden.

Die Namenskonvention mit ``slicevalue`` ist nur relevant, wenn das Formular von
Hand (in HTML) geschrieben wird. Wird der Formular-Helper (das vorgegebene
``$form``-Objekt) verwendet, findet die Umbenennung automatisch im Hintergrund
statt.

Die gespeicherten Werte können über den ``$values``-Helper abgerufen werden.
Beim Hinzufügen eines Slices ist das ``$values``-Objekt leer (ergo wird für
jeden Wert ``null`` zurückgegeben).

HTML-only
^^^^^^^^^

.. literalinclude:: module.html.input.php
   :language: php

sly_Form
^^^^^^^^

.. literalinclude:: module.form.input.php
   :language: php

Der Formular-Helper stellt eine ganze Reihe von zusätzlichen API-Methoden
bereit, um Module schnell und einfach erstellen zu können.

Modul-Ausgabe
-------------

Die Modul-Ausgabe (``mymodule.output.php``) zeigt die eingegebenen Werte in dem
gewünschten Markup an. Die Anzeige findet sowohl im Backend als auch im Frontend
statt, sodass die meisten Module zwischen den beiden Umgebungen unterscheiden
und beispielsweise im Backend statt des vollständigen Inhalts nur einen Auszug
an.

Die Modul-Ausgabe kann frei implementiert werden. Es gibt keine Vorgaben, wie
das Markup erzeugt werden sollte. Der ``$values``-Helper steht hier ebenfalls
zur Verfügung.

.. warning::

  Module sollten so fehlertolerant wie möglich sein, um bei Eingabefehlern
  keinesfalls Exceptions zu werfen oder andere Fehler zu produzieren.
  Es ist allgemein besser, im Frontend gar nichts (oder falls jemand eingeloggt
  ist, eine Hinweismeldung) anzuzeigen, anstatt blind auf unfehlbare Benutzer zu
  vertrauen.
