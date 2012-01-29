Changelog 0.5-Branch
====================

0.5.9 (6. Januar 2012)
----------------------

* Bugfix: Beim Löschen einer Medienkategorie wurde der Cache nicht korrekt
  geleert.
* Bugfix: Beim Löschen einer Sprache wurden die dazugehörigen Artikelinhalte
  nicht gelöscht.
* Bugfix: Bei Artikel-Operationen in der Strukturansicht wurden nicht alle
  Positionsangaben und Cacheinhalte korrekt erneuert.

0.5.8 (14. Dezember 2011)
-------------------------

* jQuery wurde auf 1.6.4 aktualisiert (bewusst die letzte 1.6.x Version). Das
  mitgelieferte Frontend-jQuery wurde hingegen (da nur für neue Projekte
  relevant) auf 1.7.1 aktualisiert.
* Das ``xmlns``-Attribut wurde von XHTML5-Heads entfernt.
* BabelCache wurde auf 1.2.10 aktualisiert. Dies behebt einige Probleme mit
  nicht-rekursiven Flushes (z.B. beim Löschen von Slices).
* Bugfix: Sprachen wurden nicht korrekt gelöscht.
* Bugfix: Kopieren von Inhalten zwischen Sprachen funktionierte nicht.
* Bugfix: Medienpool- & Linkmap-Popups funktionierten im IE8 nicht mehr.
* Bugfix: Beim Verschieben von Artikeln auf die Position des Startartikels einer
  Kategorie wurden nicht alle betroffenen Artikel aus dem Cache entfernt, sodass
  "doppelt vergebene" Positionen auftraten.

0.5.7 (6. Dezember 2011)
------------------------

* Bugfix: Bei vielen parallelen Requests auf den Asset-Cache wurde unter
  Umständen falsches CSS erzeugt.

0.5.6 (1. Dezember 2011)
------------------------

* Der Code, der die Verzeichnisse für dynamische Inhalte erstellt, wurde
  grundlegend überarbeitet und sollte nun schneller und wesentlich zuverlässiger
  arbeiten. Auf Servern mit problematischen Dateirechten werden klare
  Fehlermeldungen erzeugt, anstatt mit Stacktraces auszusteigen.
* BabelCache wurde auf Version 1.2.9 aktualisiert. Das Update behebt Probleme
  mit dem SQLite-Cache sowie dem Locking in allen Cache-Strategien.
* Popups können mehrfach geöffnet werden. Das bedeutet, dass mehrere Linkmaps
  offen sein können oder das vom Medienpool aus ein weiterer Medienpool geöffnet
  werden kann.
* ``sly_Util_Article::findByType()`` wurde hinzugefügt und erlaubt das einfache
  Auflisten von Artikeln bestimmter Typen (News, Jobs, ...).
* JavaScript (Dateien und Code) kann nun im XHTML-Layout vor dem schließenden
  ``</body>``-Tag platziert werden (dazu wurde
  ``sly_Layout_XHTML::putJavaScriptAtBottom()`` ergänzt).
* Das XHTML5-Layout unterstützt nun ``<meta charset="..." />`` und hat einen
  (was Newlines angeht) aufgeräumteren ``<head>``.
* Bugfix: Beim Anlegen von neuen Artikeln mit einer Position innerhalb der
  bereits bestehenden Artikel wurden nicht alle betroffenen Artikel aus dem
  Cache entfernt.
* Der Code, der für das Matching von ``sally://ID``-URLs zuständig ist, wurde
  überarbeitet und erkennt URLs nun robuster. Gleichzeitig wurde damit wieder
  ein Stück REDAXO-Code entfernt.
* weitere kleinere Bugfixes

0.5.5 (3. November 2011)
------------------------

.. note::

  Dieses Release enthält deutliche Änderungen am Rechtesystem und der
  Benutzerverwaltung. Vor einem Update sollten unbedingt die
  :doc:`Upgrade-Hinweise </general/updating>` studiert werden.

