AddOns
======

Der AddOn-Service löst immer dann ein Event aus, wenn sich der Status eines
AddOns ändert. Dabei gibt es immer ein ``PRE``- und ein ``POST``-Event. Jedes
der Event ist ein **notify**-Event, das das betroffene AddOn als Subject
übergeben erhält. AddOn-Namen werden immer vollständig angegeben (z.B.
``sallycms/be-search``).

.. note::

  Ein AddOn kann niemals auf seine eigene Aktivierung reagieren
  (deaktivierte Komponenten können nicht auf ``SLY_ADDON_POST_ACTIVATE``
  lauschen).

Es gibt die folgenden AddOn-Events:

* ``SLY_ADDON_PRE_INSTALL``
* ``SLY_ADDON_PRE_ACTIVATE``
* ``SLY_ADDON_PRE_DEACTIVATE``
* ``SLY_ADDON_PRE_UNINSTALL``
* ``SLY_ADDON_PRE_DELETE_PUBLIC``
* ``SLY_ADDON_PRE_DELETE_INTERNAL``
* ``SLY_ADDON_POST_INSTALL``
* ``SLY_ADDON_POST_ACTIVATE``
* ``SLY_ADDON_POST_DEACTIVATE``
* ``SLY_ADDON_POST_UNINSTALL``
* ``SLY_ADDON_POST_DELETE_PUBLIC``
* ``SLY_ADDON_POST_DELETE_INTERNAL``

Beispiel
--------

Das folgende Beispiel zeigt, wie man das Installieren eines AddOns verhindern
kann:

.. sourcecode:: php

  <?
  sly_Core::dispatcher()->register('SLY_ADDON_PRE_INSTALL', 'dontAllowEvilAddOn');

  function dontAllowEvilAddOn(array $params) {
    if ($params['addon'] === 'virtucon/evil-addon') {
      throw new Exception('Du darsft evil-addon nicht installieren.');
    }
  }
