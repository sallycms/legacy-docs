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
  |
  +- sally/                  Backend und Bibliothek
  |  +- include/
  |  |  +- addons/           AddOns
  |  |  +- config/           Default-Konfiguration
  |  |  +- controllers/      Sally-Backend-Controller
  |  |  +- (functions/)      Funktionssammlung aus REDAXO
  |  |  +- helpers/          Hilfsklassen für Sally
  |  |  +- install/          SQL-Dumps zur Installation
  |  |  +- lang/             Sprachdateien
  |  |  +- layout/           Sally-Backend-Layout
  |  |  +- lib/              Sammlung von Bibliotheken
  |  |  |  +- babelcache/    BabelCache: Cachingsystem
  |  |  |  +- PEAR/          PEAR: JSON-Implementierung
  |  |  |  +- (rex/)         alter REDAXO-Code (inkl. OO-Klassen)
  |  |  |  +- Scaffold/      Scaffold: erweitert und minimiert CSS
  |  |  |  +- sfYaml/        sfYaml: YAML-Parser
  |  |  |  +- sly/           Sally-eigene Bibliothek
  |  |  +- pages/            alte Backend-Seiten
  |  |  +- views/            Templates für das Backend / sly_Form / ...
  |
  +- tests/                  Unittests

Sally unterscheidet grundlegend drei Bereiche:

* **Statischer Code** enthält den SallyCMS-Core sowie alle AddOns. Dies betrifft
  alle Dateien, die im ``sally``-Verzeichnis abgelegt werden. Da dort keine
  Dateien erzeugt oder verändert werden, ist es einfach, diese bei Updates zu
  überschreiben, ohne Einstellungen oder Anpassungen zu verlieren. Gleichzeitig
  wird es damit möglich, das ``sally``-Verzeichnis auf einem Server per Symlink
  bereitzustellen und für mehrere Projekt wiederzuverwenden. Oder anders gesagt:
  Das ``sally``-Verzeichnis benötigt ausschließend lesenden Zugriff von PHP.
* **Dynamische Inhalte** wie die Konfiguration, der Medienpool, der
  Dateisystem-Cache, Datenbank-Exports etc. werden in ``data`` abgelegt. Es ist
  damit möglich, eine Installation komplett zurückzusetzen, indem nur das
  ``data``-Verzeichnis gelöscht wird.
* Die **Projektentwicklung** findet in ``develop`` und ``assets`` statt. Dort
  werden Templates verwaltet, Konfigurationen abgelegt etc.

data-Verzeichnis
^^^^^^^^^^^^^^^^

Das ``data``-Verzeichnis folgt einem genau vorgegebenen Layout, das hier kurz
angerissen werden soll.::

  /
  +- data/
  |  +- config/              Projektkonfiguration (nicht per HTTP zugänglich)
  |  |  +- sly_local.yml     nur für diesen Host gültige Konfiguation (-> Datenbankzugang)
  |  |  +- sly_project.yml   hostübergreifende Konfiguration
  |  +- dyn/
  |  |  +- internal/         Systemdateien (nicht per HTTP zugänglich)
  |  |  |  +- sally/         sly_Loader-Cache, YAML-Cache, Artikelcache, Templatecache, Logs, ...
  |  |  |  +- addon1/
  |  |  |  +- addon2/
  |  |  |  +- addon3/
  |  |  +- public/           öffentliche generierte Dateien (Assets der AddOns, Cache von ImageResize)
  |  |  |  +- sally/         CSS von Sally
  |  |  |  +- addon1/
  |  |  |  +- addon2/
  |  |  |  +- addon3/
  |  +- import_export/       Datenbank-Exports (nicht per HTTP zugänglich)
  |  +- mediapool/           Medienpool

Um an die Pfade zu gelangen, stellen die :doc:`Services <services/addon>` eine Reihe
von Methoden zur Verfügung.

SallyCMS kümmert sich automatisch darum, dass ``data/config``,
``data/dyn/internal`` und ``data/import_export`` per htaccess für den Zugriff
via HTTP gesperrt werden.

develop-Verzeichnis
^^^^^^^^^^^^^^^^^^^

In ``develop`` findet die eigentliche Projektentwicklung statt. Das Verzeichnis
wird ebenfalls gegen Zugriff via HTTP geschützt. Aufgrund seiner Wichtigkeit
wurde ihm ein [[Develop-System|eigener Artikel]] gewidmet.

Die Sally-Bibliothek
--------------------

Sally bringt eine ganze Reihe von Klassen mit. Ihre grobe Struktur soll im
Folgenden beschrieben werden. Durch den [[Autoloading|Autoloader]] werden die
Verzeichnisnamen 1:1 auf Klassennamen gemappt, sodass die Klasse
``sly_Model_Article`` in der Datei ``sly/Model/Article.php`` zu finden ist. Das
untenstehende Klassendiagramm beschreibt also gleichzeitig die Klassenpräfixe.::

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
  +- Cache.php              Wrapper für BabelCache
  +- Configuration.php      Systemkonfiguration
  +- Core.php               Systemkern (wichtigste Methoden: aktueller User, Artikel, Sprache, ...)
  +- Form.php               Formularframework
  +- I18N.php               Mehrsprachigkeits-API
  +- Layout.php             abstraktes Layout
  +- Loader.php             Autoloader
  +- Log.php                Logging-API
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

[[Services]] bieten einen Großteil der Kernfunktionalität von Sally an. Sie
dienen dazu, Models zu speichern oder anzulegen, AddOns zu verwalten, Templates
zu synchronisieren etc. Sie sind als Singletons ausgelegt und werden über die
``sly_Service_Factory`` (die selbst kein Service ist) instantiiert.

In einem klassischen objektorientierten Entwurf sind Eigenschaften und
Verhaltensweisen in *einer* Klasse gekapselt. Sally trennt diese Kapselung auf
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
Helfer für Services. ``sly_Util_YAML`` stellt zum Beispiel Methoden zum
gecachten Laden von YAML-Dateien bereit und hat nichts mit Services zu tun.

Generell sind Utility-Klassen eine Sammlung von statischen Methoden. Instanzen
dieser Klassen werden nie benötigt.
