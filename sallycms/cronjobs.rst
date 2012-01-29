Cronjobs
========

Sally kann auch außerhalb von HTTP-Requests (beispielsweise auf der Shell)
verwendet werden. Dabei kann sowohl Frontend als auch Backend simuliert werden.

Um Sally zu "booten", muss insbesondere die Konstante ``SLY_IS_TESTING``
auf den Wert ``true`` gesetzt werden. Damit werden Login und Caching
deaktiviert, sodass keine Cookies/Sessions gefälscht werden müssen. Außerdem
bricht Sally nach dem Laden aller Komponenten (AddOns, Konfiguration, ...) ab
und übergibt die Kontrolle wieder an den Cronjob (bei "normalen" Requests würde
im Anschluss der zuständige Controller gesucht und ausgeführt werden).

.. note::

  Wie man leicht sehen kann, "missbraucht" diese Beschreibung die eigentlich für
  die UnitTests gedachten Mechanismen in Sally. Es ist damit zu rechnen, dass in
  einer späteren Version (in der auch Frontend-Controller implementiert sind)
  das Handling von Cronjobs wesentlich einfacher und "offizieller unterstützt"
  wird. Aber bis dahin ...

Beispiel
--------

Ein Beispielscript, das Sally benutzt und per Cronjob ausgeführt wird, könnte
wie folgt aussehen (wir nehmen an, es liegt im Wurzelverzeichnis von Sally).

.. sourcecode:: php

  <?
  // check if we're actually called from CLI (prohibit HTTP requests)

  if (PHP_SAPI !== 'cli') {
    die('This script has to be run from command line.');
  }

  // boot Sally frontend (same stuff as in Sally's own index.php)

  define('IS_SALLY', true);
  define('IS_SALLY_BACKEND', false);
  define('SLY_HTDOCS_PATH', './');
  define('SLY_IS_TESTING', true);
  define('SLY_TESTING_USER_ID', 1);
  define('SLY_START_TIME', microtime(true));

  // let Sally boot
  require SLY_SALLYFOLDER.'/core/master.php';

  // add the backend app
  sly_Loader::addLoadPath(SLY_SALLYFOLDER.'/backend/lib/', 'sly_');

  // init the app
  $app = new sly_App_Backend();
  sly_Core::setCurrentApp($app);
  $app->initialize();

  // And we're done. Now comes our own code.

  print 'Hello, I am a cronjob!';
  doSomeVeryImportantWork();
  callAddOnMethods();
  healWorldHunger();

Innerhalb des Scripts kann nun auf sämtliche Sally-Funktionen zugegriffen
werden (:doc:`Logging <logging>`, :doc:`Mailing <mailing>`, ...).

.. warning::

  Das **Caching** wird ebenfalls durch das Setzen von ``SLY_IS_TESTING``
  abgeschaltet (d.h. es wird immer der Blackhole-Cache verwendet). Wenn es doch
  nötig ist, den Cache zu verwenden, kann er jedoch explizit aktiviert werden.

.. note::

  AddOn-Autoren sind dazu angehalten, sich nicht blind auf die möglichen
  Elemente in ``$_SERVER`` zu verlassen, da beispielsweise ``REMOTE_ADDR`` in
  diesem Fall nicht gesetzt sein wird. Um unschöne Warnungen zu vermeiden,
  sollte die Existenz der Elemente erst geprüft werden (wo es Sinn ergibt).

Caching
-------

Wenn Zugriff auf den Systemcache benötigt wird, kann dieser durch die Konstante
``SLY_TESTING_USE_CACHE`` aktiviert werden. Da Cronjobs selten
performancekritisch sind und manche Cache-Implementierungen in der CLI-Umgebung
anders oder gar nicht arbeiten (APC, XCache, ...), muss der Cache explizit
aktiviert werden.

.. sourcecode:: php

  <?
  // [...]
  define('SLY_IS_TESTING', true);            // the magic constant
  define('SLY_TESTING_USE_CACHE', true);     // enable caching
  // [...]
