Ein Projekt mit Mercurial entwickeln
====================================

`Mercurial <http://mercurial.selenic.com/>`_ ist ein einfaches aber mächtiges
Versionskontrollsystem, das wir zur Verwaltung von SallyCMS selbst und aller
AddOns einsetzen. Es stehen Binaries für Windows, Linux und Mac zur Verfügung.

In diesem Dokument soll kurz auf die Projektentwicklung mit Mercurial
eingegangen werden. Siehe dazu auch die folgenden hervorragenden Online-Quellen:

* `Mercurial: The Definitive Guide <http://hgbook.red-bean.com/>`_
* `Hg Init <http://hginit.com/>`_ (insbesondere für Umsteiger von Subversion)
* `TortoiseHg <http://tortoisehg.bitbucket.org/>`_ (wir empfehlen, unbedingt
  `Version 1.x <https://bitbucket.org/tortoisehg/stable/downloads>`_ zu
  verwenden)

.. note::

  Wir bitten um Verständnis, dass wir keinen Support für Mercurial oder andere
  Versionskontrollsysteme leisten können.

Projekt anlegen
---------------

Projekte lassen sich am einfachsten anlegen, indem das SallyCMS-Repository
gecloned wird. Dabei sollte *nicht der Trunk*, sondern der aktuellste
Release-Branch verwendet werden. Für Version 0.4 wäre das
**https://bitbucket.org/SallyCMS/0.4**.

::

  $ hg clone https://bitbucket.org/SallyCMS/0.4 myproject

Danach steht ein Klon im Verzeichnis :file:`myproject` zur Verfügung. Die
Ignorier-Filter sind bereits fertig voreingestellt, jedoch sind noch keine
AddOns enthalten.

Ein Klon bietet den Vorteil, schnell und einfach Updates für das Projekt
einzuspielen. Man kann jederzeit von Bitbucket die aktuelle Sally-Version
einspielen, ohne einen Finger krumm zu machen:

::

  $ hg pull
  $ hg merge        # wenn pull dazu aufgefordert hat
  $ hg up

Wichtig ist dabei jedoch, dass man *keine Dateien von Sally oder den AddOns
ändert*. Hält man sich an diese Grundregel, kann man immer konfliktfrei und
automatisch Updates einspielen, ohne Konflikte zu riskieren. Sally wurde mit dem
Ziel entworfen, dieses Vorgehen zu ermöglichen (und trennt daher strikt
Projektdaten und den Systemkern).

AddOns
------

AddOns sollten (wenn man sich nicht mit der `subrepo-Erweiterung
<http://mercurial.selenic.com/wiki/Subrepository>`_ auseinandersetzen möchte)
einfach hier runtergeladen und in das AddOn-Verzeichnis
(:file:`sally/include/addons` für Sally 0.4) kopiert werden. Danach können sie
dem Repository hinzugefügt werden:

::

  $ cd myproject
  $ hg addremove .                  # fügt alle unbekannten Dateien hinzu
  $ hg commit -m "addOn X added"

Typische Sally-Projekte enthalten mindestens die folgenden AddOns:

* Image Resize
* Import/Export
* BeSearch

Wir empfehlen jedoch, auch noch die folgenden AddOns zu verwenden:

* Developer Utils (Grundlage für die weiteren AddOns)
* Metainfo
* Deployer
* realURL2
* Error Handler
* Global Settings

Nimmt man alle o.g. AddOns, hat man bereits den Inhalt des :doc:`Starterkits
</general/starterkit>`, das man hier auch als ZIP-Archiv runterladen kann.
Leider ist es ohne Verwendung der subrepo-Erweiterung nicht möglich, AddOns so
wie den Sally-Core automatisch zu aktualisieren. AddOns müssen also manuell
runtergeladen und im Repo entpackt werden.

Installation
------------

Im Anschluss kann Sally :doc:`installiert </general/install>` werden. Dabei
werden nur Dateien in :file:`sally/data` erstellt, die über die bereits
vorhandene :file:`.hgignore`-Datei bei Commits nicht beachtet werden. Damit
landen Konfiguration und dynamisch erzeugte Inhalte (Caches, ...) nie im
Repository.

Medienpool
----------

Per Konvention sollten Inhalte des Medienpools (:file:`sally/data/mediapool`)
nicht committed werden. Sie blähen in den meisten Fällen das Repository unnötig
auf und enthalten nur Dateien, die bereits in anderen Speichern (Festplatte,
Netzlaufwerk, Cloud) liegen. Sie werden jedoch nicht über den ignore-Filter
ignoriert, da ab und an durchaus mal eine Datei mit versioniert werden soll.

Import/Export
-------------

Erstellte Exports (:file:`sally/data/import_export`) sollten im Gegensatz zum
Medienpool versioniert werden, da sie Projektdaten enthalten und zwischen
verschiedenen Entwicklern (wenn vorhanden) ausgetauscht werden sollen.
