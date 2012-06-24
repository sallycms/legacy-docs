Article-Models
==============

.. slyevent:: SLY_ART_TO_STARTPAGE
  :type:    notify
  :in:      int
  :subject: die ID des Artikels, der zum Startartikel wurde
  :params:  old_cat (int) die ID des vorherigen Startartikels

  wird ausgeführt, nachdem ein Artikel zum Startartikel einer Kategorie wurde

.. =============================================================================

.. slyevent:: SLY_ART_CONTENT_COPIED
  :type:    notify
  :in:      null
  :subject: N/A
  :params:
    from_id     (int)  die ID des Quellartikels
    from_clang  (int)  die Sprach-ID des Quellartikels
    to_id       (int)  die ID des Zielartikels
    to_clang    (int)  die Sprach-ID des Zielartikels

  wird ausgeführt, nachdem der **Inhalt** eines Artikels kopiert wurde

.. =============================================================================

.. slyevent:: SLY_ART_ADDED
  :type:    notify
  :in:      int
  :subject: die ID des neuen Artikels
  :params:
    re_id     (int)     ID der enthaltenden Kategorie
    clang     (int)     ID der Sprache (siehe Beschreibung!)
    name      (string)  Name des Artikels
    position  (int)     Position des neuen Artikels
    path      (string)  Kategorie-Pfad (``|id|id|...|``)
    status    (int)     Artikelstatus
    type      (string)  Artikeltyp

  wird ausgeführt, nachdem ein Artikel angelegt wurde (*wird einmal pro Sprache
  ausgeführt!*)

.. =============================================================================

.. slyevent:: SLY_ART_COPIED
  :type:    notify
  :in:      sly_Model_Article
  :subject: der duplizierte Artikel
  :params:
    source  (sly_Model_Article)  der Quellartikel

  wird ausgeführt, nachdem ein Artikel kopiert wurde (*wird einmal pro Sprache
  ausgeführt!*)

.. =============================================================================

.. slyevent:: SLY_ART_MOVED
  :type:    notify
  :in:      int
  :subject: die ID des Quellartikels
  :params:
    clang   (int)  ID der Sprache (siehe Beschreibung!)
    target  (int)  ID der Zielkategorie

  wird ausgeführt, nachdem ein Artikel verschoben wurde (*wird einmal pro
  Sprache ausgeführt!*)

.. =============================================================================

.. slyevent:: SLY_ART_UPDATED
  :type:    notify
  :in:      sly_Model_Article
  :subject: der aktualisierte Artikel

  Dieses Event wird ausgeführt, nachdem ein Artikel umbenannt oder verschoben
  (innerhalb der gleichen Kategorie) wurde.

.. note::

  Das Ändern des Status (online/offline) eines Artikels löst das Event
  ``SLY_ART_STATUS`` aus.

.. =============================================================================

.. slyevent:: SLY_ART_DELETED
  :type:    notify
  :in:      sly_Model_Article
  :subject: der gelöschte Artikel

  Dieses Event wird ausgeführt, nachdem ein Artikel gelöscht wurde.

.. note::

  Im Gegensatz zu den anderen Events wird dieses Event **nicht** pro Sprache
  ausgeführt!

.. =============================================================================

.. slyevent:: SLY_ART_STATUS
  :type:    notify
  :in:      sly_Model_Article
  :subject: der aktualisierte Artikel

  Dieses Event wird ausgeführt, nachdem der Status eines Artikels geändert
  wurde.

.. =============================================================================

.. slyevent:: SLY_ART_STATUS_TYPES
  :type:    filter
  :in:      array
  :out:     array
  :subject: Liste der möglichen Artikelstati

  Dieses Event erlaubt es, die Liste der vorhandenen Artikelstati zu erweitern.
  Auch wenn viele Stellen der API den Eindruck erwecken, ein Artikel könne nur
  online (``1``) oder offline (``0``) sein, so ist dieser Status in Wirklichkeit
  doch eine Ganzzahl, sodass auch ein Status ``14`` möglich ist.

  Jedes Element im Subject ist wiederum ein
  ``array('angezeigter Titel', 'CSS-Klasse')``. Die Array-IDs im Subject sind
  die IDs der Stati, daher ist es wichtig, dass Listener entweder eine strikte
  Reihenfolge einhalten oder feste Werte für die IDs vorgeben.

.. note::

  Die Verwendung fester IDs wird dringend empfohlen!

.. =============================================================================

.. slyevent:: SLY_ART_TYPE
  :type:    notify
  :in:      sly_Model_Article
  :subject: der aktualisierte Artikel
  :params:
    old_type (string)  der vorherige Artikeltyp

  Dieses Event wird ausgeführt, nachdem der Typ eines Artikels geändert wurde.
  Es wird 1x pro Artikel ausgeführt.

.. note::

  Der Typ eines Artikels ist immer über alle Sprachen gleich.

.. =============================================================================

.. slyevent:: URL_REWRITE
  :type:    filter
  :in:      string
  :out:     string
  :subject: ein leerer String
  :params:
    id            (int)     Artikel-ID
    clang         (int)     Sprach-ID
    params        (string)  die schon URL-kodierten GET-Parameter als String
    divider       (string)  der Trenner für die URL-Parameter
    disable_cache (bool)    wenn true, sollte die URL nicht aus einem Cache ermittelt werden

  Über dieses Event können realurl-Implementierungen die **relative** URL eines
  Artikels im Frontend ermitteln. Der erste Listener, der eine URL zurückgibt,
  gewinnt. Gibt es keinen Listener, wird eine einfache ``index.php``-URL
  vom Core erzeugt.
