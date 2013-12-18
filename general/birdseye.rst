Sally aus der Vogelperspektive
==============================

Auf dieser Seite soll der grundlegende Aufbau von Sally beschrieben werden. Dies
macht es einfacher, die gewünschte Funktionalität zu finden.

Dateisystem
-----------

::

  /
  +- assets/                 CSS/JS für das Frontend
  +- data/                   dynamisch angelegte Dateien
  +- develop/                Frontend-Entwicklung
  |  +- config/
  |  +- modules/
  |  +- templates/
  +- sally/                  Core, AddOns, Backend und dynamisch generierte Inhalte
     +- addons/              AddOns
     |  +- vendora/
     |  |  +- addon1/
     |  |  +- addon2/
     |  +- vendorb/
     |  |  +- addon3/
     +- assets/              Asset-Anwendung (liefert CSS/JS/... aus)
     |  +- lib/              Controller, App
     +- backend/             Backend-Anwendung
     |  +- assets/           CSS/JS des Backends
     |  +- lang/             Sprachdateien
     |  +- lib/              Backend-Seiten, Layouts, ...
     |  +- index.php
     +- core/
     |  +- config/           Default-Konfiguration
     |  +- install/          SQL-Dumps zur Installation
     |  +- lib/              Core-eigene Bibliothek
     |  +- views/            Templates Core-Komponenten (sly_Form / ...)
     |  +- loader.php
     |  +- master.php
     +- docs/                API-Dokumentation
     +- frontend/            Frontend-Anwendung
     |  +- lib/              Controller, App
     +- tests/               Unittests
     +- vendor/              weitere Bibliotheken
        +- symfony/
        |  +- yaml/
        +- leafo
           +- lessphp/

Sally unterscheidet grundlegend drei Bereiche:

* **Statischer Code** enthält den SallyCMS-Core sowie alle AddOns. Dies betrifft
  alle Dateien, die im :file:`sally`-Verzeichnis abgelegt werden. Da dort keine
  Dateien erzeugt oder verändert werden, ist es einfach, diese bei Updates zu
  überschreiben, ohne Einstellungen oder Anpassungen zu verlieren. Gleichzeitig
  wird es damit möglich, die Verzeichnisse :file:`backend` und :file:`core` auf
  einem Server per Symlink bereitzustellen und für mehrere Projekt
  wiederzuverwenden. Oder anders gesagt: Das :file:`sally`-Verzeichnis benötigt
  ausschließend lesenden Zugriff von PHP.
* **Dynamische Inhalte** wie die Konfiguration, der Medienpool, der
  Dateisystem-Cache, Datenbank-Exports etc. werden in :file:`data` abgelegt. Es
  ist damit möglich, eine Installation komplett zurückzusetzen, indem nur das
  :file:`data`-Verzeichnis gelöscht wird.
* Die **Projektentwicklung** findet in :file:`develop` und :file:`assets` statt.
  Dort werden Templates verwaltet, Konfigurationen abgelegt etc.

data-Verzeichnis
^^^^^^^^^^^^^^^^

Das :file:`data`-Verzeichnis folgt einem genau vorgegebenen Layout, das hier
kurz angerissen werden soll.

::

  /
  +- data/
     +- config/              Projektkonfiguration (nicht per HTTP zugänglich)
     |  +- sly_local.yml     nur für diesen Host gültige Konfiguation (-> Datenbankzugang)
     +- temp/                temporäre Dateien (nicht per HTTP zugänglich)
     |  +- sally/            Dateisystem-Cache, YAML/JSON-Cache, Logs, ...
     |  +- vendor/
     |     +- addon/         Dateien des AddOns 'vendor/addon'
     +- import-export/       Datenbank-Exports (nicht per HTTP zugänglich)
     +- mediapool/           Medienpool

Um an die Pfade zu gelangen, stellen die :doc:`Services </core-api/services/addon>`
eine Reihe von Methoden zur Verfügung.

SallyCMS kümmert sich automatisch darum, dass :file:`data/config`,
:file:`data/temp` und :file:`data/import-export` per htaccess für den Zugriff
via HTTP gesperrt werden.

develop-Verzeichnis
^^^^^^^^^^^^^^^^^^^

In :file:`develop` findet die eigentliche Projektentwicklung statt. Das
Verzeichnis wird ebenfalls gegen Zugriff via HTTP geschützt. Aufgrund seiner
Wichtigkeit wurde ihm ein :doc:`eigener Artikel </frontend-devel/develop>`
gewidmet.

Die Sally-Bibliothek
--------------------

Sally bringt eine ganze Reihe von Klassen mit. Ihre grobe Struktur soll im
Folgenden beschrieben werden. Dateinamen folgen dem `PSR-0 Standard <https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md>`_, sodass die
Klasse ``sly_Model_Article`` in der Datei :file:`sly/Model/Article.php` zu
finden ist. Das untenstehende Klassendiagramm beschreibt also gleichzeitig die
Klassenpräfixe.

