Article-Models
==============

.. hlist::
   :columns: 3

   * :ref:`page-content-header`

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
  :in:      OOArticleSlice
  :subject: das verschobene Slice
  :params:
    clang     (int)
    direction (string)  'up' oder 'down'
    oldprior  (int)
    newprior  (int)

  wird nach dem Verschieben eines Slices ausgeführt

.. =============================================================================

.. slyevent:: SLY_ART_TO_STARTPAGE
  :type:    notify
  :in:      int
  :subject: die ID des Artikels, der zum Startartikel wurde
  :params:  old_cat (int) die ID des vorherigen Startartikels

  wird ausgeführt, nachdem ein Artikel zum Startartikel einer Kategorie wurde

.. =============================================================================

.. slyevent:: SLY_ART_CONTENT_COPIED
  :type:    notify
  :in:      null
  :subject: N/A
  :params:
    from_id      (int)  die ID des Quellartikels
    from_clang   (int)  die Sprach-ID des Quellartikels
    to_id        (int)  die ID des Zielartikels
    to_clang     (int)  die Sprach-ID des Zielartikels
    start_slice  (int)  die ID des Slices, bei dem mit dem Kopieren begonnen wurde (ungenutzt seit Sally die Slices nicht mehr als verkettete Liste speichert)

  wird ausgeführt, nachdem der **Inhalt** eines Artikels kopiert wurde

.. =============================================================================

.. slyevent:: SLY_ART_COPIED
  :type:    notify
  :in:      int
  :subject: die ID des Quellartikels
  :params:
    id      (int)     ID des Quellartikels
    clang   (int)     ID der Sprache (siehe Beschreibung!)
    status  (int)     immer 0 (offline)
    name    (string)  Name des Quellartikels
    re_id   (int)     ID der Zielkategorie
    prior   (int)     Position des neuen Artikels
    path    (string)  Kategorie-Pfad (``|id|id|...|``)
    type    (string)  Artikeltyp

  wird ausgeführt, nachdem ein Artikel kopiert wurde (*wird einmal pro Sprache
  ausgeführt!*)

.. =============================================================================

.. slyevent:: SLY_ART_MOVED
  :type:    notify
  :in:      int
  :subject: die ID des Quellartikels
  :params:
    clang   (int)  ID der Sprache (siehe Beschreibung!)
    target  (int)  ID der Zielkategorie

  wird ausgeführt, nachdem ein Artikel verschoben wurde (*wird einmal pro
  Sprache ausgeführt!*)

.. =============================================================================

.. slyevent:: CLANG_ARTICLE_GENERATED
  :type:    notify
  :in:      string
  :subject: ein leerer String

  Wird ausgeführt, nachdem in ``OOArticleSlice::getSliceIdsForSlot()`` die IDs
  der Slices ermittelt wurden.
