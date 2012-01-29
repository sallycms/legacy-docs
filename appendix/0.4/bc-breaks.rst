Kompatibilitätsinformationen
============================

Auf dieser Seite werden alle rückwärts-inkompatiblen API-Änderungen aus allen
Sally-Releases dokumentiert.

.. note::

  Während der 0.x-Phase sind Updates nicht immer ohne manuelles Eingreifen
  möglich, da wir teils gravierende Änderungen an der Struktur vornehmen. Wir
  bitten, diesen Umstand zu beachten. Updates innerhalb eines Branches (z.B.
  von 0.4.4 auf 0.4.7) sollten hingegen immer problemlos möglich sein.

0.4.0 -> 0.4.1
--------------

* ``sly_Core::getTempDir()`` wurde entfernt.
* **Metainfo**-AddOn: Die Standard-Metainfos description, keywords und
  description für Medien wurden gestrichen. Bestehende Projekte, die diese
  Metainfos nutzen, sollten nach einem Update und **bevor** das Backend
  aufgerufen wird, die Inhalte aus der :file:`globals.yml` des AddOns in die
  eigene YAML-Datei mit den eigenen Metainfos übernehmen. Andernfalls werden die
  eingegebenen Metadaten entfernt, da die Metainfos nicht mehr gefunden werden.

0.4.1 -> 0.4.2
--------------

Die Datenbank wurde leicht geändert. Sie kann (muss aber nicht) wie folgt
aktualisiert werden.

.. sourcecode:: sql

  ALTER TABLE `sly_article`  CHANGE COLUMN `revision` `revision` INT(11) NOT NULL DEFAULT '0';
  ALTER TABLE `sly_article_slice`  CHANGE COLUMN `revision` `revision` INT(11) NOT NULL DEFAULT '0';
  ALTER TABLE `sly_clang`  CHANGE COLUMN `revision` `revision` INT(11) NOT NULL DEFAULT '0';
  ALTER TABLE `sly_file`  CHANGE COLUMN `revision` `revision` INT(11) NOT NULL DEFAULT '0';
  ALTER TABLE `sly_file_category`  CHANGE COLUMN `revision` `revision` INT(11) NOT NULL DEFAULT '0';
  ALTER TABLE `sly_user`  CHANGE COLUMN `revision` `revision` INT(11) NOT NULL DEFAULT '0';

Weiterhin:

* Die Dateien :file:`gzip.php`, :file:`sally/.htaccess` und
  :file:`sally/scaffold.php` müssen *gelöscht* werden.
* Die :file:`.htaccess` im Frontend hat sich geändert. Sie muss mit der neuen
  Version ersetzt werden (der Code für realURL2 und ggf. weitere Änderungen
  müssen dann wieder erneut eingetragen werden).

0.4.2 -> 0.4.5
--------------

* Nichts tun :-)

0.4.5 -> 0.4.6
--------------

* ``sly_Util_Pager`` hat kleinere Änderungen erfahren, die ggf. Anpassungen des
  CSS-Codes erfordern:

  * Das aktuelle Element erhält die Klasse ``active`` und wrappt seinen Text in
    ein ``<span>``-Element.
  * Die Klasse ``first`` wurde entfernt (``:first-child`` kann für den gleichen
    Effekt genutzt werden).
  * Außerdem wurde die Nummerierung der ``page``-Klassen korrigiert.

0.4.6 -> 0.4.9
--------------

* Nichts tun :-)

0.4.9 -> 0.4.10
---------------

* Die :file:`cache.php` wurde aus dem Asset-Cache entfernt und durch eine
  direkte Umleitung auf die :file:`index.php` ersetzt. Diese Datei kann also
  gefahrlos gelöscht werden (wird sie auch beim Leeren des Caches).

Da der Asset-Cache geänderte :file:`.htaccess`-Dateien bewusst nicht
überschreibt, wird er die neue Version der Datei nie selber an den richtigen
Platz legen. Man muss daher die Datei :file:`sally/include/install/static-cache/.htaccess`
selber nach :file:`data/dyn/public/sally/static-cache/.htaccess` kopieren.

0.4.10 -> 0.4.13
----------------

* Nichts tun :-)
