Migrationsleitfaden
===================

Die folgende Anleitung beschreibt, wie man ein bestehendes 0.5-Projekt auf 0.6
aktualisieren kann.

.. note::

  Nicht beschrieben sind die API-Änderungen, die zu Anpassungen an Modulen,
  Templates und AddOns führen. Stattdessen soll hier der grundlegende Ablauf
  beschrieben werden.

Sally aktualisieren
-------------------

Das zu migrierende Projekt (Sally 0.5) sollte lokal installiert und lauffähig
sein. Die Datenbank sollte ebenfalls aktuell sein (ggf. also einen normalen
Dump aus dem Backend der Live-Installation einspielen).

Wenn alles passt, kann mit dem Update von Sally begonnen werden.

#. Schalte im Projekt den Cache auf **Memory** und aktiviere den
   **Entwicklermodus**.

#. Deaktiviere alle AddOns.

#. Das Projekt wird auf 0.6 aktualisiert. Dabei werden alle Dateien der neuen
   Version in das Projekt kopiert. Wer Mercurial benutzt, kann sich jetzt
   zurücklehnen und einfach ``hg pull https://bitbucket.org/SallyCMS/0.6``
   ausführen und dann ``hg merge`` sowie ``hg commit``.

   * Die :file:`.htaccess` im Frontend wird vermutlich kleinere Mergeprobleme
     verursachen, da dort meistens projektspezifische Anpassungen stattfinden.
     Hier sollte einfach die passende Version ausgewählt werden.

#. Als Nächtes verschiebt man :file:`sally/data` nach :file:`data`.
   Mercurial-Benutzer können im Anschluss noch ``hg addremove . -s 100``
   ausführen, um die Renames erkennen zu lassen.

#. Bevor noch das Backend aufgerufen werden, sollte der Asset-Cache gelöscht
   werden. Dazu löscht man das *gesamte* Verzeichnis
   :file:`data/dyn/public/sally/static-cache` -- Das Verzeichnis wird beim
   ersten Backend-Request neu aufgebaut.

#. Die :file:`.htaccess` im Frontend enthält vermutlich noch veraltete Regeln,
   die auf :file:`sally/data/...` zeigen. Hier muss man also auch noch die Pfade
   anpassen.

#. Nun wird das Backend zum ersten Mal wieder aufgerufen. Fehlende Assets werden
   bereinigt, indem auf der Systemseite einmal der Cache geleert wird. Hier
   sollten auch noch einmal die Einstellungen überprüft werden.

#. Nachdem der Core nun aktualisiert ist, können wir die AddOns aktualisieren.
   Mercurial-Benutzer können wieder pullen, alle anderen müssen die AddOns von
   Hand aktualisieren. Die AddOns sollten weiterhin deaktiviert bleiben, die
   Assets können jedoch bereits schon einmal re-initialisiert werden.

Bevor nun auf die veralteten Daten zugegriffen wird, müssen diese migriert
werden. Der folgende Abschnitt erläutert den Prozess näher.

Daten aktualisieren
-------------------

Die lokal bestehende Datenbank des Projekts sollte jetzt mit einem frischen
SQL-Dump von der Live-Seite ersetzt werden. Dieser SQL-Dump wird im Folgenden
als **Master-Dump** bezeichnet.

.. warning::

  **Dieser** Dump sollte keinesfalls mit dem Import/Export-AddOn angelegt
  werden, sondern mit einem Tool wie Adminer oder phpMyAdmin. Dies stellt
  sicher, dass auch Benutzerkonten korrekt exportiert werden.

.. note::

  0.5-Dumps, die mit dem Import/Export-AddOn erstellt wurden, lassen sich wegen
  des Versionsstempels und der geänderten Verzeichnisstruktur nicht in 0.6
  einspielen!

Falls der Master-Dump ein anderes Tabellen-Präfix als das Projekt verwendet,
muss dieses noch im Dump ersetzt werden, bevor man ihn lokal einspielt (siehe
Step-by-Step Anleitung im nächsten Schritt).

Der Master-Dump wird nun in die Projekt-Datenbank eingespielt, deren Tabellen
vorher gelöscht werden sollten (soweit sie im Master-Dump vorhanden sind). Im
Anschluss kann das Migrationssscript ausgeführt werden.

Migrationsscript
^^^^^^^^^^^^^^^^

.. warning::

  Die Migration findet nicht im Browser, sondern auf der Kommandozeile/Shell
  statt!

Das unten verlinkte Migrationsscript stellt eine gute Ausgangsbasis für die
Migration dar. Prinzipbedingt sind nicht alle möglichen AddOns enthalten und in
vielen Fällen wird man noch weitere Kleinigkeiten an der Datenbank anpassen
möchte, die projektspezifisch sind. Prominente Beispiele für solche Anpassungen
sind:

* Umbenennung von Artikeltypen
* Ändern der ``finder``-Werte für Slice-Values (``SLY_VALUE[1]`` zu ``title``)
* Slices entfernen
* Erweiterung der UTF-8-Kodierung auf andere AddOn-Tabellen

Außerdem müssen der Name der Datenbank-Tabelle sowie die Zugangsdaten angepasst
werden. Das verfügbare Script sollte in :file:`develop/migration/migrate.php`
abgelegt und **über die Kommandozeile/Shell** ausgeführt werden.

Das vollständige `Migrationsscript <https://gist.github.com/3460331>`_ ist als
Gist verfügbar. Wir freuen uns über Verbesserungsvorschläge und Patches. :-)

Migration
^^^^^^^^^

#. Spiele den Master-Dump mit einem Tool wie Adminer oder phpMyAdmin in die
   Zieldatenbank ein. Verwende dazu **nicht** das Import/Export-AddOn.

   .. warning::

     Dies wird die bestehenden Tabellen überschreiben. Eventuell bereits
     eingepflegte Testinhalte gehen dabei verloren.

   .. note::

     Nicht vergessen, dies überschreibt auch die lokalen Benutzerkonten mit denen
     der Live-Seite!

#. Öffne eine Kommandozeile/Shell in :file:`/pfad/zum/projekt/develop/migration`
   und führe das Migrationsscript aus::

   > php migrate.php

#. Solange Fehler im Script auftreten, Code debuggen und wieder zu Schritt 2
   springen.

Einrichtung
-----------

Jetzt ist es an der Zeit, das Backend das erste Mal seit Beginn der Migration
aufzurufen. Hier sollte ein paar mal hart neugeladen werden (Strg+F5), damit
alle veralteten Core-Assets im Browsercache ersetzt werden, sowie der
Systemcache geleert werden.

Wenn das Backend soweit läuft, können nun die AddOns nach und nach wieder
aktiviert werden. Man sollte auch jedes AddOn re-initialisieren, damit die
Assets passen.

Am Ende leert man noch einmal den Systemcache und kann dann beginnen, die
Templates und Module an die neue API (auch die API der AddOns hat sich ggf.
geändert!) anzupassen.

.. note::

  Es kann sich lohnen, direkt nach dem Update (und noch vor der Anpassung des
  Frontend-Codes) erst einmal einen Dump im Backend anzulegen, damit man einen
  sauberen Stand hat, zudem man zurückkehren kann.
