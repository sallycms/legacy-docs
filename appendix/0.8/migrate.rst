Migrationsleitfaden
===================

Die folgende Anleitung beschreibt, wie man ein bestehendes 0.7-Projekt auf 0.8
aktualisieren kann.

.. note::

  Nicht beschrieben sind die API-Änderungen, die zu Anpassungen an Modulen,
  Templates und AddOns führen. Stattdessen soll hier der grundlegende Ablauf
  beschrieben werden.

Sally aktualisieren
-------------------

Das zu migrierende Projekt (Sally 0.7) sollte lokal installiert und lauffähig
sein. Die Datenbank sollte ebenfalls aktuell sein (ggf. also einen normalen
Dump aus dem Backend der Live-Installation einspielen).

.. warning::

  **Dieser** Dump sollte keinesfalls mit dem Import/Export-AddOn angelegt
  werden, sondern mit einem Tool wie Adminer oder phpMyAdmin. Dies stellt
  sicher, dass auch Benutzerkonten korrekt exportiert werden.

.. note::

  0.7-Dumps, die mit dem Import/Export-AddOn erstellt wurden, lassen sich wegen
  des Versionsstempels nicht in 0.8 einspielen!

Projekt-Repository
~~~~~~~~~~~~~~~~~~

Die Migration von 0.7 auf 0.8 erfordert - ein letztes Mal - ein Neuanlegen des
Projekt(-Repositories). Da die Entwicklung von 0.8 nicht mehr im alten Trunk
stattfand, ist es nicht möglich, einen bestehenden 0.7-Klon durch einen Pull
auf 0.8 zu aktualisieren.

Das neue Projekt-Repository kann entweder ein Klon des neuen SallyCMS-Repositories
oder ein frisches Repository auf Basis des regulären Downloads sein.

.. note::

  Die Verwendung eines neuen Repositories wird empfohlen, da dabei keine
  unnötigen Dateien und History verbleiben. Spätere Updates erfolgen nicht durch
  Pulls vom Sally-Repository, sondern durch Composer.

Projekt einrichten
~~~~~~~~~~~~~~~~~~

Das neue Projekt sollte nach einem ``composer install`` regulär über das Setup
(entweder im Browser oder über die `Sally Console <https://bitbucket.org/SallyCMS/sallycms-console>`_,
die allerdings erst manuell dem Projekt hinzugefügt werden muss) installiert
werden. Im Anschluss werden die Abhängigkeiten des alten Projekts aus der
:file:`composer.json` übernommen und über ``composer update`` installiert.

.. note::

  Bei dieser Gelegenheit sollte unbedingt noch einmal überprüft werden, ob keine
  zu allgemeinen Constraints für Pakete verwendet werden. Constraints sollten
  immer mindestens auf eine konkrete Major-Version festgelegt werden, wie zum
  Beispiel ``3.*`` oder ``~3.4`` für stabile Releases oder ``3.*@dev`` für den
  jeweils letzten Entwicklungsstand.

  Am einfachsten ist es, wenn man sich nach dem Übertragen der Requirements
  im Backend in der Credits-Liste überprüft wird, welche Versionen installiert
  werden. Anhand dieser Informationen können dann die Constraints eingeschränkt
  werden.

Die AddOns können jetzt im neuen Projekt installiert werden. Im Anschluss
sollten der Entwicklermodus aktiviert, das Caching auf **Memory** gesetzt und
die AddOns deaktiviert werden.

Im Anschluss werden die Develop-Inhalte (alles, was in :file:`develop/` liegt)
aus dem Referenz-Projekt in das neue Projekt übernommen. Besonders wichtig sind
dabei die Konfigurationsdateien für AddOns, die anhand dieser Konfiguration
Daten in der Datenbank verwalten. Fehlen diese, werden im Anschluss an die
Migration Daten verlorengehen, da sie als "überschüssig" betrachtet und von den
AddOns gelöscht werden.

