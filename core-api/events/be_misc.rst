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
  :params:
    layout (sly_Layout_Backend)  das aktuelle Backend-Layout

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

.. =============================================================================

.. slyevent:: SLY_PROFILE_FORM
  :type:    notify
  :in:      sly_Model_User
  :since:   0.7.0
  :subject: das Profilformular eines Nutzers
  :params:
    user (sly_Model_User)  der betroffene Benutzer

  Dieses Event wird ausgelöst, wenn das Profilformular gerendert werden soll.

.. =============================================================================

.. slyevent:: SLY_LINKMAP_URL_PARAMS
  :type:    filter
  :in:      array
  :out:     array
  :subject: alle dynamischen URL-Parameter
  :since:   0.7.4

  Über dieses Event kann ein Listener die Liste der Parameter, die über alle
  Requests innerhalb der Linkmap an alle URLs und alle Formulare angefügt
  werden, modifizieren. Das Subject ist ein assoziatives Array, wobei der Key
  jeweils der Name des Parameters und der Value jeweils der Datentyp des
  Parameters ist (z.B: ``array('callback' => 'string')``).

.. =============================================================================

.. slyevent:: SLY_I18N_MISSING_TRANSLATION
  :type:    notify
  :in:      string
  :subject: der nicht gefundene Key
  :since:   0.7.4
  :params:
    locale (string)  das aktuelle Locale

  Dieses Event wird gefeuert, wenn ``sly_I18N->setReportMissing(true)``
  aufgerufen wurde. Listener können darüber noch nicht übersetzte Keys sammeln
  und weiterverarbeiten. Listener können hierüber jedoch **keine Übersetzung**
  zurückgeben.
