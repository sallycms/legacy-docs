Changelog (Legacy)
==================

0.3.11 (28. Juni 2011)
----------------------

* Bugfix: Der Slice-Cache wurde nach einer gewissen Zeit nicht mehr korrekt
  geleert, wenn Änderungen an Artikeln vorgenommen wurden.
* Bugfix: Beim Locking von YAML-Dateien wurde die falsche Datei gelockt.

0.3.10 (1. Juni 2011)
---------------------

* Bugfix: Content-Type wurde im Backend fehlerhaft gesetzt (führte zu Problemen
  im Internet Explorer)

0.3.9 (11. Mai 2011)
--------------------

* Explizites Locking beim Lesen und Schreiben der Konfiguration.
* Explizites Locking beim Cachen der Autoloader-Pfade.
* Bugfix: Das opacity-Mixin aus Scaffold enthielt Fehler.

0.3.8 (25. April 2011)
----------------------

* Conditional Comments werden im XHTML-Kopf beim Einbinden von JavaScript
  erkannt.
* Inline JavaScript wird in CDATA-Blöcken ausgegeben.
* Linkbuttons können Strings als Identifier verwenden.
* ``bg-gradient-linear``-Mixin für Scaffold
* Bugfix: Die Parameter in ``SLY_CONTENT_UPDATED`` werden korrekt übergeben.
* Bugfix: ``OOArticleSlice::getFirstSliceForArticle`` funktionierte nicht.
* Bugfix: Strict-Warning in ``rex_backend_login``
* Bugfix: Arrays wurden in ``sly_Configuration`` nicht korrekt gemerged.
* Bugfix: Direktaufrufe des NotFound-Artikels erzeugten unter Umständen falsche
  HTTP-Statuscodes.
* Bugfix: ``If-Modified-Since`` wurde in der ``gzip.php`` nicht erkannt.
* Bugfix: Caching-Daten von Scaffold wurden nicht korrekt geschrieben.
* Bugfix: Probleme beim Einrichten der Datenbank während der Installation
  sollten nun der Vergangenheit angehören.

0.3.7 (29. März 2011)
---------------------

* jQuery wurde auf 1.5.1 aktualisiert.
* ``setTransitional`` für Layouts kann nun public aufgerufen werden.
* ``sly_Util_HTML::buildAttributeString`` erlaubt die Angabe benötigter
  Attribute (die nicht ausgelassen werden, selbst wenn sie leer sind, z.B. für
  ``<img alt="" ... />``).
* ``sly_Form_ElementBase`` erlaubt generische HTML5-Attribute (beginnend mit
  "data-").
* Performance-Verbesserung für das Kopieren von Artikeln.
* Bugfix: ``isset()`` warf bei Memcached-Caches eine Notices.
* Bugfix: Fix für das unsinnige Verhalten von APC bei ``apc_store()``.
* Bugfix: Scaffold-Extensions wurden nicht korrekt geladen.
* weitere kleinere Korrekturen

0.3.6 (5. März 2011)
--------------------

* jQuery wurde auf 1.5 Final aktualisiert.
* Encoding-Probleme im Medienpool gehören der Vergangenheit an.
* Backend-Seiten werden nun immer gzip-komprimiert ausgeliefert.
* Es werden mehr Frontend- wie auch Backend-Assets durch die ``gzip.php``
  geschickt. Auf Wunsch kann die gzip.php die komprimierten Dateien auch cachen.
* ``short_open_tags=Off`` stört nun den Setupvorgang nicht mehr.
* Die Performance von ``sly_Configuration`` (und damit ``sly_Util_Array``) wurde
  verbessert, ebenso wurden einige andere Klassen weiter optimiert.
* Die Performance des Dateisystem-Caches wurde verbessert.
* Bugfix: Die Thumbnails im Medienpool wurden fehlerhaft verkleinert.
* Bugfix: Das Kopieren von Artikeln war fehlerhaft.
* Bugfix: Labels von Formularelementen wurden 2x mit ``sly_html`` behandelt.

0.3.5 (26. Januar 2011)
-----------------------

* In MediaListButtons kann eine Datei nun mehrfach enthalten sein.
* Die Widgets in Modulen (SLY_ARTICLE_BUTTON, ...) werden nun auch von sly_Form
  gerendert und erzeugen keine Konflikte mehr mit Metainfos.
* Das Sally-CSS wird bei der Installation pre-compiled und nicht mehr durch die
  scaffold.php geroutet.
* Die Installation unter MySQL 5.5+ ist nun möglich (
  `TYPE=... wurde zu ENGINE=... <http://dev.mysql.com/doc/refman/5.5/en/create-table.html>`_).
