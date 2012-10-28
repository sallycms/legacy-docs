Changelog
=========

0.7.2 (28. Oktober 2012)
------------------------

* ``sly_Core`` erlaubt es, den Dispatcher durch eine neue Instanz zu ersetzen.
  Dispatcher müssen das neue Interface ``sly_Event_IDispatcher`` implementieren.
  Alle Methoden, die bisher per Type-Hint ein Objekt vom Typ
  ``sly_Event_Dispatcher`` verlangten, sollten aktualisiert werden.
* Sally lädt nun nur noch ``.yml``- und ``.yaml``-Dateien aus dem
  ``develop``-Verzeichnis.
* ``sly_Service_Factory::getSliceValueService()`` wurde entfernt, da es den
  Service nicht mehr gibt.
* Bugfix: Geschützte Assets wurden beim ersten Request (der noch von PHP
  behandelt wird) ausgeliefert, obwohl der Client ggf. keine Berechtigung dazu
  hatte.
* Bugfix: Unter bestimmten Umständen wurde die AddOn-Liste beim Deaktivieren von
  AddOns nicht korrekt aktualisiert, bis die Seite vollständig neu geladen
  wurde.
* Bugfix: Die "Übernehmen"-Funktion von Slices unterschied sich nicht vom
  einfachen Speichern.
* Bugfix: Es traten PHP Warnings bei Redirects auf. Ab jetzt können die
  ``redirect()`` und ``redirectResponse()`` Methoden auch ohne ``$params``
  aufgerufen werden.
* Bugfix: ``sly_Response->getDate()`` und ``getExpires()`` funktionierten nicht.
* Bugfix: Beim Abschalten des Entwicklermodus wurde ``null`` in der
  Konfiguration gespeichert.
* Bugfix: gelöschte AddOns wurden nicht korrekt erkannt.
* weitere kleine Verbesserungen

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
