LESS
====

`LESS`_ ist eine Core-Komponente. Dabei handelt es sich grob gesagt um eine
serverseitige Erweiterung für CSS-Code, die in einem Verarbeitungsschritt aus
CSS-ähnlichem, aber erweitertem Code, CSS erzeugt. In LESS-Code sind Konstanten,
Verschachtelung und "Funktionen" möglich. Außerdem wird das erzeugte CSS direkt
validiert und minimiert.

LESS ist auch im Frontend aktiviert. Alle Dateien, die in :file:`assets/css/`
liegen und auf ``.less`` enden, werden beim Aufruf durch den
:doc:`Asset-Cache </core-api/assetcache>` automatisch auch mit `lessphp`_ (einer
PHP-Implementierung von LESS) verarbeitet.

.. _LESS: http://lesscss.org/
.. _lessphp: https://github.com/leafo/lessphp

.. note::

  Für Projekte, die von älteren Sally-Versionen migriert werden, kann der
  :ref:`Support für Scaffold <scaffold>` über ein AddOn nachgerüstet werden.

Beispiel
--------

.. sourcecode:: css

  @mycolor: #F00;

  .class {
     .tab-indented {
        #my-id {
           color: blue;
           margin: 10px;
           background: @mycolor;
        }

        .short { single: definition; }
        .wee   { another: def; }
        .tiny  { please: endthis; }
     }

     &-pay-attention {
        hard-to: find-this-classname;
     }
  }

Das obige Beispiel-CSS würde (unter Missachtung einer CSS-Validierung) folgendes
ergeben:

.. sourcecode:: css

  .class .tab-indented #my-id{color:blue;margin:10px;background:#F00}
  .class .tab-indented .short{single:definition}
  .class .tab-indented .wee{another:def}
  .class .tab-indented .tiny{please:endthis}
  .class-pay-attention{hard-to:find-this-classname}

AddOns
------

AddOn-Assets werden ebenfalls durch den :doc:`Asset-Cache </core-api/assetcache>`
verarbeitet und damit durch LESS verarbeitet.

.. _scaffold:

Scaffold (Legacy)
-----------------

Anstelle von LESS kann optional auch Scaffold (wie in Sally-Projekten vor 0.7)
verwendet werden. Scaffold wird dabei als AddOn nachinstalliert und verarbeitet
alle Assets, die auf ``.css`` enden.

Das `AddOn <https://bitbucket.org/webvariants/scaffold>`_ steht unter MIT-Lizenz
bereit und kann über Composer eingebunden werden.

.. sourcecode:: javascript

  {
     "require": {
        "webvariants/scaffold": "*@dev"
     }
  }

.. note::

  Der Scaffold-Einsatz wird nur für Projekte, die von früheren Versionen
  migriert werden, empfohlen. Scaffold ist buggy, wird nicht aktiv entwickelt
  und vom Rest der Welt quasi ignoriert. Neue Projekte sollten unbedingt LESS
  verwenden.
