Aufbau
======

Zur korrekten Funktionsweise eines AddOns müssen mindestens zwei Dateien
existieren: Die :file:`composer.json`, die die Konfiguration des Pakets (und
ggf. weitere, Sally-spezifische Angaben) enthält, und eine :file:`boot.php`,
die zum "Booten" des AddOns eingebunden wird.

Es gibt noch einige weitere Dateien, die von besonderer Bedeutung sind. Diese
werden im Folgenden ebenfalls beschrieben. Eine empfohlene Struktur für AddOns
sieht wie folgt aus:

.. note::

  Dateien/Verzeichnisse, die von besonderer Bedeutung (und nicht nur eine
  Empfehlung sind), sind mit einem (*) markiert.

::

  /sally/
  +- addons/
     +- initech/
       +- myaddon/
          +- assets/              CSS/JS/Bilder (*)
          +- develop/             Beispielinhalte und Vorlagen für die Projektentwicklung (wenn nötig)
          +- docs/                Dokumentation
          +- lang/                Sprachdateien
          +- lib/                 Bibliotheken, Controller, ...
          +- views/               Views (Templates)
          +- boot.php             Bootstrap-Script (*)
          +- composer.json        statische Infos des Pakets/AddOns (*)
          +- defaults.yml         Standardkonfiguration (*)
          +- globals.yml          globale Konfigurationsdaten (*)
          +- install.php          Script zur Installation (*)
          +- install.sql          Datenbank Setup-Script (*)
          +- uninstall.php        Script zur Deinstallation (*)
          +- uninstall.sql        Datenbank Uninstall-Script (*)
          +- LICENSE              Lizenzdatei

composer.json
-------------

.. note::

  Diese Datei muss zwingend für jedes AddOn existieren.

In der :file:`composer.json` liegen die statischen Informationen über das AddOn,
wie beispielsweise der Autor, die Version oder der Link zur Website. Diese Daten
können über die Sally-API ausschließlich ausgelesen, aber nicht geändert werden.
In dieser Datei können neben den von Composer vorgeschriebenen Inhalten auch
noch weitere Informationen abgelegt werden (um z.B. einen Link im Backend-Menü
zu definieren). Diese zusätzlichen Informationen werden dann in
``extra/sallycms/...`` abgelegt.

Eine :file:`composer.json` könnte wie folgt aussehen:

.. sourcecode:: javascript

  {
    "name": "sallycms/be-search",
    "description": "AddOn for SallyCMS, providing better navigation capabilities.",
    "authors": [{"name": "webvariants GbR"}],
    "homepage": "http://www.sallycms.de/",
    "version": "1.0.2",
    "license": "MIT",
    "type": "sallycms-addon",
    "require": {
      "sallycms/composer-installer": "*",
      "sallycms/sallycms": "0.7,0.8",
      "php": ">=5.2.0",
      "sallycms/another-addon": "4.*",
      "initech/stapler": "5.*"
    },
    "autoload": {
      "psr-0": {"": "lib/"}
    },
    "extra": {
      "sallycms": {
        "page": "foo"
      }
    }
  }

Bis auf den ``type`` unterscheidet sich ein AddOn also nicht von jedem anderen
Composer-Paket, insofern sollte man auch mit der `offiziellen Dokumentation`_
vertraut sein. Folgende Angaben sind für Sally relevant:

.. _offiziellen Dokumentation: http://getcomposer.org/doc/04-schema.md

**name**
  Name des AddOns. Der Name muss dem Schema **vendor/addon** folgen und
  ebenfalls mit dem Verzeichnispfad übereinstimmen, in dem das AddOn liegt
  (:file:`sally/addons/vendor/addon`).

**authors** (benötigt)
  Der oder die Autoren des AddOns; im Gegensatz zu Composer ist dieser Wert für
  ein Sally-AddOn eine **Pflichtangabe**.

**homepage**
  Eine URL zur Projektseite des AddOns (z.B. zum Repository)

**version** (benötigt)
  Die Version des AddOns. Das Format muss dem von Composer `vorgegebenen Format`_
  folgen.

.. _vorgegebenen Format: http://getcomposer.org/doc/04-schema.md#version

**type** (benötigt)
  muss für ein AddOn zwingend ``sallycms-addon`` sein.

**require** (benötigt)
  Enthält die Abhängigkeiten des AddOns. AddOns können andere AddOns oder
  beliebige andere Pakete erfordern. Benötigte Pakete, die keine AddOns sind,
  werden nach :file:`sally/vendor` installiert.

  AddOns müssen immer ``sallycms/composer-installer`` in einer beliebigen
  Version (damit der Typ ``sallycms-addon`` bekannt ist) sowie
  ``sallycms/sallycms`` (Sally selbst) erfordern. Die Versionsangabe von Sally
  **muss** in der Form ``"version,version,version"`` erfolgen, wobei jede
  Version die numerische Sally-Version ist (z.B. ``"0.6,0.7.1,0.7.2"``).

  Benötigte AddOns werden immer **vor** dem AddOn, das sie benötigt, geladen.

.. note::

  Die Angaben zum Autoloader (``autoload``) sind optional und werden von Sally
  bisher nicht ausgewertet (da Composer keinen 5.2-kompatiblen Autoloader
  erzeugt). Die in einem AddOn enthaltenen Klassen müssen in der
  :file:`boot.php` über den ``sly_Loader`` auffindbar gemacht werden.

Unter ``sallycms/extra`` können die folgenden weiteren Keys definiert werden:

**page**
  Wenn angegeben, wird ein Link im Backend-Menü erzeugt, der auf ``?page=...``
  zeigt. Der Name des Links muss dazu über den Key ``name`` angegeben werden.

**name**
  der Name des Links (siehe oben; nur relevant, wenn ``page`` gegegeben ist)

Alle Daten aus der :file:`composer.json` können über den AddOn-Service sowie
über den AddOn-Package-Service abgerufen werden.

.. sourcecode:: php

  <?php
  $addonService = sly_Service_Factory::getAddOnService();
  print $addonService->getComposerKey('initech/stapler', 'version');

boot.php
--------

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

Es wird daher empfohlen, in der :file:`boot.php` nur "billige" Operationen
vorzunehmen (keine Datenbank-Queries, keine teuren Berechnungen, ...) und die
eigentlichen Operationen mindestens bis zum Event ``SLY_ADDONS_LOADED``
zurückzustellen. Beim Eintreten dieses Events sind alle Event-Listener der
AddOns registriert, die APIs stehen zur Verfügung und man kann von einem
sauberen System ausgehen. Auch kann es sich lohnen, mittels
``sly_Core::isBackend()`` zwischen Frontend und Backend zu unterscheiden, um
sich möglichst intelligent und ressourcenschonend ins System zu integrieren.

.. warning::

  Da die :file:`boot.php` immer eingebunden wird, ist nicht garantiert,
  dass auch ein Benutzer eingeloggt ist (im Frontend wird beispielsweise
  standardmäßig gar keine Session gestartet). Man sollte in seinem Boot-Script
  also vorsichtig den Systemzustand abklopfen, wenn man nicht aus Versehen die
  Website lahmlegen möchte.

.. sourcecode:: php

  <?php

  $here = rtrim(dirname(__FILE__), DIRECTORY_SEPARATOR);

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

  $dispatcher->register('SLY_ADDONS_LOADED',  array('Myaddon', 'initMe'));
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
