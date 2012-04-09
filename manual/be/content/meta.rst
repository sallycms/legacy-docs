Metadaten/Sonstiges
===================

Neben den Blöcken, die man auf der :doc:`Inhaltsseite <../content>` einpflegt,
gibt es eine weitere Seite, auf der zusätzliche Funktionen für die
Artikelverwaltung bereitstehen. Diese Funktion werden weniger häufig benötigt
und sind daher auf eine eigene Seite ausgelagert, um die alltägliche Arbeit mit
dem CMS nicht zu stören.

.. figure:: /_static/backend-content-meta.png
   :align: center
   :alt: Metadaten-Seite eines Artikels

   Metadaten-Seite eines Artikels

Die Metadaten-Seite besteht aus einer Reihe von kleineren Formularen, deren
Anzahl je nach Projekt variieren kann. Im Folgenden sollen die von Sally
bereitgestellten Funktionen beschrieben werden.

Allgemein
---------

In diesem Formular kann der Artikelname geändert werden. Dies entspricht der
gleichen Operation, die auch in der :doc:`Strukturansicht <../structure>` über
den "Ändern"-Link zugänglich ist. Unter dem Artikelnamen können noch weitere
Metainformationen des Artikels abgefragt werden, zum Beispiel die Beschreibung
oder die Schlüsselwörter (Angaben zur Suchmaschinenoptimierung, die wegen ihrer
geringeren Bedeutung auf die Metadaten-Seite ausgelagert wurden).

Über einen Klick auf "Speichern" werden die Änderungen übernommen.

Inhalte kopieren
----------------

.. note::

  Diese Funktion ist nur in mehrsprachigen Projekten verfügbar.

Über diese Funktion können alle Inhalte (Blöcke) von einer Sprache in eine
andere kopiert werden. Es werden dazu Quell- und Zielsprache ausgewählt. Dies
ist insbesondere nützlich, um sie beim Übersetzen als Vorlage verfügbar zu
haben.

Sally zeigt hierbei nur diejenigen Sprachen an, auf die der aktuelle Benutzer
auch Zugriff hat.

Artikel verschieben
-------------------

Mit dieser Funktion kann ein Artikel in eine beliebige andere Kategorie
verschoben werden (sofern Zugriff gewährt wurde). Dies wirkt sich auf alle
Sprachen gleichermaßen aus. Der Artikel wird beim Verschieben unter den in der
Zielkategorie vorhandenen Artikeln eingeordnet.

.. note::

  Wenn ein Startartikel bearbeitet wird, ist stattdessen die "Kategorie
  verschieben"-Funktion (siehe unten) verfügbar. Dies liegt daran, dass der
  Startartikel nicht unabhängig von seiner Kategorie verschoben werden kann, da
  sonst die Kategorie keinen Startartikel mehr hätte.

Artikel kopieren
----------------

Diese Funktion ähnelt der Verschieben-Funktion, nur dass hierbei der Artikel
nicht verschoben sondern dupliziert wird. Das Duplikat wird in allen Sprachen
angelegt und ist anfangs *offline*. Beim Kopieren werden ebenfalls die Inhalte
1:1 kopiert.

.. note::

  Kopierte Startartikel werden zu regulären Artikeln, die keine besondere
  Bedeutung mehr haben.

Kategorie verschieben
---------------------

Wenn die Metadaten-Seite eines *Startartikels* angezeigt wird, so ist anstatt
der "Artikel verschieben"-Funktion diese Funktion verfügbar. Beim Verschieben
einer Kategorie werden alle enthaltenen Artikel und Unterkategorien verschoben.

Startartikel
------------

Ein Artikel *innerhalb einer Kategorie* kann zum Startartikel der Kategorie
umgewandelt werden. Für Artikel auf der obersten Ebene der Struktur wird
hingegen eine Meldung angezeigt, dass dies nicht möglich ist (da Startartikel
nur in Kategorien existieren).

Diese Funktion wird üblicherweise recht selten benötigt. Sie betrifft nicht den
Inhalt, Artikeltyp oder die Metainformationen des alten oder neuen
Startartikels.