Nun muss mit der Datenbank-Migration fortgefahren werden.

Datenbank
---------

Die Datenbank hat sich nur minimal geändert. Die Spalte ``rights`` in
``sly_user`` wurde in ``attributes`` umbenannt und enthält nun ein
JSON-kodiertes Array mit den Angaben ``isAdmin``, ``startpage`` etc.

Die Änderung des Spalten-Typs kann statisch über die unten genannte Query
erfolgen. Das Re-Kodieren der Informationen in dieser Spalte ist, wenngleich
mit SQL sicherlich möglich, idealerweise über ein wenig (PHP-)Code zu erledigen.
Dazu eignet sich das `Migrationsscript`_ hervorragend, da es den nötigen Code
bereits enthält.

Es ist jetzt an der Zeit, den Datenbank-Dump des Referenz-Projekts in die
Datenbank des neuen Projekts zu importieren. Alle bestehenden Tabellen müssen
dabei überschrieben (und damit auf den Stand von Version 0.7 gebracht) werden.

Als nächstes werden das Schema und die Daten aktualisiert.

Schema-Updates
~~~~~~~~~~~~~~

.. note::

  Die hier genannten Queries sind im `Migrationsscript`_ bereits enthalten und
  müssen, wenn es verwendet wird, **nicht manuell ausgeführt werden**.

.. sourcecode:: mysql

  ALTER TABLE `sly_user` CHANGE COLUMN `rights` `attributes` TEXT NULL;

Migrationsscript
~~~~~~~~~~~~~~~~

Die Migration der Datenbank kann vollautomatisch vom `Migration Tool <https://bitbucket.org/SallyCMS/migration>`_
für Sally erledigt werden. Dabei handelt es sich um ein eigenständiges
Kommandozeilen-Werkzeug zur Migration von Datenbanken von Sally 0.1 bis 0.8.

Zur Verwendung gibt es im `Repository <https://bitbucket.org/SallyCMS/migration>`_
des Tools eine entsprechende Anleitung, die die Installation und Konfiguration
erklärt. Für die Migration zwischen 0.7 und 0.8 sind keine weiteren Angaben
außer den Datenbank-Zugangsdaten nötig. Die ungenutzten Angaben können also auf
Wunsch aus der Konfigurationsdatei des Tools entfernt werden.

Final Touches
-------------

Nachdem die Datenbank aktualisiert wurde, kann wieder das Backend des neuen
Projekts aufgerufen werden. Die AddOns können nun wieder aktiviert und dann
der Cache geleert werden. In der Strukturansicht sollten bereits die
eingepflegten Inhalte aus dem Referenz-Projekt zu sehen sein.

.. note::

  In Projekten kommt es häufig vor, dass während der Entwicklung bestimmte
  Dinge eingebaut werden, die sich darauf verlassen, dass alle AddOns vorhanden
  sind (zum Beispiel Event-Listener über ``LISTENERS``, die AddOn-APIs
  verwenden, ohne zu prüfen, ob das AddOn auch aktiv ist). Es kann also
  passieren, dass vor und beim Aktivieren der AddOns Warnungen über ungültige
  Listener oder sogar Fatal Errors auftreten.

  Hier ist es dann angebracht, die betroffenen Stellen erst einmal lahmzulegen,
  auszukommentieren oder zu verschieben, bis die AddOns wieder arbeiten.

  Diese temporären Fixes sind nicht zu verwechseln mit den Änderungen, die wegen
  geänderter 0.8-API notwendig sind. Hier hilft ein zeitweises Abschalten
  natürlich wenig.

Nun kann damit begonnen werden, die Developinhalte an die neuen APIs von Sally
und ggf. AddOns anzupassen.

.. note::

  Es kann sich lohnen, direkt nach dem Update (und noch vor der Anpassung des
  Frontend-Codes) erst einmal einen Dump im Backend anzulegen, damit man einen
  sauberen Stand hat, zudem man zurückkehren kann.
