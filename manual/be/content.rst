Inhaltsverwaltung
=================

Klickt man in der :doc:`Strukturansicht <structure>` auf den Namen eines
Artikels, so gelangt man zur Inhaltsverwaltung. Hier können mit Hilfe von
Blöcken die Inhalte gepflegt und der *Artikeltyp* gesteuert werden.

.. figure:: /_static/backend-content-slices.png
   :align: center
   :alt: Inhaltsseite mit zwei Blöcken

   Inhaltsseite eines Artikels mit bereits zwei eingepflegten Blöcken

Aufbau
------

Im oberen Bereich der Seite sind die **Slots** (links) und **Unterseiten**
(rechts) zu erreichen. Direkt darunter (im Block "Allgemein") werden der
Artikeltyp (und in vielen Fällen auch noch eine ganze Reihe weiterer sog.
**Metainformationen**) konfiguriert.

Unterhalb des Formulars ist der eigentliche Artikelinhalt zu sehen. Im obigen
Bild kann man zwei sog. **Blöcke** sehen. Vor, nach und zwischen den Blöcken
können jeweils neue Blöcke eingefügt werden. Auf diese Weise "wächst" der
Artikel immer weiter.

Slots
-----

Slots sind "Bereiche" eines Artikels. So könnte ein Website-Design vorgeben,
dass es einen Inhaltsbereich und eine Sidebar gibt. Diese beiden Bereiche würden
in Sally "Slots" genannt werden und können jeweils unabhängig voneinander
Inhalte enthalten.

.. note::

  Die verfügbaren Slots hängen davon ab, welcher Artikeltyp eingestellt wurde.
  Wenn ein Artikel nur einen einzigen Inhaltsbereich hat, wird die Slot-Liste
  nicht angezeigt.

Unterseiten
-----------

Neben der Seite für die Blöcke gibt es noch zwei weitere Menüpunkte, die oben
rechts neben der Slot-Liste angezeigt werden.

**Metadaten/Sonstiges**
  Auf dieser Seite können weitere Einstellungen für den Artikel vorgenommen
  werden. Hier finden sich auch die Funktionen zum Verschieben oder Kopieren
  von Artikeln. Die verfügbaren Funktionen sind auf einer
  :doc:`gesonderten Seite <content/meta>` beschrieben.

**Anzeigen**
  Dieser Link ruft den aktuellen Artikel im Frontend in einem neuen Browser-Tab
  auf. So kann man schnell überprüfen, ob die eingepflegten Inhalte korrekt
  erscheinen.

  .. note::

    Das Anzeigen des Artikels im Frontend funktioniert auch, wenn der Artikel
    *offline* ist.

Blöcke
------

Der Großteil des Inhalts eines Artikels wird üblicherweise über die Blöcke
gepflegt. Blöcke sind einzelne redaktionelle Inhalte, die jeweils einzelne
Inhaltstypen verwalten.

Jeder Block ist von einem speziellen Typ, **Modul** genannt. Das Modul steuert,
welche Inhalte in einem Block eingetragen werden können und wie diese später auf
der Website erscheinen. In den meisten Fällen werden Module projektspezifisch
entwickelt, um die konkreten Anforderungen der Redakteure zu unterstützen.

Blöcke hinzufügen
^^^^^^^^^^^^^^^^^

Um einen neuen Block hinzuzufügen, wählt man an der gewünschten Stelle (am
Anfang, am Ende oder irgendwo in der Mitte) aus dem Auswahlfeld "Block
hinzufügen" das gewünschte Modul aus. Der Browser wird danach das dazugehörige
Formular laden.

.. figure:: /_static/backend-content-moduleselect.png
   :align: center
   :alt: Auswahl eines Moduls, um einen neuen Block anzulegen.

   Auswahl eines Moduls, um einen neuen Block anzulegen.

.. note::

  Je nach Artikeltyp und Slot stehen unterschiedliche Module zur Verfügung,
  damit nur jeweils gültige, passende Inhalte eingepflegt werden können.

Nachdem das Modul ausgewählt wurde und die Seite neu geladen wurde, erscheint
das dazugehörige Formular. Dies ist immer abhängig vom Modul und bietet genau
diejenigen Eingabemöglichkeiten, die benötigt werden. Ein typisches Modul ist
ein :abbr:`WYSIWYG (What You See Is What You Get)`-Editor, der das Einpflegen
von Texten in einer Word-ähnlichen Oberfläche ermöglicht.

.. figure:: /_static/backend-content-texteditor.png
   :align: center
   :alt: WYSIWYG-Editor

   :abbr:`WYSIWYG (What You See Is What You Get)`-Editor-Modul

Nachdem im Modul alle gewünschten Inhalte eingetragen sind, kann der neue Block
über den Button "Block hinzufügen" permanenent gespeichert werden. Im Anschluss
wird Sally wieder die Inhaltsseite anzeigen, die nun um einen Block länger
geworden ist.

Blöcke bearbeiten
^^^^^^^^^^^^^^^^^

Bestehende Blöcke können über den bei jedem Block sichtbaren "Bearbeiten"-Link
jederzeit wieder geöffnet und aktualisiert werden. Dabei erscheint auf die
gleiche Weise wie beim Hinzufügen das jeweilige Formular, das dann abgespeichert
werden muss.

.. note::

  Nicht jeder Benutzer muss immer Zugriff auf alle Module haben. Falls kein
  Zugriff besteht, werden keine "Bearbeiten"/"Löschen"-Links an den Blöcken
  erzeugt und Blöcke können nur noch verschoben werden.

Blöcke löschen
^^^^^^^^^^^^^^

Blöcke können über den "Löschen"-Link gelöscht werden. Dabei erscheint eine
kurze Sicherheitsabfrage, um versehentliches Löschen zu vermeiden.

.. warning::

  Es gibt keine "Rückgängig"-Funktion für das Löschen von Blöcken! Einmal
  gelöschte Blöcke können nicht wiederhergestellt werden.

Blöcke verschieben
^^^^^^^^^^^^^^^^^^

Über die kleinen Pfeile bei jedem Block kann ein Block eine Position nach oben
oder unten verschoben werden. Dies ist immer möglich, selbst wenn keine Rechte
an dem im Block verwendeten Modul bestehen.
