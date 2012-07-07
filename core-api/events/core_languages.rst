Sprach-Events
=============

.. slyevent:: CLANG_ADDED
  :type:    notify
  :in:      sly_Model_Language
  :subject: die hinzugefügte Sprache
  :params:
    id        (int)                 ID der neuen Sprache
    language  (sly_Model_Language)  Instanz der neuen Sprache

  Dieses Event wird ausgelöst nachdem eine neue Sprache zum System hinzugefügt
  wurde.

.. =============================================================================

.. slyevent:: CLANG_UPDATED
  :type:    notify
  :in:      sly_Model_Language
  :since:   0.7.0
  :subject: die aktualisierte Sprache

  Dieses Event wird ausgelöst nachdem Sprache bearbeitet wurde.

.. =============================================================================

.. slyevent:: CLANG_DELETED
  :type:    notify
  :in:      sly_Model_Language
  :subject: die gelöschte Sprache
  :params:
    id    (int)     ID der gelöschten Sprache
    name  (string)  Name der gelöschten Sprache

  Dieses Event wird ausgelöst nachdem eine Sprache gelöscht wurde.
