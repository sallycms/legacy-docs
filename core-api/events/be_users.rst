Benutzerverwaltung
==================

.. note::

  Nicht zu verwechseln mit dem Backend vom FrontendUser-AddOn!

.. slyevent:: SLY_USER_FORM
  :type:    filter
  :in:      sly_Form
  :out:     sly_Form
  :subject: das Benutzerformular
  :params:
    user  (sly_Model_User)  der zu bearbeitende Benutzer (kann ``null`` sein)

  In diesem Event können Listener das Bearbeiten/Hinzufügen-Formular von
  Benutzern erweitern.

.. slyevent:: SLY_USER_VIEW_FORM
  :type:    filter
  :in:      sly_Form
  :out:     sly_Form
  :subject: das read-only Benutzerformular
  :since:   0.6.5
  :params:
    user  (sly_Model_User)  der anzuzeigende Benutzer

  In diesem Event können Listener das Anzeige-Formular eines Nutzers erweitern.
  Das Formular hat keine Submit-Buttons und sollte keine Möglichkeiten anbieten,
  Angaben zu ändern.

.. slyevent:: SLY_USER_FILTER_WHERE
  :type:    filter
  :in:      string
  :out:     string
  :subject: das WHERE-Statement der SQL-Query
  :since:   0.6.5
  :params:
    search  (string)  der eingegebene Suchbegriff, kann leer sein
    paging  (array)   die Paging-Parameter von ``sly_Table``

  In diesem Event können Listener das WHERE-Statement bearbeiten, das verwendet
  wird, um die anzuzeigenden Nutzer zu finden.