* Das mitgelieferte jQuery wurde auf `1.5 RC1
  <http://blog.jquery.com/2011/01/24/jquery-15rc-1-released/>`_ aktualisiert.
* Bugfix: Passwörter mit Quotes funktionierten nicht.
* Bugfix: Gelöschte Templates/Module wurden nicht erkannt.
* Bugfix: Verzeichnisrechte wurden nicht überall korrekt verarbeitet.
* weitere kleine Anpassungen

0.3.4 (13. Januar 2011)
-----------------------

* Plugins können eigene Backend-Seiten im Hauptmenü anlegen.
* Die Abhängigkeiten zwischen AddOns werden nun an mehr Stellen überprüft und
  spiegeln sich auch im Backend besser wider.
* Exceptions können nun nicht nur in der AddOn-Installation, sondern auch bei
  der Deinstallation sowie bei Plugins genutzt werden.
* AddOns und Plugins werden im Backend nun korrekt sortiert ausgegeben.
* ``develop/lib`` ist nun der erste Pfad im Autoloader.
* Der Cache des Autoloaders wurde weiter optimiert und kann nun auch über das
  Backend geleert werden.
* Aus ``MEDIA_LIST_QUERY`` wurde ``SLY_MEDIA_LIST_QUERY``.
* Bugfix: ``sly_Util_Directory::listRecursive()`` arbeitete fehlerhaft, wenn mit
  relativen Pfaden aufgerufen.
* Bugfix: ``sally://``-URLs wurden nicht korrekt erkannt.
* Bugfix: Mehrere Linklist-Elemente auf einer Seite führten zu Problemen.
* weitere kleine Anpassungen

0.3.3 (29. Dezember 2010)
-------------------------

* Auf der Systemseite kann die Frontend-Synchronisation aktiviert werden. Dabei
  werden Templates/Module auch im Frontend bei jedem Request auf Änderungen
  überprüft.
* ``sly_Form_Freeform`` kann CSS-Klassen bekommen.
* Sally bringt nun ein erstes, experimentelles Formularelement für Artikellisten
  mit.
* Bugfix: Fehlende i18n-Einträge beim SQL-Importer ergänzt.
* Bugfix: Mehrsprachige Formulare machten auf einsprachigen Seiten Probleme.

0.3.2 (10. Dezember 2010)
-------------------------

