Strukturverwaltung
==================

Die Strukturverwaltung ist der zentrale Teil der Websiteverwaltung; sie stellt
die Übersicht der Inhalte dar und dient deren Verwaltung.

.. figure:: /_static/backend-structure.png
   :align: center
   :width: 1013
   :height: 709
   :scale: 75%
   :alt: Strukturansicht der Sally-Demoseite

   Strukturansicht der Sally-Demoseite

In der Strukturverwaltung wird die Websitenstruktur hierarchisch dargestellt. Es
gibt **Kategorien** und **Artikel**. Jede Kategorie entspricht im Allgemeinen
einem Menüpunkt im Frontend der Website (d.h. die Navigation basiert in den
meisten Fällen allein auf der Kategorie-Struktur). Artikel enthalten dann den
eigentlichen Inhalt und werden in Kategorien einsortiert, um eine übersichtliche
Website zu gestalten.

Kategorien und Artikel erhalten stets einen **Namen**. Mit der **Position**
(Pos) wird die Reihenfolge angegeben (die Position entspricht auch der
Sortierung, weswegen die Positionsnummer standardmäßig nicht angezeigt wird).
Der **Status** zeigt an, ob das Element *online* oder *offline* (unsichtbar)
ist.

.. note::

  Artikel, die offline sind, können trotzdem im Frontend aufgerufen werden,
  wenn ihre URL bekannt ist. Der Offline-Status dient **nicht** dazu, den
  Zugriff auf Artikel zu beschränken, sondern nur ihre Sichtbarkeit zu steuern.
  So können in einer Website Artikel verwaltet werden, die zwar nicht in der
  Navigation im Frontend auftauchen, aber deren URL beispielsweise in
  Newslettern oder Flyern weitergegeben werden kann.

Über die Links auf der rechten Seite der Tabelle können die bestehenden
Elemente umbenannt, verschoben oder gelöscht werden (wobei Kategorien nur
gelöscht werden können, wenn sie keine Artikel mehr enthalten). Über das Icon
links oben in der Kategorie- bzw. Artikeltabelle (mit dem Plus-Symbol) kann ein
neues Element hinzugefügt werden.

Im oberen Bereich der Strukturansicht ist der sog. **Pfad** zu sehen, über den
ersichtlich ist, an welcher Stelle in der Struktur man sich gerade befindet.

Startartikel
------------

Wenn eine neue Kategorie angelegt wird, wird Sally automatisch einen Artikel,
den sog. **Startartikel** erstellen. Dieser Artikel enthält denjenigen Inhalt,
den Besucher im Frontend sehen, wenn Sie die Kategorie aufrufen.

Der Startartikel einer Kategorie kann niemals gelöscht werden. Stattdessen muss
die Kategorie selbst gelöscht werden, wobei der Startartikel automatisch
entfernt wird.

Auf der obersten Ebene der Website (der "Homepage"-Ebene) gibt es keinen
Startartikel, da man sich dort nicht in einer Kategorie befindet.

Artikeltypen
------------

Neben jedem Artikel steht sein Artikeltyp. Dieser steuert, welche Inhalte dort
eingepflegt werden können und welche Metainformationen zur Verfügung stehen.
Redakteure können den Artikeltyp selbst festlegen, nicht jedoch, welche Module
und Metainformationen für die Typen vorgeschrieben sind (dies ist Aufgabe des
Integrators).

Der Artikeltyp kann innerhalb der Strukturansicht nicht geändert werden,
stattdessen muss dazu die :doc:`Inhaltsverwaltung <content>` des jeweiligen
Artikels aufgerufen werden.

Elemente hinzufügen
-------------------

In der Kategorie- sowie Artikelliste findet sich in der linken oberen Ecke ein
Symbol zum Hinzufügen eines neuen Elements. Nach einem Klick erscheint eine neue
Zeile in der Tabelle, in der der Name sowie die gewünschte Position angegeben
werden kann.

.. figure:: /_static/backend-structure-addcat.png
   :align: center
   :alt: Formular zum Hinzufügen einer Kategorie

   Formular zum Hinzufügen einer Kategorie

Beachten Sie, dass Sie einen Namen angeben müssen. Die Position steht
standardmäßig auf dem höchsten Wert plus Eins, sodass die neue Kategorie bzw.
der neue Artikel *am Ende* der bisherigen Liste einsortiert wird. Natürlich kann
auch eine beliebige Position innerhalb der Liste angegeben werden. Ein Klick auf
den nebenstehenden Button legt das Element an.

.. figure:: /_static/backend-structure-addcat-success.png
   :align: center
   :alt: Kategorieliste nachdem die Kategorie hinzugefügt wurde

   Kategorieliste nachdem die Kategorie hinzugefügt wurde

Neue Kategorien und Artikel sind am Anfang auf *offline* gestellt und damit für
Besucher der Website unsichtbar. Dies ermöglicht es, in Ruhe die Inhalte
vollständig einzupflegen, bevor die Seite *online* gestellt wird.
