Release-Notes
=============

Eine Übersicht über die neuen Features und Verbesserungen gibt der `News-Beitrag
im Sally-Wiki <https://projects.webvariants.de/news/48>`_.

.. note::

  Aufgrund der geänderten :doc:`Verzeichnisstruktur <birdseye>` empfehlen wir,
  bestehende 0.5-Projekte neu anzulegen, anstatt in alten Projekten zu
  versuchen, die Strukturänderungen nachzuahmen. Dies betrifft natürlich nicht
  die Inhalte des Projekts.

Der grobe :doc:`Ablauf eines Updates auf 0.6 <migrate>` wird auf einer extra
Seite beschrieben.

Systemvoraussetzungen
---------------------

Beginnend mit Version 0.6 gestalten sich die Voraussetzungen wie folgt:

* PHP 5.2+ (bisher: 5.1)
* JSON-Support muss in PHP verfügbar sein.
* ``short_open_tags`` wird nicht mehr benötigt.

API-Änderungen
--------------

Im Folgenden werden soweit möglich alle API-Änderungen zwischen dem 0.5- und dem
0.6-Branch beschrieben.

Konfiguration
"""""""""""""

* ``RELOGINDELAY``, ``BLOCKED_EXTENSIONS`` und ``START_PAGE`` wurden in
  statische Konfiguration des Backends überführt (sind aber weiterhin auf die
  gleiche Weise abrufbar).
* ``MEDIAPOOL/BLOCKED_EXTENSIONS`` wurde in statische Konfiguration des Backends
  überführt und in ``BLOCKED_EXTENSIONS`` umbenannt.
* ``USE_MD5`` wurde entfernt.

Globale Variablen
"""""""""""""""""

* Die Konstante ``IS_SALLY`` wurde entfernt.

Datei(system)
"""""""""""""

.. note::

  Siehe dazu auch die :doc:`Verzeichnisstruktur </general/birdseye>`.

* Das :file:`data`-Verzeichnis wurde wieder (wie in Sally 0.4) in das
  Wurzelverzeichnis des Projekts verschoben.
* Alle Funktionssammlungen in :file:`sally/core/functions` wurden entfernt.

Datenbank
"""""""""

* Alle Felder, die ``prior`` im Namen hatten, wurden in ``pos`` umbenannt.
* Es werden getrennte Installationsscripts pro DBMS mitgeliefert. Die
  :file:`user.sql` wurde entfernt.

Die Datenbank kann über die folgenden SQL-Statements aktualisiert werden.
Bestehende Daten gehen dabei nicht verloren.

.. sourcecode:: mysql

  ALTER TABLE `sly_article` CHANGE COLUMN `catprior` `catpos` INT(11) NOT NULL AFTER `catname`;
  ALTER TABLE `sly_article` CHANGE COLUMN `prior` `pos` INT(11) NOT NULL AFTER `startpage`;
  ALTER TABLE `sly_article_slice` CHANGE COLUMN `prior` `pos` INT(11) NOT NULL AFTER `startpage`;

