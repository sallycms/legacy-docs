Events
======

Dies ist eine Auflistung aller vom Core und der Backend-Anwendung gesendet
Events. Für eine Erklärung dazu siehe die Seite zum :doc:`Eventsystem <index>`.

.. note::

  Leider sind die Events [noch] nicht konsistent benannt und haben daher nicht
  alle das Präfix ``SLY_``. Wir arbeiten daran, die Namen nach und nach zu
  vereinheitlichen.

Zur Vereinfachung wird im Folgenden eine Pseudo-Syntax verwendet, um zu
kennzeichnen, welche Ein- und Ausgaben die Events jeweils haben. Dabei wird so
getan, als wären Events Methoden und ihre "Signaturen" aufgelistet.

``string MY_EVENT(string)``
  Stellt ein Event dar, das einen ``string`` als Eingabe ("Subject") erhält und
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
  **Notify-Until-Event**). Wird beispielsweise bei ``URL_REWRITE`` verwendet,
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

  benachrichtigt über die endgültig festgelegte Backend-Seite, die nun
  ausgeführt wird

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

.. slyevent:: SLY_CAT_MOVED
  :type:    notify
  :in:      int
  :subject: die ID der Quellkategorie
  :params:
    clang   (int)  ID der Sprache (siehe Beschreibung!)
    target  (int)  ID der Zielkategorie

  wird ausgeführt, nachdem eine Kategorie verschoben wurde (*wird einmal pro
  Sprache ausgeführt!*)

.. =============================================================================

.. slyevent:: ALL_GENERATED
  :type:    filter
  :in:      string
  :out:     string
  :subject: die Erfolgsnachricht

  Wird ausgeführt, nachdem der Core-Cache (Artikel, Templates, ...) geleert
  wurde. Alle Bestandteile des Systems, die Daten in irgendeiner Art cachen,
  sollten auf dieses Event reagieren und ihren Cache **vollständig** leeren.

.. note::

  Im laufenden Betrieb sollte es nie nötig sein, dieses Event auszulösen, um
  Caches zu invalidieren.

Frontend
--------

Die folgenden Events werden nur im Frontend ausgelöst.

.. slyevent:: SLY_PRE_PROCESS_ARTICLE
  :type:    filter
  :in:      sly_Model_Article
  :out:     sly_Model_Article
  :subject: der ermittelte Artikel (die meisten realurl-Implementierungen
            haben bereits den Request abgearbeitet, sodass hier beispielsweise
            bei RealURL2 bereits der richtige Artikel bereitsteht)

  gibt Listenern und AddOns eine letzte Chance, den anzuzeigenden Artikel zu
  verändern, bevor dessen Template schlussendlich eingebunden und ausgeführt
  wird

Frontend & Backend
------------------

.. slyevent:: OUTPUT_FILTER
  :type:    filter
  :in:      string
  :out:     string
  :subject: der vollständige, generierte HTML-Code
  :params:  environment (string) 'frontend' oder 'backend'

  ermöglicht eine letzte Korrktur/Erweiterung der Ausgabe, bevor sie an den
  Client gesendet wird

.. =============================================================================

.. slyevent:: OUTPUT_FILTER_CACHE
  :type:    notify
  :in:      string
  :subject: der finale HTML-Code

  Nachdem Listener in ``OUTPUT_FILTER`` ihre letzten Änderungen vorgenommen
  haben, ist das Subject in diesem Event readonly und eignet sich daher ideal
  zum Cachen der Seite. Zwischen diesem Event und dem Senden des Inhalts an den
  Client besteht keine Möglichkeit mehr, den Inhalt zu verändern.
