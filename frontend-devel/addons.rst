AddOns verwenden
================

AddOns sind Erweiterungen für SallyCMS, die sowohl im Frontend als auch im
Backend bei jedem Seitenaufruf geladen (ausgeführt) werden. AddOns können daher
wesentlich tiefer ins System eingreifen als es Module oder Templates könnten.

Auf dieser Seite wird beschrieben, wie AddOns **genutzt** werden. Ein anderer
Teil der Dokumentation beschreibt die :doc:`Entwicklung neuer AddOns </addon-devel>`.

Übersicht
---------

AddOns werden im Verzeichnis :file:`sally/addons` abgelegt und müssen zur
Verwendung im Backend installiert und aktiviert werden. Sie müssen anhand ihres
Namens abgelegt werden, d.h. dass das AddOn **sallycms/be-search** im
Verzeichnis :file:`sally/addons/sallycms/be-search` liegen.

Ein wichtiger Aspekt von AddOns ist, dass sie innerhalb eines Projekts **nicht
verändert** werden sollten. Verändert man ein AddOn, indem man beispielsweise
die Backend-Seiten umbaut oder eigene Arbeitsabläufe (wie "beim Löschen eines
Termins aus dem Terminkalender_ soll eine eMail an den Redakteur verschickt
werden") in ein AddOn schreibt, verliert die Möglichkeit, automatische Updates
zu erhalten.

In vielen Fällen gibt es bereits passende :doc:`Events </core-api/events>` oder
:doc:`Konfigurationsoptionen </core-api/configuration>`, um das gewünschte
Verhalten zu erreichen. Und wenn mal eine Stelle nicht so erweiterbar ist, wie
man es benötigt, sollte man einfach den Autor des AddOns kontaktieren und mit
ihm eine Erweiterung besprechen. Das ist meist schnell gemacht und kommt allen
Nutzern zugute. So entsteht *ein* AddOn, das anpassbar ist, anstatt vieler
zusammengehackter Versionen in verschiedenen Projekten.

Natürlich ist es möglich, AddOns so hinzubiegen, wie man möchte, aber von dieser
Möglichkeit sollte nur im Extremfall Gebrauch gemacht werden.

.. _Terminkalender: https://bitbucket.org/webvariants/datebook

Installation
------------

Der empfohlene Weg, AddOns zu installieren, ist Composer_ zu verwenden. Das
erspart nicht nur den Aufwand, das AddOn herunterzuladen, zu entpacken und alle
ggf. benötigten Abhängigkeiten ebenso zu besorgen. Es ermöglicht auch das
automatische Aktualisieren, sodass Korrekturen (und ggf. benötigte kleine
Anpassungen, siehe oben) schnell und einfach im Projekt landen.

Alternativ können AddOns auch nur heruntergeladen und an die richtige Stelle
entpackt werden. Dann ist man allerdings selber dafür verantwortlich, sich um
Updates zu kümmern.

Um ein AddOn zu installieren, benötigt man den vollen AddOn-Namen. Dieser
besteht immer aus dem Vendornamen (also dem Autor) und dem eigentlichen Namen
des AddOns. So gibt es beispielsweise **sallycms/be-search** oder
**webvariants/datebook**. Zur Installation führt man dann einfach den folgenden
Befehl aus::

  $ php composer.phar require sallycms/be-search=*

Dies wird das genannte AddOn inkl. aller Abhängigkeiten in der letzten stabilen
Version herunterladen und an die richtige Stelle legen. Danach kann das AddOn
im Backend installiert werden.

.. _Composer: http://getcomposer.org/

Aktualisierung
--------------

Ein AddOn kann, wenn es von Hand installiert wurde, einfach durch Überschreiben
seiner Dateien mit denen einer neueren Version aktualisiert werden. Wenn man
Composer verwendet, kann ein einzelnes AddOn wie folgt aktualisiert werden::

  $ php composer.phar update sallycms/be-search

Um alle AddOns auf einmal zu aktualisieren, lässt man den AddOn-Namen weg::

  $ php composer.phar update

.. note::

  Dies aktualisiert nicht nur die AddOns, sondern **alle** verwendeten Pakete.
  Dabei sind auch die von Sally benötigten Bibliotheken, wie sfYaml oder
  BabelCache. Es wird daher empfohlen, AddOns soweit nötig einzeln zu
  aktualisieren.

Notfall-Aus
-----------

Für den Fall, dass ein AddOn seinen Dienst eingestellt hat und den Zugriff auf
das Backend blockiert, kann es in der Konfiguration des Projekts von Hand
deaktiviert werden. Dazu öffnet man die Projektkonfiguration in
:file:`data/config/sly_project.yml` und sucht den entsprechenden Eintrag.
Hierbei ist zu beachten, dass der Schrägstrich im AddOn-Namen durch einen
Doppelpunkt ersetzt wurde. Anstatt **sallycms/be-search** muss man also
**sallycms:be-search** suchen.

.. sourcecode:: yaml

  addons:
     'sallycms:be-search':
        install: true
        status: true

Beim zum AddOn gehörenden Eintrag setzt man nun ``status`` auf ``false``:

.. sourcecode:: yaml

  addons:
     'sallycms:be-search':
        install: true
        status: false

Im Folgenden wird das deaktivierte AddOn nicht mehr geladen und kann daher
keinen "Schaden" anrichten.

.. warning::

  Beim Deaktivieren von AddOns sollte man die Abhängigkeiten im Blick haben.
  Es müssen immer ebenso alle aktivierten AddOns deaktiviert werden, um das
  "böse" AddOn wirklich abzuschalten. Andernfalls wird es aufgrund der
  Abhängigkeiten trotzdem geladen.
