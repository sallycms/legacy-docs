Aufbau
======

Zur korrekten Funktionsweise eines AddOns müssen mindestens zwei Dateien
existieren: Die :file:`static.yml`, die die Konfiguration des AddOns enthält,
und eine :file:`config.inc.php`, die zum "Booten" des AddOns eingebunden wird.

Es gibt noch einige weitere Dateien, die von besonderer Bedeutung sind. Diese
werden im Folgenden ebenfalls beschrieben. Eine empfohlene Struktur für AddOns
sieht wie folgt aus:

.. note::

  Dateien/Verzeichnisse, die von besonderer Bedeutung (und nicht nur eine
  Empfehlung sind), sind mit einem (*) markiert.

::

  /sally/
  +- addons/
     +- myaddon/
        +- assets/              CSS/JS/Bilder (*)
        +- develop/             Beispielinhalte und Vorlagen für die Projektentwicklung (wenn nötig)
        +- docs/                Dokumentation
        +- lang/                Sprachdateien
        +- lib/                 Bibliotheken, Controller, ...
        +- views/               Templates
        +- config.inc.php       Bootstrap-Script (*)
        +- defaults.yml         Standardkonfiguration (*)
        +- globals.yml          globale Konfigurationsdaten (*)
        +- install.inc.php      Script zur Installation (*)
        +- install.sql          Datenbank Setup-Script (*)
        +- static.yml           statische Infos des AddOns (*)
        +- uninstall.inc.php    Script zur Deinstallation (*)
        +- uninstall.sql        Datenbank Uninstall-Script (*)
        +- LICENSE              Lizenzdatei

static.yml
----------

.. note::

  Diese Datei muss zwingend für jedes AddOn existieren.

In der :file:`static.yml` liegen die *statischen* Informationen über das AddOn,
wie beispielsweise der Autor, die Version oder der Link zur Website. Diese Daten
können sich zur Laufzeit *nicht ändern*. In dieser Datei können neben den von
Sally benötigten Daten auch noch weitere Daten abgelegt werden (solange diese
niemals im Code geändert werden sollen).

Eine :file:`static.yml` könnte wie folgt aussehen:

.. sourcecode:: yaml

  name: 'Mein AddOn'
  page: 'myaddon'
  author: 'Tom Mustermann'
  supportpage: 'http://www.example.com/'
  version: '1.0'
  sally: ['0.5.8', '0.5.9', '0.6']
  requires: ['developer_utils', 'metainfo', 'varisale/coupon']
  mycustomvalue: 'foo'
  is_awesome:
    monday: 'yes'
    sunday: 'no'

Hier die Beschreibung der einzelnen Werte:

**name**
  angezeigter Name des AddOns (erzeugt automatisch einen Menü-Eintrag und einen
  Link zum Controller ``sly_Controller_Myaddon`` (abgeleitet vom
  Verzeichnisnamen des AddOns)).

**page**
  Gibt an, auf welchen Controller der Link im Menü zeigen soll. Praktisch, wenn
  der Name des AddOns nicht 1:1 auf den Controllernamen gemapt werden soll.

**author** (benötigt)
  Der oder die Autoren des AddOns

**supportpage**
  Eine URL zur Projektseite des AddOns (z.B. zum Repository)

**version**
  Die Version des AddOns. Das Format kann frei gewählt werden, da die Angabe
  ebenfalls optional ist.

**sally** (benötigt)
  Eine Liste von Versionen, mit denen das AddOn kompatibel ist. ``'0.6'`` passt
  auf alle Versionen der 0.6.x-Linie. ``0.5.8`` matcht nur auf diese konkrete
  Version.

**requires**
  Hier kann eine Liste von benötigten AddOns und Plugins notiert werden. Diese
  werden dann **vor** dem eigentlichen AddOn geladen und müssen ebenfalls
  aktiviert sein, damit das AddOn geladen wird. Sind nicht alle benötigten
  AddOns vorhanden, lässt Sally keine Installation zu. AddOns werden über ihren
  Namen angegeben (``'developer_utils'``), Plugins als Kombination aus AddOn-
  und Pluginname (``'varisale/coupon'``).

**(weitere Infos)**
  (nach Wunsch)

.. note::

  Alle Versionsnummern sollten als **Strings** notiert werden, damit sie beim
  Parsen nicht in Floats umgewandelt werden. Das gilt sowohl für die eigene
  Version als auch für die Versionen im ``sally``-Key.

Die Informationen aus der :file:`static.yml` werden beim Laden des AddOns in die
Konfiguration an die Stelle ``ADDON/myaddon/...`` geladen und stehen über den
AddOn-Service zum Abfruf bereit.

.. note::

  Die :file:`static.yml` wird nur geladen, wenn das AddOn installiert und
  aktiviert ist.

