Sally aktualisieren
===================

.. note::

  Während der 0.x-Phase sind Updates nicht immer ohne manuelles Eingreifen
  möglich, da wir teils gravierende Änderungen an der Struktur vornehmen. Wir
  bitten, diesen Umstand zu beachten. Updates innerhalb eines Branches (z.B.
  von 0.4.4 auf 0.4.7) sollten hingegen immer problemlos möglich sein.

0.4-Branch
----------

0.4.0 -> 0.4.1
^^^^^^^^^^^^^^

* ``sly_Core::getTempDir()`` wurde entfernt.
* **Metainfo**-AddOn: Die Standard-Metainfos description, keywords und
  description für Medien wurden gestrichen. Bestehende Projekte, die diese
  Metainfos nutzen, sollten nach einem Update und **bevor** das Backend
  aufgerufen wird, die Inhalte aus der :file:`globals.yml` des AddOns in die
  eigene YAML-Datei mit den eigenen Metainfos übernehmen. Andernfalls werden die
  eingegebenen Metadaten entfernt, da die Metainfos nicht mehr gefunden werden.

0.4.1 -> 0.4.2
^^^^^^^^^^^^^^

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
^^^^^^^^^^^^^^

* Nichts tun :-)

0.4.5 -> 0.4.6
^^^^^^^^^^^^^^

* ``sly_Util_Navigation`` hat kleinere Änderungen erfahren, die ggf. Anpassungen
  des CSS-Codes erfordern:

  * Das aktuelle Element erhält die Klasse ``active`` und wrappt seinen Text in
    ein ``<span>``-Element.
  * Die Klasse ``first`` wurde entfernt (``:first-child`` kann für den gleichen
    Effekt genutzt werden).
  * Außerdem wurde die Nummerierung der ``page``-Klassen korrigiert.

0.5-Branch
----------

0.4.x -> 0.5.0
^^^^^^^^^^^^^^

.. note::

  Aufgrund der geänderten :doc:`Verzeichnisstruktur <birdseye>` empfehlen wir,
  bestehende 0.4-Projekte neu anzulegen, anstatt in alten Projekten zu
  versuchen, die Strukturänderungen nachzuahmen. Dies betrifft natürlich nicht
  die Inhalte des Projekts.

Lege als erstes einen Datenbank-Export (ohne Konfiguration!) an, der später in
dem neuen Projekt importiert werden kann.

#. Die webvariants-AddOns müssen auf die jeweils aktuellsten Versionen
   aktualisiert werden. Projekte, die den Error Handler verwenden, sollten auch
   im neuen Projekt das AddOn verwenden, da der :doc:`integrierte Error Handler
   </sallycms/errorhandler>` nicht alle Funktionen des AddOns enthält.
#. Übernimm deine develop-Dateien und deine Assets.
#. Passe deine AddOns an die neue API (siehe unten) an.
#. Gehe deine develop-Dateien durch und passe sie ebenfalls an die neue API an.
#. Installiere das neue Projekt, installiere dann alle AddOns und spiele deinen
   Datenbank-Dump ein.
#. Führe das unten gegebene MySQL-Script aus, um die Indexe deiner Datenbank
   und die Slice-Werte zu aktualisieren.
#. Testen & Feinschliff.

API-Änderungen
^^^^^^^^^^^^^^

Im Folgenden werden soweit möglich alle API-Änderungen zwischen dem 0.4- und dem
0.5-Branch beschrieben.

.. note::

  TODO

Konfiguration
"""""""""""""

  * ``TIMEZONE`` wurde hinzugefügt.
  * ``LANG`` wurde in ``DEFAULT_LOCALE`` umbenannt.
  * ``START_CLANG_ID`` wurde in ``DEFAULT_CLANG_ID`` umbenannt.
  * ``VERSION`` wurde in ``VERSION/MAJOR`` umbenannt.
  * ``SUBVERSION`` wurde in ``VERSION/MINOR`` umbenannt.
  * ``MINORVERSION`` wurde in ``VERSION/BUGFIX`` umbenannt.
  * ``SERVERNAME`` wurde in ``PROJECTNAME`` umbenannt.
  * ``SERVER``, ``ERROR_EMAIL``, ``SESSION_DURATION`` und ``USE_GZIP`` wurden
    entfernt.
  * Die ``INSTNAME`` wird nicht mehr aus einem Timestamp, sondern einem SHA-1
    Hash eines Zufallswerts.
  * Der Zugriff auf die wichtigsten Konfigurationen sollte nun über die neuen
    API-Methoden in ``sly_Core`` stattfinden.

    * ``::getProjectName()``
    * ``::getSiteStartArticleId()``
    * ``::getNotFoundArticleId()``
    * ``::getDefaultLocale()``
    * ``::getDefaultLanguageId()``
    * ``::getVersion()`` (erlaubt die Angabe des Formats, z.B. ``X.Y``)
    * ``::getDefaultArticleType()``
    * ``::getCachingStrategy()``
    * ``::getTimezone()``
    * ``::getFilePerm()``
    * ``::getDirPerm()``

