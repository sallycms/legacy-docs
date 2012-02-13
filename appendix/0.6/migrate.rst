Migrationsleitfaden
===================

Die folgende Anleitung beschreibt, wie man ein bestehendes 0.5-Projekt auf 0.6
aktualisieren kann.

.. note::

  Nicht beschrieben sind die API-Änderungen, die zu Anpassungen an Modulen,
  Templates und AddOns führen. Stattdessen soll hier der grundlegende Ablauf
  beschrieben werden.

Vorbereitungen
--------------

Das zu migrierende Projekt (Sally 0.5) sollte lokal installiert und lauffähig
sein. Die Datenbank sollte ebenfalls aktuell sein (ggf. also einen Dump von der
Live-Installation einspielen).

.. note::

  Es wird dringend empfohlen, *erst* die aktuellen Daten einzuspielen und *dann*
  mit dem Update zu beginnen. Andernfalls werden einige AddOns beim Einspielen
  des Dumps Probleme machen.

.. note::

  0.5-Dumps lassen sich wegen des Versionsstempels und der geänderten
  Verzeichnisstruktur nicht in 0.6 einspielen!

.. note::

  Die AddOns sollten vor dem Update *deaktiviert* (nicht *deinstalliert*)
  werden.

Update
------

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

#. Nachdem der Core nun aktualisiert ist, können wir die AddOns aktualisieren.
   Mercurial-Benutzer können wieder pullen, alle anderen müssen die AddOns von
   Hand aktualisieren.

.. note::

  Wir sind an dieser Stelle *noch nicht fertig*!

Datenbank
---------

Die Datenbank benötigt zwei Updates: Ein formelles (Tabellendefinitionen) und
ein inhaltliches. Das formelle Update kann direkt in SQL erfolgen:

.. sourcecode:: mysql

  ALTER TABLE `sly_article` CHANGE COLUMN `catprior` `catpos` INT UNSIGNED NOT NULL;
  ALTER TABLE `sly_article` CHANGE COLUMN `prior` `pos` INT UNSIGNED NOT NULL;
  ALTER TABLE `sly_article_slice` CHANGE COLUMN `prior` `pos` INT UNSIGNED NOT NULL;
  ALTER TABLE `sly_file` CHANGE COLUMN `filesize` `filesize` INT UNSIGNED NOT NULL;
  ALTER TABLE `sly_file_category` CHANGE COLUMN `attributes` `attributes` TEXT NULL;
  ALTER TABLE `sly_slice_value` DROP COLUMN `type`;
  ALTER TABLE `sly_user` CHANGE COLUMN `name` `name` VARCHAR(255) NULL;
  ALTER TABLE `sly_user` CHANGE COLUMN `description` `description` VARCHAR(255) NULL;

.. warning::

  Durch diese Änderung liegen nun alle Slice-Werte im gleichen Namensraum. Wenn
  es im Projekt innerhalb eines Slices sowohl eine Medialiste ``foo`` und ein
  Input-Feld namens ``foo`` gab, so tritt nun ein Konflikt auf. Um diesen zu
  bereinigen müssen alle Duplikate einfach vorher umbenannt (z.B. die Werte
  der Medialiste in ``foo_media``) werden.

Die bestehenden Daten müssen nun noch angepasst werden: Slice-Werte werden seit
0.6 als JSON-Strings gespeichert. Da das Kodieren von Strings in reinem SQL
nicht (einfach) möglich ist, kann man dazu auch ein kleines PHP-Script wie das
Folgende verwenden:

.. sourcecode:: php

  <?php

  // zur Datenbank verbinden
  mysql_connect('localhost', 'username', 'password');
  mysql_select_db('myproject');
  mysql_query('SET NAMES utf8');

  // alle Slicewerte aberufen
  $res = mysql_query('SELECT * FROM sly_slice_value WHERE 1');

  while ($row = mysql_fetch_assoc($res)) {
     $value = $row['value'];

     // Bildpfade korrigieren
     $value = str_replace('"sally/data/mediapool', '"data/mediapool', $value);

     // JSON-Kodierung
     $value = json_encode($value);

     // and update it
     mysql_query('UPDATE sly_slice_value SET value = "'.mysql_real_escape_string($value).'" WHERE id = '.intval($row['id']));
  }

  mysql_close();

Einrichtung
-----------

Jetzt ist es an der Zeit, das Backend das erste Mal seit Beginn der Migration
aufzurufen. Hier sollte ein paar mal hart neugeladen werden (Strg+F5), damit
alle veralteten Core-Assets im Browsercache ersetzt werden.

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
