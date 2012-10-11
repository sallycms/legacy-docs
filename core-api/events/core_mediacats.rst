MediaCategory-Models
====================

.. slyevent:: SLY_MEDIACAT_ADDED
  :type:    notify
  :in:      sly_Model_MediaCategory
  :subject: die hinzugefügte Kategorie
  :params:
    user (sly_Model_User)  der Nutzer, der die Aktion ausgeführt hat; seit v0.7

  Dieses Event wird ausgelöst nachdem eine neue Medienkategorie angelegt wurde.

.. =============================================================================

.. slyevent:: SLY_MEDIACAT_UPDATED
  :type:    notify
  :in:      sly_Model_MediaCategory
  :subject: die aktualisierte Kategorie
  :params:
    user (sly_Model_User)  der Nutzer, der die Aktion ausgeführt hat; seit v0.7

  Dieses Event wird ausgelöst nachdem eine Medienkategorie umbenannt wurde.

.. =============================================================================

.. slyevent:: SLY_MEDIACAT_DELETED
  :type:    notify
  :in:      sly_Model_MediaCategory
  :subject: die gelöschte Kategorie

  Dieses Event wird ausgelöst nachdem eine Medienkategorie gelöscht wurde.
