Changelog
=========

0.6.8 (12. Oktober 2012)
------------------------

* Security: Nutzer konnten im Strukturcontroller mehr Aktionen ausführen als
  erlaubt.
* **Bugfix: Der Bugfix aus v0.6.7 war nicht vollständig. Es war weiterhin
  möglich, Kategorien zu löschen, die nur weitere Artikel enthielten.**
* ``sly_Model_ArticleSlice->getNext()`` und ``->getPrev()`` wurden ergänzt.
* Die beiden Tabellen in der Strukturansicht im Backend sind nun mit ``data-``-
  Attributen ausgestattet, um die Ansicht leichter per JavaScript zu erweitern.
* Das Löschen von Artikeln, Kategorien und Benutzern kann jetzt unterbrochen
  werden, indem auf das Event ``SLY_PRE_ART_DELETE`` (``SLY_PRE_CAT_DELETE`` und
  ``SLY_PRE_USER_DELETE`` respektive) gelauscht und eine Exception geworfen wird.
* Bugfix: Im Frontend fehlten ein paar Core-Translations.
* Bugfix: ``sly_Form_ElementBase->addStyle()`` fügte Styles nicht korrekt
  zusammen.
* Bugfix: WYMeditoren können nun wieder als Metainfos verwendet werden.
* Bugfix: Artikel, die über ein Routing-AddOn eine absolute URL erhielten,
  wurden auf der Contentseite im Backend nicht korrekt verlinkt.
* Bugfix: Auf der System- und Profilseite wird nun nicht mehr aus Versehen das
  Locale geändert.
* weitere kleinere Verbesserungen

0.6.7 (4. September 2012)
-------------------------

* **Bugfix: Es war möglich, Kategorien zu löschen, die noch Kinder enthielten,
  sofern alle Kinder offline waren.**
* Beim Anlegen einer neuen Sprache wird nun nicht mehr die erste, sondern die
  Standardsprache als Quelle verwendet.
* Beim Rendern eines Tabellenkopfes können nun die GET-Parameter, die an die
  Pager-Links angehängt werden, explizit gesetzt werden. Dies erlaubt es,
  Tabellen als Antwort auf POST-Requests anzuzeigen.
* Das ``@sly class``-Attribut in Developdateien kann nun nicht mehr nur eine
  einzelne Klasse enthalten, sondern alternativ ein Array.
* ``sly_Response_Stream`` wurde so erweitert, dass statt eines Dateinamens auch
  ein offener Filepointer übergeben werden kann.
* Das Attribut ``required`` wird nun für Datepicker unterstützt.
* ``sly_Util_User::getCurrentUser()`` wurde um den Parameter ``$forceRefresh``
  erweitert.
* Der Asset-Cache kann über ``->removeCacheFiles($file)`` nun auch eine einzelne
  Datei aus dem Cache entfernen.
* Der Parametername ``templateFile_C3476zz3g21ug327ur623`` steht nun im
  Template-Service für Templates zur Verfügung. ;-)
* Bugfix: Versionsinformationen von AddOns wurden bei der Deinstallation nicht
  entfernt (:redmine:`6511`).
* Bugfix: ``sly_Slice_Values->getUrl()`` war defekt.
* Bugfix: Die Permission-Tokens für AddOns wurden nicht korrekt geladen.
* Bugfix: Das Recht auf "alle" Module wurde beim Verschieben oder Löschen von
  Modulen nicht beachtet.
* Bugfix: ``<em>`` und ``<a>`` waren in ``.sly-message`` so gestylt, dass man
  sie nicht erkennen konnte.

0.6.6 (7. Juli 2012)
--------------------

* Bei der Datenbankkonfiguration können nun auch Socket-Pfade
  (``/tmp/mysql.sock``) oder Hosts mit Port (``localhost:1234``) angegeben
  werden.
