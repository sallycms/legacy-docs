Scaffold
========

`Scaffold <https://github.com/sunny/csscaffold>`_ ist eine Core-Komponente.
Dabei handelt es sich grob gesagt um eine serverseitige Erweiterung für
CSS-Code, die in einem Verarbeitungsschritt aus CSS-ähnlichem, aber erweitertem
Code, CSS erzeugt.
In Scaffold-Code sind Konstanten, Verschachtelung und "Funktionen" möglich.
Außerdem wird das erzeugte CSS direkt validiert und minimiert.

Scaffold ist auch im Frontend aktiviert. Alle CSS-Dateien, die in
:file:`assets/css/` liegen, werden beim Aufruf über den Webbrowser mit Scaffold
verarbeitet und automatisch in :file:`sally/data/dyn/internal/sally/css-cache/`
gespeichert.

.. note::

  Sally verwendet nicht das Original Scaffold, sondern den oben verlinkten Fork.

Beispiel
--------

.. sourcecode:: css

  .class {
     .tab-indented {
        #my-id {
           color: blue;
           margin: 10px;
           background: red;
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

  .class .tab-indented #my-id{color:blue;margin:10px;background:red}
  .class .tab-indented .short{single:definition}
  .class .tab-indented .wee{another:def}
  .class .tab-indented .tiny{please:endthis}
  .class-pay-attention{hard-to:find-this-classname}

AddOns
------

Auch bei AddOns werden die CSS-Dateien durch Scaffold verarbeitet. Dies
geschieht einmalig bei der Installation (und auf Wunsch manuell durch die
"Re-Initialisieren"-Funktion auf der AddOn-Seite im Backend). AddOns können die
Verarbeitung abschalten, indem sie in ihrer :file:`static.yml` den Key
``noscaffold`` definieren:

.. sourcecode:: yaml

  noscaffold: ['css/my.css', 'css/special/*'] # glob-Ausdrücke sind möglich

Die Pfade, die in ``noscaffold`` angegeben werden, sind relativ zum
:file:`assets`-Verzeichnis des AddOns (es heißt also :file:`css/foo.css` anstatt
:file:`assets/css/foo.css`).