.. note::

  Diese Liste ist natürlich nicht vollständig.

::

  /lib/sly/
  +- Authorisation/         Authorisierungs-API (Work in Progress)
  +- Controller/            Basisimplementierung für Controller
  +- DB/                    Datenbank-Abstraktion
  |  +- PDO                 PDO-spezifische Implementierung
  +- Event/                 Event-Dispatcher (ersetzt Extension-API aus REDAXO)
  +- Form/                  Formularframework (datenbankunabhängige, saubere Version von rex_form)
  |  +- Input/
  |  +- Select/
  |  +- Widget/
  +- I18N/                  Mehrsprachigkeits-API
  +- Layout/                Basisimplementierung der Layouts
  +- Mail/                  Mail-Exception
  +- Model/                 Models (Klassen, die einzelne Datenbankzeilen kapseln)
  +- Registry/              Registry (Key-Value-Stores) (temporär und persistent)
  +- Service/               Dienstfunktionalitäten (zum Interagieren mit AddOns, Models, ...)
  +- Table/                 Tabellenframework
  +- Util/                  Utilities (allgemeine Hilfsklassen und Shortcuts für Services)
  +- Authorisation.php      Authorisierungs-API
  +- Configuration.php      Systemkonfiguration
  +- Core.php               Systemkern (wichtigste Methoden: aktueller User, Artikel, Sprache, ...)
  +- Form.php               Formularframework
  +- I18N.php               Mehrsprachigkeits-API
  +- Layout.php             abstraktes Layout
  +- Log.php                simpler, dateibasierter Logger
  +- Mail.php               Mailing-API
  +- Table.php              Tabellenframework
  +- Util.php               gemischte Methoden, die sonst nirgends hingehören

Models, Services und Utilities
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Neben den gemischten Klassen für Formulare, Tabellen und dergleichen gibt es
drei wichtige Gruppen, die für das Verständnis von Sally wichtig sind.

Models
^^^^^^

Die Model-Klassen beschreiben einzelne Datenbank-Einträge. Jede Instanz wrappt
genau einen Datensatz. So repräsentiert ``sly_Model_Article`` einen Artikel und
``sly_Model_User`` einen Backend-Benutzer.
Models sind meist recht primitive Klassen, die zu einem großen Teil aus Getter-
und Settermethoden bestehen. Dies liegt daran, dass ein Model nicht weiß, wo es
gespeichert wird. Es "sieht" damit nie die anderen Datensätzen um sich herum und
ist nicht in der Lage, sich selbst zu speichern. Eine Methode wie ``->save()``
existiert damit in keinem Model.

Diese Kapselung ermöglicht es, Models in verschiedenen Systemen zu speichern.
Für die meisten Models kommt die Datenbank zum Einsatz, jedoch wäre es auch ohne
Weiteres denkbar, die Sprachen (``sly_Model_Language``) in einer YAML-Datei zu
definieren. Das Model selbst wüsste davon nichts.

Services
^^^^^^^^

:doc:`Services </core-api/services>` bieten einen Großteil der Kernfunktionalität
von Sally an. Sie dienen dazu, Models zu speichern oder anzulegen, AddOns zu
verwalten, Templates zu synchronisieren etc. Services sind über den
:doc:`DI-Container </core-api/di-container>` zugänglich.

In einem klassischen objektorientierten Entwurf sind Eigenschaften und
Verhaltensweisen in **einer** Klasse gekapselt. Sally trennt diese Kapselung auf
und legt Eigenschaften in den schon besprochenen Models und das Verhalten in den
Services ab. So ist es möglich, ein und dassselbe Model mit verschiedenen
Services zu bearbeiten, wobei einer das Model in die Datenbank und ein anderen
es in eine YAML-Datei schreiben könnte.

Es ist jedoch recht aufwändig, sich für alle Tätigkeiten immer zuerst einen
Service zu holen und dann dessen gewünschte Methode aufzurufen. Um dies zu
vereinfachen, kommen die Utilities ins Spiel.

Utilities
^^^^^^^^^

Die Klassen in ``sly_Util_...`` stellen häufig benutzte Methoden zur Verfügung,
um insbesondere beim Entwickeln von Templates und Modulen die Arbeit zu
erleichtern. So gibt es ein ``sly_Util_Article``, das Shortcuts für Methoden in
``sly_Service_Article`` anbietet. Allerdings gibt es weder für alle Services
eine entsprechende Utility-Klasse, noch enthalten die Utilities ausschließlich
Helfer für Services. So gibt es einige HTML-Helper in ``sly_Util_HTML``, zu
denen kein Service existiert.

Generell sind Utility-Klassen eine Sammlung von statischen Methoden. Instanzen
dieser Klassen werden nie benötigt.
