Category-Models
===============

.. slyevent:: SLY_CAT_ADDED
  :type:    notify
  :in:      int
  :subject: die ID des neuen Artikels
  :params:
    re_id     (int)             ID der enthaltenden Kategorie
    clang     (int)             ID der Sprache (siehe Beschreibung!)
    name      (string)          Name des Artikels
    position  (int)             Position des neuen Artikels
    path      (string)          Kategorie-Pfad (``|id|id|...|``)
    status    (int)             Kategoriestatus
    type      (string)          Artikeltyp des Startartikels
    user      (sly_Model_User)  der Nutzer, der die Aktion ausgeführt hat; seit v0.7

  wird ausgeführt, nachdem eine Kategorie angelegt wurde (*wird einmal pro
  Sprache ausgeführt!*)

  .. note::

    Wirft ein Listener zu diesem Event eine Exception, so bricht dies die
    aktuelle Transaktion ab und macht alle Änderungen an der Datenbank
    rückgängig.

.. =============================================================================

.. slyevent:: SLY_CAT_UPDATED
  :type:    notify
  :in:      sly_Model_Category
  :subject: die aktualisierte Kategorie
  :params:
    user (sly_Model_User)  der Nutzer, der die Aktion ausgeführt hat; seit v0.7

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
    clang   (int)             ID der Sprache (siehe Beschreibung!)
    target  (int)             ID der Zielkategorie
    user    (sly_Model_User)  der Nutzer, der die Aktion ausgeführt hat; seit v0.7

  wird ausgeführt, nachdem eine Kategorie verschoben wurde (*wird einmal pro
  Sprache ausgeführt!*)

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
  :params:
    user (sly_Model_User)  der Nutzer, der die Aktion ausgeführt hat; seit v0.7

  Dieses Event wird ausgeführt, nachdem der Status einer Kategorie geändert
  wurde.

.. =============================================================================

.. slyevent:: SLY_CAT_STATUS_TYPES
  :type:    filter
  :in:      array
  :out:     array
  :subject: Liste der möglichen Kategoriestati

  analog zu ``SLY_ART_STATUS_TYPES``
