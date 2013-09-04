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
gibt **Kategorien** und **Artikel**, wobei Kategorien wiederum andere Kategorien
oder Artikel enthalten können. Über die Kategorien wird im Allgemeinen die
*Struktur* (Navigation im Frontend) gepflegt, während die Artikel die
eigentlichen *Inhalte* enthalten. Artikel werden in Kategorien einsortiert, um
eine übersichtliche Website zu gestalten.

Kategorien und Artikel erhalten stets einen **Namen**. Mit der **Position**
(Pos) wird die Reihenfolge angegeben (die Position entspricht auch der
Sortierung, weswegen die Positionsnummer standardmäßig nicht angezeigt wird).

Um sich den Inhalt einer Kategorie anzuzeigen, klickt man auf den Namen der
Kategorie (oder das kleine Icon links davon). Ein Klick auf einen Artikel führt
hingegen zur :doc:`Inhaltsverwaltung <content>`, in der der Artikelinhalt
(Texte, Bilder, ...) gepflegt werden können.

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
den Besucher im Frontend sehen, wenn Sie die Kategorie aufrufen. Durch die
enge Verbindung des Startartikels zu seiner Kategorie haben beide den gleichen
Status (d.h. beim Onlineschalten eines Startartikels wird auch automatisch
seine Kategorie online geschaltet).

Der Startartikel einer Kategorie kann niemals gelöscht werden. Stattdessen muss
die Kategorie selbst gelöscht werden, wobei der Startartikel automatisch
entfernt wird.

.. figure:: /_static/backend-structure-startarticle.png
   :align: center
   :alt: Kategorie mit Startartikel und regulärem Artikel

   In der Kategorie liegen zwei Artikel: Der Startartikel und ein weiterer,
   regulärer Artikel. Zu sehen ist, dass weder der Status geändert noch der
   Startartikel gelöscht werden kann.

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

Elemente bearbeiten
-------------------

Um ein Element zu bearbeiten, klickt man auf den "Ändern"-Link. Dadurch wird
die Tabellenzeile durch ein Formular ersetzt, das ähnlich dem beim Hinzufügen
eines Elements funktioniert.

.. figure:: /_static/backend-structure-edit.png
   :align: center
   :alt: Formular zum Bearbeiten einer Kategorie

   Formular zum Bearbeiten einer Kategorie

Elemente können dann umbenannt und verschoben und über den nebenstehenden Button
gespeichert werden.

.. note::

  Der Name einer Kategorie kann sich vom Namen seines Startartikels
  unterscheiden. Der Name der Kategorie dient im Frontend in der Regel für die
  Bezeichnung des Menüpunkts, während der Name des Startartikels in der
  Titelzeile des Browsers angezeigt wird.

Elemente löschen
----------------

Elemente werden über den roten "Löschen"-Link gelöscht. Dabei erfolgt bei
aktiviertem JavaScript eine kurze Rückfrage, ob die Operation wirklich
durchgeführt werden soll.

.. warning::

  Es gibt keine "Rückgängig"-Funktion für das Löschen. Wird ein Artikel
  gelöscht, sind alle eingepflegten Inhalte unwiederbringlich gelöscht (es sei
  denn, ein Administrator hat vorher ein vollständiges Backup des Projekts
  angefertigt).

Kategorien können nur gelöscht werden, wenn sie keine Artikel (abgesehen vom
Startartikel) mehr enthalten. Der Startartikel selbst kann nicht manuell
gelöscht werden (um ihn zu löschen, muss seine Kategorie gelöscht werden).

Weitere Funktionen
------------------

Artikel können (inklusive ihres Inhalts) kopiert oder verschoben werden; ebenso
können Kategorien verschoben werden. Diese Funktionen sind allerdings nicht in
der Strukturansicht, sondern in der :doc:`Inhaltsverwaltung <content/meta>` zu
finden. Der Zugriff auf diese Funktionen kann durch Benutzerrechte eingeschränkt
werden, sodass ggf. nicht alle Funktionen zur Verfügung stehen.

Versionierung
-------------

Alle Änderungen am Inhalt von Artikeln werden in Sally automatisch versioniert,
d.h. wenn ein Artikel umbenannt wird, so entsteht eine neue Version. Die
Strukturansicht zeigt grundsätzlich von allen Kategorien und Artikeln die
letzte (jüngste) Version an. Innerhalb der :doc:`Inhaltsverwaltung <content/meta>`
kann zwischen den verschiedenen Versionen gewechselt werden.
