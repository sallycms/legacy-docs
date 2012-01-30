Medienpool
==========

Diese Seite listet alle Events auf, die im Medienpool ausgelöst werden. Nicht
enthalten sind die Events, die vom :doc:`Medium-Model <core_media>` und vom
:doc:`MediaCategory-Model <core_mediacat>` ausgelöst werden.

.. slyevent:: PAGE_MEDIAPOOL_MENU
  :type:    filter
  :in:      array
  :out:     array
  :subject: die vom Core vorgegebenen Menüpunkte

  wird ausgeführt, bevor das Submenü des Medienpool-Popups ausgegeben wird

.. =============================================================================

.. slyevent:: SLY_MEDIA_LIST_QUERY
  :type:    filter
  :in:      string
  :out:     string
  :subject: das vom Core vorgegebene WHERE-Statement (``f.category_id = X``)
  :params:
    category_id (int)  ID der aktuellen Medienkategorie

  Über dieses Event können Listener das WHERE-Statement erweitern, über das die
  anzuzeigenden Medien gefiltert werden. Das Filtern nach Medienkategorie wird
  bereits vom Core erledigt (allerdings kann ein Listener diese Vorgabe auch
  überschreiben). Im Statement kann über den Alias ``f`` die
  ``sly_file``-Tabelle referenziert werden.

.. =============================================================================

.. slyevent:: SLY_MEDIA_FORM_EDIT
  :type:    filter
  :in:      sly_Form
  :out:     sly_Form
  :subject: das Formular zum Bearbeiten von Medien im Medienpool
  :params:
    file_id (int)
    medium  (sly_Model_Medium)

  Über dieses Event können Listener das Medienformular noch einmal bearbeiten,
  bevor es ausgegeben wird. Das Event wird ausgeführt bevor die Buttons
  gesetzt werden.

.. =============================================================================

.. slyevent:: SLY_MEDIA_LIST_FUNCTIONS
  :type:    filter
  :in:      string
  :out:     string
  :subject: der String zum Auswählen einer Datei (oder ein leerer String)
  :params:
    medium  (sly_Model_Medium)

  Über dieses Event können Listener den Link, über den im Medienpool-Popup eine
  Datei ausgewählt werden kann, erweitern. So könnten weitere Links hinzugefügt
  oder der Sally-eigene überschrieben werden. Der Rückgabewert wird direkt
  ausgegeben.

.. =============================================================================

.. slyevent:: SLY_MEDIA_FORM_SYNC
  :type:    filter
  :in:      sly_Form
  :out:     sly_Form
  :subject: das Synchronisieren-Formular aus dem Medienpool

  Über dieses Event können Listener das Medien-synchronisieren-Formular
  nachträglich noch verändern. Das Form wird im Anschluss direkt gerendert.

.. =============================================================================

.. slyevent:: PAGE_MEDIAPOOL_HEADER
  :type:    filter
  :in:      string
  :out:     string
  :subject: ein leerer String
  :params:
    category_id (int)

  Über dieses Event können im Medienpool noch weitere Inhalte im Kopfbereich
  ausgegeben werden. In der Strukturansicht des Medienpools kann auch einfach
  das Formular in ``SLY_MEDIA_LIST_TOOLBAR`` verändert werden (anstatt ein
  eigenes zu erstellen und zu rendern). Der Rückgabewert wird direkt ausgegeben.

.. =============================================================================

.. slyevent:: SLY_MEDIA_LIST_TOOLBAR
  :type:    filter
  :in:      sly_Form
  :out:     sly_Form
  :subject: das Header-Formular im Medienpool-Index
  :params:
    category_id (int)

  Über dieses Event können Listener das Formular im Kopf der Medienpool-
  Strukturansicht erweitern (dort, wo auch die Medienpoolkategorie ausgewählt
  werden kann). Das Formular wird im Anschluss direkt ausgegeben.

.. =============================================================================

.. slyevent:: SLY_MEDIA_FORM_ADD
  :type:    filter
  :in:      sly_Form
  :out:     sly_Form
  :subject: das Datei-hinzufügen-Formular aus dem Medienpool

  Über dieses Event können Listener das Medien-hinzufügen-Formular
  nachträglich noch verändern. Das Form wird im Anschluss direkt gerendert.