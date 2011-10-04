Frontend-Listeners
==================

SallyCMS ermöglicht (beginnend mit Version *0.5*) es, ohne den Einsatz eines
AddOns auf Ereignisse im Backend zu reagieren. In früheren Versionen konnte der
projektspezifische Code (im @develop@-Verzeichnis) keinen Einfluss auf Events
nehmen, die im Backend ausgelöst wurden, da er nicht geladen wurde. Zu diesem
Zweck musste ein AddOn geschrieben werden, da nur diese sowohl im Frontend als
auch im Backend geladen wurden.

Konfiguration
-------------

Um auf Events zu reagieren, wird die reguläre :doc:`Sally-Konfiguration
</sallycms/configuration>` verwendet. Unter dem Key ``LISTENERS`` können pro
Event beliebig viele Listener registriert werden:

.. sourcecode:: yaml

  LISTENERS:
     OUTPUT_FILTER: [listener1, listener2, listener3]
     URL_REWRITE: [mySpecialRewriteFunction]

Wie üblich kann diese Konfiguration in einer oder mehreren beliebigen Dateien im
:file:`develop/config`-Verzeichnis erfolgen. AddOns können den gleichen
Mechanismus nutzen, um ihre Listener anzugeben. Dazu können sie in der
:file:`globals.yml` eines AddOns notiert werden.

Die auf diese Weise angegebenen Listener werden registriert, nachdem alle AddOns
geladen wurden (nachdem das Event ``ADDONS_INCLUDED`` ausgelöst wurde). Im
Anschluss wird das Event ``SLY_LISTENERS_REGISTERED`` ausgelöst.

Einschränkungen
---------------

Die in mehreren Dateien angegebenen Listener werden durch die Konfiguration
automatisch gemerged. Da das Mergen der Listener rekursiv erfolgt, dürfen
Listeners, die aus Klassenname und Methode bestehen, **nicht als Array angegeben
werden**. Ein Callback wie ``array('MyClass', 'myMethod')`` darf in YAML also
**nicht** als ``[MyClass, myMethod]`` notiert werden. Stattdessen muss die in
`PHP 5.2.3 <http://www.php.net/manual/en/language.pseudo-types.php>`_
eingeführte Syntax``MyClass::myMethod`` verwendet werden.

.. sourcecode:: yaml

  LISTENERS:
     OUTPUT_FILTER:
        - myGlobalFunction
        - MyClass::myMethod
     URL_REWRITE:
        - [MyClass, myMethod] # falsch!

Außerdem müssen Listeners immer als **Liste** angegeben werden, damit sie
gemerged werden können. Wird an einer Stelle für ein Event einfach nur ein
Listener angegeben, so können andere Komponenten auf dieses Event nicht mehr
reagieren.

.. sourcecode:: yaml

  LISTENERS:
     OUTPUT_FILTER: myCallback    # falsch!
     OUTPUT_FILTER: [myCallback]  # richtig
     OUTPUT_FILTER:
        - myCallback              # auch OK

REDAXO "Actions"?
-----------------

Das Listener-Konzept stellt eine verallgemeinerte Version der REDAXO-Actions
dar. In REDAXO können Actions nur auf drei bestimmte Events (postsave, presave,
preview) reagieren und müssen pro Modul konfiguriert werden.

In SallyCMS kann das Nachbearbeiten der Slice-Werte von Modulen erreicht werden,
indem sich auf auf Events ... *(noch zu implementieren)*
