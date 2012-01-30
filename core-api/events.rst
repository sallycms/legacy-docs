Eventsystem
===========

Im Eventsystem von Sally werden Benachrichtigungen über den globalen Dispatcher
gesendet. Dieser bietet drei Verfahren, wie die Ergebnisse mehrerer Listener
(Code, der auf Event reagiert) miteinander verknüpft werden:

* **notify**: Die Listener werden nur benachrichtigt. Ihr Rückgabewert wird
  verworfen, jeder erhält das gleiche Subject.
* **notifyUntil**: Wie notify, nur dass hierbei abgebrochen wird, wenn ein
  Listener ``true`` zurückgibt.
* **filter**: Die Listener haben die Aufgabe, das Subject zu verändern. Der
  Rückgabewert eines Listeners wird an den nächsten als Subject weitergeleitet.
  Der Rückgabewert des Aufrufs ist das Ergebnis des letzten Listeners.

Dispatcher
----------

Der Dispatcher kann wie folgt abgerufen werden:

.. sourcecode:: php

  <?
  $dispatcher = sly_Core::dispatcher();

Events auslösen
---------------

Bei jedem Aufruf müssen zwei und können drei Argumente angegeben werden:

* ``event``: Der Name des Events. Per Konvention in Großschreibung (wie bei
  Konstanten, z.B. ``MY_ADDON_EVENT``)
* ``subject``: Der Wert, der an die Listener übergeben werden soll. Siehe die
  Verknüpfungsstrategien für die Weitergabe des Subjects zwischen den Listenern.
* ``params`` (optional): Weitere Parameter als assoziatives Array.

*Beispiel*

.. sourcecode:: php

  <?
  $dispatcher = sly_Core::dispatcher();
  $nav        = sly_Core::getNavigation();

  $dispatcher->notify('SLY_PAGE_CHECKED', 'thePage');
  $nav = $dispatcher->filter('SLY_LAYOUT_NAVI', $nav, array('myparam' => 'myvalue'));

Für Events registrieren
-----------------------

Ein Listener kann wie folgt registriert werden:

.. sourcecode:: php

  <?
  $dispatcher = sly_Core::dispatcher();

  function myFunc($params) {
      $subject = $params['subject'];
  }

  $dispatcher->register('SLY_PAGE_CHECKED', 'myFunc');

Dabei ist zu beachten, dass der Listener korrekt auf die Verknüpfungsstragie
reagiert: Wenn es sich um ein filter-Event handelt und ein Listener nichts
zurückgibt, erhält der nächste Listener nur ``null`` als Subject.

.. note::

  Listeners können beliebige PHP Callables sein (in PHP 5.3 natürlich auch
  Closures oder anonyme Funktionen).

:tocdepth: 2

.. toctree::
   :hidden:

   events/core_articles
   events/core_categories
   events/core_media
   events/core_users
   events/core_models
   events/core_assetcache
   events/core_addons
   events/core_layout
   events/core_misc

   events/be_structure
   events/be_content
   events/be_slices
   events/be_mediapool
   events/be_users
   events/be_addons
   events/be_specials
   events/be_misc

Events
------

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
^^^^

Die folgenden Events werden von der Kern-API ausgelöst und können (teilweise)
sowohl im Backend (in jedem Backend, nicht zwangsweise dem
Sally-Standardbackend) als auch im Frontend auftreten.

.. hlist::
   :columns: 3

   * :doc:`events/core_articles`

     * CLANG_ARTICLE_GENERATED
     * SLY_ART_ADDED
     * SLY_ART_CONTENT_COPIED
     * SLY_ART_COPIED
     * SLY_ART_MOVED
     * SLY_ART_UPDATED
     * SLY_ART_DELETED
     * SLY_ART_STATUS
     * SLY_ART_STATUS_TYPES
     * SLY_ART_TO_STARTPAGE
     * SLY_ART_TYPE
     * SLY_CONTENT_UPDATED
     * SLY_SLICE_MOVED
     * URL_REWRITE

   * :doc:`events/core_categories`

     * SLY_CAT_MOVED

   * :doc:`events/core_media`

     * SLY_OOMEDIA_IS_IN_USE

   * :doc:`events/core_users`
   * :doc:`events/core_models`

     * SLY_MODEL\_*\_*

   * :doc:`events/core_assetcache`

     * SLY_CACHE_PROCESS_ASSET
     * SLY_CACHE_REVALIDATE_ASSETS
     * SLY_CACHE_GET_PROTECTED_ASSETS
     * SLY_CACHE_IS_PROTECTED_ASSET

   * :doc:`events/core_addons`

     * SLY_ADDON\_*\_*
     * SLY_PLUGIN\_*\_*

   * :doc:`events/core_layout`

     * HEADER_CSS
     * HEADER_CSS_FILES
     * HEADER_JAVASCRIPT
     * HEADER_JAVASCRIPT_FILES

   * :doc:`events/core_misc`

     * __AUTOLOAD
     * ADDONS_INCLUDED
     * OUTPUT_FILTER
     * OUTPUT_FILTER_CACHE
     * SLY_DB_IMPORTER_BEFORE
     * SLY_LISTENERS_REGISTERED
     * SLY_MAIL_CLASS
     * SLY_PRE_PROCESS_ARTICLE

Backend
^^^^^^^

Diese Liste umfasst alle Events, die vom Sally-Backend ausgelöst werden. Sie
umfasst nicht diejenigen Events, die von Models oder dem Core ausgelöst werden,
selbst wenn deren API vom Backend aufgerufen wird (so ist hier beispielsweise
nicht ``SLY_CONTENT_UPDATED`` enthalten).

.. hlist::
   :columns: 3

   * :doc:`events/be_structure`

     * PAGE_STRUCTURE_HEADER

   * :doc:`events/be_content`

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

   * :doc:`events/be_slices`

     * SLY_SLICE_PRESAVE_ADD
     * SLY_SLICE_PRESAVE_EDIT
     * SLY_SLICE_PRESAVE_DELETE
     * SLY_SLICE_POSTSAVE_ADD
     * SLY_SLICE_POSTSAVE_EDIT
     * SLY_SLICE_POSTSAVE_DELETE
     * SLY_SLICE_POSTVIEW_ADD
     * SLY_SLICE_POSTVIEW_EDIT

   * :doc:`events/be_mediapool`

     * PAGE_MEDIAPOOL_HEADER
     * PAGE_MEDIAPOOL_MENU
     * SLY_MEDIA_FORM_ADD
     * SLY_MEDIA_FORM_EDIT
     * SLY_MEDIA_FORM_SYNC
     * SLY_MEDIA_LIST_FUNCTIONS
     * SLY_MEDIA_LIST_QUERY
     * SLY_MEDIA_LIST_TOOLBAR

   * :doc:`events/be_users`

     * SLY_PAGE_USER_SUBPAGES

   * :doc:`Systemseite (Einstellungen & Sprachen) <events/be_specials>`

     * ALL_GENERATED
     * SLY_SETTINGS_UPDATED
     * SLY_SPECIALS_MENU

   * :doc:`Sonstige <events/be_misc>`

     * PAGE_CHECKED
     * PAGE_TITLE
     * PAGE_TITLE_SHOWN
     * SLY_LAYOUT_NAVI