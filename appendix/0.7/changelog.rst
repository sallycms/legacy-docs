Changelog
=========

0.7.3 (23. Dezember 2012)
-------------------------

* Das Session-Cookie von Sally wird nun immer mit dem ``httponly``-Flag
  gesendet.
* ``sly_Loader`` unterstützt nun PHP 5.3-Namespaces (wow, seriously?).
* Im Frontend wird nun automatisch die System-Standardsprache als aktuelle
  Sprache eingestellt.
* Vor dem Hinzufügen eines Nutzers wird nun das Event ``SLY_PRE_USER_ADD``,
  vor dem Aktualisieren eines bestehenden Nutzers ``SLY_PRE_USER_UPDATED``
  gefeuert.
* Die Meldungen auf der Slice-Seite eines Artikels wurden etwas optimiert und
  umorganisiert.
* Das Benutzer-Formlar zeigt nun auch das Registrierdatum sowie das Datum der
  letzten Aktualisierung an.
* Beim Ermitteln der URL eines Artikels wird vor ``URL_REWRITE`` nun noch das
  neue Event ``SLY_URL_REDIRECT`` ausgelöst, mit dem das Ziel überschrieben
  werden kann.
* Die Response-Klasse wurde um von Symfony2 portierte Caching-Funktionen
  erweitert.
* ``sly_Util_HTTP::getBasePath()`` wurde ergänzt.
* ``sly_Util_HTTP::replaceSallyLinks()`` wurde ergänzt und übernimmt die Aufgabe
  von ``sly_Slice_Render->replaceLinks()``.
* Bugfix: Das Recht auf "alle" Module wurde nicht korrekt beachtet.
* Bugfix: AddOn-Abhängigkeiten wurde nicht korrekt erkannt.
* Bugfix: Datetime-Picker wurden nicht korrekt positioniert, seit jQuery 1.8
  zum Einsatz kommt.
* Bugfix: Module, die im Backend eine Exception warfen, führten zu ungültigem
  HTML.
* Bugfix: Doppelte Unterstriche werden im Medienpool beim Hinzufügen einer
  Datei entfernt (da sie sonst zu Konflikten mit Image-Resize führen und noch
  dazu hässlich sind).
* Bugfix: Links im Medienpool waren an bestimmten Stellen fehlerhaft.
* Bugfix: ``sly_Model_ArticleSlice->setValue()`` funktionierte nicht.
* Bugfix: ``sly_Util_HTTP`` hatte Probleme mit Non-Standard Ports.
* Bugfix: Vendor-Pakete, die von Hand installiert wurden, wurden nicht korrekt
  erkannt.
* weitere kleine Korrekturen

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
