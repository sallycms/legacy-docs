Changelog
=========

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
