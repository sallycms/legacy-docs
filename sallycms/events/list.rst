:tocdepth: 2

.. toctree::
   :hidden:

   list/core_articles
   list/core_categories
   list/core_media
   list/core_users
   list/core_models
   list/core_assetcache
   list/core_addons
   list/core_layout
   list/core_misc

   list/be_structure
   list/be_content
   list/be_slices
   list/be_mediapool
   list/be_users
   list/be_addons
   list/be_specials
   list/be_misc

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

Core
----

Die folgenden Events werden von der Kern-API ausgelöst und können (teilweise)
sowohl im Backend (in jedem Backend, nicht zwangsweise dem
Sally-Standardbackend) als auch im Frontend auftreten.

.. hlist::
   :columns: 3

   * :doc:`list/core_articles`

     * CLANG_ARTICLE_GENERATED
     * SLY_ART_CONTENT_COPIED
     * SLY_ART_COPIED
     * SLY_ART_MOVED
     * SLY_ART_TO_STARTPAGE
     * SLY_CONTENT_UPDATED
     * SLY_SLICE_MOVED
     * URL_REWRITE

   * :doc:`list/core_categories`

     * SLY_CAT_MOVED

   * :doc:`list/core_media`

     * SLY_OOMEDIA_IS_IN_USE

   * :doc:`list/core_users`
   * :doc:`list/core_models`

     * SLY_MODEL\_*\_*

   * :doc:`list/core_assetcache`
   * :doc:`list/core_addons`
   * :doc:`list/core_layout`

     * HEADER_CSS
     * HEADER_CSS_FILES
     * HEADER_JAVASCRIPT
     * HEADER_JAVASCRIPT_FILES

   * :doc:`list/core_misc`

     * __AUTOLOAD
     * ADDONS_INCLUDED
     * OUTPUT_FILTER
     * OUTPUT_FILTER_CACHE
     * SLY_DB_IMPORTER_BEFORE
     * SLY_LISTENERS_REGISTERED
     * SLY_MAIL_CLASS
     * SLY_PRE_PROCESS_ARTICLE

Backend
-------

Diese Liste umfasst alle Events, die vom Sally-Backend ausgelöst werden. Sie
umfasst nicht diejenigen Events, die von Models oder dem Core ausgelöst werden,
selbst wenn deren API vom Backend aufgerufen wird (so ist hier beispielsweise
nicht ``SLY_CONTENT_UPDATED`` enthalten).

.. hlist::
   :columns: 3

   * :doc:`list/be_structure`

     * PAGE_STRUCTURE_HEADER

   * :doc:`list/be_content`

     * ART_SLICE_MENU
     * PAGE_CONTENT_HEADER
     * PAGE_CONTENT_SLOT_MENU
     * PAGE_CONTENT_MENU
     * SLY_ART_META_UPDATED
     * SLY_ART_MESSAGES
     * SLY_ART_META_FORM
     * SLY_ART_META_FORM_FIELDSET
     * SLY_ART_META_FORM_ADDITIONAL
     * SLY_PAGE_CONTENT_ACTIONS_MENU
     * SLY_PAGE_CONTENT_SLOT_MENU

   * :doc:`list/be_slices`

     * SLY_SLICE_PRESAVE_ADD
     * SLY_SLICE_PRESAVE_EDIT
     * SLY_SLICE_PRESAVE_DELETE
     * SLY_SLICE_POSTSAVE_ADD
     * SLY_SLICE_POSTSAVE_EDIT
     * SLY_SLICE_POSTSAVE_DELETE
     * SLY_SLICE_POSTVIEW_ADD
     * SLY_SLICE_POSTVIEW_EDIT

   * :doc:`list/be_mediapool`

     * PAGE_MEDIAPOOL_HEADER
     * PAGE_MEDIAPOOL_MENU
     * SLY_MEDIA_FORM_ADD
     * SLY_MEDIA_FORM_EDIT
     * SLY_MEDIA_FORM_SYNC
     * SLY_MEDIA_LIST_FUNCTIONS
     * SLY_MEDIA_LIST_QUERY
     * SLY_MEDIA_LIST_TOOLBAR

   * :doc:`list/be_users`

     * SLY_PAGE_USER_SUBPAGES

   * :doc:`AddOn-Verwaltung <list/be_addons>`
   * :doc:`Systemseite (Einstellungen & Sprachen) <list/be_specials>`

     * ALL_GENERATED
     * SLY_SETTINGS_UPDATED
     * SLY_SPECIALS_MENU

   * :doc:`Sonstige <list/be_misc>`

     * PAGE_CHECKED
     * PAGE_TITLE
     * PAGE_TITLE_SHOWN
     * SLY_LAYOUT_NAVI
