AddOn-Entwicklung: Grundlagen
=============================

config.inc.php / AddOn-Infos
----------------------------

SallyCMS nutzt eine leicht andere API, um AddOns zu laden. Informationen werden
nicht mehr aus ``$REX['ADDON']...`` ausgelsen, sondern aus einer YAML-Datei
geparsed. Dies bietet den Vorteil, dass auf die Informationen zugegriffen werden
kann, ohne potentiell gefährlichen Code auszuführen. Damit stehen diese Daten
auch zur Verfügung, wenn das AddOn nicht installiert oder aktiviert ist.

In den meisten Fällen sollte es reichen, die Daten aus dem ``$REX``-Array in
eine YAML-Datei zu packen. Die Datei muss :file:`static.yml` heißen, im
AddOn-Verzeichnis liegen (dort, wo auch die :file:`config.inc.php` liegt) und
könnte wie folgt aussehen:

.. sourcecode:: yaml

  page: 'my_addon'
  name: 'translate:my_i18n_title_key'
  perm: 'my_addon[]'
  author: 'Peter Griffin'
  supportpage: 'www.example.com'
  # abhängig von addon_x, addon_y und dem Plugin myplugin des AddOns myaddon
  requires: [addon_x, addon_y, 'myaddon/myplugin']

Informationen zur Syntax von YAML-Dateien liefert unter anderem die `Allwissende
Müllhalde <http://de.wikipedia.org/wiki/YAML>`_.

Beachte, dass du keinen **schreibenden** Zugriff auf diese Daten haben wirst.
Lege hier also wirklich nur die Werte ab, die sich in einem Projekt vermutlich
nicht ändern. Oder anders gesagt: Wenn die Werte konfigurierbar sein sollen,
dann gehören sie nicht in die :file:`static.yml`.

Tipp
^^^^

In der :file:`static.yml` können neben den oben genannten Werten noch beliebig
viele weitere Werte notiert werden, ganz so, wie man es auch im ``$REX``-Array
tun konnte:

.. sourcecode:: yaml

  page: 'my_addon'
  name: 'translate:my_i18n_title_key'
  perm: 'my_addon[]'
  author: 'Peter Griffin'
  supportpage: 'www.example.com'
  requires: [addon_x, addon_y, 'myaddon/myplugin']
  config:
    setting_x: [1,2,3]
    setting_y: {hallo: welt}

Wenn du Werte speichern möchtest, die **veränderbar** sein sollen, solltest du
dafür die *optionale* Datei :file:`defaults.yml` in deinem AddOn verwenden.
Werte in dieser Datei haben Vorrang vor denen aus der :file:`static.yml` und
können sie daher überschreiben.

Globale Konfiguration erweitern/überscheiben
--------------------------------------------

In der Datei :file:`defaults.yml` können globale Konfigurationseinstellungen
hinzugefügt oder überschieben werden. Zum Beispiel möchte ein Blog-AddOn einen
Artikeltypen zufügen.

.. sourcecode:: yaml

  ARTICLE_TYPES:
    blog:
      title: Blog
      template: blogtemplate

index.inc.php
-------------

.. note::

  Seit Sally 0.5 werden AddOns nur noch über ihre Controller-Klassen geladen.

Um eine eigene Backend-Seite zu implementieren, muss eine Klasse implementiert
werden, die sich von ``sly_Controller_Backend`` ableitet und zwingend so heißen
muss, wie auch das AddOn heißt.

.. sourcecode:: php

  <?
  // Das AddOn heißt 'myaddon'.
  class sly_Controller_Myaddon extends sly_Controller_Backend {
    // ...
  }

.. note::

  Wenn das AddOn einen mehrteiligen Namen hat (zum Beispiel ``my_addon``), muss
  der Seitenname überschrieben werden. Standardmäßig wird für ``?page=...`` der
  Name des AddOns verwendet.

Für ein AddOn, das ``my_addon`` heißt, könnte die Konfiguration wie folgt
aussehen.

.. sourcecode:: yaml

  # static.yml des AddOns
  page: myaddon
