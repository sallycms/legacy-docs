Medium-Models
=============

.. slyevent:: SLY_MEDIA_ADDED
  :type:    notify
  :in:      sly_Model_Medium
  :subject: das hinzugefügte Medium

  Dieses Event wird ausgelöst nachdem ein neues Medium angelegt wurde. Dies kann
  nach einem Upload oder nach dem Synchronisieren von Dateien geschehen.

.. =============================================================================

.. slyevent:: SLY_MEDIA_UPDATED
  :type:    notify
  :in:      sly_Model_Medium
  :subject: das aktualisierte Medium

  Dieses Event wird ausgelöst nachdem eine Medienkategorie umbenannt wurde.

.. =============================================================================

.. slyevent:: SLY_MEDIA_DELETED
  :type:    notify
  :in:      sly_Model_Medium
  :subject: das gelöschte Medium

  Dieses Event wird ausgelöst nachdem ein Medium gelöscht wurde.

.. =============================================================================

.. slyevent:: SLY_MEDIUM_FILENAME
  :type:    filter
  :in:      string
  :out:     string
  :subject: der Dateiname
  :params:
    orig  (string)  der originale Dateiname

  Über dieses Element können Listener den finalen Dateinamen, unter dem eine
  Datei im Medienpool abgelegt wird, noch einmal verändert. Als Subject wird
  ein schon vorgefertigter Name reingegeben. Im Anschluss an das Event werden
  alle Sonderzeichen aus dem Dateinamen entfernt.

