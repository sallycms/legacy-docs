Kompatibilitätsinformationen
============================

Auf dieser Seite werden alle rückwärts-inkompatiblen API-Änderungen aus allen
Sally-Releases dokumentiert.

.. note::

  Während der 0.x-Phase sind Updates nicht immer ohne manuelles Eingreifen
  möglich, da wir teils gravierende Änderungen an der Struktur vornehmen. Wir
  bitten, diesen Umstand zu beachten. Updates innerhalb eines Branches (z.B.
  von 0.4.4 auf 0.4.7) sollten hingegen immer problemlos möglich sein.

0.6.0 -> 0.6.1
--------------

* Das Handling der Backend-Navigation wurde überarbeitet, um AddOns die
  Möglichkeit zu geben, einen Auth-Provider zu setzen. Userland-Code sollte
  keinesfalls vor dem ``ADDONS_INCLUDED``-Event auf die Navigation zugreifen.
  Vor diesem Event sind keinerlei Backend-Seiten in der Navigation vorhanden.
* AddOns werden im Setup nun keinesfalls geladen.
* jQuery UI wurde auf `1.8.18`_ aktualisiert.
* Modernizr wurde auf `2.5.3`_ aktualisiert.
* Die API, die für Slices bereitsteht, wurde deutlich erweitert:

  * ``sly_Slice_Values->getMedium()`` wurde hinzugefügt (funktioniert analog zu
    ``->getArticle()``).
  * ``sly_Slice_Form->addInput()``, ``->addCheckbox()``, ``->addTextarea()``,
    ``->addText()``, ``->addSelect()``, ``->addLink()``, ``->addLinkList()``,
    ``->addMedia()`` und ``->addMediaList()`` wurden als Shortcuts hinzugefügt
    und sollten Module deutlich einfacher machen.

* Fieldsets in Modulen werden nun nicht mehr ausgeblendet.

.. _1.8.18: http://blog.jqueryui.com/2012/02/jquery-ui-1-8-18/
.. _2.5.3:  http://www.modernizr.com/news/modernizr-25

0.6.1 -> 0.6.next
-----------------

* Das wird die Zeit zeigen...
