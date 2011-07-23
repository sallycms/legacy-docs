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

  rxid: 999
  page: 'my_addon'
  name: 'translate:my_i18n_title_key'
  perm: 'my_addon[]'
  author: 'Peter Griffin'
  supportpage: 'www.example.com'
  requires: [addon_x, addon_y]

Informationen zur Syntax von YAML-Dateien liefert unter anderem die `Allwissende
Müllhalde <http://de.wikipedia.org/wiki/YAML>`_.

Beachten Sie, dass Sie keinen **schreibenden** Zugriff auf diese Daten haben
werden. Legen Sie hier also wirklich nur die Werte ab, die sich in einem Projekt
vermutlich nicht ändern. Oder anders gesagt: Wenn die Werte konfigurierbar sein
sollen, dann gehören sie nicht in die :file:`static.yml`.

Tipp
^^^^

In der :file:`static.yml` können neben den oben genannten Werten noch beliebig
viele weitere Werte notiert werden, ganz so, wie man es auch im ``$REX``-Array
tun konnte:

.. sourcecode:: yaml

  rxid: 999
  page: 'my_addon'
  name: 'translate:my_i18n_title_key'
  perm: 'my_addon[]'
  author: 'Peter Griffin'
  supportpage: 'www.example.com'
  requires: [addon_x, addon_y]
  config:
    setting_x: [1,2,3]
    setting_y: {hallo: welt}

Wenn Sie Werte speichern möchten, die **veränderbar** sein sollen, sollten Sie
dafür die *optionale* Datei :file:`defaults.yml` in Ihrem AddOn verwenden. Werte
in dieser Datei haben Vorrang vor denen aus der :file:`static.yml` und können
sie daher überschreiben.

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

*Wenn Ihr AddOn keine eigene Backend-Seite anlegt, betrifft Sie diese Änderung
nicht.*

In der :file:`pages/index.inc.php` Ihres AddOns werden Sie vermutlich die
folgenden beiden Dateien einbinden:

* :file:`layout/top.php`
* :file:`layout/bottom.php`

Dies ist in SallyCMS nicht mehr nötig und möglich. Wenn beim Aufruf Ihrer
AddOn-Seite im Backend eine leere Seite erscheint, wird vermutlich noch die
:file:`layout/top.php` mit require eingebunden.
