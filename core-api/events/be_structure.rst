Strukturansicht
===============

.. slyevent:: PAGE_STRUCTURE_HEADER
  :type:    filter
  :in:      string
  :out:     string
  :subject: leerer String
  :params:
    category_id (int)  die ID der aktuellen Kategorie
    clang       (int)  die aktuelle Sprache

  In diesem Event können Listener den Kopfbereich der Strukturseite um eigene
  Elemente erweitern. Der Rückgabewert des Events wird direkt ausgegeben.
  BeSearch nutzt diesen Mechanismus, um die Filterleiste zu erzeugen.

.. =============================================================================

.. slyevent:: CAT_FORM_EDIT
  :type:    filter
  :in:      string
  :out:     string
  :subject: leerer String
  :params:
    category      (sly_Model_Category)  die zu bearbeitende Kategorie
    data_colspan  (int)                 zu verwendender colspan (deprecated und ohne Bedeutung)

  In diesem Event können Listener das Bearbeiten-Formular von Kategorien um
  eigene Tabellenzeilen erweitern.
