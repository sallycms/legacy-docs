Migrationsleitfaden
===================

Die folgende Anleitung beschreibt, wie man ein bestehendes 0.6-Projekt auf 0.7
aktualisieren kann.

.. note::

  Nicht beschrieben sind die API-Änderungen, die zu Anpassungen an Modulen,
  Templates und AddOns führen. Stattdessen soll hier der grundlegende Ablauf
  beschrieben werden.

Sally aktualisieren
-------------------

Das zu migrierende Projekt (Sally 0.6) sollte lokal installiert und lauffähig
sein. Die Datenbank sollte ebenfalls aktuell sein (ggf. also einen normalen
Dump aus dem Backend der Live-Installation einspielen).

.. warning::

  **Dieser** Dump sollte keinesfalls mit dem Import/Export-AddOn angelegt
  werden, sondern mit einem Tool wie Adminer oder phpMyAdmin. Dies stellt
  sicher, dass auch Benutzerkonten korrekt exportiert werden.

.. note::

  0.6-Dumps, die mit dem Import/Export-AddOn erstellt wurden, lassen sich wegen
  des Versionsstempels nicht in 0.7 einspielen!

Projekte können entweder in-place oder durch Anlegen eines frischen 0.7-Projekts
(also als Kopie) aktualisiert werden. Nutzern, die Projekte als Mercurial- oder
Git-Klon von Sally verwalten, können in-place über einen Pull vom 0.7-Repository
aktualisieren.

Wer Projekte nicht als Klon von Sally verwaltet, sollte entweder mit einer
frischen Kopie arbeiten oder beim Ersetzen der Sally-Dateien aufpassen, keine
ggf. gelöschten Dateileichen im Projekt zu belassen. Es empfiehlt sich dabei,
die Verzeichnisse in :file:`sally/` vorher zu löschen.

Wenn entweder ein frisches 0.7-Projekt oder das in-place zu aktualisierende
Projekt stehen, kann mit dem Upgrade begonnen werden.

.. note::

  In allen beteiligten Projekten (Quelle & Ziel) sollte jeweils die Caching-
  Strategie auf **Memory** gestellt und der **Entwicklermodus** aktiviert sein.
  Außerdem sollten alle **AddOns deaktiviert** sein.

System-Upgrade
~~~~~~~~~~~~~~

Im Folgenden wird beschrieben, wie der Sally-Code (Core, Backend und Frontend)
aktualisiert werden kann.

Mercurial/Git
"""""""""""""

Man führt im Projekt einfach ein Pull auf das
`0.7-Repository <https://bitbucket.org/SallyCMS/0.7>`_ aus, mergt die Änderungen
mit dem Projekt und committet den Merge.::

  $ hg pull https://bitbucket.org/SallyCMS/0.7
  $ hg merge
  $ hg commit -m "updated to sally 0.7"

(Git-Nutzer verwenden den für Git passenden Workflow mit dem
`GitHub-Mirror <https://github.com/sallycms/0.7>`_.)

Die :file:`.htaccess` im Frontend wird vermutlich kleinere Mergeprobleme
verursachen, da dort meistens projektspezifische Anpassungen stattfinden. Hier
sollte einfach die passende Version ausgewählt werden.

Manuell
"""""""

Vor dem Upgrade sollten alle Verzeichnisse innerhalb von :file:`sally/` gelöscht
werden. AddOns sollten ebenfalls gelöscht werden, sofern sie über Composer
bereitstehen (dies ist für alle SallyCMS- und webvariants-AddOns der Fall).

Im Anschluss kopiert man die Verzeichnisse aus dem 0.7-Download rüber. Danach
ersetzt man noch die Dateien im Root (:file:`index.php`, :file:`.htaccess`, ...).
Man sollte hier unbedingt auch die :file:`composer.json` übernehmen, um die
benötigten AddOns im Projekt pflegen zu können.

Vorbereitungen
~~~~~~~~~~~~~~

Nun können, wenn ein frisches Projekt verwendet wurde, die Assets und
Develop-Dateien in das neue Projekt übernommen werden. Bis auf wenige
API-Änderungen sind keine Arbeiten an den Dateien nötig.

Bevor noch das Backend aufgerufen werden, sollte der Asset-Cache gelöscht
werden. Dazu löscht man das *gesamte* Verzeichnis
:file:`data/dyn/public/sally/static-cache` -- Das Verzeichnis wird beim ersten
Backend-Request neu aufgebaut. Der Sally-Cache in
:file:`data/dyn/internal/sally` sollte ebenfalls gelöscht werden.

Die Änderungen am Datenbank-Schema erfordern, dass vor weiteren Aktionen im
Backend erst die Datenbank migriert werden muss.

Datenbank
---------

Das Datenbank-Upgrade erfordert zwei Schritte:

