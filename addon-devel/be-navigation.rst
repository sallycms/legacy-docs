Backend-Navigation
==================

SallyCMS verwendet ab Version 0.3 eine neue API, um das Backend im Menü zu
erstellen. Diese soll hier kurz erklärt werden.

Die gesamte Navi wird von der ``sly_Layout_Navigation_Sally``-Instanz in
``sly_Core`` verwaltet und kann wie folgt abgerufen werden:

.. sourcecode:: php

  <?
  $nav = sly_Core::getNavigation();

In der Navigation gibt es eine assoziative Liste von Gruppen, die jeweils die
einzelnen Seiten enthalten. Es werden zwei Gruppen vorangelegt:

* **system**: Basis-Navigation
* **addon**: AddOn-Seiten

Seiten können eine Liste von Unterseiten enthalten. Damit ergibt sich eine
Klassenstruktur wie folgt:

* Navigation (``sly_Layout_Navigation_Sally``)

  * Gruppe 1 (``sly_Layout_Navigation_Group``)

    * Seite 1 (``sly_Layout_Navigation_Page``)
    * Seite 2
    * Seite 3

  * Gruppe 2

    * Seite 4

      * Unterseite 1 (``sly_Layout_Navigation_Subpage``)
      * Unterseite 2

    * Seite 5

Neue Seiten können über Helfermethoden erzeugt oder direkt als entsprechendes
Objekt in die Navigation eingefügt werden. Dabei muss immer die Gruppe angegeben
werden.

Jede Seite besteht aus den folgenden Eigenschaften:

* **name**: interner Name (entspricht dem Controller-Namen bei Core-Seiten und
  dem Verzeichnis von AddOns)
* **title**: angezeigter Name
* **popup**: Gibt an, ob der Link auf ein Popup zeigen wird (Legacy).
* **pageParam**: Entspricht per default dem internen Namen, kann aber geändert
  werden. Gibt an, wie der Wert des URL-Parameter ``?page=...`` lauten soll.
* **hidden**: Wenn true, wird der Menüpunkt im Standard-View des Backends nicht
  angezeigt.

Code-Beispiele
--------------

Code sagt mehr als tausend Worte...

Neue AddOn-Seite anlegen
^^^^^^^^^^^^^^^^^^^^^^^^

.. sourcecode:: php

  <?
  $nav = sly_Core::getNavigation();
  $nav->addPage('addon', 'myaddon', 'Mein AddOn');

Der dritte Parameter (der Titel) kann leergelassen (``null``) werden. In diesem
Fall wird der interne Name als I18N-Key verwendet.

Seite finden und ändern
^^^^^^^^^^^^^^^^^^^^^^^

.. sourcecode:: php

  <?
  $nav  = sly_Core::getNavigation();
  $page = $nav->find('myaddon');

  $page->setTitle('Mein anderes AddOn');

Neue Gruppe anlegen
^^^^^^^^^^^^^^^^^^^

.. sourcecode:: php

  <?
  $nav = sly_Core::getNavigation();
  $nav->addGroup('mygroup', 'Meine Gruppe');

Subpages verwalten
^^^^^^^^^^^^^^^^^^

.. sourcecode:: php

  <?
  $nav = sly_Core::getNavigation();

  $page = $nav->createPage('myaddon', 'Mein AddOn');
  $page->addSubpage('mysublink', 'Unterseite 1');
  $page->addSubpage('sub2', 'Unterseite 2');

  $nav->addPageObj('addon', $page);

Der Titel einer Subpage kann leergelassen (``null``) werden. In diesem Fall wird
ihr interner Name als I18N-Key verwendet.

Aktive Seite/Gruppe finden
^^^^^^^^^^^^^^^^^^^^^^^^^^

.. sourcecode:: php

  <?
  $nav   = sly_Core::getNavigation();
  $page  = $nav->getActivePage();
  $group = $nav->getActiveGroup();

Daten auslesen
^^^^^^^^^^^^^^

.. sourcecode:: php

  <?
  $nav    = sly_Core::getNavigation();
  $pages  = $nav->getGroup('addon')->getPages(); // array(a,b,c)
  $groups = $nav->getGroups();                   // array(name:title, name:title)
