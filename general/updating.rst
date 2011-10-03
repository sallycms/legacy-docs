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

* ``sly_Util_Pager`` hat kleinere Änderungen erfahren, die ggf. Anpassungen des
  CSS-Codes erfordern:

  * Das aktuelle Element erhält die Klasse ``active`` und wrappt seinen Text in
    ein ``<span>``-Element.
  * Die Klasse ``first`` wurde entfernt (``:first-child`` kann für den gleichen
    Effekt genutzt werden).
  * Außerdem wurde die Nummerierung der ``page``-Klassen korrigiert.

0.4.6 -> 0.4.9
^^^^^^^^^^^^^^

* Nichts tun :-)

0.4.9 -> 0.4.10
^^^^^^^^^^^^^^^

* Die :file:`cache.php` wurde aus dem Asset-Cache entfernt und durch eine
  direkte Umleitung auf die :file:`index.php` ersetzt. Diese Datei kann also
  gefahrlos gelöscht werden (wird sie auch beim Leeren des Caches).

Da der Asset-Cache geänderte :file:`.htaccess`-Dateien bewusst nicht
überschreibt, wird er die neue Version der Datei nie selber an den richtigen
Platz legen. Man muss daher die Datei :file:`sally/include/install/static-cache/.htaccess`
selber nach :file:`data/dyn/public/sally/static-cache/.htaccess` kopieren.

0.4.10 -> 0.4.13
^^^^^^^^^^^^^^^^

* Nichts tun :-)

0.5-Branch
----------

Eine Übersicht über die neuen Features und Verbesserungen gibt der `News-Beitrag
im Sally-Wiki <https://projects.webvariants.de/news/48>`_.

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
    Hash eines Zufallswerts ermittelt.
  * Der Zugriff auf die wichtigsten Konfigurationen sollte nun über die neuen
    API-Methoden in ``sly_Core`` stattfinden.

    * ``::getProjectName()``
    * ``::getSiteStartArticleId()``
    * ``::getNotFoundArticleId()``
    * ``::getDefaultLocale()``
    * ``::getDefaultClangId()``
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
    * ``LOCALES`` steht über ``sly_I18N::getLocales()`` zur Verfügung.
    * ``PERM`` steht über ``sly_Authorisation::getRights()`` zur Verfügung.
    * ``EXTPERM`` steht über ``sly_Authorisation::getExtendedRights()`` zur
      Verfügung.
    * ``EXTRAPERM`` steht über ``sly_Authorisation::getExtraRights()`` zur
      Verfügung.

  * ``$I18N`` wurde entfernt. Die Instanz kann über ``sly_Core::getI18N()``
    abgerufen und über ``::setI18N()`` gesetzt werden.

Konstanten
""""""""""

  * ``SLY_INCLUDE_PATH`` wurde entfernt, da es keinen Include-Pfad mehr gibt.
  * ``SLY_SALLYFOLDER`` gibt den absoluten Pfad zum :file:`sally`-Verzeichnis
    an (z. B. :file:`/var/www/myproject/sally/`).
  * ``SLY_COREFOLDER`` gibt den absoluten Pfad zum :file:`core`-Verzeichnis an.
  * AddOns sollten ihren eigenen Pfad entweder über ``dirname(__FILE__)`` in
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
* Das Cache-Verzeichnis :file:`dyn/internal/sally/files` existiert nicht mehr.

Datenbank
"""""""""

* Die ``type``-Angaben in ``sly_slice_value`` wurden jeweils von ``REX_...`` in
  ``SLY_...`` umbenannt, da sich die API der rex_vars geändert und sie teilweise
  auch völlig neu implementiert wurden.
* Die Indexe von ``sly_article``, ``sly_article_slice``, ``sly_file``,
  ``sly_file_category`` und ``sly_registry`` wurden angepasst.

Die Datenbank kann über die folgenden SQL-Statements aktualisiert werden.
Bestehende Daten gehen dabei nicht verloren.

