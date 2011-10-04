Kern-API
========

Die Klasse ``sly_Core`` bietet Zugang zu den wichtigsten Objekten und
Einstellungen und soll hier kurz beschrieben werden.

.. note::

  Auch wenn die Klasse eine ``::getInstance()``-Methode anbietet, wird diese
  quasi nie benötigt, da alle Zugriffsfunktionen statisch sind.

Die Tatsache, dass einige Methoden ``getXY()`` und andere ``xy()`` heißen, ist
dem Umstand geschuldet, dass sich die API langsam entwickelt hat. Für kommende
0.x-Releases ist es nicht geplant, die Benennung zu vereinheitlichen. Spätestens
für die 1.x-Serie ist dies aber angedacht.

Systemcache
-----------

``sly_Core`` enthält die globale Caching-Instanz, über die alle weiteren
Kern-Komponenten sowie AddOns ihre Daten zwischenspeichern können/sollten.
AddOn-Autoren können sich sicher sein, dass die Instanz immer dasselbe Interface
unterstützt, egal, ob in Memcache oder das Dateisystem geschrieben wird.

*Beispiel*

.. sourcecode:: php

  <?
  $cache = sly_Core::cache();
  $cache->set('namespace', 'key', 'value');
  $cache->get('namespace', 'key');

Siehe dazu auch die :doc:`Caching-Dokumentation <caching>`.

Sprachenzugriff
---------------

Da die aktuelle Frontendsprache in den meisten Requests von Bedeutung ist, gibt
es in ``sly_Core`` eine Reihe von Hilfsmethoden, um komfortabel darauf
zuzugreifen.

*Beispiel*

.. sourcecode:: php

  <?
  // aktuelle Sprache ermitteln
  $clang = sly_Core::getCurrentClang(); // z.B. 1

  // aktuelle Sprache ändern (meist nur für realurl-Implementierungen o.ä. relevant)
  sly_Core::setCurrentClang(2); // ID muss existieren

  // aktuelle Sprache als sly_Model_Language-Objekt ermitteln
  $lang = sly_Core::getCurrentLanguage(); // object(sly_Model_Language) {...}

  // Von der aktuellen Sprache kann z.B. das dazugehörige Locale ermittelt werden.
  $locale = $lang->getLocale(); // z.B. de_DE

  // Um das Locale zu ermitteln gibt es auch eine Methode im Language-Utility
  $locale = sly_Util_Language::getLocale();

Artikelzugriff
--------------

Der aktuelle Artikel ist mindestens so wichtig wie die aktuelle Sprache, deshalb
gibt es auch dafür entsprechende Methoden.

*Beispiel*

.. sourcecode:: php

  <?
  // aktuelle Artikel-ID ermitteln
  $articleID = sly_Core::getCurrentArticleId(); // z.B. 1

  // aktuelle Artikel-ID ändern (nur für realurl-Implementierungen relevant)
  sly_Core::setCurrentArticleId(12);

  // aktuellen Artikel als sly_Model_Article ermitteln
  $article = sly_Core::getCurrentArticle(); // object(sly_Model_Article) {}

Systemkonfiguration
-------------------

Die globale Konfiguration kann wie im folgenden Beispiel gezeigt abgerufen
werden.

.. sourcecode:: php

  <?
  $config = sly_Core::config();

  // Beispiele
  $config->get('START_CLANG_ID');
  $config->get('DATABASE/TABLE_PREFIX');

Eine umfassendere Beschreibung des :doc:`Konfigurationssystems von SallyCMS
<configuration>` ist auch verfügbar.

Event-Dispatcher
----------------

Der Dispatcher dient dazu, Listener (PHP-Callbacks) auf einzelne Events zu
registrieren. Siehe dazu auch :doc:`Eventsystem <events/index>`.

.. sourcecode:: php

  <?
  $dispatcher = sly_Core::dispatcher();

  // Beispiele
  $dispatcher->register('MY_EVENT', 'myCallbackFunction');
  $dispatcher->notify('ADDONS_INCLUDED');

Layout
------

SallyCMS verwendet im Backend eine Instanz der Klasse ``sly_Layout``, um die
HTML-Seite zu rendern. AddOns und Module können über eine einfache API
CSS/JS-Dateien zum ``<head>`` hinzufügen.