* ``SLY_CONTENT_UPDATED`` wird jetzt nach jeder Änderung an Slices aufgerufen
  (#1197).
* Die Mediabuttons und Medialistbuttons funktionieren wieder (#1200 und #1201).
* Das 3sekündige Zeitlimit für alle Requests wurde entfernt (Debugging-Code im
  Cache-System, der durchgerutscht ist).
* Fehlende Icons für sly_Table wurden ergänzt.
* Die fehlende Übersetzung für einige Einstellungen auf der Systemseite wurde
  ergänzt.
* ``sly_Cache::generateKey()`` wirft keine Fehler mehr bei leeren Arrays.
* Bei der Re-Installation von AddOns wird die Konfiguration ausgewertet, falls
  das AddOn nicht aktiviert war.
* weitere kleinere Änderungen kosmetischer Natur

0.3.1 (16. November 2010)
-------------------------

* ``sly_Layout_Navigation_Page->addSubpages()`` ergänzt.
* Die Slot-Leiste wird nicht mehr angezeigt, wenn das Template nur einen Slot
  besitzt.
* Eine rudimentäre Unterstützung für Updates von AddOns wurde implementiert.
* Der implizite Standard-Slot eines Templates hat nun den Key ``default``
  (#1162).
* Bugfix: ``OOArticle::exists()`` hat Slicedateien für Artikel gehalten.
* Bugfix: Inhalte konnten nicht kopiert werden.
* Bugfix: Slices wurden im Backend in jedem Slot angezeigt (#1121).
* entfernt: ``rex_tabindex()``, ``rex_is_avsuite()``, ``rex_call_func()``,
  ``rex_addslashes()`` und ``_rex_deleteArticle()``
* weitere kleinere Korrekturen

0.3 (29. Oktober 2010)
----------------------

* *Templates und Module* werden in Dateien verwaltet und bieten eine
  :doc:`umfangreiche API </frontend-devel>`. *Actions* wurden aus diesem
  Release entfernt, da wir sie später von Grund auf neu implementieren wollen.
* Das Verzeichnis *redaxo* wurde in *sally* umbenannt.
* Die Projektkonfiguration liegt ebenfalls in einer YAML-Datei und muss so nicht
  mehr bei jedem Request aus der Datenbank abgerufen werden.
* *sly_Cache* speichert Daten transparent in Memcache / XCache / APC / Zend
  Server / eAccelerator / Dateisystem. AddOns können den Systemcache
  gleichberechtigt nutzen.
* *Artikelslices* werden nicht mehr als verkettete Liste, sondern einfach
  durchnummeriert in der Datenbank gespeichert.
* *sly_Form* übernimmt die Erzeugung sämtlicher Formulare im Backend.
  Mehrsprachige und -spaltige Formulare sind nun nativ über ein einheitliches
  Interface zugänglich. Ein gutes Stück des CSS-Codes konnte damit entfernt
  werden.
* Sprachdateien müssen in *YAML* verfasst werden und werden automatisch als
  PHP-Code gecached.
* AddOns werden in Reihenfolge ihrer Abhängigkeiten geladen. Über ``requires``
  kann ein AddOn eine Liste von Abhängigkeiten angeben, die auch bei der
  Installation automatisch geprüft werden.
* *sly_Loader* cached die Pfade zu bekannten Klassen, um in späteren Requests
  nicht alle möglichen Load-Pfade abtesten zu müssen.
* *Coco* erzeugt die API-Dokumentation.
* Bis auf die Struktur- und Content-Seite wurden alle Backend-Seiten in das
  Sally-MVC überführt.
* *sly_Log* hat Log-Rotation und benutzerdefinierte Log-Locations gelernt.
* ``$REX['PAGES']`` wurde durch *sly_Layout_Navigation* ersetzt. Die Links im
  AddOn-Menü werden nun automatisch sortiert.
* AddOns können im Backend nicht mehr gelöscht werden.
* Die Assets von AddOns (JS/CSS/Bilder) müssen nun im Verzeichnis *assets*
  (statt -files-) liegen. CSS-Dateien werden automatisch mit *CSScaffold*
  verarbeitet und gecached.
* ``PERM`` und ``EXTPERM`` können in der static.yml eines AddOns gesetzt werden.
* Die Salts, die beim Hashen der Benutzerkennwörter verwendet werden, sind nun
  abhängig von der Benutzer-ID (und nicht mehr von der Installations-ID).
* Die drei Standard-AddOns (Import/Export, Image Resize und BE Search) werden in
  eigenen Repositories verwaltet.
* Die JavaScript-Variablen ``redaxo``, ``sally`` und ``pageloaded`` wurden
  entfernt. jQuery ist im Backend auch als ``$`` verfügbar.
* rex_form (= alle Formularklassen), rex_list, rex_template und rex_navigation
  wurden entfernt.
* Der *YUI Compressor* kommt nun zum Einsatz, um das JavaScript von Sally zu
  komprimieren.

0.2.9 (29. Dezember 2010)
-------------------------

* CSS/JS-Dateien werden nicht mehr mehrfach ausgegeben, wenn sie mehrfach in den
  HTML-Kopf eingefügt wurden.
* Backend-Seiten werden mit robots=noindex,nofollow als Metatag ausgeliefert.
* Bugfix: Das Löschen nicht-existierender AddOn führte zu Fehlern.
* Bugfix: Die Transparenz von GIF-Dateien wurde nicht korrekt verarbeitet.

0.2.8 (31. Oktober 2010)
------------------------

* Korrigiert nur einen Syntaxfehler, der in die 0.2.7 gerutscht ist.

0.2.7 (31. Oktober 2010)
------------------------

* ``ART_META_UPDATED`` wird nicht mehr fälschlicherweise bei jedem Aufruf der
  Metaseiten von Artikeln ausgeführt. [Christoph]
* ``REX_SQL_INIT`` wird nicht mehr bei jedem Request in die Konfiguration
  geschrieben. [Zozi]
* MediaListButtons können wieder komplett geleert werden. [Christoph]
* ImageResize wurde auf v1.6.2 aktualisiert. [Robert]
* ``OOMedia::_getDate()`` wurde ``public``, da ``OORedaxo`` sie nutzt.
  [Christoph]
* Scaffold und der URL-Laufzeitcache von Sally funktionieren zuverlässiger unter
  PHP 5.1. [Christoph]
* Der Standard-URL-Rewriter erlaubt alle Zeichen in einer URL. [Christoph]
* weitere kleinere Korrekturen

0.2.6 (1. Oktober 2010)
-----------------------

* Im Medienpool fanden einige kleinere Korrekturen statt. [Christoph]
* Die JavaScript-IDs für Widgets (Linkbuttons, Mediabuttons, ...) sind nun
  optional. Damit ist es einfacher möglich, in einem Formular mehrere Widgets
  einzubauen. Außerdem wurden die Widgets grundlegend aktualisiert und sollten
  nun endlich funktionieren. [Christoph]
* ``sly_Form_Textarea`` erzeugt ``textarea``-Elemente mit rows/cols-Angabe.
  [Christoph]
* Der Datetime-Picker (``sly_Form_DateTime``) wurde erneuert und bringt nun sein
  eigenes jQueryUI inkl. Skin mit. [Christoph]
* Bugfix: Der Cache von Artikellisten wird korrekt geleert. [Christoph]
* Wird auf ein nicht-existentes Bild via ImageResize gezeigt, so wird nun keine
  Warning mehr erzeugt und stattdessen das Fehlerbild mit dem korrekten Status
  (404) zurückgeliefert. [Dave]
* GLOB_BRACE wurde entfernt, da es `auf einigen Systemen nicht funktionierte
  <http://php.net/manual/en/function.glob.php#notes>`_ (Solaris). [Dave]
* Bugfix: Der Breadcrumb-Pfad von Kategorien ab der 4. Ebene war fehlerhaft.
  [Christoph]
* Kleinere CSS-Anpassungen für den IE7. [Christoph]

0.2.5 (9. September 2010)
-------------------------

* Der Medienpool hat viele UI-Fixes erhalten. [Christoph]
* OOMedia::fileExists() wurde verbessert. [Dave]
* Die letzten Überreste von MAXLOGINS und login_tries wurden entfernt.
  [Christoph]
* Bugfix: Die Rewrite-Regeln für den ImageResize-Cache wurden verbessert. [Dave]
* Bugfix: Die Namen der System-Permissions waren falsch. [Dave]
* Bugfix: Im JavaScript für den RexLinkbutton traten Fehler auf. [Zozi]
* Bugfix: Der Systemcache wurde nach dem Hinzufügen einer Kategorie nicht
  korrekt geleert. [Christoph]
* Bugfix: Beim Cachen von Artikeln konnte es passieren, dass die Slices
  fehlerhaft gecached wurden. [Dave]
* Bugfix: Wenn keine Berechtigungen für eine Kategorie bestanden, wurde noch die
  bottom.php versucht einzubinden. [Christoph]

0.2.4 (27. August 2010)
-----------------------

*(Primär wegen der Veränderung in sly_Configuration veröffentlicht.)*

* Die Accountsperre nach N fehlgeschlagenen Logins wurde entfernt. (Backport aus
  dem Trunk) [Zozi]
* ImageResize wurde teilweise refactored. (v1.5) [Robert]
* Der Link-Button funktioniert wieder. (Backport aus dem Trunk) [Stephan]
* Die Konfiguration wird nur bei Änderungen neu geschrieben (verbessert die
  Stabilität bei vielen parallelen Requests). [Dave, Zozi, Christoph]

0.2.3 (24. August 2010)
-----------------------

* viele CSS-Fixes
* Plugins können wieder deinstalliert werden.
* Fixed: Benutzer konnten sich erst ab dem zweiten Versuch einloggen.
* leichte Verbesserungen im Medienpool (primär codeseitig)
* MOD_REWRITE kann wieder im Backend konfiguriert werden.
* Security Fix: Das Backup-Verzeichnis des Import/Export-AddOns wurde nicht
  gegen Zugriffe via HTTP geschützt.

0.2.2 (1. August 2010)
----------------------

* Dem <body>-Element werden die CSS-Klassen "sally" und "sallyYZ" (im Moment
  also sally02) hinzugefügt. Damit wird es wesentlich einfacher,
  Sally-spezifisches CSS zu entwickeln und dabei nur eine CSS-Datei zu
  verwenden.
* Die Datenbank und die Tabellen werden explizit als UTF-8 angelegt.
* AddOns können besser über Symlinks eingebunden werden.
* kleinere Bugfixes

0.2.1 (26. Juli 2010)
---------------------

* CSS-Fix für die Anzeige deaktivierter Selectboxen
* Bugfix: Neu angelegte Benutzer konnten sich nicht einloggen.

0.2 (23. Juli 2010)
-------------------

* neuer Backend-Skin
* unzählige Bugfixes
* ...
* TABLE_PREFIX wurde in DATABASE/TABLE_PREFIX umbenannt.
* Setup-Routine erneuert
* AddOn-Namen müssen explizit mit translate: gekennzeichnet werden, um übersetzt
  zu werden.
* sly_Event_Dispatcher übernimmt und erweitert das Extension-Point-Konzept
* sly_Layout übernimmt im Backend den Aufbau der XHTML-Seiten
* rex_tabindex() deaktiviert
* ``include/generated`` wurde nach ``data/dyn/internal/sally`` verlegt.
* erste Gehversuche mit UnitTests
* Refactoring der REDAXO-Bibliothek in das Schema des sly_Loader
* Magic Quotes werden entfernt, anstatt explizit hinzugefügt zu werden