* Es müssen eine Reihe einfacher Updates vorgenommen werden. Dazu müssn die
  unten genannten Queries auf der Projektdatenbank ausgeführt werden.
* Die Slice-Werte müssen in das neue 0.7-Format konvertiert werden. Das lässt
  sich am einfachsten mit einem PHP-Script durchgeführt werden. Im
  `Migrationsscript`_ sind die nötigen Arbeiten bereits exemplarisch
  vor-implementiert.

Schema-Updates
~~~~~~~~~~~~~~

.. note::

  Die hier genannten Queries sind im `Migrationsscript`_ bereits enthalten und
  müssen, wenn es verwendet wird, **nicht manuell ausgeführt werden**.

.. sourcecode:: mysql

  -- rename psw column on users

  ALTER TABLE `sly_user`
     CHANGE COLUMN `psw` `password` VARCHAR(128) NULL DEFAULT NULL AFTER `login`;

  -- add new column for slice values

  ALTER TABLE `sly_slice`
     ADD COLUMN `serialized_values` LONGTEXT NOT NULL AFTER `module`;

  -- add temp column pairs

  ALTER TABLE `sly_article`
     ADD COLUMN `created` DATETIME NOT NULL AFTER `createdate`,
     ADD COLUMN `updated` DATETIME NOT NULL AFTER `updatedate`;

  ALTER TABLE `sly_article_slice`
     ADD COLUMN `created` DATETIME NOT NULL AFTER `createdate`,
     ADD COLUMN `updated` DATETIME NOT NULL AFTER `updatedate`;

  ALTER TABLE `sly_file`
     ADD COLUMN `created` DATETIME NOT NULL AFTER `createdate`,
     ADD COLUMN `updated` DATETIME NOT NULL AFTER `updatedate`;

  ALTER TABLE `sly_file_category`
     ADD COLUMN `created` DATETIME NOT NULL AFTER `createdate`,
     ADD COLUMN `updated` DATETIME NOT NULL AFTER `updatedate`;

  ALTER TABLE `sly_user`
     ADD COLUMN `created` DATETIME NOT NULL AFTER `createdate`,
     ADD COLUMN `updated` DATETIME NOT NULL AFTER `updatedate`,
     ADD COLUMN `lasttry` DATETIME NULL AFTER `lasttrydate`;

  -- recode the existing data

  UPDATE `sly_article`       SET `created` = FROM_UNIXTIME(`createdate`), `updated` = FROM_UNIXTIME(`updatedate`);
  UPDATE `sly_article_slice` SET `created` = FROM_UNIXTIME(`createdate`), `updated` = FROM_UNIXTIME(`updatedate`);
  UPDATE `sly_file`          SET `created` = FROM_UNIXTIME(`createdate`), `updated` = FROM_UNIXTIME(`updatedate`);
  UPDATE `sly_file_category` SET `created` = FROM_UNIXTIME(`createdate`), `updated` = FROM_UNIXTIME(`updatedate`);
  UPDATE `sly_user`          SET `created` = FROM_UNIXTIME(`createdate`), `updated` = FROM_UNIXTIME(`updatedate`), `lasttry` = FROM_UNIXTIME(`lasttrydate`);

  -- remove old columns

  ALTER TABLE `sly_article`       DROP COLUMN `createdate`, DROP COLUMN `updatedate`;
  ALTER TABLE `sly_article_slice` DROP COLUMN `createdate`, DROP COLUMN `updatedate`;
  ALTER TABLE `sly_file`          DROP COLUMN `createdate`, DROP COLUMN `updatedate`;
  ALTER TABLE `sly_file_category` DROP COLUMN `createdate`, DROP COLUMN `updatedate`;
  ALTER TABLE `sly_user`          DROP COLUMN `createdate`, DROP COLUMN `updatedate`, DROP COLUMN `lasttrydate`;

  -- rename new columns

  ALTER TABLE `sly_article`
     CHANGE COLUMN `created` `createdate` DATETIME NOT NULL,
     CHANGE COLUMN `updated` `updatedate` DATETIME NOT NULL;

  ALTER TABLE `sly_article_slice`
     CHANGE COLUMN `created` `createdate` DATETIME NOT NULL,
     CHANGE COLUMN `updated` `updatedate` DATETIME NOT NULL;

  ALTER TABLE `sly_file`
     CHANGE COLUMN `created` `createdate` DATETIME NOT NULL,
     CHANGE COLUMN `updated` `updatedate` DATETIME NOT NULL;

  ALTER TABLE `sly_file_category`
     CHANGE COLUMN `created` `createdate` DATETIME NOT NULL,
     CHANGE COLUMN `updated` `updatedate` DATETIME NOT NULL;

  ALTER TABLE `sly_user`
     CHANGE COLUMN `created` `createdate`  DATETIME NOT NULL,
     CHANGE COLUMN `updated` `updatedate`  DATETIME NOT NULL,
     CHANGE COLUMN `lasttry` `lasttrydate` DATETIME NULL;

  -- change engine to InnoDB

  ALTER TABLE `sly_article`       ENGINE=InnoDB;
  ALTER TABLE `sly_article_slice` ENGINE=InnoDB;
  ALTER TABLE `sly_clang`         ENGINE=InnoDB;
  ALTER TABLE `sly_file`          ENGINE=InnoDB;
  ALTER TABLE `sly_file_category` ENGINE=InnoDB;
  ALTER TABLE `sly_registry`      ENGINE=InnoDB;
  ALTER TABLE `sly_slice`         ENGINE=InnoDB;
  ALTER TABLE `sly_user`          ENGINE=InnoDB;

  -- remove unused table
  -- You should do this *after* you have migrated the slice contents into the
  -- new serialized_value column. See the migration script for a basic
  -- implementation.

  -- DROP TABLE `sly_slice_value`;

