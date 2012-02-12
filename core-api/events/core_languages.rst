Sprach-Events
=============

.. slyevent:: CLANG_ADDED
  :type:    notify
  :in:      string
  :subject: ein leerer String
  :params:
    id        (int)                 ID der neuen Sprache
    language  (sly_Model_Language)  Instanz der neuen Sprache

  Dieses Event wird ausgelöst nachdem eine neue Sprache zum System hinzugefügt
  wurde.

.. =============================================================================

.. slyevent:: CLANG_DELETED
  :type:    notify
  :in:      string
  :subject: ein leerer String
  :params:
    id    (int)     ID der gelöschten Sprache
    name  (string)  Name der gelöschten Sprache

  Dieses Event wird ausgelöst nachdem eine Sprache gelöscht wurde.