* Encoding-Probleme in PHP 5.4 wurden vorerst umgangen, bis die relevanten
  PHP-Bugs behoben wurden. Damit werden Assets wieder beim ersten Requests
  korrekt ausgeliefert.
* Beim Synchronisieren von Dateien im Medienpool wird nun der Dateiname als
  Medientitel gesetzt.
* Der Medienpool-Patch für Chrome 18 wurde nun auch für Chrome 20 angewandt, da
  der Chrome-Bug wieder aufgetaucht ist.
* Userland-Code kann im Backend nun Links mit der Klasse ``.sly-confirm-me``
  versehen, um einen Klick mit einem JavaScript ``confirm()``-Aufruf zu
  versehen. Die bisherige Klasse ``.sly-delete`` existiert weiterhin, deren
  Bestätigungsfrage könnte sich allerdings in einem späteren Release von
  "Sicher?" auf "Sicher, dass das Element gelöscht werden soll?" ändern. Für
  allgemeine Sicherheitsabfragen wird daher ``.sly-confirm-me`` empfohlen.
* ``sly_DB_PDO_Persistence->all()`` kann nun den `PDO-Fetchmodus`_ übergeben
  bekommen.
* ``sly_Util_User::exists($id)`` und ``::isValid()`` wurden hinzugefügt.
* ``sly_Util_ArticleSlice::findByArticle()`` wurde hinzugefügt.
* ``sly_Response`` wurde mit dem aktuellen Stand von Symfony2 synchronisiert.
  Dabei wurde auch ``sly_Response_Stream`` hinzugefügt, die Dateien als
  Chunked Response zum Client senden kann.
* Bugfix: AddOns, die nicht installiert waren, wurden nie auf Änderungen an der
  ``static.yml`` überprüft und wurden daher im Zweifelsfall nie als kompatibel
  markiert (:redmine:`6395`, :redmine:`6512`).
* Bugfix: Die Detailseite des Medienpools kam mit den Output Buffern
  durcheinander (:redmine:`6459`).
* Bugfix: Beim Löschen von Sprachen wurde der Laufzeitcache nicht korrekt
  geleert, sodass AddOns, die direkt im Event ``CLANG_DELETED`` auf die Sprachen
  zugreifen wollten, fehlerhafte Informationen erhielten.
