Frontend-Controller
===================

SallyCMS erlaubt es, Controller nicht nur im Backend (über AddOns), sondern auch
im Frontend zu verwenden. Im Standard-Umfang von Sally sind zwei Controller
bereits enthalten: Der *Artikel-Controller* rendert Artikel (und ist der
Standard-Controller) und der *Asset-Controller* steuert den
:doc:`Asset-Cache </core-api/assetcache>`.

Frontend-Controller müssen dem Namensschema **sly_Controller_Frontend_Xxx**
folgen und über eine Route ansprechbar gemacht werden. Die Implementierungen
können überall liegen, wo sie vom Autoloader gefunden werden können (also sowohl
in AddOns als auch in :file:`develop/lib`).

.. warning::

  Es kann immer nur ein Controller gleichzeitig ausgeführt werden. Daher gibt es
  in Frontend-Controllern **keinen Artikelkontext** (da kein Artikel gesucht
  wurde). Ein Aufruf von ``sly_Core::getCurrentArticle()`` gibt daher ``null``
  zurück. Ebenso gibt es keine **aktuelle Sprache**.

  Beide Angaben können vom Controller natürlich jederzeit gesetzt werden. So
  könnte die Sprache auf die voreingestellte Sprache oder der aktuelle Artikel
  auf den Seiten-Startartikel gesetzt werden.

Beispiel-Controller
-------------------

Wir entwickeln im Folgenden einen Controller, der einfach nur das Wort *hallo*
ausgibt. Dazu legen wir einen ``sly_Controller_Frontend_Hello`` an und legen ihn
in :file:`develop/lib/sly/Controller/Frontend/Hello.php` ab.

.. literalinclude:: hellocontroller.php
   :language: php

Routing
-------

Der Router (``sly_Router_Base``) versucht, anhand von URL-Mustern die angefragte
URL aufzulösen und dabei den Controller (und ggf. weitere Parameter) zu
ermitteln.

Im Normalfall gibt es in Sally keine vordefinierten Routen. Die Frontend-App
erlaubt es allerdings, im :doc:`SLY_FRONTEND_ROUTER-Event </core-api/events/fe_misc>`
eigene Routen zu definieren. Dies nutzen wir nun dazu, unseren Hello-Controller
ansprechbar zu machen.

.. note::

  Das Hinzufügen der Routen kann überall passieren, wo auf dieses Event
  gelauscht werden kann. Aus Komfortgründen liegt der Code in diesem Beispiel
  direkt in der Controller-Klasse. *Überlicherweise sollten die Routen
  allerdings nicht im Controller definiert werden!*

.. literalinclude:: hellorouting.php
   :language: php

Event-Konfiguration
-------------------

Die ``addRoutes()``-Methode muss nun nur noch beim Feuern des Events ausgeführt
werden. Dazu registrieren wir über eine beliebige Konfigurationsdatei in
:file:`develop/config` einen Listener:

.. sourcecode:: yaml

  LISTENERS:
     SLY_FRONTEND_ROUTER: ['sly_Controller_Frontend_Hello::addRoutes']

Ergebnis
--------

Wenn alles funktioniert hat, kann man nun im Browser die URL
**example.com/hello** oder **example.com/hello/tom** aufrufen.
