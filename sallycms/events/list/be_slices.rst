Slice-Handling
==============

.. slyevent:: SLY_SLICE_MOVED
  :type:    notify
  :in:      OOArticleSlice
  :subject: das verschobene Slice
  :params:
    clang     (int)
    direction (string)  'up' oder 'down'
    oldprior  (int)
    newprior  (int)

  wird nach dem Verschieben eines Slices ausgeführt

.. =============================================================================

.. slyevent:: SLY_SLICE_PRESAVE_ADD
  :type:    filter
  :in:      array
  :out:     array
  :subject: die Daten des betroffenen Slices (``SLY_VALUE``\s, ...)
  :params:
    module      (string)
    article_id  (int)
    clang       (int)

  wird **vor** dem Speichern eines neuen Slices ausgeführt

.. =============================================================================

.. slyevent:: SLY_SLICE_PRESAVE_EDIT
  :type:    filter
  :in:      array
  :out:     array
  :subject: die Daten des betroffenen Slices (``SLY_VALUE``\s, ...)
  :params:
    module      (string)
    article_id  (int)
    clang       (int)

  wird **vor** dem Aktualisieren eines Slices ausgeführt

.. =============================================================================

.. slyevent:: SLY_SLICE_PRESAVE_DELETE
  :type:    filter
  :in:      array
  :out:     array
  :subject: die Daten des betroffenen Slices (``SLY_VALUE``\s, ...)
  :params:
    module      (string)
    article_id  (int)
    clang       (int)

  wird **vor** dem Löschen eines Slices ausgeführt

.. =============================================================================

.. slyevent:: SLY_SLICE_POSTSAVE_ADD
  :type:    filter
  :in:      mixed
  :out:     array
  :subject: die Erfolgsmeldungen (der erste Listener erhält einen leeren String
            als Subject, alle folgenden erhalten ein Array von Nachrichten, das
            sie erweitern können)
  :params:  article_slice_id (int)

  wird **nach** dem Speichern eines neuen Slices ausgeführt

.. =============================================================================

.. slyevent:: SLY_SLICE_POSTSAVE_EDIT
  :type:    filter
  :in:      mixed
  :out:     array
  :subject: die Erfolgsmeldungen (der erste Listener erhält einen leeren String
            als Subject, alle folgenden erhalten ein Array von Nachrichten, das
            sie erweitern können)
  :params:  article_slice_id (int)

  wird **nach** dem Aktualisieren eines Slices ausgeführt

.. =============================================================================

.. slyevent:: SLY_SLICE_POSTSAVE_DELETE
  :type:    filter
  :in:      mixed
  :out:     array
  :subject: die Erfolgsmeldungen (der erste Listener erhält einen leeren String
            als Subject, alle folgenden erhalten ein Array von Nachrichten, das
            sie erweitern können)
  :params:  article_slice_id (int)

  wird **nach** dem Löschen eines Slices ausgeführt

.. =============================================================================

.. slyevent:: SLY_SLICE_POSTVIEW_ADD
  :type:    notify
  :in:      array
  :subject: die Slice-Werte
  :params:
    module     (string)
    article_id (int)
    clang      (int)
    slot       (string)

  wird nach dem Anzeigen des Slice-hinzufügen-Formulars ausgeführt

.. =============================================================================

.. slyevent:: SLY_SLICE_POSTVIEW_EDIT
  :type:    notify
  :in:      array
  :subject: die Slice-Werte
  :params:
    module     (string)
    article_id (int)
    clang      (int)
    slot       (string)
    slice      (``OOArticleSlice``)

  wird nach dem Anzeigen des Slice-bearbeiten-Formulars ausgeführt