* Bugfix: ``; charset=UTF-8`` wird nun nur noch bei ``text/*``- und
  ``application/javascript``-Responses hinzugefügt.
* Bugfix: Der Asset-Cache streamt nun wieder korrekt die Dateien zum Client,
  nachdem sie erzeugt wurden.
* Bugfix: Nach dem Entfernen eines AddOns aus der Konfiguration tauchte es immer
  noch für einen weiteren Request im Backend auf. Außerdem werden nun die
  dynamischen Dateien von AddOns gelöscht, wenn das AddOn gelöscht wird
  (:redmine:`6499`).
* weitere kleinere Verbesserungen

.. _PDO-Fetchmodus: http://php.net/manual/de/pdostatement.fetchall.php

0.6.5 (15. Juni 2012)
---------------------

.. note::

  Dieses Release enthält kleinere :doc:`BC-Breaks <bc-breaks>`.

* jQueryUI wurde auf 1.8.21 aktualisiert.
* Nutzer müssen die Berechtigung Apps/Backend erhalten, um das Backend zu nutzen
  (gilt nur für Nicht-Admins).
* Non-Admins können die Rechte erhalten, auf die Nutzerverwaltung zuzugreifen
  und Nutzer anzulegen, bearbeiten und zu löschen. Non-Admins dürfen Admins
  dabei nur eingeschränkt bearbeiten und sich niemals selbst zum Admin erheben.
* AddOns können über das neue Event ``SLY_USER_FILTER_WHERE`` die Nutzerliste im
  Backend mitfiltern.
* In ``sly_Util_Pager`` können Elemente ausgelassen werden, indem ihre Texte
  auf leere Strings gesetzt werden.
* ``sly_Util_User::findById($userId)`` wurde hinzugefügt.
* Das Interface von ``sly_Mail`` ist nun fluid.
* Die Liste möglicher HTTP-Codes in ``sly_Util_HTTP::redirect()`` wurde
  erweitert.
* ``sly_Form_ElementBase->setValue()``, ``->setName()`` und ``->setID()`` wurden
  hinzugefügt.
* ``sly_Util_String::humanImplode()`` kann mit assoziativen Arrays aufgerufen
  werden.
* Bugfix: Die Filterfunktion von Tabellen funktionierte nicht.
* Bugfix: Beim Kopieren von Artikeln traten Fehler auf, wenn der Quellartikel
  keinen Typ besitzt.
* Bugfix: Nutzer mit eingeschränkten Rechten wurden in der Strukturansicht im
  IE9 falsch weitergeleitet.
* Bugfix: Das min/max-Handling in List-Widgets war fehlerhaft.
* Bugfix: Notice wenn ein Plugin ein anderes Plugin benötigt korrigiert.
* weitere kleinere Optimierungen

0.6.4 (29. April 2012)
----------------------

.. warning::

  Bestehende Projekte, bei denen die Unit-Tests deployt wurden, sollten dringend
  aktualisiert werden, da unter Umständen durch einen Aufruf der Tests via HTTP
  die Datenbank überschrieben werden kann.

* Security: Unit-Tests können nun nicht mehr via HTTP ausgeführt werden.
* Chosen_ wurde im Backend integriert und ist für alle Selectboxen aktiviert.
* Die enthaltene Modernizr-Distribution wurde vervollständigt und enthält jetzt
  alle Standard-Tests. Ebenso enthält das Cookie (``sly_modernizr``) nun alle
  Angaben und nicht mehr nur die Inputtypes. Gleichzeitig wurde
  ``sly_Helper_Modernizr::hasCapability()`` hinzugefügt.
* `JSON.js`_ wurde im Backend integriert, um das Modernizr-Cookie sauber zu
  erzeugen.
* Das Leeren des Caches kann nun selektiv erfolgen. AddOns können dazu die Liste
  der Optionen per Event erweitern. Siehe dazu die
  :doc:`Dokumentation </core-api/events/be_specials>` des neuen Events
  ``SLY_SYSTEM_CACHES``.
* Plugins können nun ebenfalls automatisch inklusive Abhängigkeiten installiert
  werden.
* Artikelinhalte können in mehr als eine Sprache auf einmal kopiert werden.
* Die Behandlung von inkompatiblen AddOns, die in v0.6.3 eingeführt wurde, wurde
  auf den Entwicklermodus beschränkt. Wenn AddOns aktualisiert werden, **muss**
  vorher der Entwicklermodus aktiviert werden, da die Angaben nun nicht mehr
  immer überprüft werden.
* Bugfix: Benutzer, die keinen Zugriff auf die Standardsprache hatten, konnten
  die Strukturansicht nur über Umwege erreichen.
* Bugfix: Dateien im Medienpool, die keine Bilder sind, konnten nicht
  ausgetauscht werden.
* Bugfix: Beim Kopieren von Artikel-Inhalten wurden die Slice-Positionen falsch
  ermittelt (:redmine:`6066`).
* Bugfix: AddOns, deren Backendseiten über den Kompatibilitätsmechanismus
  (``page``-Angabe in der :file:`static.yml`) eingebunden werden, führten dazu,
  dass die Konfiguration bei jedem Seitenaufruf neu geschrieben wurde.
* Bugfix: Die Fehlermeldungen bei mehrdeutigen Modulen waren falsch formuliert
  und verwirrten mehr, als dass sie halfen.
* Bugfix: ``sly_Util_HTTP::getHost()`` war seit v0.6.3 defekt.
* Bugfix: Fehler beim Synchronisieren von Dateien im Medienpool
  (:redmine:`6142`).
* ``sly_Helper_Form::getTimezoneSelect()`` wurde ergänzt.
* ``sly_Util_Medium::getMimetype()`` wurde um einen weiteren Parameter
  ``$realName`` ergänzt, anhand dessen Dateiendung der Mimetype abgelesen wird.
* weitere kleine Detailverbesserungen

.. _Chosen: http://harvesthq.github.com/chosen/
.. _JSON.js: https://github.com/douglascrockford/JSON-js

0.6.3 (8. April 2012)
---------------------

.. note::

  Dieses Release enthält kleinere :doc:`BC-Breaks <bc-breaks>`.

* Die Positionierung des Medienpool-Popups wurde in Chrome 18 deaktiviert, da
  unter Windows das Popup andernfalls gar nicht zu sehen ist (siehe
  Chromium-Tickets 114762_ und 115585_).
* Es können jetzt Rechte auf "alle" Module vergeben werden (ebenso wie bei
  Artikeln).
* Die Kompatibilität von AddOns wird nun bei jedem Request geprüft. Inkompatible
  AddOns werden inklusive aller abhängigen AddOns vor dem Laden deaktiviert, um
  Fehler zu vermeiden. Nachdem die Kompatibilität wiederhergestellt wurde,
  können die AddOns wieder aktiviert werden.
* Listener auf ``SLY_SETTINGS_UPDATED`` erhalten nun die ursprünglichen Werte
  als Parameter und können so leichter auf Veränderungen reagieren.
* Wird keine Homepage/404-Seite im Backend ausgewählt, wird nun keine
  irreführende Fehlermeldung mehr angezeigt. Die Fehlermeldung erscheint nur
  noch, wenn jemand tatsächlich einen fehlerhaften Artikel auswählt.
* ``sly_Service_AddOn->getInstalledAddOns()`` wurde hinzugefügt, da es eine
  entsprechende Methode auch im Plugin-Service gibt.
* Das Scaffold-Mixin ``box-shadow`` wurde um einen weiteren Parameter ``spread``
  erweitert (als 4. Parameter, siehe :doc:`BC-Breaks <bc-breaks>`).
* Bugfix: Unnötige Pfadangaben in URLs (``foo.com/dir/./subdir``) werden jetzt
  entfernt (``foo.com/dir/subdir``).
* Bugfix: Die Portnummer wird nun immer in ``sly_Util_HTTP::getHost()`` entfernt
  (Port ist per Definition nicht Teil des Hostnamens).
* Bugfix: Fehler in ``install.sql``/``uninstall.sql`` werden beim Installieren
  von AddOns/Plugins nun korrekt abgefangen.
* Bugfix: Templates und Module konnten im Produktivmodus nicht mehr
  synchronisiert werden. Nun werden sie auch in diesem Modus synchronisiert,
  wenn ein Administrator im Backend eingeloggt ist oder der Cache geleert wird
  (:redmine:`6010`).
* Bugfix: Redakteure konnten keine bestehenden Slices mehr bearbeiten
  (:redmine:`5988`).
* Bugfix: Die Option "Struktur" wird nun beim Bearbeiten von Benutzern nicht
  mehr fälschlicherweise immer deaktiviert.
* weitere kleinere Verbesserungen

.. _114762: http://code.google.com/p/chromium/issues/detail?id=114762
.. _115585: http://code.google.com/p/chromium/issues/detail?id=115585

0.6.2 (28. März 2012)
---------------------

.. note::

  Dieses Release enthält kleinere :doc:`BC-Breaks <bc-breaks>`.

* Komponenten

  * jQuery wurde auf 1.7.2 aktualisiert.
  * BabelCache wurde auf 1.2.12 aktualisiert.

* Templates und Module können nun beliebig innerhalb ihrer Verzeichnisse
  verschachtelt werden; die internen Namen müssen jeweils vollständig angegeben
  werden und eindeutig sein.
* AddOns können wieder re-installiert werden.
* Beim Kopieren von Inhalten werden nur noch diejenigen Sprachen zur Auswahl
  angeboten, auf die Zugriff besteht.
* Schlägt das Auffinden einer URL (``sally://ID``) fehl, so wid der Platzhalter
  mit ``#`` ersetzt.
* Änderungen an Widgets lösen jetzt das change-Event aus. Damit ist es möglich,
  auf Änderungen beispielsweise an Linkbuttons zu reagieren.
* Datenbank-Imports wurden beschleunigt und benötigen deutlich weniger Speicher.
* Link- und Mediawidgets können auf required gesetzt werden (es erfolgt keine
  Browser-eigene Validierung, da dabei nicht das ``required``-Attribut zum
  Einsatz kommt).
* Linklist- und Medialist-Widgets können eine minimale/maximale Anzahl an
  Elementen erhalten.
* Neues ``text-shadow(x,y,blur,color)``-Mixin für Scaffold wurde hinzugefügt.
* Testing

  * AddOns können in Unit-Tests über ``SLY_TESTING_LOCAL_CONF`` und
    ``SLY_TESTING_PROJECT_CONF`` eigene Konfigurationsdateien angeben und laden
    lassen.
  * Unit-Tests können ``->getDataSetName()`` überschreiben und null zurückgeben,
    um kein Core-Dataset laden zu lassen.
  * Neue Basisklasse ``sly_StatelessTest`` für statische Tests, die den Overhead
    von DBUnit vermeiden möchten.

* Bugfixes

  * Encoding-Probleme unter Windows (Dateisystem-API ist ANSI) wenn im
    Medienpool Dateien synchronisiert werden. Dies stellt ebenfalls die
    Ersetzung der Umlaute wieder her (:redmine:`5602`).
  * Schlug eine AddOn-Installation fehl, so wurde nicht der aufgetretene Fehler
    angezeigt.
  * Rechte-Abfrage für Medienkategorien war defekt.
  * Fehlerhafte Slices konnten nicht gelöscht werden.
  * HTML-Fehler im Backend (Slotliste).
  * Rechte-Abfrage auf Metadaten-Seite von Artikeln war defekt (:redmine:`5605`).
  * Startartikel konnten nicht kopiert werden (:redmine:`5604`).
  * Unklare Fehlermeldung wenn ein Upload fehlschlägt (:redmine:`5798`).
  * Fehler beim Speichern von Slices behoben.
  * Abhängigkeiten der Form ``addon/plugin`` wurden nicht korrekt ausgewertet
    (:redmine:`5783`).
  * Falls beim Deployment das data-Verzeichnis bereits existiert, aber
    ``data/config`` nicht angelegt werden konnte, wurde keine brauchbare
    Fehlermeldung generiert (:redmine:`5624`).
  * Fehlerhaft konfigurierte Zeitzonen führten zu ausgelassenen / defekten
    Assets.
  * Dateien, die keine Breite/Höhe haben, konnten nicht in den Medienpool gelegt
    werden.
  * Nicht alle Klassennamen in ``sly_Slice_Form->addInput()`` und
    ``->addSelect()`` wurden korrekt zusammengesetzt.
  * Inhalte konnten nicht zwischen Sprachen kopiert.

* Neues Event: ``SLY_MEDIUM_FILENAME`` dient zum Filtern des Dateinames beim
  Upload in den Medienpool.
* weitere kleine Verbesserungen

0.6.1 (25. Februar 2012)
------------------------

.. warning::

  Beginnend mit diesem Release gilt die Regel, dass AddOns **keinesfalls** vor
  dem ``ADDONS_INCLUDED``-Event auf die Backend-Navigation zugreifen dürfen.
  Andernfalls kann es sein, dass kein Auth-Provider existiert und daher die
  Rechte-Abfragen ins Leere laufen. Außerdem werden die von Sally vorgegebenen
  Backend-Seiten ebenfalls erst später initialisiert, sodass vor
  ``ADDONS_INCLUDED`` die Navigation noch leer ist.

* Die Backend-Navigation wird nun erst initialisiert, nachdem alle AddOns
  geladen wurden. Das korrigiert die Probleme, die auftraten, weil Sally bereits
  Benutzerrechte abfragte, aber noch kein Auth-Provider gesetzt war.
* jQuery UI wurde auf `1.8.18`_ aktualisiert.
* Modernizr wurde auf `2.5.3`_ aktualisiert.
* Die API, die für Slices bereitsteht, wurde deutlich erweitert:

  * ``sly_Slice_Values->getMedium()`` wurde hinzugefügt (funktioniert analog zu
    ``->getArticle()``).
  * ``sly_Slice_Form->addInput()``, ``->addCheckbox()``, ``->addTextarea()``,
    ``->addText()``, ``->addSelect()``, ``->addLink()``, ``->addLinkList()``,
    ``->addMedia()`` und ``->addMediaList()`` wurden als Shortcuts hinzugefügt
    und sollten Module deutlich einfacher machen.

* In ``sly_Slice_Values`` und ``sly_Slice_Form`` wurden "Catch All"-Events
  hinzugefügt (siehe die
  :doc:`Event-Dokumentation </core-api/events/core_catchall>`).
* Die :file:`mimetypes.yml` wurde auf Basis von `Apache 2.4.1`_ erneuert
  (erweitert).
* Bugfix: In der Dokumentation schon sehr lange erwähnt, nun auch wirklich
  umgesetzt: Im Setup werden keine AddOns geladen (egal, wie die Konfiguration
  aussieht).
* Bugfix: Erfolgs- und Fehlermeldungen wurden im Medienpool nicht angezeigt
  (:redmine:`5451`).
* Bugfix: Notice entfernt, wenn keine Permissions definiert sind.
* Bugfix: ``sly_Model_Slice->getValue()`` rief eine nicht mehr vorhandene
  Methode auf und führte zu einem Fatal Error.
* Bugfix: Das Recht für "alle" Artikel wurde nicht korrekt ausgewertet und
  bezog sich nicht wirklich auf alle.
* Bugfix: Input-Felder mit ``placeholder`` sehen in Firefox nun nicht mehr
  wie ausgefüllt aus (sondern haben eine etwas hellere Textfarbe).
* Bugfix: Der Font-Stack im CSS wurde für Systeme ohne Calibri verbessert (
  insbesondere Windows XP ohne Microsoft Office installiert).
* Bugfix: Notice entfernt, wenn ein Slice keine Formulardaten übermittelt.
* Bugfix: Das Styling von Formularen in Modulen wurde verbessert und an das
  Styling aller anderen Formulare angeglichen.
* Bugfix: Module konnten keine Fieldsets nutzen. Fieldsets werden jetzt
  angezeigt, wenn sie auch für die allermeisten Module nicht nötig und daher
  auch nicht empfohlen sind.
* Bugfix: Artikeltyp-Namen wurden auf der Systemseite nicht übersetzt.
* Bugfix: Die Links zu Slots in der Content-Verwaltung waren ungültiges HTML.
* Bugfix: Fehlermeldungen im Asset-Controller sollten nicht vom Client gecacht
  werden. Außerdem sollte im Produktivmodus nur eine allgemeine Fehlermeldung,
  anstatt aller Details angezeigt werden.
* kleinere weitere Verbesserungen sowie alle Korrekturen aus
  :doc:`Sally 0.5.10 </appendix/0.5/changelog>`

.. _1.8.18:       http://blog.jqueryui.com/2012/02/jquery-ui-1-8-18/
.. _2.5.3:        http://www.modernizr.com/news/modernizr-25
.. _Apache 2.4.1: http://httpd.apache.org/docs/2.4/en/

0.6.0 (14. Februar 2012)
------------------------

* :doc:`Major Feature Release <releasenotes>`