Migrationsscript
~~~~~~~~~~~~~~~~

.. warning::

  Die Migration findet nicht im Browser, sondern auf der Kommandozeile/Shell
  statt!

Das unten verlinkte Migrationsscript stellt eine gute Ausgangsbasis für die
Migration dar. Prinzipbedingt sind nicht alle möglichen AddOns enthalten und in
vielen Fällen wird man noch weitere Kleinigkeiten an der Datenbank anpassen
möchte, die projektspezifisch sind. Prominente Beispiele für solche Anpassungen
sind:

* Umbenennung von Artikeltypen
* Erweiterung der UTF-8-Kodierung auf andere AddOn-Tabellen

Außerdem müssen der Name der Datenbank-Tabelle sowie die Zugangsdaten angepasst
werden. Das verfügbare Script sollte in :file:`develop/migration/migrate.php`
abgelegt und **über die Kommandozeile/Shell** ausgeführt werden.

Das vollständige `Migrationsscript <https://gist.github.com/3460331>`_ ist als
Gist verfügbar. Wir freuen uns über Verbesserungsvorschläge und Patches. :-)

Das Script ist denkbar einfach zu verwenden: Öffne eine Kommandozeile/Shell in
:file:`/pfad/zum/projekt/develop/migration` und führe das Migrationsscript aus::

  $ php migrate.php

Einrichtung
-----------

Bevor das Backend aufgerufen werden kann, müssen mindestens die Vendor-Libraries
installiert werden. Dazu wird im Projekt-Root Composer aufgerufen::

  $ php composer.phar install

Nutzer, die das Standalone-Starterkit nutzen, müssen diesen Schritt nicht
ausführen, da die nötigen Libraries bereits im Ziparchiv enthalten sind und beim
Kopieren der Verzeichnisse in :file:`sally/` bereits übernommen wurden.

Jetzt ist es an der Zeit, das Backend das erste Mal seit Beginn der Migration
aufzurufen. Wenn die Datenbank-Updates erfolgreich waren, sollte nun wieder ein
Login möglich sein.

Im Backend sollte ein paar mal hart neugeladen werden (Strg+F5), damit alle
veralteten Core-Assets im Browsercache ersetzt werden, sowie der Systemcache
geleert werden.

Die eingepflegten Inhalte sollten ebenfalls bereits verfügbar sein. Nun ist es
an der Zeit, die AddOns einzurichten.

AddOns
------

Es wird empfohlen, die AddOns im neuen Projekt fortan mit Composer zu verwalten.
Dazu ruft man Composer auf der Kommandozeile auf und bindet die benötigten
AddOns ein::

  $ php composer.phar require sallycms/be-search=*
  $ php composer.phar require sallycms/image-resize=*
  $ php composer.phar require sallycms/import-export=*
  $ php composer.phar require sallycms/vendorx-addon-name=*
  $ ...

.. note::

  Grundsätzlich ist es auch kein Problem, AddOns einzubinden, die nicht auf
  Packagist angemeldet sind. Die Composer-Dokumentation enthält weitere Hinweise
  zu Custom Repositories und Repositories.

Alle AddOns, die nicht über Composer verwaltet werden können, sollten manuell
auf die aktuelle Version aktualisiert werden.

Nachdem alle AddOns erfolgreich aktualisiert sind, können sie nun nach und nach
wieder im Backend aktiviert / installiert werden. Die Assets sollten unbedingt
bei jedem AddOn re-initialisiert werden.

Final Touches
-------------

Am Ende leert man noch einmal den Systemcache und kann dann beginnen, die
Templates und Module an die neue API (auch die API der AddOns hat sich ggf.
geändert!) anzupassen.

.. note::

  Es kann sich lohnen, direkt nach dem Update (und noch vor der Anpassung des
  Frontend-Codes) erst einmal einen Dump im Backend anzulegen, damit man einen
  sauberen Stand hat, zudem man zurückkehren kann.
