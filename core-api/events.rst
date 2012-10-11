Eventsystem
===========

Im Eventsystem von Sally werden Benachrichtigungen über den globalen Dispatcher
gesendet. Dieser bietet drei Verfahren, wie die Ergebnisse mehrerer Listener
(Code, der auf Event reagiert) miteinander verknüpft werden:

**notify**
  Die Listener werden nur benachrichtigt. Ihr Rückgabewert wird verworfen, jeder
  erhält das gleiche Subject.

**notifyUntil**
  Wie notify, nur dass hierbei abgebrochen wird, wenn ein Listener ``true``
  zurückgibt.

**filter**
  Die Listener haben die Aufgabe, das Subject zu verändern. Der Rückgabewert
  eines Listeners wird an den nächsten als Subject weitergeleitet. Der
  Rückgabewert des Aufrufs ist das Ergebnis des letzten Listeners.

Dispatcher
----------

Der Dispatcher kann wie folgt abgerufen werden:

.. sourcecode:: php

  <?
  $dispatcher = sly_Core::dispatcher();

Events auslösen
---------------

Bei jedem Aufruf müssen zwei und können drei Argumente angegeben werden:

``event``
  Der Name des Events. Per Konvention in Großschreibung (wie bei Konstanten,
  z.B. ``MY_ADDON_EVENT``)

``subject``
  Der Wert, der an die Listener übergeben werden soll. Siehe die
  Verknüpfungsstrategien für die Weitergabe des Subjects zwischen den Listenern.

``params`` (optional)
  Weitere Parameter als assoziatives Array.

*Beispiel*

.. sourcecode:: php

  <?
  $dispatcher = sly_Core::dispatcher();
  $nav        = sly_Core::getNavigation();

  // ein notify-Event mit einem String als Subject und ohne weitere Parameter
  // auslösen
  $dispatcher->notify('SLY_CONTROLLER_FOUND', 'theCurrentController');

  // weitere Parameter mitgeben
  $dispatcher->notify('SLY_CONTROLLER_FOUND', 'theCurrentController', array(
    'myparam' => 'foo',
    'object'  => $this
  ));

  // filter-Events geben den Rückgabewert des letzten Listeners zurück
  // (in 99% der Fälle entspricht dies vom Typ dem, was als Subject reingegeben
  // wurde)
  $nav = $dispatcher->filter('SLY_LAYOUT_NAVI', $nav, array('myparam' => 'myvalue'));

Für Events registrieren
-----------------------

Ein Listener kann wie folgt registriert werden:

.. sourcecode:: php

  <?

  function myFunc(array $params) {
      $subject = $params['subject'];
  }

  $dispatcher = sly_Core::dispatcher();
  $dispatcher->register('SLY_CONTROLLER_FOUND', 'myFunc');

Dabei ist zu beachten, dass der Listener korrekt auf die Verknüpfungsstragie
reagiert: Wenn es sich um ein filter-Event handelt und ein Listener nichts
zurückgibt, erhält der nächste Listener nur ``null`` als Subject.

.. note::

  Listeners können beliebige PHP Callables sein (in PHP 5.3 natürlich auch
  Closures oder anonyme Funktionen).

.. toctree::
   :hidden:

   events/core_apps
   events/core_articles
   events/core_categories
   events/core_media
   events/core_mediacats
   events/core_users
   events/core_catchall
   events/core_assetcache
   events/core_addons
   events/core_languages
   events/core_layout
   events/core_misc

   events/be_structure
   events/be_content
   events/be_slices
   events/be_mediapool
   events/be_users
   events/be_specials
   events/be_misc

   events/fe_misc
   events/fe_article

Events
------

