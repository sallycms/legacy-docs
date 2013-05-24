Changelog
=========

0.7.5 (25. Mai 2013)
--------------------

* Listener auf ``SLY_URL_REDIRECT`` können jetzt auch ein ``sly_Model_Article``-
  Objekt zurückgeben.
* Das Frontend sendet einen HTTP 404, wenn der aufgerufene Artikel kein Template
  hat.
* Der Beschreibungstext eines Boolean Inputs in ``sly_Form`` wird nun
  automatisch übersetzt.
* Bugfix: War eine Datei ``AB.jpg`` in einem Modul eingepflegt, so konnte eine
  Datei ``B.jpg`` nicht gelöscht werden.
* Bugfix: Der Konfigurationscache wurde zu oft neu generiert.
* Bugfix: Artikel ohne Template konnten nicht kopiert werden.
* weitere kleinere Fixes

0.7.4 (4. Februar 2013)
-----------------------

.. note::

  Dieses Release enthält kleinere :doc:`BC-Breaks <bc-breaks>`.

* Die aktuelle Version des Composer-Installers für Sally kann nun bei jedem
  ``install`` und ``update`` automatisch die Assets der AddOns re-initialisieren
  und den Asset-Cache leeren. Siehe unten für weitere Details.
* Das Handling der zusätzlichen Parameter im Medienpool und der Linkmap wurde
  grundlegend überarbeitet. Das bekannte ``args``-Array besteht noch, ist aber
  deprecated. Stattdessen können über die neuen Events
  ``SLY_MEDIAPOOL_URL_PARAMS`` und ``SLY_LINKMAP_URL_PARAMS`` weitere Parameter
  angegeben werden, die über alle Requests innerhalb des Popups mit übertragen
  werden sollen. Dabei wurden gleichzeitig einige Stellen korrigiert, an denen
  bisher die Zusatz-Parameter verlorengingen (z.B. beim Upload eines neuen
  Mediums).
* WYSIWYG-Editoren erhalten in den Callbacks vom Medienpool und der Linkmap
  nun als weiteren Parameter das ``window``-Objekt des Popups übergeben.
* ``sly_Util_String::cutText()`` entfernt überhängende Leerzeilen.
* ``sly_Util_ArticleSlice`` wurde um Methoden zur Rechteüberprüfung erweitert:
  ``::canEditSlice($user, $slice)``, ``::canMoveSlice($user, $slice)``,
  ``::canAddModule($user, $module)``, ``::canEditModule($user, $module)`` und
  ``::canDeleteModule($user, $module)``. Dabei wurden auch Probleme im
  Content-Controller behoben.
* Beim Rendern von Slices werden nun die Events ``SLY_SLICE_PRE_RENDER`` und
  ``SLY_SLICE_POST_RENDER`` ausgeführt, um das Rendern vorher abzubrechen oder
  die Ausgabe hinterher zu filtern.
* Innerhalb von allen LESS-Dateien kann nun die Funktion ``asset()`` verwendet
  werden, die versucht, die angegebene Datei im Dateisystem zu finden und
  automatisch deren mtime als ``?t=...`` an die URI anzufügen.
* ``sly_I18N`` kann nun über ``->setReportMissing(true)`` dazu gebracht werden,
  das Event ``SLY_I18N_MISSING_TRANSLATION`` zu feuern. In diesem Event sind
  der Key und das aktuelle Locale des nicht gefundenen Elements enthalten.
* ``SLY_ART_TYPE`` enthält als Subject nun den Artikel in der ursprünglich
  übergebenen Sprache, nicht in der jeweils letzten Systemsprache. Das Ändern
  des Typs wirkt sich natürlich weiterhin auf alle Sprachen gleichzeitig aus.
* ``sly_Model_Medium->getUrl()`` gibt die URL zu einem Medium zurück. Die URL
  ist immer relativ zum Frontend, es sei denn, es wird ``true`` übergeben, dann
  handelt es sich um eine absolute URL.
* ``sly_Util_Session::start()`` wurde um einen optionalen Parameter
  ``$onlyIfCookieSet = false`` erweitert. Ist dieser auf ``true`` gesetzt, wird
  die Session nur gestartet, wenn ein korrekt benanntes Session-Cookie
  existiert. Ebenso wurden ``::isCookieSet()`` sowie ``::destroy()`` ergänzt.
* Bugfix: ``sly_Util_Article::getUrl()`` hatte Probleme, wenn die ID eines
  nicht existierenden Artikels angegeben wurde.
* Bugfix: Die Mindestversion von MySQL wurde auf 5.0 (von 5.1) heruntergesetzt,
  da es keinen Grund gibt, Sally nicht mit 5.0 zu verwenden und die 5.1 wohl nur
  übriggebliebener Test-Code war.
* Bugfix: ``sly_Layout->getBodyAttr()`` verhielt sich bei nicht gesetzten
  Attributen unerwartet (es wurden alle Attribute zurückgegeben, anstatt
  ``null``).
* Bugfix: Die Positionierung des clear-Icons in Chosen-Elementen war inkorrekt.
* Bugfix: Das Datum des letzten Logins wurde für Nutzer, die sich noch nie
  eingeloggt haben, falsch angezeigt.
* Bugfix: Vendor-Pakete wurden in den Credits teils doppelt angezeigt.
* Bugfix: Header, die im Konstruktor von ``sly_Response`` angegeben wurden,
  wurden nicht korrekt verarbeitet.

Um das automatische Re-initialisieren der Assets zu verwenden, muss die
:file:`composer.json` des Projekts die folgenden beiden Scripts enthalten und
**mindestens Version 1.1.2** von ``sallycms/composer-installer`` verwendet
werden.

.. sourcecode:: javascript

  {
     "scripts": {
        "post-package-install": [
           "sly\\Composer\\Installer::onPostPkgInstall"
        ],
        "post-package-update": [
           "sly\\Composer\\Installer::onPostPkgInstall"
        ]
     }
  }

Die Scripts können auch problemlos in bestehenden 0.7-Projekten nachgetragen
werden, solange der Installer aktuell ist.

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
