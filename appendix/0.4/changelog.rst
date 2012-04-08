Changelog
=========

0.4.13 (3. Oktober 2011)
------------------------

* Artikel und Kategorien, für die keine Rechte vorhanden sind, werden nicht mehr
  angezeigt.
* Bugfix: Permission-Probleme in der Strukturansicht

0.4.12 (5. September 2011)
--------------------------

* Security-Fix: Asset-Cache konnte beliebige Dateien ausliefern

0.4.11 (27. August 2011)
------------------------

* BabelCache wurde auf v1.2.6 aktualisiert.
* ``sly_Util_Mime`` wurde zum Zugriff auf Mimetypes ergänzt. Über diese Klasse
  ermittelt der Asset-Cache (anhand einer Liste von Dateiendungen) nun den
  Mimetype der auszuliefernden Assets.
* Bugfix: Strict-Warnung in ``sly_Util_HTTP::isSecure()`` korrigiert.
* Bugfix: Sende immer den Content-Length-Header beim Asset-Cache.
* Bugfix: Virtuelle Dateien (ImageResize-Aufrufe) führten zu fehlerhaften
  Content-Type-Angaben.

0.4.10 (23. August 2011)
------------------------

* Der Zugriff auf die beiden Scripts im Projektroot (:file:`rebuild_lang.php`
  und :file:`release.php`) wurde auf die Kommandozeile eingeschränkt, um nicht
  zu Problemen zu führen, wenn sie aus Versehen mit deployed werden.
* Bugfix: Prüfe, ob die Cache-Datei weiterhin existiert (im Asset-Cache), bevor
  sie verarbeitet werden soll. Löst Probleme auf Servern mit seltsamen
  I/O-Settings.
* Bugfix: Der Asset-Cache wurde abermals korrigiert und sollte nun auch den
  nervigsten Clients standhalten, indem auch beim ersten Request auf eine Datei
  keine Weiterleitungen mehr verwendet werden.

Die letzte Änderung macht es erforderlich, bei bestehenden Projekten mehr als
nur die Sally-Dateien zu überschreiben. Siehe dazu die
:doc:`Upgrade-Hinweise <bc-breaks>`.

0.4.9 (19. August 2011)
-----------------------

* AddOns, die aktive Plugins haben, können nicht mehr deaktiviert werden.
* Bugfix: Der Asset-Cache wurde für den Einsatz im IE wieder einmal korrigiert.

0.4.8 (10. August 2011)
-----------------------

* BabelCache wurde auf Version 1.2.5 aktualisiert. Damit wurde der
  Dateisystem-Cache weiter stabilisiert.
* Bugfix: Geschützte Assets funktionierten nicht auf Servern ohne mod_headers.

0.4.7 (3. August 2011)
----------------------

* ``FILEPERM`` und ``DIRPERM`` werden nun konsequenter von Sally für erzeugte
  Dateien und Verzeichnisse verwendet.
* Fehler, die in Modulen auftreten, werden von der Content-Seite abgefangen und
  ausgegeben.
* Bugfix: Assets wurden vom IE7/IE8 nicht beim ersten Aufruf geladen (`#3711
  <https://projects.webvariants.de/issues/3711>`_).
* Bugfix: CSS-Fix für überlange (tiefe) Strukturen
* Bugfix: ``sly_Util_Article::isSiteStartArticle()`` und
  ``sly_Util_Article::isNotFoundArticle()`` sollten statisch sein.
* Bugfix: SQL-Fehler in ``OOArticleSlice::getNextSlice()`` und
  ``OOArticle::getPreviousSlice()``

0.4.6 (14. Juli 2011)
---------------------

* `BabelCache <https://projects.webvariants.de/projects/babelcache>`_ wurde auf
  Version 1.2.1 aktualisiert und enhält damit einen stabileren
  Dateisystem-Cache, der nun ebenfalls Locking verwendet.
* ``sly_Util_Navigation``:

  * Das aktuelle Element erhält die Klasse ``active`` und wrappt seinen Text in
    ein ``<span>``-Element.
  * Die Klasse ``first`` wurde entfernt (``:first-child`` kann für den gleichen
    Effekt genutzt werden).
  * Außerdem wurde die Nummerierung der ``page``-Klassen korrigiert.