.. sourcecode:: mysql

  UPDATE `sly_slice_value` SET `type` = REPLACE(`type`, "REX_", "SLY_") WHERE 1;
  ALTER TABLE `sly_article` DROP INDEX `id`, ADD PRIMARY KEY (`id`, `clang`);
  ALTER TABLE `sly_article_slice` DROP PRIMARY KEY, ADD PRIMARY KEY (`id`), ADD KEY `find_article` (`article_id`, `clang`);
  ALTER TABLE `sly_file` ADD KEY `filename` (`filename`(255));
  ALTER TABLE `sly_article` DROP PRIMARY KEY, ADD PRIMARY KEY (`id`, `clang`);
  ALTER TABLE `sly_registry` DROP INDEX `name`, ADD PRIMARY KEY (`name`);

JavaScript
""""""""""

Der Großteil der JavaScript-API wurde neu implementiert, um ohne kryptische IDs
auszukommen. Die Änderungen, die nur die Funktionsweise der vorimplementierten
Widgets ("Mediabutton", "Medialistbuton", etc.) betreffen, sollen hier nicht
dargelegt werden.

* Der Medienpool kann nun über ``sly.openMediapool(subpage, value, callback)``
  geöffnet werden. Der ``callback`` ist der *Name* einer JavaScript-Funktion,
  die vom Popup aufgerufen wird, wenn eine Datei übernommen werden soll. Der
  Callback erhält die Parameter ``(filename, fullName, title, link)`` übergeben.

  * ``filename`` ist der Dateiname, z. B. ``foo.jpg``.
  * ``fullName`` ist der anzuzeigende Titel (z. B. "Meine Datei (foo.jpg)").
  * ``title`` ist der Dateititel (z. B. "Meine Datei", kann leer sein).
  * ``link`` ist der Pfad zur Datei, z. B. ``data/mediapool/foo.jpg``.

  Der Name des Callbacks darf keine Punkte enthalten.

* Die Linkmap kann nun über ``sly.openLinkmap(value, callback)`` geöffnet
  werden. Der ``callback`` ist der *Name* einer JavaScript-Funktion, die vom
  Popup aufgerufen wird, wenn eine Datei übernommen werden soll. Der Callback
  erhält die Parameter ``(id, fullName, name, link)`` übergeben.

  * ``id`` ist die ID des ausgewählten Artikels.
  * ``fullName`` ist der anzuzeigende Titel (z. B. "Mein Artikel [1]").
  * ``name`` ist der Artikelname (z. B. "Mein Artikel").
  * ``link`` ist die virtuelle Artikel-URL (z. B. ``sally://1/``).

  Der Name des Callbacks darf keine Punkte enthalten.

* Popups können nun allgemein über ``sly.openCenteredPopup(name, link, width,
  height, extra)`` geöffnet werden. Die Namen ``slymediapool`` und
  ``slylinkmap`` sind für Sally und den Medienpool respektive Linkmap
  reserviert.
* Keine der bisher existierenden JavaScript-Funktionen (``addREX...``, ...)
  wurde übernommen. Alle neuen Funktionen sind Eigenschaften des globalen
  ``sly``-Objekts.

Globale Funktionen
""""""""""""""""""

Die folgenden Funktionen wurden **entfernt** (soweit möglich wurde die
Alternativ-API angegeben):

* ``rex_send_file()`` (durch den :doc:`Asset-Cache </sallycms/assetcache>`
  obsolet)
* ``rex_send_gzip()`` (es wird immer gzip verwendet, soweit möglich)
* ``rex_module_exists()``
* ``rex_execPreSaveAction()`` (Actions werden über :doc:`Frontend-Listener
  </developing/listeners>` umgesetzt)
* ``rex_execPostSaveAction()``
* ``_rex_execSaveAction()``
* ``rex_getActionModeBit()``
* ``rex_deleteCacheSliceContent()``
* ``rex_deleteDir`` (siehe ``sly_Util_Directory->delete()``)
* ``rex_deleteFiles()`` (siehe ``sly_Util_Directory->deleteFiles()``)
* ``rex_create_lang()`` (wurde mit dem ``sly_I18N``-Konstruktor zusammengeführt)
* ``sly_set_locale()`` (wird beim Anlegen eines ``sly_I18N``-Objekts erledigt)
* ``rex_info_block()``
* ``rex_warning_block()``
* ``rex_message_block()``
* ``rex_highlight_string()``
* ``rex_highlight_file()``
* ``_rex_highlight()``
* ``array_flatten()`` (siehe ``sly_Util_Array::flatten()``)
* ``rex_getUrl()`` (URLs können nur noch direkt von Artikel-Models abgerufen
  werden)
* ``rex_param_string()`` (mit ``sly_Util_HTTP::queryString()`` zusammengeführt)

Es wurden keine neuen globalen Funktionen hinzugefügt.

Das Interface der folgenden Funktionen hat sich **geändert**:

* ``rex_send_last_modified()`` kann ohne Timestamp aufgerufen werden und
  verwendet in diesem Fall die aktuelle Zeit (``time()``).
* Der Parameter ``$direction`` in ``rex_moveSlice()`` muss ``up`` oder ``down``
  sein (nicht mehr ``moveup`` bzw. ``movedown``).
* ``rex_slice_module_exists()`` erhielt einen zweiten Parameter (``$clang``),
  um die Existenz von Slices in einer Sprache zu überprüfen. Der Parameter ist
  Pflicht.
* Die Datentypen ``rex-template-id``, ``rex-module-id``, ``rex-action-id``,
  ``rex-slot`` und ``rex-ctype-id`` für ``_rex_cast_var()`` wurden entfernt.

Die folgenden Funktionen sind mit diesem Release **deprecated** und sollten
nicht mehr verwendet werden:

* ``rex_message()`` (siehe ``sly_Helper_Message::message()``)
* ``rex_info()`` (siehe ``sly_Helper_Message::info()``)
* ``rex_warning()`` (siehe ``sly_Helper_Message::warn()``)

Das **Verhalten** der folgenden Funktionen hat sich geändert:

* ``rex_send_article()``: "Dynamische Bereiche" (``<!--DYN-->``) werden nicht
  mehr besonders beachtet und daher bei der Berechnung von ETags nicht mehr
  entfernt. Gleichzeitig wird der HTTP-Header ``Content-MD5`` nicht mehr
  gesendet.
* ``rex_moveSlice()`` wirft im Fehlerfall eine ``sly_Exception`` anstatt einen
  Error auszuösen.

Klassen
"""""""

Die folgenden Klassen wurden **entfernt**:

* ``OOMedia`` wurde durch ``sly_Model_Medium`` ersetzt. Sehr spezielle Methoden
  wie ``toIcon()``, ``toImage()`` etc. wurden nicht übernommen. Die
  `API-Dokumentation <../coco/index.html>`_ beschreibt das neue Interface.
* ``OOMediaCategory`` wurde durch ``sly_Model_MediaCategory`` ersetzt. Die
  `API-Dokumentation <../coco/index.html>`_ beschreibt das neue Interface.
* ``sly_Model_Media_Medium`` wurde in ``sly_Model_Medium`` umbenannt. Ebenso
  wurde mit dem dazugehörigen Service verfahren.
* ``sly_Model_Media_Category`` wurde in ``sly_Model_MediaCategory`` umbenannt.
  Ebenso wurde mit dem dazugehörigen Service verfahren.
* ``OOArticle`` und ``OOCategory`` wurden entfernt. Siehe die dazugehörigen
  Utility-Klassen, um die statischen Getter zu finden (z. B.
  ``sly_Util_Article::findById()``).
* ``sly_Form_FreeformArea`` wurde entfernt, da es sich effektiv nicht von
  ``sly_Form_Container`` unterschied.
* ``sly_Form_Widget`` wurde entfernt, da es keine Basisklasse für die Widgets
  mehr geben muss.
* ``rex_var_globals`` wurde ersatzlos gestrichen.

Die folgenden Klassen wurden **hinzugefügt**:

* die Klassen für den Error Handler

  * ``sly_ErrorHandler_Base``
  * ``sly_ErrorHandler_Development``
  * ``sly_ErrorHandler_Production``
  * ``sly_ErrorHandler`` (Interface)

* Formular-Framework

  * ``sly_Form_Exception``
  * ``sly_Form_Input_Boolean`` als neue Basisklasse für Checkboxen und
    Radiobuttons
  * ``sly_Form_Input_Email`` (HTML5-Element)
  * ``sly_Form_Input_Number`` (HTML5-Element)
  * ``sly_Form_Input_Range`` (HTML5-Element)
  * ``sly_Form_Input_Slider`` (HTML5-Element mit jQuery UI Fallback)
  * ``sly_Form_Input_URL`` (HTML5-Element)
  * Die Widgets (komplexe Elemente, die nicht nur aus einem einzelnen HTML-Tag
    bestehen) wurden umbenannt. Das Suffix ``Button`` wurde jeweils entfernt,
    sodass aus ``sly_Form_Widget_LinkButton`` die Klasse
    ``sly_Form_Widget_Link`` wurde.

* ``sly_Util_ArticleSlice`` kümmert sich um Artikel-Slices.
* ``sly_Util_BootCache`` implementiert den :doc:`BootCache
  </sallycms/bootcache>`.
* ``sly_Util_Slice``
* ``sly_Viewable`` als Basis-Klasse für Controller, Formulare und Layouts

Abgesehen von den hinzugefügten und entfernten Klassen ergeben sich die
folgenden Änderungen an der API:

* ``OOArticleSlice``

  * ``__construct()`` erhielt nach ``$slot`` einen weiteren
    ``$module``-Parameter.
  * ``getArticleSliceById()`` erhielt nach ``$id`` einen weiteren
    ``$clang``-Parameter (Standardwert ``false``).
  * ``getModule()`` wurde deprecated.

* ``sly_Controller_Base``

  * ``setCurrentPage($page)`` wurde ergänzt (dient als Ersatz von
    ``$REX['PAGE']``).
  * Wird in ``factory()`` der Controller für eine Subpage nicht gefunden, wird
    automatisch der Controller für die Hauptseite gesucht und zurückgegeben
    (d.h. wenn ``sly_Controller_Myaddon_Mysubpage`` nicht existiert, wird
    als Fallback ``sly_Controller_Myaddon`` gesucht).

* ``sly_DB_PDO_Driver::getAvailable()`` gibt eine Liste von verfügbaren (d.h.
  in PHP kompilierten) PDO-Treibern zurück.
* ``sly_DB_Dump``

  * ``getCharset()`` wurde entfernt, da alle Dumps in UTF-8 vorliegen. Eine
    ``charset``-Angabe in Dumps wird also ignoriert.
  * Der Platzhalter ``%TEMP_PREFIX%`` für SQL-Dumps steht nicht mehr zur
    Verfügung. ``%USER%`` wird immer unterstützt (wenn niemand eingeloggt ist,
    wird der Platzhalter durch einen leeren String ersetzt).
  * Die Implementierung von ``readQueries()`` wurde durch MIT-lizensiertem Code
    (aus Adminer) ersetzt. Damit werden Dumps auch schneller verarbeitet.

* Die ``render()``-Methoden verschiedener Objekte (Formulare, Tabellen, ...)
  gibt nun konsistent den erzeugten HTML-Code zurück, anstatt ihn teilweise
  selber auszugeben. Es ist daher nötig, immer ``print $obj->render()`` zu
  schreiben.
* Formular-Framework

  * Alle vom Formular-System geworfenen Exceptions sind nun Instanzen von
    ``sly_Form_Exception`` (statt ``sly_Exception``).
  * Der ``$allowedAttributes``-Parameter wurde überall entfernt. Elemente
    unterstützen damit beliebige HTML-Attribute.
  * Der Konstruktor von ``sly_Form`` verlangt nun zwingend die Angabe der
    ``$method``.
  * Die ``render()``-Methode von ``sly_Form`` hat keinen ``$print``-Parameter
    mehr (nur noch den ``$omitFormTag``-Parameter).
  * ``sly_Form_Input_Base`` unterstützt für alle Input-Elemente das
    HTML5-Attribut ``placeholder`` (``->setPlaceholder($str)``).
  * ``sly_Form_Input_Base::setReadOnly()`` hat ``true`` als Standard-Argument
    und kann jetzt ohne Argumente aufgerufen werden.
  * ``sly_Form_Input_Boolean::setChecked()`` hat ``true`` als Standard-Argument
    und kann jetzt ohne Argumente aufgerufen werden.
  * Selects (Checkbox-Gruppe, Radiobutton-Gruppe, DropDowns):

    * ``setValues()`` verlangt zwingend ein Array als Argument.
    * ``removeValue($key)`` wurde hinzugefügt.
    * ``setMultiple()`` wird nur noch für DropDown-Elemente unterstützt und kann
      jetzt ohne Argumente aufgerufen werden.

  * Widgets:

    * Die Basisklasse wurde entfernt (``sly_Form_Widget``).
    * Es werden keine globalen IDs mehr verwendet; die Elemente verwenden die
      ID für ihre erzeugten HTML-Elemente, die auch im Konstruktor der Objekte
      angegeben wurde (kein ``REX_LINK_1`` bzw. ``REX_LINK[1]`` mehr). Der
      Bedarf, die IDs ggf. über Offsets zu verändern, um sie eindeutig zu
      machen, ist damit nicht mehr gegeben.
    * Linklist-Widgets verwenden ebenfalls das Linkmap-Popup und dafür keinen
      Artikelfilter mehr. Der Filter konnte sich nicht durchsetzen und wurde
      daher entfernt.
    * Linklist-Widgets können Artikel mehrmals enthalten.
    * Die angezeigten Werte in den Widgets sind nun informativer:

      * Artikel werden mit ihrem Namen und Dateien mit (wenn vorhanden) ihrem
        Titel angezeigt.
      * Benutzer mit ``advancedMode[]`` sehen bei Links die Artikel-ID und bei
        Dateien den Dateinamen (z.B. "Mein Artikel [12]" und "Logo (logo.png)").

  * ``sly_Form_Base`` (betrifft Formulare, Fieldsets und Slices)

    * ``addElements()`` verlangt zwingend ein Array.
    * ``addRows()`` verlangt zwingend ein Array.
    * ``isMultilingual()`` verlangt zwingend ein Array.

  * ``sly_Form_ElementBase::setDisabled()`` hat ``true`` als Standard-Argument
    und kann jetzt ohne Argumente aufgerufen werden.
  * ``sly_Form_DateTime``

    * ``setWithTime($withTime = true)`` wurde hinzugefügt.
    * Das Element wird, wenn möglich, den nativen HTML5-Datetime-Picker
      verwenden. Das ist bisher nur in Opera 11+ möglich. Alle anderen Browser
      erhalten den bekannten jQuery UI Fallback.

  * ``sly_Form_Fieldset::clearElements()`` wurde in ``::clearRows()`` umbenannt.
  * ``sly_Form_Helper:: getCategorySelect()`` hat einen weiteren Parameter
    ``$addHomepage = true`` erhalten.
  * ``sly_Form_Text::setText()`` wurde hinzugefügt.

* ``addMsg()`` wurde vom Interface ``sly_I18N_Base`` entfernt.
* Models

  * Artikel

    * ``getUrl()`` wurde um ``$divider = '&amp;'``  und ``$disableCache =
      false`` erweitert (da ``rex_getUrl()`` entfernt wurde). ``$disableCache``
      ist nur für den internen Gebrauch durch Sally gedacht.
    * ``hasTemplate()`` wurde hinzugefügt.

  * ``sly_Model_User::hasPerm()`` ist **deprecated** und sollte nicht mehr
    verwendet werden. ``hasRight()`` ist die neue Version.
  * siehe auch die Hinweise zu ``sly_Model_Medium`` und
    ``sly_Model_MediaCategory`` weiter oben

* Services

  * AddOns / Plugins

    * Die beiden Services für AddOns und Plugins wurden weiter vereinheitlicht.
    * ``getDependencies()`` wurde in den Basis-Service verschoben.
    * ``dependencyHelper()`` wurde in den Basis-Service verschoben.
    * ``isRequired()`` wurde in den Basis-Service verschoben.
    * Es können nicht mehr nur Abhängigkeiten zu AddOns, sondern auch zu
      Plugins angegeben werden. Dazu müssen AddOn und Plugin als String mit
      einem Schrägstrich getrennt notiert werden (``myaddon/myplugin``).

  * ``sly_Service_Article::touch()`` wurde hinzugefügt und setzt ``updatedate``
    und ``updateuser`` neu.
  * Factory

    * ``getMediumService()`` wurde hinzugefügt.
    * ``getMediaCategoryService()`` wurde hinzugefügt.

  * Services für Medien und Medienkategorien wurde ergänzt. Siehe die
    `API-Dokumentation <../coco/index.html>`_ für mehr Details.

* Tabellen-Framework

  * ``sly_Table_Column::setIndex()`` wurde hinzugefügt, damit die
    ``render()``-Methode kompatibel zur Basisklasse ist (um
    ``E_STRICT``-Meldungen zu vermeiden).
  * ``sly_Table_Column::setTable()`` wurde ergänzt, um die Bezugstabelle für
    eine Spalte zu setzen.
  * ``setIndex()`` und ``setTable()`` sollten in der Regel nicht von Userland
    Code aufgerufen werden.
  * Tabellen müssen nun durch die Umstellung auf ``sly_Viewable`` als Basis
    wie folgt gerendert werden:

    * Vor dem Rumpf muss ``$table->openBuffer()`` aufgerufen werden.
    * Nach dem Rumpf muss ``$table->closeBuffer()`` aufgerufen werden.
    * Die Ausgabe erfolgt direkt im Anschluss via ``print $table->render()``
      (das ``print`` ist ebenfalls neu in Sally 0.5).

* ``sly_Authorisation``: ``getRights()``, ``getExtendedRights()`` und
  ``getExtraRights()`` wurden hinzugefügt.
* ``sly_Configuration`` wirft bei Problemen Instanzen von ``sly_Exception``
  (anstatt wie bisher teilweise ``Exception``).
* ``sly_Core``

  * enthält die Instanz des aktuellen Error Handlers (``getErrorHandler()``
    und ``setErrorHandler()``)
  * enthält die Instanz des I18N-Objects (``getI18N()`` und ``setI18N()``)
  * siehe Abschnitt über ``$REX`` für die Liste der neu hinzugefügten Methoden,
    um auf Systemkonfigurationen zuzugreifen. Diese sind in jedem Fall dem
    direkten Zugriff via ``sly_Core::config()->get('...')`` vorzuziehen.
  * ``registerListeners()`` dient dazu, die :doc:`Frontend-Listener
    </developing/listeners>` zu registrieren und sollte nicht von Userland Code
    aufgerufen werden.
  * ``getCurrentPage()`` gibt die aktuelle Backend-Seite zurück.

* I18N

  * Der Konstruktor von ``sly_I18N()`` wurde um ``$setlocale = true`` erweitert
    und wird wenn ``true`` dann das Locale setzen, wie es vorher schon
    ``sly_set_locale()`` getan hat. Um dies nachträglich zu erledigen, kann
    auch ``->setLocale()`` aufgerufen werden.
  * Sprachdateien müssen auf ``.yml`` enden.
  * ``addMsg()`` wurde entfernt.

* ``sly_Layout``: Der gesetzte Seitentitel wird automatisch mit ``sly_html()``
  verarbeitet.
* ``sly_Loader::findClass()`` wurde hinzugefügt.
* ``sly_Log::getInstance()`` gibt nun echte Singletons zurück.
* ``sly_Layout_Navigation_Sally`` wurde in ``sly_Layout_Navigation_Backend``
  umbenannt.
* Utilities

  * ``sly_Util_Array::hasget()`` wurde hinzugefügt, um Zugriffe auf die
    Konfiguration zu beschleunigen.
  * ``sly_Util_Array::flatten()`` wurde als Ersatz für ``array_flatten()``
    hinzugefügt.
  * ``sly_Util_Directory::create()`` gibt im Erfolgsfall den Pfad anstatt
    ``true`` zurück.
  * ``sly_Util_Directory::delete()`` wurde hinzugefügt, um ein Verzeichnis
    zu löschen. ``deleteFiles()`` kann nun auch rekursiv arbeiten. ``copyTo()``
    kopiert ein Verzeichnis.
  * ``sly_Util_HTTP::queryString()`` ersetzt ``rex_param_string()``.
  * ``sly_Util_Language::hasPermissionOnLanguage()`` wurde hinzugefügt.
  * ``formatDate()``, ``formatTime()`` und ``formatDatetime()`` wurden
    ``sly_Util_String`` hinzugefügt. Ebenso kam ``escapePHP()`` hinzu.

Backend
"""""""

* Die Basisklasse für Backend-Controller muss nun ``sly_Controller_Backend``
  (statt ``sly_Controller_Sally``) sein. Dies wird dazu führen, dass die meisten
  AddOns, die ein eigenes Backend mitbringen, entweder mit 0.4 oder 0.5
  kompatibel sind, aber nie mit beiden Versionen.
* Assets müssen aufgrund der geänderten Verzeichnisstruktur nun via
  ``../sally/data/dyn/......`` verlinkt werden (man beachte das hinzugekommene
  ``sally/``).
* Das CSS wurde aufgeräumt und einige Klassen haben sich geändert. Alle
  aufzulisten wäre unmöglich -- und auch unnötig, da der Großteil des Markups
  von Sally generiert wird.

Events
""""""

* ``SLY_BOOTCACHE_CLASSES_[FRONTEND|BACKEND]`` wird gefeuert, wenn der
  :doc:`BootCache </sallycms/bootcache>` erzeugt wird.
* "The Events that were formerly known as 'Actions'"

  * Beim Bearbeiten von Slices werden nun Events ausgelöst. Bei den Events
    wird jeweils ``ADD``, ``EDIT`` oder ``DELETE`` als Funktion angenommen.
  * *Vor dem Speichern* eines Slices wird das Event
    ``SLY_SLICE_PRESAVE_[Funktion]`` ausgelöst. Dem Event werden ``module``,
    ``article_id`` und ``clang`` als Parameter übergeben. Das Subject sind die
    Slice-Daten.
  * *Nach dem Speichern* eines Slices wird das Event
    ``SLY_SLICE_POSTSAVE_[Funktion]`` ausgelöst. Dem Event wird
    ``article_slice_id`` als Parameter übergeben. Das Subject ist ein leerer
    String, in dem die Listener ihre Nachrichten (Infos oder Warnungen)
    unterbringen können.

rex_vars
""""""""

* Die Platzhalter wurden jeweils von ``REX_...`` in ``SLY_...`` umbenannt. Dies
  betrifft auch die Speicherung in der Datenbank (siehe weiter oben für das
  SQL-Script, mit dem bestehende Daten aktualisiert werden können).
* Die "Buttons" wurden in "Widgets" umbenannt (siehe oben für die Klassennamen).
  Die Platzhalter lauten damit wie ``SLY_LINK_WIDGET``, ``SLY_LINKLIST_WIDGET``
  etc.
* Die Alternativen für Medien (``REX_FILE_...``) wurden entfernt. Verwende
  ``SLY_MEDIA_...`` stattdessen.
* ``SLY_ARTICLE`` kann nicht mehr auf einzelne Eigenschaften des jeweiligen
  Artikels zugreifen (``SLY_ARTICLE[field=description]``). Das war in Sally
  seit langem nicht mehr möglich und führte daher schon lange zu Fehlern. Jetzt
  wurde der dafür zuständige Code auch entfernt.
* ``REX_MODULE_ID``, ``REX_SLICE_ID``, ``REX_CTYPE_ID``, ``REX_SLOT`` wurden
  entfernt (da ``rex_var_globals`` entfernt wurde).
* ``SLY_LINK`` gibt jetzt die Artikel-ID zurück. ``SLY_LINK_URL`` kann zum
  Zugriff auf die URL verwendet werden.

0.5.0 -> 0.5.1
^^^^^^^^^^^^^^

* Das Styling von Modulen wurde leicht angepasst, insbes. wurde
  ``.rex-form-notice`` in ``.sly-form-helptext`` umbenannt.
* ``rex_send_article()`` kann mit ``$content = null`` aufgerufen werden und wird
  dann alle offenen Output Buffer selber schließen.
* ``sly_Util_String::shortenFilename()`` prüft nicht mehr explizit die Typen der
  übergebenen Parameter (kein ``is_string()`` und dergleichen mehr).

0.5.1 -> 0.5.2
^^^^^^^^^^^^^^

* ``sly_Service_ArticleType::get()`` ist nun public, damit AddOns auf beliebige
  Eigenschaften von Artikeltypen zugreifen können.
* Die Hilfsmethoden zum Zugriff auf Slicewerte (``OOArticleSlice::getValue()``,
  ``::getLink()`` etc.) geben nun die Werte direkt zurück. Vorher war es
  fälschlicherweise nötig, auf dem Rückgabewert selbst (im Modul) noch einmal
  ``->getValue()`` aufzurufen. Siehe Ticket `#3870
  <https://projects.webvariants.de/issues/3870>`_.
* Die Konstanten ``sly_Core::DEFAULT_FILEPERM`` und
  ``sly_Core::DEFAULT_DIRPERM`` entsprechen nun den Konfigurationsdaten (ihre
  Werte wurden vertauscht, sodass ``DIRPERM`` nun ``0777`` und ``FILEPERM`` den
  Wert ``0664`` annehmen). Siehe Ticket `#3867
  <https://projects.webvariants.de/issues/3867>`_.

0.5.2 -> 0.5.3
^^^^^^^^^^^^^^

* Die :file:`cache.php` wurde aus dem Asset-Cache entfernt und durch eine
  direkte Umleitung auf die :file:`index.php` ersetzt. Diese Datei kann also
  gefahrlos gelöscht werden (wird sie auch beim Leeren des Caches).

Da der Asset-Cache geänderte :file:`.htaccess`-Dateien bewusst nicht
überschreibt, wird er die neue Version der Datei nie selber an den richtigen
Platz legen. Man muss daher die Datei :file:`sally/core/install/static-cache/.htaccess`
selber nach :file:`sally/data/dyn/public/sally/static-cache/.htaccess` kopieren.

0.5.3 -> 0.5.4
^^^^^^^^^^^^^^

* ``sly_Table::getSortingParameters()`` hat einen weiteren Parameter erhalten.
  Der neue Parameter ``$tableName`` verhält sich analog zu den getPaging und
  getSearching-Aufrufen und muss als erstes beim Aufruf notiert werden. Das alte
  Interface mit zwei Parametern wird weiterhin unterstützt, ist allerdings ab
  0.6 deprecated. Sie sollte also ab sofort immer wie in
  ``sly_Table::getSortingParameters($tableName, $default, $allowed)`` aufgerufen
  werden.
* ``sly_Log`` kann nun benutzerdefinierte Platzhalter verwenden, die bei dem
  eigentlichen Log-Aufruf als Kontext mit übergeben werden können. Damit können
  auch die Werte von vordefinierten Platzhaltern überschrieben werden. Die
  betroffenen Methoden haben einen zusätzlichen Parameter ``array $context =
  array()`` erhalten.
* hinzugefügt: ``sly_Util_String::getFileExtension($filename)``
* hinzugefügt: ``sly_Util_String::stringify($value)`` zum Ermitteln einer gut
  lesbaren String-Repräsentation eines Wertes

0.5.4 -> 0.5.next
^^^^^^^^^^^^^^^^^

* Das wird die Zeit zeigen...