Dies ist eine Auflistung aller vom Core und der Backend-Anwendung gesendet
Events.

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

     * SLY_ART_ADDED
     * SLY_ART_COPIED
     * SLY_ART_CONTENT_COPIED
     * SLY_ART_DELETED
     * SLY_ART_MOVED
     * SLY_ART_PRE_DELETE
     * SLY_ART_STATUS
     * SLY_ART_STATUS_TYPES
     * SLY_ART_TO_STARTPAGE
     * SLY_ART_TYPE
     * SLY_ART_UPDATED
     * URL_REWRITE

   * :doc:`events/core_categories`

     * SLY_CAT_ADDED
     * SLY_CAT_DELETED
     * SLY_CAT_MOVED
     * SLY_CAT_PRE_DELETE
     * SLY_CAT_STATUS
     * SLY_CAT_STATUS_TYPES
     * SLY_CAT_UPDATED

   * :doc:`events/core_media`

     * SLY_MEDIA_ADDED
     * SLY_MEDIA_DELETED
     * SLY_MEDIA_UPDATED
     * SLY_MEDIUM_FILENAME

   * :doc:`events/core_mediacats`

     * SLY_MEDIACAT_ADDED
     * SLY_MEDIACAT_DELETED
     * SLY_MEDIACAT_UPDATED

   * :doc:`events/core_users`

     * SLY_USER_ADDED
     * SLY_USER_DELETED
     * SLY_USER_PRE_DELETE
     * SLY_USER_UPDATED

   * :doc:`events/core_layout`

     * HEADER_CSS
     * HEADER_CSS_FILES
     * HEADER_JAVASCRIPT
     * HEADER_JAVASCRIPT_FILES
     * PAGE_HEADER

   * :doc:`events/core_assetcache`

     * SLY_CACHE_PROCESS_ASSET
     * SLY_CACHE_REVALIDATE_ASSETS
     * SLY_CACHE_GET_PROTECTED_ASSETS
     * SLY_CACHE_IS_PROTECTED_ASSET

   * :doc:`events/core_addons`

     * SLY_ADDON\_*\_*
     * SLY_PLUGIN\_*\_*

   * :doc:`events/core_apps`

     * SLY_CONTROLLER_FOUND

   * :doc:`events/core_catchall`

     * SLY_MODEL\_*\_*
     * SLY_SLICEVALUES\_*\_*
     * SLY_SLICEFORM\_*\_*

   * :doc:`events/core_misc`

     * __AUTOLOAD
     * ADDONS_INCLUDED
     * OUTPUT_FILTER
     * SLY_DB_IMPORTER_AFTER
     * SLY_DB_IMPORTER_BEFORE
     * SLY_LISTENERS_REGISTERED
     * SLY_MAIL_CLASS
     * SLY_CACHE_CLEARED
     * SLY_SEND_RESPONSE
     * SLY_DEVELOP_REFRESHED
     * SLY_BOOTCACHE_CLASSES\_*

Backend
^^^^^^^

Diese Liste umfasst alle Events, die vom Sally-Backend ausgelöst werden. Sie
umfasst nicht diejenigen Events, die von Models oder dem Core ausgelöst werden,
selbst wenn deren API vom Backend aufgerufen wird.

.. hlist::
   :columns: 2

   * :doc:`events/be_structure`

     * CAT_FORM_EDIT
     * PAGE_STRUCTURE_HEADER

   * :doc:`events/be_content`

     * ART_SLICE_MENU
     * PAGE_CONTENT_HEADER
     * SLY_ART_META_UPDATED
     * SLY_ART_MESSAGES
     * SLY_ART_META_FORM
     * SLY_ART_META_FORM_FIELDSET
     * SLY_ART_META_FORM_ADDITIONAL
     * SLY_PAGE_CONTENT_ACTIONS_MENU
     * SLY_PAGE_CONTENT_SLOT_MENU

   * :doc:`events/be_mediapool`

     * PAGE_MEDIAPOOL_HEADER
     * SLY_MEDIAPOOL_MENU
     * SLY_MEDIA_FORM_ADD
     * SLY_MEDIA_FORM_EDIT
     * SLY_MEDIA_FORM_SYNC
     * SLY_MEDIA_LIST_FUNCTIONS
     * SLY_MEDIA_LIST_QUERY
     * SLY_MEDIA_LIST_TOOLBAR
     * SLY_MEDIA_USAGES

   * :doc:`events/be_users`

     * SLY_USER_FORM

   * :doc:`Systemseite (Einstellungen & Sprachen) <events/be_specials>`

     * SLY_SETTINGS_UPDATED

   * :doc:`events/be_slices`

     * SLY_CONTENT_UPDATED
     * SLY_SLIVE_MOVED
     * SLY_SLICE_PRESAVE_ADD
     * SLY_SLICE_PRESAVE_EDIT
     * SLY_SLICE_PRESAVE_DELETE
     * SLY_SLICE_POSTSAVE_ADD
     * SLY_SLICE_POSTSAVE_EDIT
     * SLY_SLICE_POSTSAVE_DELETE
     * SLY_SLICE_POSTVIEW_ADD
     * SLY_SLICE_POSTVIEW_EDIT

   * :doc:`Sonstige <events/be_misc>`

     * PAGE_CHECKED
     * PAGE_TITLE
     * PAGE_TITLE_SHOWN
     * SLY_LAYOUT_NAVI


Frontend
^^^^^^^^

Diese Liste umfasst alle Events, die vom Sally-Frontend ausgelöst werden.

.. hlist::
   :columns: 1

   * :doc:`events/fe_misc`

     * SLY_FRONTEND_ROUTER

   * :doc:`events/fe_article`

     * SLY_ARTICLE_OUTPUT
     * SLY_CURRENT_ARTICLE
     * SLY_RESOLVE_ARTICLE
