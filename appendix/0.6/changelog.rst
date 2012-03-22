Changelog
=========

0.6.2 (??. März 2012)
---------------------

.. note::

  Dieses Release enthält kleinere :doc:`BC-Breaks <bc-breaks>`.

* jQuery wurde auf 1.7.2 aktualisiert.
* BabelCache wurde auf 1.2.11 aktualisiert.
* Templates und Module können nun beliebig innerhalb ihrer Verzeichnisse
  verschachtelt werden; die internen Namen müssen jeweils vollständig angegeben
  werden und eindeutig sein.
* AddOns können wir re-installiert werden.
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
* Bugfix: Encoding-Probleme unter Windows (Dateisystem-API ist ANSI) wenn
  im Medienpool Dateien synchronisiert werden. Dies stellt ebenfalls die
  Ersetzung der Umlaute wieder her (#5602).
* Bugfix: Schlug eine AddOn-Installation fehl, so wurde nicht der aufgetretene
  Fehler angezeigt.
* Bugfix: Rechte-Abfrage für Medienkategorien war defekt.
* Bugfix: Fehlerhafte Slices konnten nicht gelöscht werden.
* Bugfix: HTML-Fehler im Backend (Slotliste).
* Bugfix: Rechte-Abfrage auf Metadaten-Seite von Artikeln war defekt (#5605).
* Bugfix: Startartikel konnten nicht kopiert werden (#5604).
* Bugfix: Unklare Fehlermeldung wenn ein Upload fehlschlägt (#5798).
* Bugfix: Fehler beim Speichern von Slices behoben.
* Bugfix: Abhängigkeiten der Form ``addon/plugin`` wurden nicht korrekt
  ausgewertet (#5783).
* Bugfix: Falls beim Deployment das data-Verzeichnis bereits existiert, aber
  ``data/config`` nicht angelegt werden konnte, wurde keine brauchbare
  Fehlermeldung generiert (#5624).
* Bugfix: Fehlerhaft konfigurierte Zeitzonen führten zu ausgelassenen / defekten
  Assets.
* Bugfix: Dateien, die keine Breite/Höhe haben, konnten nicht in den Medienpool
  gelegt werden.
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
  (#5451).
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