* Das Backend ist nun auch über ``/backend`` (ohne Slash am Ende) zu erreichen.
* Das Handling von Benutzerrechten wurde massiv überarbeitet und unterstützt nun
  externe Autorisierungssysteme.
* ``SLY_MEDIA_LIST_TOOLBAR`` wird auch ausgeführt, wenn es keine Kategorien
  gibt (AddOns können also die Toolbar immer anpassen).
* Benutzer können auf ihrer Profilseite das Locale auf den Projektstandard
  (anstatt eines konkreten Wertes) zurücksetzen. Außerdem kann im Formular für
  einen Benutzer nun dessen Zeitzone einstellen.
* Auf der Loginseite wird ein Cookie gesetzt, das alle Fähigkeiten des Browsers
  (also die Properties von ``Modernizr``) enthält. Sally prüft nun serverseitig,
  ob der Client beispielsweise Datepicker nativ unterstützt und erspart dem
  Client dann das Laden der jQuery UI Dateien. Über ``sly_Helper_Modernizr``
  kann auf die Eigenschaften zugegriffen werden.
* Das Interface ``sly_Authorisation_Provider`` hat sich leicht geändert.
* Die Benutzerliste enthält nun einen Pager sowie ein Filter-Eingabefeld.
* Der Statcache von PHP wird beim Leeren des Caches ebenfalls geleert
  (``clearstatcache()`` wird noch vor ``ALL_GENERATED`` ausgeführt).
* BabelCache wurde auf Version 1.2.7-beta aktualisiert und bringt nun einen
  SQLite-basierten Cache sowie einen einfacheren Dateisystem-Cache mit. Der neue
  Dateisystem-Cache ist ebenfalls der Standard für neue Projekte.
* ``sly_Layout_XHTML5->setLanguage()`` wurde in das XHTML-Layout zurückportiert
  (= verschoben) und kann nun auch dort verwendet werden.
* Das Event ``SLY_SETUP_INIT_FUNCTIONS_FORM`` wurde entfernt, da es keine
  Listener dafür geben konnte (im Setup-Prozess).
* hinzugefügt: ``SLY_SLICE_POSTVIEW_ADD`` und ``SLY_SLICE_POSTVIEW_EDIT`` als
  neue Events, die nach dem Hinzufügen/Bearbeiten eines Slices ausgeführt
  werden.
* hinzugefügt: Das Event ``SLY_ART_META_FORM_ADDITIONAL`` erlaubt es, das
  Meta-Formular von Artikeln nachträglich noch einmal zu verändern.
* hinzugefügt: ``sly_Form->getFieldsets()`` und
  ``sly_Form->findElementByName()``
* hinzugefügt: ``SLY_USER_FORM`` erlaubt es, das Benutzerformular nachträglich
  zu erweitern.
* hinzugefügt: ``SLY_USER_ADDED`` und ``SLY_USER_UPDATED`` werden ausgeführt,
  nachdem ein Benutzer angelegt oder bearbeitet wurde. ``SLY_USER_DELETED`` wird
  ausgeführt, nachdem ein Benutzer gelöscht wurde.
* hinzugefügt: Über ``SLY_PAGE_USER_SUBPAGES`` kann das Menü der Benutzerseite
  um eigene Unterseiten erweitert werden.
* hinzugefügt: ``sly_Layout->setBase()`` zum Setzen der Base-URI.
* Bugfix: Mehrere Datepicker auf seiner Seite führten zu JavaScript-Konflikten.
* Bugfix: Die Konfiguration wurde nicht neu gespeichert, wenn Elemente entfernt
  wurden.
* Bugfix: Wenn AddOns oder Plugins nicht (mehr) verfügbar sind, wird nun nur
  noch eine einmalige Warnung ausgegeben und dann die Komponente aus der
  Konfiguration entfernt.
