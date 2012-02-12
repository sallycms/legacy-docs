Benutzerverwaltung
==================

.. note::

  Nicht zu verwechseln mit dem Backend von FrontendUser!

.. slyevent:: SLY_USER_FORM
  :type:    filter
  :in:      sly_Form
  :out:     sly_Form
  :subject: das Benutzerformular
  :params:
    user  (sly_Model_User)  der zu bearbeitende Benutzer (kann ``null`` sein)

  In diesem Event können Listener das Bearbeiten/Hinzufügen-Formular von
  Benutzern erweitern.