JavaScript
""""""""""

Die in 0.5 eingeführten Erweiterungen wurden noch einmal verfeinert und wie
folgt geändert:

* ``sly.openMediapool(subpage, value, callback)`` nimmt zwei weitere Parameter
  zum Einschränken der Dateitypen und Kategorien entgegen. Beide sind optional.
* ``sly.openLinkmap(subpage, value, callback)`` nimmt zwei weitere Parameter
  zum Einschränken der Artikeltypen und Kategorien entgegen. Beide sind
  optional.
* ``sly.inherit(subClass, baseClass)`` ist nun ein öffentlicher Helper, um zwei
  Prototypen zu verketten (also eine Klasse in JavaScript abzuleiten).
* ``sly.initWidgets(context)`` kann dazu verwendet werden, nachträglich via
  DOM-Operationen eingefügte Widgets zu initialisieren.

Globale Funktionen
""""""""""""""""""

* Die folgenden Typen, die bei ``sly_settype()`` (meistens über ``sly_get()``
  oder ``sly_post()`` genutzt) verwendet werden konnten, wurden entfernt:

  * ``rex-*`` (wurden nicht alle entsprechend validiert und waren daher
    irreführend)
  * ``uinteger``, ``uint``, ``udouble``, ``ufloat``, ``ureal``

* ``rex_send_article()``, ``rex_send_content()``, ``rex_send_last_modified()``
  und ``rex_send_etag()`` wurden entfernt. Die Optionen wurden soweit möglich
  in das ``sly_Response``-Objekt verlegt, das von den Apps zurückgegeben und
  an den Client gesendet wird.
* Slice-Funktionen

  * ``rex_moveSliceUp()`` und ``rex_moveSliceDown()`` wurden entfernt.
  * ``rex_moveSlice()`` wurde in ``sly_Service_ArticleSlice->move()`` verlegt.
  * ``rex_deleteArticleSlice()`` wurde in ``sly_Service_ArticleSlice->deleteById()``
    verlegt.
  * ``rex_slice_module_exists()`` wurde entfernt und durch
    ``sly_Util_ArticleSlice::getModule`` ersetzt

* Artikel-Funktionen

  * ``rex_article2startpage()`` wurde entfernt und durch
    ``sly_Service_Article->convertToStartArticle()`` ersetzt.
  * ``rex_copyContent()`` wurde entfernt und durch
    ``sly_Service_Article->copyContent()`` ersetzt.
  * ``rex_copyArticle()`` wurde entfernt und durch
    ``sly_Service_Article->copy()`` ersetzt.
  * ``rex_moveArticle()`` wurde entfernt und durch
    ``sly_Service_Article->move()`` ersetzt.
  * ``rex_moveCategory()`` wurde entfernt und durch
    ``sly_Service_Category->move()`` ersetzt.
  * ``rex_deleteArticle()`` wurde entfernt und durch
    ``sly_Service_Article->delete()`` ersetzt.

* Cache-Funktionen

  * ``rex_generateAll()`` wurde entfernt und durch ``sly_Core::clearCache()``
    ersetzt.
  * ``rex_deleteCacheArticle()`` wurde entfernt.

* Globals

  * ``_rex_array_key_cast()`` wurde entfernt und durch ``sly_setarraytype()``
    ersetzt.
  * ``_rex_cast_var()`` wurde entfernt und durch ``sly_settype()`` ersetzt.

* Sonstige

  * ``rex_translate()`` wurde durch ``sly_translate()`` umbenannt. Die neue
    Funktion wendet nicht mehr automatisch ``sly_html()`` auf die Übersetzung
    an!
  * ``rex_copyDir()`` wurde entfernt und durch ``sly_Util_Directory->copyTo()``
    ersetzt.
  * ``rex_message()``, ``rex_info()``, ``rex_warning()`` und
    ``rex_split_string()`` wurden entfernt.

Klassen
"""""""

.. note::

  TODO

Backend
"""""""

* Alle CSS-Klassen, die noch ``rex-`` im Namen hatten, wurde in ``sly-``
  umbenannt. Viele Klassen wurden auch entfernt und durch neue ersetzt.
* Assets müssen aufgrund der geänderten Verzeichnisstruktur nun wieder via
  ``../data/dyn/public/......`` verlinkt werden.
* Das mitgelieferte jQuery UI-Theme wurde mehr an das Backenddesign angepasst.
* jQuery wurde auf 1.7.1 aktualisiert, jQuery UI auf 1.8.17.
* Es wurden einige Icons aus den Assets entfernt.
* Die Sprachdateien des Backends wurden in großen Teilen umgebaut. Statt teils
  generischer Keys (``content_function_x``) kommen nun durchgängig sprechende
  Keys (``delete_article``) zum Einsatz. Es sind viele neue Verben hinzugekommen
  und AddOns sollten versuchen, wenn mögliche die mitgelieferten Übersetzungen
  zu verwenden.
* ``sly_App_Backend`` wurde hinzugefügt und übernimmt alle Aufgaben der Backend-
  Anwendung.
* Die ``specials``-Seite wurde in ``system`` umbenannt.
* Beim Installieren von AddOns und Plugins werden diese auch sofort aktiviert.
* Die Linkmap kann auf einzelne Kategorien (auf Wunsch rekursiv) eingeschränkt
  werden. Ebenso können die Artikeltypen vorausgewählt werden. Das Gleiche gilt
  für das Medienpool-Popup (hier natürlich mit Dateitypen statt Artikeltypen).
* Das Markup der Linkmap hat sich in großen Teilen geändert.
* ``sly_Layout_Backend`` leitet sich jetzt von ``sly_Layout_XHTML5`` ab.

  * Dem ``<body>``-Tag werden die Klassen ``sly-0``, ``sly-0_6`` und ``sly-0_6_0``
    hinzugefügt.
  * Die ID des ``<body>``-Tags wurde von ``rex-page...`` in ``sly-page-...``
    umbenannt.
  * Bei ``pageHeader()`` muss nun die Liste der Submenü-Seiten nicht mehr mit
    übergeben werden. Die Navigation wird sich an der Backend-Navigation
    orientieren und die Seiten daher automatisch ermitteln.
  * ``pageHeader()`` erwartet ein Page-Objekt oder ein Array von assoziativen
    Arrays mit den Menü-Daten (früher wurde ein Array von normalen Arrays
    erwartet). Die assoziativen Arrays können die Keys ``page``, ``label``,
    ``forced``, ``extra`` und ``class`` enthalten.

    * ``forced`` (boolean) legt fest, ob der Menüeintrag als aktiv angezeigt
      werden soll.
    * ``extra`` (array) sind weitere Parameter für den Link, die auch bei der
      Ermittlung der aktiven Seite herangezogen werden.
    * ``class`` (string) sind die CSS-Klassen für die erzeugten ``<li>``-Tags.

  * An den generierten Links im Submenü werden die Klassen ``sly-first``,
    ``sly-last`` und ``sly-active`` verwendet.
  * Die Navigation kann direkt von der Layout-Instanz abgerufen werden:
    ``$layout->getNavigation()``

* Die Navigation des Backends wird im Konstruktor von
  ``sly_Layout_Navigation_Backend`` eingerichtet. Backend-Seiten, die nicht im
  Menü zu sehen sind, werden auch nicht mehr der Navigation hinzugefügt.
* ``sly_Layout_Navigation_Backend->createGroup()`` wurde entfernt.
* ``sly_Layout_Navigation_Subpage``-Instanzen können eine Liste von weiteren
  Parametern erhalten. Diese Parameter werden an die URL zum Controller
  angefügt und beim Ermitteln der aktuellen Seite ausgewertet. So ist es
  möglich, mit einem Controller mehrere Backend-Seiten im Menü anzuzeigen (ohne
  dass es zu Konflikten in der Anzeige kommt).

  * neue Methode: ``->getExtraParams()``
  * neue Methode: ``->getForcedStatus()``
  * neue Methode: ``->setExtraParams(array $params)``
  * neue Methode: ``->matches($subpagePageParam, array $extraParams = array())``

* Die AddOn-Verwaltung wurde neu implementiert und nutzt Ajax, um die vielen
  Reloads der Seite zu vermeiden. Damit gehen keine größeren API-Änderungen
  einher.
* Die IDs von Artikeln/Dateien werden nicht mehr für Admins extra angezeigt, da
  es auch kein Benutzerrecht für den "erweiterten Modus" mehr gibt.

Events
""""""

* Das Subject von ``SLY_MEDIAPOOL_MENU`` ist nun das Backend-Seiten-Objekt
  (``sly_Layout_Navigation_Page``) anstatt des Submenüs als Array. Listeners
  müssen die API des Objekts nutzen, um das Menü zu erweitern.
* ``SLY_OOMEDIA_IS_IN_USE`` wurde in ``SLY_MEDIA_USAGES`` umbenannt.
* ``SLY_PAGE_USER_SUBPAGES`` wurde entfernt (AddOns sollten einfach die
  Backend-Navigation entsprechend erweitern).
* ``SLY_SLICE_POSTVIEW_ADD`` wird immer ein leeres Array als Subject übergeben.
* ``PAGE_CHECKED`` wird vom Core ausgeführt und wurde als deprecated markiert.
  Neuer Code sollte eher ``SLY_CONTROLLER_FOUND`` nutzen:
* ``SLY_CONTROLLER_FOUND`` wird ausgeführt, wenn der Controller ermittelt wurde.
  Dem Event wird die Controller-Instanz als Subject übergeben, sowie der Name,
  die App-Instanz und die auszuführende Action als weitere Parameter.

rex_vars
""""""""

* wurden vollständig und ersatzlos entfernt
* ``sly_Slice_Values`` und ``sly_Slice_Helper`` stellen nun die Hilfs-API zur
  Verfügung (siehe Feature-Beschreibung am Anfang der Seite).

Sonstiges
"""""""""

* Die mitgelieferte :file:`.htaccess` enthält nun bereits die Catch-All-Regeln,
  die bisher von realurl-AddOns extra hinzugefügt werden mussten.