.. sourcecode:: php

  <?
  $layout = sly_Core::getLayout();

  // Beispiele
  $layout->addCSSFile('../sally/data/dyn/public/myaddon/css/backend.css');
  $layout->addJavaScript('alert("foo!");');

.. note::

  Wie in :doc:`Frontend-Layouts </developing/develop/layouts>` beschrieben, ist
  es von Vorteil, auch im Frontend ``sly_Layout`` zu verwenden.

Systemzustand
-------------

``sly_Core`` bietet Methoden zur Unterscheidung zwischen Frontend/Backend und
Entwickler- und Produktivmodus an.

.. sourcecode:: php

  <?
  // Backend?
  sly_Core::isBackend(); // true/false

  // Entwicklermodus?
  sly_Core::isDeveloperMode(); // true/false

.. note::

  Es gibt jeweils nur diese eine Methode für die jeweiligen Stati. Das heißt, es
  gibt **keine** ``::isFrontend()``-Methode.

Übersetzung (I18N)
------------------

Übersetzungen können (und sollten) im Backend über die globale Funktion
``t(...)`` vorgenommen werden, in der die Logik zum Abruf der aktuellen
Backend-Sprache und der Aufruf von AddOns, falls keine Übersetzung gefunden
wurde, bereits implementiert ist.

Der Sprachkatalog, der die einzelnen Übersetzungen enthält, kann dabei wie folgt
abgerufen werden.

.. sourcecode:: php

  <?
  $i18n = sly_Core::getI18N(); // object(sly_I18N) {}

  // Beispiele
  $i18n->msg('foo');  // entspricht t('foo')
  $i18n->getLocale(); // z.B. 'de_de'

.. note::

  Backend- und Frontendsprachen haben nichts miteinander zu tun. Übersetzungen
  via I18N im Frontend zu benutzen ist daher nicht empfohlen, da im Frontend
  immer das eingestellte Standard-Locale (``LANG``) zum Einsatz kommt.

Registry
--------

Die Registry ist ein einfacher Key-Value-Speicher, in dem zum Beispiel
modulübergreifend Daten abgelegt werden können. So könnten über Module Daten
eingepflegt werden, die dann im Template aus der Registry ausgelesen werden.

Es stehen eine temporäre (nur für einen Request gültige) und eine persistente
(in der Datenbank gespeicherte) Registry zur Verfügung. Beide bieten dasselbe
Interface an.

.. sourcecode:: php

  <?
  $reg = sly_Core::getPersistentRegistry(); // persistent
  $reg = sly_Core::getTempRegistry();       // temporär

  // Beispiele
  $reg->set('key', 'value');
  $reg->get('key', 'default-value');

Backend-Seite
-------------

Die aktuelle Backend-Seite kann wie folgt ermittelt werden.

.. sourcecode:: php

  <?
  sly_Core::getCurrentPage(); // z.B. 'structure'

.. note::

  Die Methode hat im Frontend keine Bedeutung und gibt deswegen dort immer
  ``null`` zurück.

Error Handler
-------------

Der systemweise :doc:`Error Handler <errorhandler>` wird in ``sly_Core``
registriert, damit AddOns ihn abrufen und überschreiben können.

.. sourcecode:: php

  <?
  // Error Handler abrufen
  $handler = sly_Core::getErrorHandler(); // object

  // Die abgerufene Instanz ist in der Regel nicht sonderlich nützlich, es
  // sei denn, man möchte seinen eigenen Handler registrieren. Dann wird die
  // Instanz benötigt, um sie zu deregistrieren.
  $handler->uninit();

  // eigenen Handler setzen
  $myHandler = new MyErrorHandler();
  sly_Core::setErrorHandler($myHandler);

Sally-Version
-------------

Die Versionsnummer von Sally besteht aus drei Komponenten: Major, Minor und
Bugfix. Die steht als statische Konfiguration bereit, sollte aber immer über die
angebotene API-Methode abgerufen werden.

.. sourcecode:: php

  <?
  // angenommen, es handelt sich um Sally 0.5.12

  // X = Major
  // Y = Minor
  // Z = Bugfix

  sly_Core::getVersion('X')      === '0'
  sly_Core::getVersion('X.Y')    === '0.5'   // wird am häufigsten benötigt
  sly_Core::getVersion('Z')      === '12'
  sly_Core::getVersion('ZY/X')   === '125/0'