* ``sly_Util_Pager`` erlaubt eine leere Liste von GET-Parametern.
* ``sly_Table`` erlaubt es, die Caption zu überschreiben.
* Das ``develop/actions``-Verzeichnis wird bei der Installation nicht mehr
  erzeugt (#3407).
* Die ``globals.yml`` eines AddOns wird bereits während der Installation
  geladen, damit die darin enthaltenen Informationen bereits zugänglich sind.
* Bugfix: Die Warnmeldung über ein zu niedriges Memory Limit im Setup war
  falsch.
* Bugfix: Die Eingabefelder beim Anlegen von neuen Medienkategorien waren
  fehlerhaft positioniert.
* Bugfix: Plugins, die AddOns benötigten, konnten nicht installiert werden.
* Bugfix: ``sly_Util_HTTP`` ermittelt die Basis-URL auch über ``::getHost()``.
* Bugfix: Fehler über bereits existierende Verzeichnisse im Asset-Cache werden
  unterdrückt. Trat auf, wenn PHP mit FastCGI arbeitet und mehrere
  Child-Prozesse gleichzeitig den Cache aufbauen.

0.4.5 (24. Juni 2011)
---------------------

* Der Asset-Cache wird beim Leeren des Caches die ``.htaccess``-Dateien nicht
  mehr entfernen. Diese Änderung war nötig, da auf manchen Hostern (***hust***
  1&1 ***hust***) die Dateien noch einmal angepasst werden müssen.
* AddOns werden geladen, bevor der Asset-Cache revalidiert und das
  ``develop``-Verzeichnis synchronisiert werden (Backend). Damit sind Frontend
  und Backend in der Ladereihenfolge identisch.
* Bugfix: Dateien, die im Medienpool verschoben/gelöscht wurden, wurden nicht
  aus dem Cache entfernt.
* Bugfix: Das Handling von geschützten Dateien im Asset-Cache wurde verbessert.
  Gleichzeitig wird beim Verschieben/Löschen von Dateien der Asset-Cache
  revalidiert.
* Bugfix: Beim Locking von YAML-Dateien wurde die falsche Datei gelockt. Die
  Korrektur sollte hoffentlich das Problem, dass sporadisch die gesamte
  Konfiguration von Sally gelöscht wird, beheben.
* Bugfix: Benutzerrechte wurden bei Nicht-Admins innerhalb von Kategorien nicht
  korrekt verarbeitet.
* Bugfix: MacRoman wurde aus der Liste der Encodings wieder entfernt.
* Bugfix: PHP erlaubt keine 4xx-Header bei Weiterleitungen, daher wurde der mit
  0.4.4 eingeführte HTTP401-Statuscode bei Weiterleitungen wieder entfernt.
* weitere kleinere Korrekturen am Backend-HTML sowie dem Navigation-Utility
  (``sly_Util_Navigation``)
* Neu: Nach dem Synchronisieren des develop-Verzeichnisses wird das Event
  ``SLY_DEVELOP_REFRESHED`` ausgeführt.

0.4.4 (9. Juni 2011)
--------------------

* Der Asset-Cache wird vor den AddOns intialisiert, damit der Scaffold-Prozessor
  zuerst ausgeführt wird.
* Artikeltypen und Module werden alphabetisch sortiert.
* ``sly_Util_Session::start()`` prüft nun auch den Rückgabewert von
  ``session_id()``.
* Hilfetexte von Formularelementen werden durch ``rex_translate()`` geschickt.
* Bugfix: Der Slice-Cache wurde beim Kopieren von Inhalten nicht geleert.
* Bugfix: ``iconv()`` auf Mac-Rechnern machte im Medienpool Probleme und
  resultierte in leeren Dateinamen.
* Bugfix: ``sly_Service_Article->findArticlesByCategory()`` behandelt nicht
  vorhandene Kategorien besser.
* Bugfix: DateTime-Formularelemente mit Timepicker funktionierten nicht mehr.
* API: ``sly_I18N::getLocales()`` ist nun ``static``.

0.4.3 (2. Juni 2011)
--------------------

* Der Asset-Cache wird auch im Backend nur noch dann synchronisiert, wenn der
  Entwicklermodus aktiviert ist.
* Weiterleitungen in ``sly_Util_HTTP`` können auch mit 401 Statuscode gesendet
  werden.
* Das Verzeichnis develop/config wird nicht mehr by default erzeugt.
* Die Konfiguration wurde in Projekt- und Lokal-Konfiguration aufgetrennt, um
  klarer zu definieren, welche Settings lokal und welche projektübergreifend
  sind.
* PDF- und JPEG-Dateien werden jetzt auch im Asset-Cache abgelegt.
* Bugfix: Der Content-Type wurde im Backend nicht korrekt gesetzt.
* Bugfix: Das Scaffold-Mixin text-overflow war fehlerhaft.
* Bugfix: Der Artikeltyp wird nun korrekt in allen Sprachen gleichzeitig
  geändert. Dies behebt insbesondere bei der Verwendung von MetaInfo einige
  Probleme.
* Bugfix: Im Benutzerformular konnten keine Kategorien/Medienkategorien
  ausgwählt werden.
* Bugfix: Fehlende/falsche Datenbank-Konfiguration störte den Asset-Cache. Dies
  führte zu ungestylten Setup-Seiten.
* Bugfix: Beim Leeren des Caches wurde der Asset-Cache nicht korrekt
  re-initialisiert. Die erzeugte Seite war dann für einen Aufruf ungestylt.
* Bugfix: Server-Komprimierung wird für Dateien im Asset-Cache explizit
  abgeschaltet.
* Bugfix: Thumbnails im Medienpool funktionierten nicht, wenn Image-Resize
  aktiviert war.
* Bugfix: "select all" im Medienpool funktionierte nicht.
* Entfernt: ``TEMP_PREFIX`` (Konfiguration)
* Hinzugefügt: ``sly_Util_HTTP::getHost()`` und ``sly_Util_HTTP::isSecure()``

0.4.2 (28. Mai 2011)
--------------------

* :doc:`Asset-Cache </core-api/assetcache>` zur Entlastung des Servers
* jQuery wurde auf 1.6.1 aktualisiert (löst Probleme mit dem Linklist-Button)
* Bugfix: Das Styling von Linklist-Buttons war fehlerhaft.
* Bugfix: Fehlermeldungen beim Leeren des Slice-Caches wurden behoben.
* Bugfix: Alle ``revision``-Spalten in der Datenbank sind nun auf ``DEFAULT 0``
  gesetzt.
* Bugfix: Fehlender I18N-String (en_GB) bei der AddOn-Installation ergänzt.
* Bugfix: Fehlendes ``alt``-Attribut im Medienpool hinzugefügt.
* Bugfix: :doc:`Scaffold </frontend-devel/scaffold>` brach mit einem Error ab, wenn
  in einer CSS-Property ein Entity vorkam.

0.4.1 (18. Mai 2011)
--------------------

* ``$article`` ist nun auch in Modulen mit dem aktuellen Artikel vorbelegt.
* ``sly_Util_Language::getLocale()`` gibt das aktuelle Locale zurück.
* Der ``sly_Loader`` verwendet explizites Locking, um Problemen beim Erstellen
  des Pfadcaches vorzubeugen.
* jQueryUI Sortable und Widget wurden hinzugefügt.
* ``sly_Core::getCurrentArticle()`` gibt den aktuellen Artikel und
  ``sly_Core::getCurrentLanguage()`` gibt die aktuelle Sprache (als Objekt!)
  zurück.
* jquery.imgcheckboxes ersetzt das unter GPL lizensierte jquery.checkimg-Plugin.
  Außerdem ist es nun jQuery 1.6 kompatibel. Löst Probleme mit mehrsprachigen
  Formularelementen.
* ``sly_Model_User->hasCategoryRight()`` und
  ``sly_Model_User->hasStructureRight()`` wieder hinzugefügt.
* ``SLY_SETTINGS_UPDATED`` wird als notify-Event gefeuert, wenn die
  Systemeinstellungen aktualisiert wurden.
* Neue Events: ``SLY_ART_TO_STARTPAGE``, ``SLY_ART_CONTENT_COPIED``,
  ``SLY_ART_MOVED`` und ``SLY_CAT_MOVED``
* Bugfix: Löschen von Dateien im Medienpool konnte fehlschlagen.
* Bugfix: Datenbankimporte auf Servern mit extrem seltsamen
  PHP/MySQL-Konfigurationen wurden behoben.
* Bugfix: Viele API-Calls auf veraltete Methoden wurden angepasst oder entfernt.
* Bugfix: Der Startartikel einer Kategorie konnte nicht umbenannt werden.
* Bugfix: Anzeige der ID im erweiterten Modus der Strukturansicht war fehlerhaft.
* Bugfix: Artikel zum Startartikel machen funktionierte nicht.
* Bugfix: Artikel verschieben funktionierte nicht.
* Bugfix: Übernehmen von Sliceinhalten zeigte nicht wieder das Eingabemodul an.
* Bugfix: Die Kategorieauswahl beim Verschieben von Kategorien zeigte nicht
  immer die korrekte Sprache an.
* Bugfix: Caching-Probleme bei ``article2startpage`` behoben.
* Bugfix: Nicht-Admins hatten Probleme beim Login und sahen die Strukturansicht
  nicht.
* Bugfix: Verbesserungen bei den Events ``CLANG_ADDED`` und ``CLANG_DELETED``.
* Bugfix: Es wurden zu viele Sonderzeichen beim Versenden von Mails entfernt.
* Bugfix: Das Anlegen von Kategorien erzeugte fehlerhafte Pfadangaben in der
  Datenbank.
* Bugfix: Locale-Probleme beim Verwenden von ``getMediaCategorySelect()``.
* Entfernt: ``sly_Core::getTempDir()`` (fehlerhaft und ungenutzt)

0.4.0 (6. Mai 2011)
-------------------

* Major Feature Release, siehe `Newsbeitrag
  <https://projects.webvariants.de/news/37>`_
