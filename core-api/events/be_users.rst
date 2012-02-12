Benutzerverwaltung
==================

.. note::

  Nicht zu verwechseln mit dem Backend von FrontendUser!

.. slyevent:: SLY_PAGE_USER_SUBPAGES
  :type:    filter
  :in:      array
  :out:     array
  :since:   0.5.5
  :subject: die vom Core vorgegebenen Menüpunkte

  wird ausgeführt, bevor das Submenü der Benutzerseite ausgegeben wird

.. =============================================================================

.. slyevent:: SLY_USER_FORM
  :type:    filter
  :in:      sly_Form
  :out:     sly_Form
  :subject: das Benutzerformular
  :params:
    user      (sly_Model_User)  der zu bearbeitende Benutzer (kann ``null`` sein)

  In diesem Event können Listener das Bearbeiten/Hinzufügen-Formular von
  Benutzern erweitern.
