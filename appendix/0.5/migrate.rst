Migrationsleitfaden
===================

Die folgende Anleitung beschreibt, wie man ein bestehendes 0.4-Projekt auf 0.5
aktualisieren kann.

.. note::

  Nicht beschrieben sind die API-Änderungen, die zu Anpassungen an Modulen,
  Templates und AddOns führen. Stattdessen soll hier der grundlegende Ablauf
  beschrieben werden.

.. note::

  Projekte sollten mindestens Version 0.4.2 verwenden, um relativ schmerzfrei
  aktualisiert zu werden. Ältere Sally-Versionen unterscheiden sich, was die
  Auslieferung der Assets angeht, deutlich von dem ab 0.4.2 verwendeten System.

Vorbereitungen
--------------

#. Installiere dir ein neues, leeres 0.5.x-Projekt auf deinem Rechner.
#. Installiere die AddOns. Beachte, dass die wenigstens 0.4-AddOns mit 0.5
   kompatibel sind. Du wirst also die AddOns aktualisieren müssen. Ihre Daten
   werden zwar später überschrieben, aber so sind ihre Assets und sonstigen
   Einrichtungen schon einmal vorbereitet.
#. Dumpe die bestehende Datenbank (der aktuellen 0.4-Live-Seite). Verwende dazu
   **nicht** das Import/Export-AddOn, da durch die geänderte Pfadstruktur deren
   Export nicht in dem 0.5-Projekt eingespielt werden kann. Ob du dazu
   phpMyAdmin, Adminer, HeidiSQL oder ``mysql`` direkt verwendest, ist egal.

Ablauf
------

Alle folgenden Schritte finden lokal statt.

#. Spiele den Datenbank-Dump in die Datenbank des neuen Projekts ein (lokal). Im
   Idealfall nutzt du das gleiche Werkzeug, das auch den Dump erzeugt hat.
#. Ersetze die bestehenden RexVar-Keys durch die neuen Versionen (``REX_VALUE``
   wird zu ``SLY_VALUE``) mit Hilfe der in den :doc:`Aktualisierungshinweisen
   <releasenotes>` gegebenen SQL-Queries (siehe unten).
#. Leere den Sally-Cache im Backend.
#. Übernimm deine develop-Dateien und deine Assets aus dem alten Projekt.
#. Passe deine Module, Templates und AddOns an die neue API von Sally an. Viel
   Spaß dabei ;-) Beachte dabei vor allem die folgenden Punkte.

   * Das Backend ist via ``/backend/`` zu erreichen.
   * Es gibt keine OO-API mehr.
   * ``$REX`` wurde entfernt.
   * Es heißt ``sally/data/..`` anstatt ``data/..``.

#. Testen & Feinschliff.
#. Deployment.

Datenbank aktualisieren
-----------------------

.. sourcecode:: mysql

  UPDATE `sly_slice_value` SET `type` = REPLACE(`type`, "REX_", "SLY_") WHERE 1;
  ALTER TABLE `sly_article` DROP INDEX `id`, ADD PRIMARY KEY (`id`, `clang`);
  ALTER TABLE `sly_article_slice` DROP PRIMARY KEY, ADD PRIMARY KEY (`id`), ADD KEY `find_article` (`article_id`, `clang`);
  ALTER TABLE `sly_file` ADD KEY `filename` (`filename`(255));
  ALTER TABLE `sly_article` DROP PRIMARY KEY, ADD PRIMARY KEY (`id`, `clang`);
  ALTER TABLE `sly_registry` DROP INDEX `name`, ADD PRIMARY KEY (`name`);
