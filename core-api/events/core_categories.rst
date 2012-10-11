Category-Models
===============

.. slyevent:: SLY_CAT_ADDED
  :type:    notify
  :in:      int
  :subject: die ID des neuen Artikels
  :params:
    re_id     (int)     ID der enthaltenden Kategorie
    clang     (int)     ID der Sprache (siehe Beschreibung!)
    name      (string)  Name des Artikels
    position  (int)     Position des neuen Artikels
    path      (string)  Kategorie-Pfad (``|id|id|...|``)
    status    (int)     Kategoriestatus
    type      (string)  Artikeltyp des Startartikels

  wird ausgeführt, nachdem eine Kategorie angelegt wurde (*wird einmal pro
  Sprache ausgeführt!*)

.. =============================================================================

.. slyevent:: SLY_CAT_UPDATED
  :type:    notify
  :in:      sly_Model_Category
  :subject: die aktualisierte Kategorie

  Dieses Event wird ausgeführt, nachdem eine Kategorie umbenannt oder verschoben
  (innerhalb der gleichen Kategorie) wurde.

.. note::

  Das Ändern des Status (online/offline) einer Kategorie löst das Event
  ``SLY_CAT_STATUS`` aus.

.. =============================================================================

.. slyevent:: SLY_CAT_MOVED
  :type:    notify
  :in:      int
  :subject: die ID der Quellkategorie
  :params:
    clang   (int)  ID der Sprache (siehe Beschreibung!)
    target  (int)  ID der Zielkategorie

  wird ausgeführt, nachdem eine Kategorie verschoben wurde (*wird einmal pro
  Sprache ausgeführt!*)

.. =============================================================================

.. slyevent:: SLY_CAT_PRE_DELETE
  :type:    notify
  :in:      sly_Model_Category
  :subject: der zu löschende Kategorie
  :since:   0.6.8 / v0.7.1

  Dieses Event wird ausgelöst, bevor eine Kategorie gelöscht wird. Der Vorgang
  kann gestoppt werden, indem eine Exception geworfen wird.

.. =============================================================================

.. slyevent:: SLY_CAT_DELETED
  :type:    notify
  :in:      sly_Model_Category
  :subject: die gelöschte Kategorie

  wird ausgeführt, nachdem eine Kategorie gelöscht wurde

.. =============================================================================

.. slyevent:: SLY_CAT_STATUS
  :type:    notify
  :in:      sly_Model_Article
  :subject: die aktualisierte Kategorie

  Dieses Event wird ausgeführt, nachdem der Status einer Kategorie geändert
  wurde.

.. =============================================================================

.. slyevent:: SLY_CAT_STATUS_TYPES
  :type:    filter
  :in:      array
  :out:     array
  :subject: Liste der möglichen Kategoriestati

  analog zu ``SLY_ART_STATUS_TYPES``
