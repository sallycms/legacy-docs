Integratoren & Redakteure
=========================

Aus der Projektbeschreibung:

.. pull-quote::

  Das Sally CMS richtet sich besonders an Professionals und Integratoren, die
  für ihre Kunden gut bedienbare und professionelle Webseiten auf Basis eines
  CMS umsetzen wollen.

Damit ergibt sich eine klare Trennung zwischen Entwicklern und Redakteuren. Dies
führt zu einer Unterscheidung zwischen Elementen, die zur Entwicklungszeit
festgelegt und Inhalten, die später im Live-Betrieb geändert werden können.
Diese Trennung spiegelt sich in der Art und Weise wider, wie Projekte aufgebaut
werden.

YAML
----

`YAML <http://www.yaml.org/>`_ dient uns als systemweite Konfigurationssprache.
Es ist leicht zu schreiben, leicht zu lesen und dank
`sfYaml <http://components.symfony-project.org/yaml/>`_ leicht zu parsen. Die
Performance von SallyCMS wird durch einen transparenten YAML-Cache
sichergestellt.

Entwickler
----------

Der Entwickler legt bei SallyCMS die grundlegenden Eigenschaften einmalig fest.
Dazu zählen verfügbare Metainformationen, Formulare, Einstellungen usw. Da sich
diese Angaben im Produktivbetrieb nicht ändern sollen, werden sie über
YAML-Dateien in :file:`develop/config` verwaltet. So ist es möglich, das CMS
genau auf den Kunden zuzuschneiden.

Die gesamte Architektur, insbesondere der AddOns, ist auf diese Konfektionierung
ausgelegt:

* **Artikeltypen** legen fest, welche Inhalte (Module, Metainfos) verwaltet
  werden können.
* **Metainformationen** werden pro Artikeltyp definiert, sodass ein Redakteur
  später nur die Eingabemöglichkeiten erhält, die er wirklich benötigt.
* **Global Settings** machen beliebig komplexe Einstellungen im Backend möglich
  und erlauben so, Aspekte wie die Adresse im Footer einer Seite zu bearbeiten.
* **Benutzer** erhalten genau die Eigenschaften, die im Projekt benötigt werden.
  Es werden keine unnötigen Standardfelder angezeigt, die ungenutzt bleiben.

Neben dieser Struktur des Projekts gibt es den Inhalt, der nicht in YAML-Dateien
erfasst werden kann, da dieser im Backend änderbar sein sollte.

Redakteure
----------

Redakteure erhalten ein maßgeschneidertes Interface und können die Dinge
einstellen, die einstellbar sein sollen.

* Bei **Formularen** können Empfängeradresse, Betreff und Inhalt der Mail
  angepasst werden.
* **Metainfos** können mit den entsprechenden Daten belegt werden.
* API-Keys, Domaineinstellungen, spezielle Artikel und dergleichen können
  angepasst werden.
* **Übersetzungen** können eingepflegt, Sprachen können ergänzt werden.

Für all diese Elemente gilt, dass sie in der Datenbank vorgehalten werden. Damit
werden sie bei einem Export gesichert (Backup) und können wiederhergestellt
werden.

Zusammenfassung
---------------

Bei der Umsetzung eines Projekts werden statische Eigenschaften in YAML-Dateien
verwaltet, die einfach zu erstellen, leicht zu versionieren und dokumentierbar
sind.

Die eigentliche Inhalte werden in der Datenbank verwaltet und können so leicht
gesichert und wiederhergestellt werden.