* Bugfix: Warnung beim Re-Installieren von Plugins entfernt.
* Bugfix: Das Escaping des Slotnamens in OOArticleSlice war fehlerhaft.
* Bugfix: Der Sally-ErrorHandler kannte ``E_COMPILE_ERROR`` nicht.
* Bugfix: Fehler in den ``PRESAVE``-Events von Slices wurden behoben.
* Bugfix: Beim Umbenennen von Artikeln wurde der Cache nicht richtig geleert
  (Ticket #4519).

0.5.4 (3. Oktober 2011)
-----------------------

* Das Styling & Handling von Sortierungen in ``sly_Table`` wurde überarbeitet.
  Dabei kam es zu einer :doc:`API-Änderung </general/updating>`.
* ``sly_Log`` kann nun benutzerdefinierte Platzhalter verwenden, die bei dem
  eigentlichen Log-Aufruf als Kontext mit übergeben werden können. Damit können
  auch die Werte von vordefinierten Platzhaltern überschrieben werden.
* Das XHTML5-Layout ermittelt die aktuelle Sprache (das Locale) nicht mehr
  automatisch.
* hinzugefügt: ``sly_Util_String::getFileExtension()``
* hinzugefügt: ``sly_Util_String::stringify()`` zum Ermitteln einer gut lesbaren
  String-Repräsentation eines Wertes
* hinzugefügt: Helper-Methoden zum Zugriff auf die Klassen des ``<body>``-Tags.
* hinzugefügt: Event ``SLY_SPECIALS_MENU`` zum Erweitern der Systemseite um
  eigene Unterseiten.
* hinzugefügt: Die Konstante ``SLY_TESTING_USE_CACHE`` schaltet das Caching im
  Testmodus explizit ein (standardmäßig ist Caching dort abgeschaltet).
* Bugfix: Fehlende CSS-Styles für einige Inputs ergänzt.
* Bugfix: Im Asset-Cache wird öfter ``clearstatcache()`` aufgerufen.

0.5.3 (8. September 2011)
-------------------------

* (alle Änderungen im 0.4-Branch seit Sally 0.4.9)
* In der Strukturansicht wird nun nicht mehr das Datum angezeigt, an dem ein
  Artikel angelegt wurde, sondern der jeweilige Artikeltyp.
* Das Event ``SLY_SLICE_MOVED`` wurde hinzugefügt.
* Das Styling der Formulare wurde weiter aufpoliert.
* Im Menü eines AddOns kann nun bei den Subpages als weiteres Argument jeweils
  eine CSS-Klasse für das generierte ``<li>`` (in ``rex-navi-page``) angegeben
  werden.
* Es wurde ein Script ergänzt, dass die :file:`mimetypes.yml` aus Apache-Sourcen
  neu aufbaut.
* Bugfix: Der Header von XHTML5-Layouts wurde nicht ausgegeben.
* Bugfix: Benutzer ohne Admin-Rechte hatten Probleme in der Strukturansicht,
  wenn sie nicht auf alle Sprachen Zugriff hatten. Das
  Benutzer-Bearbeiten-Formular wurde dahingehend angepasst, dass die Struktur
  nicht mehr als Startseite ausgewählt werden kann, wenn jemand keine
  Sprachrechte besitzt.
* Bugfix: Der Specials-Controller ist nun wie angedacht nur noch für Admins
  zugänglich.
* Bugfix: Medienkategorien konnten nicht bearbeitet werden.
* Bugfix: Das Kopieren von Inhalten zwischen Sprachen funktionierte nicht.
* Bugfix: Die Einrückung des XHTML-Headers wurde aufgehübscht.
* Bugfix: Fatal Error bei Tabellen mit Pagern

0.5.2 (19. August 2011)
-----------------------

* Auf der Credits-Seite (erreichbar über den Link im Footer) befindet sich nun
  eine neue Unterseite, die einige Informationen über die Sally-Installation
  enthält. Die dort gegebenen Hinweise sollten beim Erstellen von Bugreports
  unbedingt beachtet werden. Die Unterseite sieht nur der Administrator.
* Der Parser, der aus Templates und Modulen die ``@sly``-Angaben extrahiert,
  kann nun mit mehrzeiligen Angaben arbeiten.
* Die Backend-Navigation wurde um Methoden zum Entfernen von Gruppen, Seiten und
  Unterseiten erweitert.
* ``sly_Service_ArticleType->get()`` ist nun öffentlich zugänglich.
* ``sly_Core::DEFAULT_FILEPERM`` und ``sly_Core::DEFAULT_DIRPERM`` wurden
  hinzugefügt (sind aber primär für Sally intern während der Installation
  gedacht und sollten nicht von Userland-Code verwendet werden).
* Bugfix: An einigen Stellen wurden CSS-Probleme behoben (fehlende und falsche
  Styles)
* Bugfix: Wenn Memcached als Cache ausgewählt wurde, war die vom BootCache
  erzeugte Cachedatei fehlerhaft.
* Bugfix: Der Medienpool vergaß den JavaScript-Callback beim Wechseln der
  Medienpoolkategorie (führte zu Problemen im Medienpool-Popup).
* Bugfix: Der vom Medienpool an JavaScript-Callbacks übergebene Dateipfad war
  fehlerhaft.
* Bugfix: ``sly_Util_Navigation->getNavigationHash()`` gab keinen Hash zurück.
* Bugfix: Wenn der Input- oder Output-Teil eines Moduls fehlte, wurde eine
  Warnung von PHP generiert.
* Bugfix: ``OOArticleSlice::get[Value|Link|LinkList|...]()`` verwendeten noch
  das alte ``REX_``-Präfix und verlangten außerdem, dass das Modul auf den
  Rückgabewert noch einmal ``->getValue()`` aufrief.

0.5.1 (11. August 2011)
-----------------------

* BabelCache wurde auf Version 1.2.5 aktualisiert. Damit wurde der
  Dateisystem-Cache weiter stabilisiert.
* sfYaml wurde auf die aktuellste Version (8a266aadcec87) von GitHub
  aktualisiert.
* Weitere Verbesserungen am Styling von Formular-Elementen in Modulen;
  ``.rex-form-notice`` wurde in ``.sly-form-helptext`` umbenannt.
* Bugfix: Zeige Slotmenü nicht, wenn nur ein Slot existiert.
* Bugfix: Fehlermeldung beim Installieren von inkompatiblen Plugins korrigiert.
* Bugfix: Log-Rotation war immer aktiviert, unabhängig vom
  ``enableRotation``-Flag.
* Bugfix: Warnungen, die während des Bootens von Sally auftreten, führten u.U.
  zu fehlerhaft kodierten (gzip) Seiten.
* Bugfix: Zugriff auf Sprachen für Non-Admins funktionierte nicht (Zugriff auf
  die Strukturseite war nicht möglich).
* Bugfix: Das Setup sollte wenigstens bis zum Punkt, wo ``short_open_tags``
  geprüft wird, sauber arbeiten.

0.5.0 (4. August 2011)
----------------------

.. note::

  Diese Liste umfasst nur die groben Änderungen, eine Detailliste befindet sich
  im Dokument zum :doc:`Aktualisieren von SallyCMS-Projekten
  </general/updating>`.

* integrierter :doc:`Error Handler </sallycms/errorhandler>`
* neue :doc:`Verzeichnisstruktur </general/birdseye>`
* neue Content-Verwaltung
* JavaScript-Refactoring
* BootCache zur Verbesserung der Leistung
* HTML5-Unterstützung in ``sly_Form``
* neue Dokumentation
* ``$REX`` wurde entfernt.
* u.v.m.

Siehe dazu auch den `News-Beitrag <https://projects.webvariants.de/news/48>`_
