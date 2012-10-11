User-Models
===========

.. slyevent:: SLY_USER_ADDED
  :type:    notify
  :in:      sly_Model_User
  :subject: der hinzugefügte Benutzer

  Dieses Event wird ausgelöst nachdem eine neuer Benutzer angelegt wurde.

.. =============================================================================

.. slyevent:: SLY_USER_UPDATED
  :type:    notify
  :in:      sly_Model_User
  :subject: der aktualisierte Benutzer

  Dieses Event wird ausgelöst nachdem ein Benutzer bearbeitet wurde.

.. =============================================================================

.. slyevent:: SLY_USER_PRE_DELETE
  :type:    notify
  :in:      sly_Model_User
  :subject: der zu löschende Benutzer
  :since:   0.6.8 / v0.7.1

  Dieses Event wird ausgelöst, bevor ein Benutzer gelöscht wird. Der Vorgang
  kann gestoppt werden, indem eine Exception geworfen wird.

.. =============================================================================

.. slyevent:: SLY_USER_DELETED
  :type:    notify
  :in:      int
  :subject: die ID des gelöschten Benutzers

  Dieses Event wird ausgelöst nachdem ein Benutzer gelöscht wurde.

