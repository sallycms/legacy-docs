Category-Models
===============

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

.. slyevent:: SLY_CAT_DELETED
  :type:    notify
  :in:      sly_Model_Category
  :subject: die gelöschte Kategorie

  wird ausgeführt, nachdem eine Kategorie gelöscht wurde
