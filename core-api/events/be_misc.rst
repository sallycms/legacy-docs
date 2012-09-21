Sonstige Backend-Events
=======================

.. slyevent:: PAGE_CHECKED
  :type:    notify
  :in:      string
  :subject: der Name der aktuellen Backendseite

  benachrichtigt über die endgültig festgelegte Backend-Seite, die nun
  ausgeführt wird

.. warning::

   *deprecated*, stattdessen besser :doc:`SLY_CONTROLLER_FOUND <core_apps>`
   verwenden

.. =============================================================================

.. slyevent:: PAGE_TITLE
  :type:    filter
  :in:      string
  :out:     string
  :subject: der Seitentitel
  :params:
    page (string)  der Name der aktuellen Seite

  Über dieses Event können Listener den Seitentitel noch einmal verändern.

.. =============================================================================

.. slyevent:: PAGE_TITLE_SHOWN
  :type:    notify
  :in:      string
  :subject: die gerenderten Untermenülinks als HTML-String
  :params:
    page (string)  der Name der aktuellen Seite

  wird direkt nach ``PAGE_TITLE`` ausgeführt

.. =============================================================================

.. slyevent:: SLY_LAYOUT_NAVI
  :type:    filter
  :in:      sly_Layout_Navigation_Backend
  :out:     sly_Layout_Navigation_Backend
  :subject: die Backend-Navigation

  Über dieses Event können AddOns das Menü von Sally noch einmal verändern,
  bevor es gerendert wird.

.. =============================================================================

.. slyevent:: SLY_BE_LOGIN
  :type:    notify
  :in:      sly_Model_User
  :since:   0.7.0
  :subject: der Nutzer, der sich gerade eingeloggt hat

  Dieses Event wird ausgelöst, nachdem sich ein Benutzer im Backend eingeloggt
  hat. Dazu muss der Nutzer auch das Recht ``apps/backend`` haben.

.. =============================================================================

.. slyevent:: SLY_BE_LOGOUT
  :type:    notify
  :in:      sly_Model_User
  :since:   0.7.0
  :subject: der Nutzer, der sich gerade ausgeloggt hat

  Dieses Event wird ausgelöst, nachdem sich ein Benutzer aus dem Backend
  ausgeloggt hat.
