Dependency Injection Container
==============================

SallyCMS verwendet einen sog. `Container`, um an einer zentralen Stelle alle
Services zu sammeln und ihre Abhängigkeiten zu konfigurieren. Eine umfassende
Einführung in das Thema `Dependency Injection` gibt es online:

* `Pimple-Homepage <http://pimple.sensiolabs.org/>`_
* `What is Dependency Injection? <http://fabien.potencier.org/article/11/what-is-dependency-injection>`_
* `Dependency Injection with Pimple <http://www.sitepoint.com/dependency-injection-with-pimple/>`_

Wie die obigen Links andeuten, basiert der Container von Sally auf **Pimple**
und ist in ``sly_Container`` implementiert.

Services
--------

Ein **Service** ist eine Klasse, die *stateless* arbeitet und eine Reihe von
Operationen auf Daten anbietet (diese Daten sind hingegen oft in *Models*
gekapselt). Ein Twitter-Client wäre beispielsweise ein Service, während ein
einzelner Tweet ein Model ist.

.. sourcecode:: php

  <?

  // ein klassischer Service
  class TwitterClient {
    public function __construct($username, $password) { ... }
    public function getLatestTweets($max) { ... }
    public function respond(Tweet $tweet, $msg) { ... }
    public function retweet(Tweet $tweet) { ... }
  }

  class Tweet {
    public $id;
    public $author;
    public $date;
    public $message;
  }

Dependency Injection
--------------------

Nehmen wir an, unser ``TwitterClient`` benötigt *Guzzle*, um mit der Twitter-API
zu kommunizieren. Wenn wir das Wissen aus den obigen Tutorials anwenden, können
wir den Client wie folgt erweitern:

.. sourcecode:: php

  <?

  class TwitterClient {
    public function __construct(Guzzle\Http\Client $client, $username, $password) { ... }
  }

Die Instanziierung des Twitter-Clients wird damit schon deutlich aufwendiger:

.. sourcecode:: php

  <?

  $guzzleOptions = getOptionsFromWhereever();
  $guzzle        = Guzzle::client($guzzleOptions);
  $client        = new TwitterClient($guzzle, 'max', 'must3r');

Um Nutzern des Twitter-Clients die Arbeit zu erleichtern, kann dieses Stückchen
"Factory-Code" am Container als Service definiert werden.

Services definieren
-------------------

Ein Service benötigt einen eindeutigen Namen und eine Vorschrift, wie er
instanziiert werden soll (also ein Stück Code). Zur Definition verwendet man
den Container von Sally als Array und definiert einfach einen neuen Key:

.. sourcecode:: php

  <?

  $container = sly_Core::getContainer();

  $container['myservice'] = function() {
    return new MySuperService();
  };

Nach der Definition kann von überall auf den Service über seinen Key zugegriffen
werden:

.. sourcecode:: php

  <?

  $container = sly_Core::getContainer();
  $service   = $container['myservice'];

  $service->dominateWorld();

Abhängigkeiten
^^^^^^^^^^^^^^

In vielen Fällen haben Services Abhängigkeiten zu anderen Services. Um an diese
zu gelangen, sollte die automatisch an die anonyme Factory-Funktion übergebene
Instanz des Containers genutzt werden:

.. sourcecode:: php

  <?

  $container = sly_Core::getContainer();

  $container['myservice'] = function($container) {
    $configuration  = $container['sly-config'];
    $myOtherService = $container['my-other-service'];

    return new MySuperService($configuration, $myOtherService);
  };

  $container['my-other-service'] = function() {
    return new MySplendidService();
  };

Am Zugriff auf den Service ändert sich dabei nichts; die ganze Komplexität der
Erzeugung wird vor dem Nutzer verborgen.

Sharing
^^^^^^^

Da Services im Idealfall stateless sind, reicht es aus, sie ein einziges mal für
die Scriptlaufzeit zu erzeugen und dann diese Instanz immer wieder zu verwenden.
Anstatt nun auf ein Singleton zu setzen (d.h. die Instanziierung der
Serviceklasse in ihr selbst zu beschränken), sollte man es dem Container
überlassen, die Instanzen zu verwalten.

Ein solcher einmalig instanziierte Service wird als *shared* bezeichnet. Daran
angelegt ist auch die API:

.. sourcecode:: php

  <?

  $container = sly_Core::getContainer();

  $container['myservice'] = $container->share(function($container) {
    return new MySuperService();
  });

  $serviceA = $container['myservice'];
  $serviceB = $container['myservice'];

  $serviceA === $serviceB;

Beispiel
^^^^^^^^

Unser Twitter-Client könnte nun wie folgt definiert werden:

.. sourcecode:: php

  <?

  $container = sly_Core::getContainer();

  // Der Guzzle-Client ist stateless und kann von allen, die ihn benötigen,
  // wiederverwendet werden. Sharing ist okay.
  $container['guzzle-client'] = $container->share(function($container) {
    $config = $container['sly-config']->get('guzzleconfig');
    $client = new Guzzle\Http\Client($config);

    $client->addListener(...);

    return $client;
  });

  // ebenso
  $container['my-twitter-client'] = $container->share(function($container) {
    $config = $container['sly-config']->get('twitterconfig');
    $client = $container['guzzle-client'];

    return new TwitterClient($client, $config['username'], $config['password']);
  });
