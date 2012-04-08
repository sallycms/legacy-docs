Changelog
=========

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