Globale Variablen
"""""""""""""""""

  * ``$REX`` wurde entfernt. Einige der in 0.4 noch genutzten Elemente sind nun
    über die folgenden API-Methoden erreichbar:

    * ``LANG`` für die aktuelle Backend-Sprache in
      ``sly_Core::getI18N()->getLocale()``
    * ``PAGE`` über ``sly_Core::getCurrentPage()`` (gibt ``null`` im Frontend
      zurück)
    * ``PAGEPATH`` wurde entfernt.
    * ``CLANG`` ist über ``sly_Util_Language::findAll()`` zu erreichen. Dabei
      werden ``sly_Model_Language``-Instanzen zurückgegeben, deren Namen erst
      über ``->getName()`` abgerufen werden muss.
    * ``CUR_CLANG`` ist über ``sly_Core::getCurrentClang()`` zu erreichen.
    * ``ARTICLE_ID`` steht in ``sly_Core::getCurrentArticleId()`` zur Verfügung.
    * ``USER`` steht über ``sly_Util_User::getCurrentUser()`` zur Verfügung.

  * ``$I18N`` wurde entfernt. Die Instanz kann über ``sly_Core::getI18N()``
    abgerufen und über ``::setI18N()`` gesetzt werden.

Konstanten
""""""""""

  * ``SLY_INCLUDE_PATH`` wurde entfernt, da es keinen Include-Pfad mehr gibt.
  * ``SLY_SALLYFOLDER`` gibt den absoluten Pfad zum :file:`sally`-Verzeichnis
    an (z. B. :file:`/var/www/myproject/sally/`).
  * ``SLY_COREFOLDER`` gibt den absoluten Pfad zum :file:`core`-Verzeichnis an.
  * AddOns sollten ihre eigenen Pfad entweder über ``dirname(__FILE__)`` in
    ihrer :file:`config.inc.php` oder über ``SLY_ADDONFOLDER.'/myaddon'``
    ermitteln.
  * Die Konstanten ``E_RECOVERABLE_ERROR``, ``E_DEPRECATED`` und
    ``E_USER_DEPRECATED`` werden gesetzt, falls sie noch nicht vorhanden sind
    (PHP < 5.3).
  * ``SLY_HTDOCS_PATH`` wurde hinzugefügt und gibt den relativen Pfad zum Root
    des Projekts an.

Datei(system)
"""""""""""""

.. note::

  Siehe dazu auch die :doc:`Verzeichnisstruktur </general/birdseye>`.

* :file:`master.inc.php` heißt nun :file:`master.php`.
* Sprachdateien müssen auf ``.yml`` statt auf ``.lang`` enden. Damit werden sie
  in Editoren endlich automatisch mit Syntax Highlighting versehen.
* AddOns können **nicht mehr** über eine :file:`pages/index.inc.php` geladen
  werden, sondern müssen als Controller implementiert werden.
* Die Datei :file:`sally/include/functions/function_rex_url.inc.php` wurde
  entfernt. Mit ihr wurden auch ``rex_getUrl()`` und ``rex_param_string()``
  entfernt.

Datenbank
"""""""""

* Die ``type``-Angaben in ``sly_slice_value`` wurden jeweils von ``REX_...`` in
  ``SLY_...`` umbenannt,
  da sich die API der rex_vars geändert und sie teilweise auch völlig neu
  implementiert wurden.
* Die Indexe von ``sly_article``, ``sly_article_slice``, ``sly_file``,
  ``sly_file_category`` und ``sly_registry`` wurden angepasst.

Die Datenbank kann über die folgenden SQL-Statements aktualisiert werden.
Bestehende Daten gehen dabei nicht verloren.

.. sourcecode:: mysql

  UPDATE `sly_slice_value` SET `type` = REPLACE(`type`, "REX_", "SLY_") WHERE 1;
  ALTER TABLE `sly_article` DROP INDEX `id`, ADD PRIMARY KEY (`id`, `clang`);
  ALTER TABLE `sly_article_slice` DROP PRIMARY KEY, ADD PRIMARY KEY (`id`), ADD KEY `find_article` (`article_id`, `clang`);
  ALTER TABLE `sly_file` ADD KEY KEY `filename` (`filename`(255));
  ALTER TABLE `sly_article` DROP PRIMARY KEY, ADD PRIMARY KEY (`id`);
  ALTER TABLE `sly_registry` DROP INDEX `name`, ADD PRIMARY KEY (`name`);
