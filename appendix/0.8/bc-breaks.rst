Kompatibilitätsinformationen
============================

Auf dieser Seite werden alle rückwärts-inkompatiblen API-Änderungen aus allen
0.8-Releases dokumentiert.

0.8.0 -> 0.8.1
-----------------

* ``sly_Model_User->setAttrubute()`` wurde entfernt und durch ``setAttribute()``
  ersetzt.
* ``sly_Helper_Message::renderFlashMessage()`` erwartet nun eine Instanz von
  ``sly_Util_FlashMessage`` (anstatt ``sly_Util_Flash``).

0.8.1 -> 0.8.2
-----------------

* (keine)

0.8.2 -> 0.8.3
--------------

* Standardmäßig kommt nun lessphp in Version 0.4+ zum Einsatz, da das Backend
  jetzt zusätzlich auch mit dieser Version kompatibel ist. Projekte, die nicht
  auf Version 0.4 umgestellt werden können (weil z.B. die Projekt-Assets nicht
  kompatibel sind), können über ein explizites Requirement in der
  :file:`composer.json` auf 0.3.* beschränkt werden:

  .. sourcecode:: javascript

    {
      ...
      "require": {
        ...
        "leafo/lessphp": "0.3.*"
      }
      ...
    }

  Das Sally-Backend ist mit beiden Versionen kompatibel.

0.8.3 -> 0.8.next
-----------------

* Das wird die Zeit zeigen...
