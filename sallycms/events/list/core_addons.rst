AddOns & Plugins
================

Der AddOn-Service löst immer dann ein Event aus, wenn sich der Status eines
AddOns oder Plugins ändert. Dabei gibt es immer ein ``PRE``- und ein ``POST``-
Event. Jedes der Event ist ein **filter**-Event, das ``true`` als Subject
erhält und die aktuelle Aktion abbrechen kann, indem der Rückgabewert auf
``false`` geändert wird. So kann beispielsweise das Deaktivieren eines AddOns
abgebrochen werden.

.. note::

  Ein AddOn/Plugin kann niemals auf seine eigene Aktivierung reagieren
  (deaktivierte Komponenten können nicht auf ``SLY_X_POST_ACTIVATE`` lauschen).

AddOns
------

Es gibt die folgenden AddOn-Events:

* ``SLY_ADDON_PRE_INSTALL``
* ``SLY_ADDON_PRE_ACTIVATE``
* ``SLY_ADDON_PRE_DEACTIVATE``
* ``SLY_ADDON_PRE_UNINSTALL``
* ``SLY_ADDON_POST_INSTALL``
* ``SLY_ADDON_POST_ACTIVATE``
* ``SLY_ADDON_POST_DEACTIVATE``
* ``SLY_ADDON_POST_UNINSTALL``

Jedem Event wird als weiterer Parameter der Name des AddOns als ``addon``
übergeben.

Plugins
-------

Für Plugins gibt es die gleichen Events wie für AddOns, nur dass sie
``SLY_PLUGIN_...`` heißen. Ihnen werden der Name des AddOns (``addon``) und der
Name des Plugins (``plugin``) übergeben.

Beispiel
--------

Das folgende Beispiel zeigt, wie man das Installieren eines AddOns verhindern
kann:

.. sourcecode:: php

  <?
  sly_Core::dispatcher()->register('SLY_ADDON_PRE_INSTALL', 'dontAllowEvilAddOn');

  function dontAllowEvilAddOn(array $params) {
    // Falls ein vorheriger Listener bereits false zurückgegeben hat,
    // leiten wir den Wert einfach nur weiter, um dessen Entscheidung
    // nicht zu überschreiben. Ist insbes. zu empfehlen, wenn unser
    // eigener Code recht aufwändig ist, sodass wir auf diese Weise
    // die Ausführung einsparen können.
    if (!$params['subject']) return false;

    // verbieten
    if ($params['addon'] === 'evil_addon') return false;

    // erlauben
    return true;
  }
