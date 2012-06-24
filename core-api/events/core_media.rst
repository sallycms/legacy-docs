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
  :subject: der bereits vorgefertige Dateiname
  :since:   0.6.2

  Dieses Event wird ausgeführt, wenn eine neue Datei hochgeladen oder eine
  Synchronisation im Medienpool ausgeführt wird. Als Eingabe (Subject) dient
  der bereits vorbereitete Dateiname (z.B. ``tuer.jpg``, wenn eine ``tür.jpg``
  hochgeladen wurde), bei dem die Deutschen Umlaute und das ß bereits ersetzt
  wurden. Listener können weitere Ersetzungen vornehmen (z.B. **é** in **e**
  ersetzen). Im Anschluss an das Event werden alle nicht-alphanumerischen
  Zeichen entfernt, es ist also nicht möglich, Dateinamen mit Sonderzeichen
  zurückzugeben und im Medienpool zu verwenden.
