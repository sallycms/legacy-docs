Inhaltsverwaltung
=================

Die auf dieser Seite aufgelisteten Events werden von der Inhaltsverwaltung des
Backends ausgelöst. Nicht enthalten sind diejenigen Events, die von
:doc:`core_articles` und :doc:`core_categories` ausgelöst werden. Ebenfalls
nicht enthalten sind die :doc:`generischen PRE- und POST-Events <be_slices>`
für Slices.

.. slyevent:: PAGE_CONTENT_HEADER
  :type:    filter
  :in:      string
  :out:     string
  :since:   0.1.0
  :subject: das Menü (der erste Listener erhält einen leeren String)
  :params:
    article_id        (int)
    clang             (int)
    function          (string)
    mode              (string)
    slice_id          (int)
    page              (string)
    slot              (string)
    category_id       (int)
    article_revision  (int)
    slice_revision    (int)

  erzeugt eine Titelzeile über der Sliceseite (wird z.B. von BeSearch genutzt)

.. =============================================================================

.. slyevent:: SLY_ART_META_UPDATED
  :type:    notify
  :in:      null
  :since:   0.5.0
  :subject: N/A
  :params:
    id     (int)
    clang  (int)

  Wird ausgeführt, nachdem die **Metadaten** eines Artikels aktualisiert wurden.
  Vor Version 0.5 hieß dieses Event noch ``ART_META_UPDATED``.

.. =============================================================================

.. slyevent:: PAGE_CONTENT_SLOT_MENU
  :type:    filter
  :in:      array
  :out:     array
  :since:   0.3.0
  :subject: Array von Links auf die Slotseiten
  :params:
    article_id  (int)
    clang       (int)
    function    (string)
    mode        (string)
    slice_id    (int)

  ermöglicht die Erweiterung der Slotliste auf der Sliceseite

.. =============================================================================

.. slyevent:: PAGE_CONTENT_MENU
  :type:    filter
  :in:      array
  :out:     array
  :since:   0.1.0
  :subject: Array von Links auf die Slotseiten
  :params:
    article_id  (int)
    clang       (int)
    function    (string)
    mode        (string)
    slice_id    (int)

  ermöglicht die Erweiterung des Slice/Meta/Anzeigen-Menüs auf der Sliceseite

.. =============================================================================

.. slyevent:: SLY_ART_MESSAGES
  :type:    notify
  :in:      sly_Model_Article
  :since:   0.4.0
  :subject: der aktuell im Backend bearbeitete Artikel

  ermöglicht das Anzeigen von Erfolgs/Fehlernachrichten auf der Sliceseite
  (insbesondere nützlich, nachdem auf ``SLY_ART_META_UPDATED`` reagiert wurde)

.. =============================================================================

.. slyevent:: SLY_ART_META_FORM
  :type:    filter
  :in:      sly_Form
  :out:     sly_Form
  :subject: das Formular, in dem die Metadaten, Artikelname und Zusatzfunktionen
            (wie die Buttons zum Kopieren des Artikels) enthalten sind
  :params:
    id       (int)
    clang    (int)
    article  (``sly_Model_Article``)

  ermöglicht das Erweitern des Meta-Formulars

.. =============================================================================

.. slyevent:: SLY_ART_META_FORM_FIELDSET
  :type:    filter
  :in:      sly_Form
  :out:     sly_Form
  :subject: wie bei ``SLY_ART_META_FORM``
  :params:
    id       (int)
    clang    (int)
    article  (``sly_Model_Article``)

  Erlaubt es, sich direkt in das oberste Fieldset (das auch "Metadaten" betitelt
  ist) reinzuhängen und dort weitere Elemente hinzuzufügen. Praktisch, wenn man
  kein eigenes Fieldset verwenden möchte.

.. =============================================================================

.. slyevent:: SLY_ART_META_FORM_ADDITIONAL
  :type:    filter
  :in:      sly_Form
  :out:     sly_Form
  :since:   0.5.5
  :subject: wie bei ``SLY_ART_META_FORM``
  :params:
    id       (int)
    clang    (int)
    article  (``sly_Model_Article``)

  Erlaubt es, das komplette Meta-Formular noch einmal zu verändern, bevor es
  ausgegeben wird.

.. =============================================================================

.. slyevent:: ART_SLICE_MENU
  :type:    filter
  :in:      array
  :out:     array
  :subject: die vom Core vorgegebenene Menüpunkte für ein Slice
  :params:
    article_id (int)
    clang      (int)
    slot       (string)
    module     (string)
    slice_id   (int)

  Über dieses Event können Listener das Slice-Menü erweitern. Dieses Menü wird
  bei jedem Slice angezeigt und erlaubt es, diese zu löschen, bearbeiten oder zu
  verschieben.

.. =============================================================================

.. slyevent:: SLY_PAGE_CONTENT_SLOT_MENU
  :type:    filter
  :in:      array
  :out:     array
  :subject: die vom Core vorgegebenene Links für die Slots
  :params:
    article_id (int)
    clang      (int)

  Über dieses Event können Listener die Liste der Slots für einen Artikel
  erweitern. Das Slot-Menü wird überhalb der Artikelslices auf der linken Seite
  angezeigt (während auf der rechten Seite das Actions-Menü ist).

.. =============================================================================

.. slyevent:: SLY_PAGE_CONTENT_ACTIONS_MENU
  :type:    filter
  :in:      array
  :out:     array
  :subject: die vom Core vorgegebenene Links
  :params:
    article_id (int)
    clang      (int)

  Über dieses Event können Listener die Liste der Aktionslinks für einen Artikel
  erweitern. Diese Links werden auf der rechten Seite über dem Artikelinhalt
  angezeigt und erlauben by default den Zugriff auf Slices, die Metadaten und
  die Vorschau im Frontend.