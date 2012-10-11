Slice-Handling
==============

.. slyevent:: SLY_CONTENT_UPDATED
  :type:    notify
  :in:      string
  :since:   0.3.2
  :subject: ein leerer String
  :params:
    article_id  (int)
    clang       (int)

  wird ausgeführt, nachdem der Inhalt eines Artikels aktualisiert wurde

.. =============================================================================

.. slyevent:: SLY_SLICE_MOVED
  :type:    notify
  :in:      sly_Model_ArticleSlice
  :subject: das verschobene Slice
  :params:
    clang     (int)
    direction (string)  'up' oder 'down'
    old_pos   (int)
    new_pos   (int)
    user      (sly_Model_User)  der Nutzer, der die Aktion ausgeführt hat; seit v0.7

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

  wird **vor** dem Speichern eines neuen Slices ausgeführt; seit Version 0.7
  besteht das Subject nur noch aus den beiden Keys ``SAVE`` und ``VALUES`` (
  ``MESSAGES`` wurden entfernt, da für Meldungen die Flash-Message benutzt
  werden sollte).

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

  wird **vor** dem Aktualisieren eines Slices ausgeführt; seit Version 0.7
  besteht das Subject nur noch aus den beiden Keys ``SAVE`` und ``VALUES`` (
  ``MESSAGES`` wurden entfernt, da für Meldungen die Flash-Message benutzt
  werden sollte).

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

  wird **vor** dem Löschen eines Slices ausgeführt; seit Version 0.7
  besteht das Subject nur noch aus den beiden Keys ``SAVE`` und ``VALUES`` (
  ``MESSAGES`` wurden entfernt, da für Meldungen die Flash-Message benutzt
  werden sollte).

.. =============================================================================

.. slyevent:: SLY_SLICE_POSTSAVE_ADD
  :type:    notify
  :in:      int
  :subject: die Artikelslice-ID

  wird **nach** dem Speichern eines neuen Slices ausgeführt

.. =============================================================================

.. slyevent:: SLY_SLICE_POSTSAVE_EDIT
  :type:    notify
  :in:      int
  :subject: die Artikelslice-ID

  wird **nach** dem Aktualisieren eines Slices ausgeführt

.. =============================================================================

.. slyevent:: SLY_SLICE_POSTSAVE_DELETE
  :type:    notify
  :in:      int
  :subject: die Artikelslice-ID

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
