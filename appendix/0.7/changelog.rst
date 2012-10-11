Changelog
=========

0.7.1 (12. Oktober 2012)
------------------------

* alle Änderungen aus v0.6.8
* ``.webp``-Dateien werden nun standardmäßig durch den Assetcache behandelt.
* Das Favicon wurde mit einer transparenten Version ersetzt.
* ``sly_Util_User::findByLogin($login)`` wurde ergänzt.
* Die Content- und Contentmeta-Seiten verwenden jetzt Redirects nach
  erfolgreichen Aktionen.
* ``sly_DB`` unterstützt nun ``NULL`` als Wert.
* Die Modulauswahl auf der Contentseite wird nicht mehr angezeigt, wenn keine
  Module zur Verfügung stehen.
* Der Bootcache wird nun direkt beim Ändern der Systemkonfiguration erzeugt bzw.
  gelöscht (anstatt erst beim Leeren des Caches).
* Der Bootcache kann über die projektweite Option ``bootcache`` abgeschaltet
  werden (``bootcache: false``).
* Bugfix: Der Updatecheck im AddOn-Manager-Service griff auf eine nicht
  existierende Variable zu und schlug fehl.

0.7.0 (3. Oktober 2012)
-----------------------

* :doc:`Major Feature Release <releasenotes>`
