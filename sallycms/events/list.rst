Events
======

Dies ist eine Auflistung aller vom Core gesendet Events. Für eine Erklärung dazu
siehe die Seite zum :doc:`Eventsystem <index>`.

.. note::

  Leider sind die Events [noch] nicht konsistent benannt und haben daher nicht
  alle das Präfix ``SLY_``. Wir arbeiten daran, die Namen nach und nach zu
  vereinheitlichen.

Zur Vereinfachung wird im Folgenden eine Pseudo-Syntax verwendet, um zu
kennzeichnen, welche Ein- und Ausgaben die Events jeweils haben. Dabei wird so
getan, als wären Events Methoden und ihre "Signaturen" aufgelistet.

``string MY_EVENT(string)``
  Stellt ein Event dar, dass einen ``string`` als Eingabe ("Subject") erhält und
  einen String zurückgeben muss (ein **Filter-Event**). In den meisten Fällen
  müssen Listener den gleichen Typ zurückgeben, den sie auch im Subject
  reingegeben bekommen (damit der nachfolgende Listener happy ist).
``void ANOTHER_EVENT(int)``
  Ein Event, das ein ``int`` als Eingabe erhält und nichts zurückgeben muss
  (ein **Notify-Event**). Rückgabewerte sind möglich, werden aber vom System
  nicht ausgewertet und sind daher nutzlos.
``string FILTER_UNTIL_EVENT(int) BREAKS``
  Ein Event, das ebenfalls ein ``int`` als Eingabe erhält. Der erste Listener,
  der etwas anderes als ``null`` zurückgibt, "gewinnt" (ein
  **Filter-Until-Event**). Wird beispielsweise bei ``URL_REWRITE`` verwendet,
  bei dem die erste von einem Listener erzeugte URL gewinnt und alle weiteren
  Listener nicht ausgeführt werden.

.. note::

  Neben dem Subject (das oben als Parameter dargestellt wird) werden einem
  Listener in vielen Fällen noch weitere Daten übergeben. Da diese keiner
  allgemeinen Struktur oder Reihenfolge folgen, werden sie in der Signatur nicht
  erwähnt.

Backend
-------

Die folgenden Events werden (was Sally angeht) nur im Backend ausgelöst.
Natürlich ist es möglich, dass Frontend-Code beliebige Events auslöst (und
darunter auch die Core-Events sind), aber dabei würde es sich um ein Problem mit
der Frontend-Logik handeln: Warum sollte man im Frontend ``PAGE_CHECKED``
auslösen?

.. slyevent:: PAGE_CONTENT_HEADER
  :type:    filter
  :in:      string
  :out:     string
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

.. slyevent:: SLY_CONTENT_UPDATED
  :type:    notify
  :in:      string
  :subject: ein leerer String
  :params:
    article_id  (int)
    clang       (int)

  wird ausgeführt, nachdem der Inhalt eines Artikels aktualisiert wurde

.. =============================================================================

.. slyevent:: ART_META_UPDATED
  :type:    notify
  :in:      string
  :subject: die Erfolgsnachricht des Cores (kann um eigene Meldungen erweitert
            werden)
  :params:
    id     (int)
    clang  (int)

  wird ausgeführt, nachdem die **Metadaten** eines Artikels aktualisiert wurden

.. =============================================================================

.. slyevent:: PAGE_CONTENT_SLOT_MENU
  :type:    filter
  :in:      array
  :out:     array
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
  :subject: der aktuell im Backend bearbeitete Artikel

  ermöglicht das Anzeigen von Erfolgs/Fehlernachrichten auf der Sliceseite
  (insbesondere nützlich, nachdem auf ``ART_META_UPDATED`` reagiert wurde)

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
    article  (sly_Model_Article)

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
    article  (sly_Model_Article)

  Erlaubt es, sich direkt in das oberste Fieldset (das auch "Metadaten" betitelt
  ist) reinzuhängen und dort weitere Elemente hinzuzufügen. Praktisch, wenn man
  kein eigenes Fieldset verwenden möchte.

.. =============================================================================

.. slyevent:: PAGE_CHECKED
  :type:    notify
  :in:      string
  :subject: der Name der aktuellen Backendseite
  :params:
    id       (int)
    clang    (int)
    article  (sly_Model_Article)

  benachrichtigt über die endgültig festgelegte Backend-Seite, die nun
  ausgeführt wird