config.inc.php
--------------

.. note::

  Diese Datei muss zwingend für jedes AddOn existieren.

Diese Datei ist der Einstiegspunkt für das AddOn. Sie wird von Sally
eingebunden um das AddOn "hochzufahren". Hier werden üblicheweise die
Sprachdateien geladen, die Bibliotheken beim
:doc:`Autoloader </core-api/autoloading>` angemeldet, Event-Listener registriert
und weitere Initialisierungen vorgenommen.

Die Datei wird sowohl im Frontend als auch im Backend eingebunden. Dies findet
relativ früh im Sally-Prozess statt, sodass hier noch nicht alle Bestandteile
fertig initialisiert sind. So steht der Controller noch nicht fest, ebenso wie
noch kein Artikel gesucht oder Sprache erkannt wurde.

Es wird daher empfohlen, in der :file:`config.inc.php` nur "billige" Operationen
vorzunehmen (keine Datenbank-Queries, keine teuren Berechnungen, ...) und die
eigentlichen Operationen mindestens bis zum Event ``ADDONS_INCLUDED``
zurückzustellen. Beim Eintreten dieses Events sind alle Event-Listener der
AddOns registriert, die APIs stehen zur Verfügung und man kann von einem
sauberen System ausgehen. Auch kann es sich lohnen, mittels
``sly_Core::isBackend()`` zwischen Frontend und Backend zu unterscheiden, um
sich möglichst intelligent und ressourcenschonend ins System zu integrieren.

.. warning::

  Da die :file:`config.inc.php` immer eingebunden wird, ist nicht garantiert,
  dass auch ein Benutzer eingeloggt ist (im Frontend wird beispielsweise
  standardmäßig gar keine Session gestartet). Man sollte in seinem Boot-Script
  also vorsichtig den Systemzustand abklopfen, wenn man nicht aus Versehen die
  Website lahmlegen möchte.

.. sourcecode:: php

  <?php

  $here = SLY_ADDONFOLDER.'/myaddon';

  // dafür sorgen, dass Sally unsere Klassen findet
  sly_Loader::addLoadPath($here.'/lib');

  // Sprachdateien laden, falls in Backend
  if (sly_Core::isBackend()) {
     sly_Core::getI18N()->appendFile($here.'/lang');
  }

  // Remember: isBackend() garantiert *nicht*, dass auch jemand eingeloggt ist!
  if (sly_Util_User::findCurrentUser() !== null) {
     // jemand ist eingeloggt
  }

  // Event-Listener registrieren
  $dispatcher = sly_Core::dispatcher();

  $dispatcher->register('ADDONS_INCLUDED',    array('Myaddon', 'initMe'));
  $dispatcher->register('SLY_ARTICLE_OUTPUT', array('Myaddon', 'fixSpellingMistakesByMagic'));

defaults.yml
------------

Während in der :file:`static.yml` **statische** Informationen stehen, können in
der :file:`defaults.yml` AddOn-Daten abgelegt werden, die über die API änderbar
sein sollen. In den meisten Fällen handelt es sich dabei um Vorgabewerte für
die AddOn-Konfiguration, die dann im Backend angepasst werden kann.

Die :file:`defaults.yml` wird ebenfalls nach ``ADDON/myaddon/...`` geladen und
hat Vorrang vor der :file:`static.yml` (obwohl es selten Sinn machen dürfte,
die Informationen aus der statischen Config zu überschreiben).

Auch die Daten aus der :file:`defaults.yml` stehen damit über den
AddOn-Service (``->getProperty()``) zur Verfügung.

.. note::

  Die :file:`static.yml` wird nur geladen, wenn das AddOn installiert und
  aktiviert ist.

globals.yml
-----------

In der Datei :file:`globals.yml` können globale Konfigurationseinstellungen
hinzugefügt oder überschieben werden. Zum Beispiel möchte ein Blog-AddOn einen
Artikeltypen zufügen.

.. sourcecode:: yaml

  ARTICLE_TYPES:
    blog:
      title: 'Blog'
      template: 'blogtemplate'

Die Daten aus der :file:`globals.yml` werden im Gegensatz zu den anderen beiden
YAML-Dateien direkt in den **Root** der Konfiguration geladen und können daher
quasi alles überschreiben.

.. note::

  Die :file:`globals.yml` wird **immer** geladen, wenn das AddOn installiert ist
  (es muss dafür nicht aktiviert sein). Autoren sollten also vorsichtig sein,
  welche Inhalte sie hier ablegen (Referenzen zu Klassen, die nicht gefunden
  werden können, wenn das AddOn nicht aktiv ist, können zu Problemen führen).

  Hier sollten also auch keine Event-Listener über ``LISTENERS`` definiert
  werden.
