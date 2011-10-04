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
