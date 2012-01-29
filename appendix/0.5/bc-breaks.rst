Kompatibilitätsinformationen
============================

Auf dieser Seite werden alle rückwärts-inkompatiblen API-Änderungen aus allen
Sally-Releases dokumentiert.

.. note::

  Während der 0.x-Phase sind Updates nicht immer ohne manuelles Eingreifen
  möglich, da wir teils gravierende Änderungen an der Struktur vornehmen. Wir
  bitten, diesen Umstand zu beachten. Updates innerhalb eines Branches (z.B.
  von 0.4.4 auf 0.4.7) sollten hingegen immer problemlos möglich sein.

0.5.0 -> 0.5.1
--------------

* Das Styling von Modulen wurde leicht angepasst, insbes. wurde
  ``.rex-form-notice`` in ``.sly-form-helptext`` umbenannt.
* ``rex_send_article()`` kann mit ``$content = null`` aufgerufen werden und wird
  dann alle offenen Output Buffer selber schließen.
* ``sly_Util_String::shortenFilename()`` prüft nicht mehr explizit die Typen der
  übergebenen Parameter (kein ``is_string()`` und dergleichen mehr).

0.5.1 -> 0.5.2
--------------

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
--------------

* Die :file:`cache.php` wurde aus dem Asset-Cache entfernt und durch eine
  direkte Umleitung auf die :file:`index.php` ersetzt. Diese Datei kann also
  gefahrlos gelöscht werden (wird sie auch beim Leeren des Caches).

Da der Asset-Cache geänderte :file:`.htaccess`-Dateien bewusst nicht
überschreibt, wird er die neue Version der Datei nie selber an den richtigen
Platz legen. Man muss daher die Datei :file:`sally/core/install/static-cache/.htaccess`
selber nach :file:`sally/data/dyn/public/sally/static-cache/.htaccess` kopieren.

0.5.3 -> 0.5.4
--------------

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
* hinzugefügt: ``sly_Layout::getBodyAttr($name)`` und
  ``sly_Layout::appendBodyClass($class)``
* hinzugefügt: Event ``SLY_SPECIALS_MENU`` zum Erweitern der Systemseite um
  eigene Unterseiten.
* hinzugefügt: Die Konstante ``SLY_TESTING_USE_CACHE`` schaltet das Caching im
  Testmodus explizit ein (standardmäßig ist Caching dort abgeschaltet).
* Das XHTML5-Layout ermittelt die aktuelle Sprache (das Locale) nicht mehr
  automatisch. Stattdessen muss ``setLanguage($locale)`` selber aufgerufen
  werden (damit ist das XHTML5-Layout nicht mehr von der ``I18NUtils``-Klasse
  abhängig).

0.5.4 -> 0.5.5
--------------

Diese Version bringt deutliche Veränderungen am Rechtesystem und der
Benutzerverwaltung mit. Dies führt zu einigen API-Änderungen, die mit der
Kompatibilität brechen, aber nur in Projekten, die FrontendUser einsetzen,
problematisch sein dürften.

* Rechtesystem

  * Das Interface von ``sly_Authorisation_Provider`` hat sich geändert und
    verlangt nun eine ``hasPermission($userId, $token, $value = true)``-Methode.
  * Die lokale Konfiguration wurde um sog. "Objektrechte" (``OBJECTPERM``)
    erweitert. Die Objektrechte umfassen u.a. Sprach- und Kategoriezugriff.
  * AddOns sollten unbedingt ``->isAdmin()`` anstatt ``->hasRight('admin[]')``
    nutzen, damit das neue Rechtesystem korrekt arbeiten kann. Selbst ohne das
    neue Rechtesystem ist ``isAdmin()`` schneller, kürzer zu schreiben und damit
    immer die bessere Wahl.
  * ``sly_Model_User->hasRight()`` verwendet nun den Auth-Provider, falls einer
    vorhanden ist.
  * ``sly_Model_User->hasCategoryRight()`` wurde entfernt.
  * ``sly_Util_Category::hasPermissionOnCategory()`` wurde entfernt.
  * ``sly_Util_Article``

    * ``->canReadArticle(sly_Model_User $user, $articleId)`` wurde hinzugefügt.
    * ``->canEditArticle(sly_Model_User $user, $articleId)`` wurde hinzugefügt.
    * ``->canEditContent(sly_Model_User $user, $articleId)`` wurde hinzugefügt.

