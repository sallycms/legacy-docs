Artikeltypen
============

SallyCMS verwendet seit Version 0.4 sog. Artikeltypen zur Unterscheidung
zwischen verschiedenen Artikeln. Artikel werden nicht einem bestimmten Template
(Anzeigestil) zugewiesen, sondern einem Artikeltypen. Damit muss ein Redakteur
nicht mehr entscheiden, wie Inhalte angezeigt werden sollen, sondern kann
Artikel nach "Stellenangebot", "Newsbeitrag" etc. unterscheiden.

Artikeltypen definieren

* welches :doc:`Template <templates>` zur Anzeige des Artikels zum Einsatz
  kommt.
* welche :doc:`Module <modules>` im Artikel verwendet werden dürfen.
* welche Metainformationen verfügbar/verpflichtend sind (wenn das
  `Metainfo-AddOn`_ verwendet wird).

.. _`Metainfo-AddOn`: https://projects.webvariants.de/projects/metainfoex

Redakteure haben grundsätzlich keine Kontrolle darüber, welche Module erlaubt
sind.

Definition
----------

Artikeltypen werden in der :doc:`Konfiguration </core-api/configuration>`
definiert. Dazu wird empfohlen, eine Datei namens :file:`types.yml` in
:file:`develop/config/` abzulegen und dort alle Typen zu notieren:

.. sourcecode:: yaml

  ARTICLE_TYPES:
    # 'default' hat keine besondere Bedeutung, der Artikeltyp heißt nur
    # zufällig so. Dies ist nicht auf magische Weise der Standard-Artikeltyp
    # in Sally.
    default:
      title: 'Standardseite'
      template: 'default'
      modules:
        leftcol: ['editor']
        rightcol: ['teaser']
    job:
      title: 'translate:job_offer'     # wird automatisch aufgelöst
      template: 'default'
      modules: ['editor', 'download', 'pdf']
    news:
      title: 'Newsbeitrag'
      template: 'twocolumn'
      custom: 'foo'                    # eigene Key-Value-Pairs sind beliebig ergänzbar

Der Inhalt jeder Datei, die in dem o.g. Verzeichnis gefunden wird, wird mit der
globalen Konfiguration zusammengeführt. So ist es auch möglich, die Definition
auf mehrere Dateien aufzuteilen. Ein AddOn kann somit neue Typen mitbringen und
muss dafür nichts weiter tun, als die Konfiguration an ``ARTICLE_TYPES`` um neue
Einträge zu erweitern.

Artikeltyp-API
--------------

Die definierten Artikeltypen stehen über die reguläre ``sly_Configuration``
bereit:

.. sourcecode:: php

  <?php
  $config = sly_Core::config();
  $types  = $config->get('ARTICLE_TYPES'); // böse!

Um die Artikeltypen abzurufen und mit ihnen zu interagieren sollte jedoch besser
der dafür zuständige :doc:`Service </core-api/services>` verwendet werden:

.. sourcecode:: php

  <?php
  $service = sly_Service_Factoy::getArticleTypeService();
  $types   = $service->getTypes();

Jeder Artikel (``sly_Model_Article``) gibt gern preis, zu welchem Typ er gehört:

.. sourcecode:: php

  <?php
  $article = sly_Util_Article::findById(1);
  $type    = $article->getType();

.. note::

  Es ist zu beachten, dass Artikel initial auch keinem Typen angehören können.
  In diesem Fall wird ein leerer String zurückgegeben.

Moduldefintionen
----------------

Seit Sally 0.6 werden die erlaubten Module direkt in der Liste der Artikeltypen
definiert.

Über den Key ``modules`` können die zulässigen Module für dieses Template
definiert werden. Dabei ist es möglich die Module auch auf einzelne Slots eines
Templates festzulegen. Folgende Bepiele sollen die Nutzung verdeutlichen.

Einfache Modulliste
^^^^^^^^^^^^^^^^^^^

In diesem Beispiel ist eine einfache Liste mit Modulen definiert.

.. sourcecode:: yaml

  ARTICLE_TYPES:
    default:
      title: 'Standard'
      template: 'foo'
      modules: ['wymeditor', 'gallery']

Diese Definition erlaubt die beiden Module in jedem Slot, die im Template foo
vorhanden sind. Alle andereren ggf. vorhandenen Module sind über das Backend
nicht hinzufügbar.

Komplexe Modulliste
^^^^^^^^^^^^^^^^^^^

In diesem Beispiel stehen die Module ``wymeditor`` und ``image`` für alle Slots
zur Verfügung. Für den Slot ``main`` steht außerdem das Modul ``gallery`` zur
Verfügung und für den Slot ``sidebar`` die Module ``teaserbox`` und
``quickcontact``.

.. sourcecode:: yaml

  ARTICLE_TYPES:
    default:
      title: 'Standard'
      template: 'foo'
      modules:
        _ALL_: ['wymeditor', 'image']
        main: 'gallery'
        sidebar: ['teaserbox', 'quickcontact']

.. warning::

  Sollte ein Slot des Templates zufällig ``_ALL_`` heißen, müssen Module, die
  für alle Slots zur Verfügung stehen sollen auch für alle Slots eingetragen
  werden. ``_ALL_`` wird dann wie ein normaler Slot behandelt.

.. warning::

  Es kann bei der Definition der Modulliste zu einem Konflikt kommen, wenn die
  komplexe Modulliste (z.B. auf Grund der Slotdefinitionen) in der Form
  ``modules: {0: wymeditor, 1: gallery, 2: teaserbox}`` definiert wird. Sie
  wird dann wie die einfache Modulliste interpretiert:
  ``[wymeditor, gallery, teaserbox]``

.. hint::

  Spätestens bei dieser Benutzung ist es ausgesprochen hilfreich, benannte Slots
  zu benutzen, da man sonst leicht durcheinander kommt.