* Events

  * ``SLY_SLICE_POSTVIEW_ADD``: Subject sind die Slicewerte und als weitere
    Parameter werden ``module``, ``article_id``, ``clang`` und ``slot``
    übergeben.
  * ``SLY_SLICE_POSTVIEW_EDIT``: Subject sind die Slicewerte und als weitere
    Parameter werden ``module``, ``article_id``, ``clang``, ``slot`` und
    ``slice`` übergeben.
  * ``SLY_MEDIA_LIST_TOOLBAR`` wird immer ausgeführt, wenn der Medienpool
    geöffnet wird (und nicht mehr nur, wenn es bereits Medienkategorien
    gibt).
  * ``SLY_META_FORM_ADDITIONAL`` wird direkt vor dem Rendern des Metaformulars
    von Artikeln ausgeführt. Subject ist das Formular-Objekt, die weiteren
    Parameter sind wie bei den anderen ``SLY_META_FORM``-Events.
  * ``SLY_USER_FORM`` wird direkt vor dem Rendern des Benutzerformulars
    ausgeführt. Subject ist das Formular-Objekt, als weiterer Parameter wird
    das User-Objekt mit übergeben (ist beim Hinzufügen eines Benutzers
    ``null``).
  * ``SLY_USER_ADDED``, ``SLY_USER_UPDATED`` und ``SLY_USER_DELETED``
    wurden ergänzt. In ``ADDED`` und ``UPDATED`` können Exceptions geworfen
    werden, um Fehlermeldungen im Backend anzeigen zu lassen.
  * ``SLY_PAGE_USER_SUBPAGES`` ermöglicht es, das Submenü der Benutzerseite zu
    erweitern. Subject sind die Subpages; es werden keine weiteren Parameter
    übergeben.

* Sonstiges

  * ``sly_Service_AddOn`` und ``sly_Service_Plugin`` kennen nun die Methode
    ``exists($component)``.
  * ``sly_Helper_Modernizr`` wurde hinzugefügt.
  * ``sly_Service_Model_Base->count($where, $group)`` wurde hinzugefügt.
  * ``sly_Layout->setBase($base)`` wurde hinzugefügt.
  * ``setLanguage($language)`` wurde von ``sly_Layout_XHTML5`` nach
    ``sly_Layout_XHTML`` verschoben (da XHTML5 sich von XHTML ableitet, steht
    die Methode dort weiterhin zur Verfügung).
  * Emulierte Datepicker (jQuery UI) verwenden kein ``<input type="date">``
    mehr, sondern verwenden ``<input type="text">``. Die date-Version hat einige
    Browser verwirrt und führte zu Problemen, wenn Modernizr den
    Datepicker-Support nicht korrekt erkannte.
  * ``sly_Util_Language->findById()`` wurde hinzugefügt.
  * Das Event ``SLY_SETUP_INIT_FUNCTIONS_FORM`` wurde entfernt.

Beim Aktualisieren einer bestehenden Installation sollten die neuen Objektrechte
von Hand in die lokale Konfiguration (:file:`sally/data/config/sly_local.yml`)
übertragen werden, falls Sally das nicht bereits automatisch erledigt.

.. sourcecode:: yaml

  EXTRAPERM:
    - 'editContentOnly[]'
  OBJECTPERM:
    - clang
    - csw
    - media
    - module

Da das Rechtesystem-AddOn noch nicht öffentlich ist, muss das nicht zwingend
erledigt werden, da der Sally-Core die Objektrechte selbst nicht beachten wird.
Aber schaden kann es auch nicht.

0.5.5 -> 0.5.6
--------------

* ``sly_Util_Directory::create()`` erhielt ``$throwException`` als dritten
  Parameter, um bei Problemen eine ``sly_Util_DirectoryException`` zu werfen
  (die im Gegensazu zu einer Warnung von PHP das betroffene Verzeichnis
  enthält).
* ``sly_Service_Article::findByType($type, $ignore_offlines = false, $clangId = null)``
  wurde hinzugefügt.
* ``sly_Util_Article::findByType($type, $ignore_offlines = false, $clangId = null)``
  wurde hinzugefügt.
* ``sly_Layout_XHTML::putJavaScriptAtBottom($switch = true)`` wurde hinzugefügt.
* ``sly_Layout_XHTML5::setCharset($charset)`` wurde hinzugefügt.

0.5.6 -> 0.5.next
-----------------

* Das wird die Zeit zeigen...
