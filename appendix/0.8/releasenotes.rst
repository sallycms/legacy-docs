Release-Notes
=============

.. centered:: -- Composer, Dependency Injection & Other Goodies --

.. note::

  Sally 0.8 befindet sich zur Zeit im **Release Candidate**-Stadium. Bis zum
  finalen Release können sich noch Kleinigkeiten ändern. Neue Feature sind
  allerdings nicht zu erwarten.

Knapp fünf Monate nach dem Release der letzten großen Major-Version freut sich
das Sally-Team, nun die Verfügbarkeit von **SallyCMS 0.8** bekanntzugeben. Das
neue Major Release treibt vor allem die Composer-Integration weiter voran und
führt dazu ein neues, an Symfony2 angelegtes Repository-System ein.

Neben der verbesserten Composer-Integration bringt Version 0.8 ebenfalls noch
ein von Grund auf **neu entwickeltes Setup**, einen
**Dependency Injection**-Container, einen integrierten **CSRF-Schutz** sowie ein
flexibles **Backend-Routing** mit.

Der grobe :doc:`Ablauf eines Updates auf 0.8 <migrate>` wird auf einer extra
Seite beschrieben.

**Sally im Web**

* `Downloads <https://bitbucket.org/SallyCMS/sallycms/downloads>`_
* `Google+ <https://plus.google.com/b/114660281857431220675/>`_ und
  `Twitter <https://twitter.com/#!/webvariants>`_
* `Repository <https://bitbucket.org/SallyCMS/sallycms/>`_ und
  `Code-Statistik bei Ohloh <http://www.ohloh.net/p/sallycms>`_
* `Bugtracker <https://bitbucket.org/SallyCMS/sallycms/issues/>`_ und
  `Forum <https://projects.webvariants.de/projects/sallycms/boards/>`_

Wir freuen uns über *jedes* Feedback. Kommentare können via Ticket_, eMail_,
Tweet oder Google+-Kommentar eingeschickt werden. :-)

.. _Ticket: https://bitbucket.org/SallyCMS/sallycms/issues/
.. _eMail:  info@sallycms.de

Änderungen
----------

Im Folgenden sollen kurz die Neuerungen in diesem Release beschrieben werden.

Composer & Apps
"""""""""""""""

Beginnend mit Version 0.7 wurden sämtliche AddOns und externe Libraries über
Composer installiert. Diese Integration wird in 0.8 noch vertieft, indem nun
auch Sally selbst über Composer installiert sowie der automatisch generierte
Autloader genutzt werden.

Repositories
^^^^^^^^^^^^

Um Sally selbst als externe Library zu betrachten, können Projekte nicht mehr
selbst ein Klon von Sally sein, sondern ein eigenständiges Repository. Dies
entspricht dem Aufbau eines Symfony2-Projekts, bei dem ``symfony/symfony``
ebenfalls erst nachinstalliert wird.

In Sally gibt es fortan eine "Standard-Distribution", deren Paketname
``sallycms/sallycms`` ist. In diesem `Repository <https://bitbucket.org/SallyCMS/sallycms/>`_
gibt es nur die :file:`index.php` und weitere Dateien im Root sowie die
:file:`composer.json`. Die Standard-Distribution ist damit die Grundlage für
neue Projekte und kann entweder heruntergeladen oder geklont werden. Die bisher
bekannten Downloads (Starterkit, Minimal, ...) gibt es dabei weiterhin.

Die Standard-Distribution enthält Abhängigkeiten zu den neuen, in einzelne
Repositories aufgeteilten Sally-Apps, darunter:

* ``sallycms/core``
* ``sallycms/backend``
* ``sallycms/frontend``
* ``sallycms/setup``

Bis auf das Setup gibt es dabei keine großen Neuerungen. Die Apps werden wie
bisher nach ``sally/`` installiert, der Core liegt also in ``sally/core``. Dies
gilt für alle Pakete vom Typ ``sallycms-app``: Es wird immer nur der hintere
Teil des Paketnamens verwendet und statt nach ``sally/vendor/`` nach ``sally/``
installiert. Aus diesem Grund gibt es aus Sicht der Verzeichnisstruktur keine
Änderungen in Version 0.8. AddOns müssen nicht auf ein neues Verzeichnissystem
umgestellt werden.

``sallycms/setup`` ist eine neue App, auf die in einem späteren Abschnitt
eingegangen werden soll.

Der Umbau auf einzelne App-Repositories sorgt dafür, dass zukünftig bei einem
``composer update`` ebenfalls Sally aktualisiert werden kann. Ausgenommen davon
sind die Inhalte des Root-Pakets (``sallycms/sallycms``), aber da die
:file:`index.php` und anderen Dateien wenig Spannendes enthalten, ist das
Verschmerzlich. Bei einer neuen Hauptversion (0.9) können im Zweifelsfall nötige
Änderungen von Hand vorgenommen werden.

Wie in Version 0.7 gehabt, wird ein Projekt dann gestartet, indem weitere
Abhängigkeiten (AddOns) in die :file:`composer.json` eingetragen und installiert
werden.

Autoloading
^^^^^^^^^^^

Im Normalfall generiert Composer einen PHP 5.3-kompatiblen Autoloader, den Sally
nicht verwenden kann (können schon, nur nicht voraussetzen). Um dennoch von den
Vorteilen dieses Autoloaders zu profitieren, haben wir mit
``xrstf/composer-php52`` ein Hilfspaket eingeführt, das zusätzlich zum
originalen Autoloader eine 5.2-kompatible Variante erstellt. Dieser Autoloader
wird in Sally 0.8 als primärer Autoloader verwendet.

Der alte Autoloader, ``sly_Loader``, existiert weiterhin und kann vorerst weiter
verwendet werden, ist aber deprecated. Seine einzige Daseinsberechtigung ist
das Laden von Klassen, deren Name mit einem führenden Unterstrich beginnt. Für
alle anderen Situation ist der Composer-Autoloader von nun an the way to go.

Für AddOn-Autoren gilt, dass sie die ``autoload``-Konfiguration ihrer AddOns
sauber erstellen sollten, da sie mit Version 0.9 noch wichtiger werden sollen.
Gleichzeitig können AddOns, die ihre :file:`composer.json` korrekt definiert
haben, sich die Aufrufe zu ``sly_Loader`` in ihrer :file:`boot.php` sparen.

.. warning::

  Diese Änderung bewirkt ebenfalls, dass grundsätzlich alle Klassen von allen
  AddOns jederzeit bekannt sind, selbst wenn diese nicht in Sally installiert
  und aktiviert sind. Ein ``class_exists('My_AddOn_Class')`` ist damit keine
  geeignete Methode mehr, zu überprüfen, ob ein AddOn aktiviert ist!

.. note::

  Die Standard-Verzeichnisse, die Sally dem Autoloader hinzufügt, werden nun
  ebenfalls von Composer verwaltet. Damit ist es ohne weitere Konfiguration von
  ``sly_Loader`` nicht mehr möglich, in diesen Verzeichnissen Klassen abzulegen,
  die mit einem Unterstrich beginnen. Dies betrifft insbesondere
  ``develop/lib``.

Bootstraping
^^^^^^^^^^^^

Sally verwendet nun nur noch eine einzelne :file:`index.php` im Root des
Projekts für das Laden sämtlicher Apps. Von dort aus wird jeweils die
:file:`boot.php` der aufgerufenen App eingebunden und ausgeführt.

Die Entscheidung, welche App geladen werden soll, findet über die
``mod_rewrite``-Regeln statt: hier werden nun die Umgebungsvariablen ``SLYAPP``
und ``SLYBASE`` gesetzt, die von der :file:`index.php` ausgewertet werden.
``SLYAPP`` enthält den Verzeichnisnamen der gewünschten App, z.B. ``setup`` für
das Setup. ``SLYBASE`` ist die Basis-URL und im Frontend ``/``, für das
Backend ``/backend`` usw..

Über diese Konfiguration können Apps auf beliebige URL-Präfixe gelegt werden.
Auf Wunsch kann das Backend damit auch auf ``/redaxion`` konfiguriert werden
oder auch gänzlich unzugänglich gemacht werden. So ist es möglich, das Setup
abzuschalten, indem die dazugehörigen Regeln in der :file:`.htaccess`
auskommentiert werden.

Neues Setup
"""""""""""

In bisherigen Versionen war das Setup ein Bestandteil der Backend-App, was dazu
führte, dass es dort vielerorts Checks der Form *if-setup-stuff-else-other-stuff*
gab. Sämtliche dieser Checks sind im Produktivbetrieb einer Website ebenso
irrelevant wie die eigentliche Setup-Funktionalität. Gleichzeitig wird in den
kommenden Monaten an einem neuen Backend gearbeitet, sodass das Setup als
Teil des "Legacy-Backends" problematisch wird.

Aus diesem Grund wurde das Setup aus dem Backend herausgelöst und existiert nun
als `eigenständige App <https://bitbucket.org/SallyCMS/sallycms-setup>`_. Sie
wird in einem Standard-Projekt mitinstalliert, kann aber auf Wunsch nach der
erfolgten Einrichtung vollständig gelöscht werden (insbes. nach dem Deployment
auf den Produktivserver, um die mögliche Angriffsfläche zu verringern).

Im Zuge dieses Umbaus wurde das Setup vollständig re-implementiert. Da das vom
Backend vorgegebene Layout nicht zur Verfügung steht, kommt hierbei ein
minimales, auf Bootstrap basierendes Layout zum Einsatz.

.. image:: /_static/0.8-setup-1.png
.. image:: /_static/0.8-setup-2.png
.. image:: /_static/0.8-setup-3.png

Einige der Goodies im neuen Setup sind:

* Sprachauswahl anhand des ``Accept-Language``-Headers (spart einen nutzlosen
  Schritt ein); Sprache kann jederzeit gewechselt werden
* Lizenzannahme über einfache Checkbox (spart einen weiteren nutzlosen Schritt
  ein)
* Projektkonfiguration (Titel, Zeitzone) und Datenbank-Konfiguration auf einer
  Seite (spart ebenfalls einen Schritt ein)
* Es werden grundsätzlich nur diejenigen Möglichkeiten angezeigt, die auch
  wirklich zur Verfügung steht. Wenn die Datenbank leer ist, steht "weiter ohne
  Einrichtung" nicht zur Verfügung. Existiert noch kein Nutzer, muss einer
  angelegt werden.
* Fehlermeldungen & Probleme sollen nur angezeigt werden, wenn sie wirklich
  auftreten. Keine sinnfreie "Alles ist in Ordnung, weitermachen"-Seite.
* Es kann - je nach Zustand der Konfiguration - beliebig zwischen den Seiten
  im Assistenten gewechselt werden. Wenn die Datenbank-Konfiguration passt,
  kann direkt auf den "Einrichten"-Tab gewechselt werden. Ist die Datenbank
  okay und ein Nutzer vorhanden, kann vom Start aus direkt auf die
  "Profit!"-Seite gewechselt werden.
* Eine obligatorische South Park-Referenz ist ebenfalls enthalten.

Noch nicht implementiert, aber bis zur finalen 0.8-Version geplant, ist ein
CLI-Script zur Installation, um sie soweit nötig zu automatisieren (insbes.
bei automatischen Deployments kann das interessant werden).

DI-Container
""""""""""""

Aus Sicht der Sally-API ist die Einführung des Dependency Injection Containers
sicherlich die größte Neuerung in Version 0.8. Sally setzt dabei so gut es mit
PHP 5.2 eben geht einen Container um, der in ``sly_Container`` implementiert
und für das Erzeugen/Verwalten fast aller System-Objekte zuständig ist. Sallys
Container orientiert sich stark an Fabien Potenciers `Pimple
<http://pimple.sensiolabs.org/>`_, allerdings mit einer Menge Helper-Methoden,
da PHP 5.2 uns keine Closures erlaubt.

Für Entwickler stellt der Container nun **die** zentrale Anlaufstelle für alle
Objekte, Services etc. dar. Dazu zählen der Autoloader, die Konfiguration, die
Model-Services, der Request & die Response und viele weitere "globale"
Instanzen.

Der Container kann beliebig von jedem, der Zugriff auf ihn erlangt, erweitert
und verändert werden. So können neue Services hinzugefügt oder bestehende
ausgetauscht werden. So kann zum Beispiel der Event-Dispatcher einfach
ausgetauscht werden: ``$container['sly-dispatcher'] = new MyDispatcher();``

Obwohl der Sinn des Containers u.a. ist, alle möglichen Abhängigkeiten zu
kapseln und globalen Zustand zu vermeiden, hält Sally eine zentrale Instanz des
Containers statisch bereit. Von jeder beliebigen Stelle kann über
``sly_Core::getContainer()`` darauf zugegriffen werden, allerdings ist diese
Art des Zugriffes nicht empfohlen. Für viele Stellen in der Sallywelt ist es
leider schlichtweg erforderlich, diesen Zugriff zu ermöglichen, z.B. wenn man
an statische Eventlistener-Funktionen denkt.

Innerhalb von Controllern sollte der zu verwendende Controller über die
in ``sly_Controller_Base`` implementierte ``getContainer()``-Methode abgerufen
werden. Sally wird einen Controller entsprechend initialisieren, bevor es seine
Action ausführt, sodass hier kein Griff in den globalen Zustand notwendig ist.
Dies ist auch die empfohlene Art, innerhalb von Controllern an den Request (ein
weiteres in 0.8 neu eingeführtes Objekt, siehe weiter unten) zu gelangen.

Ebenfalls deprecated sind fast sämtliche Methoden innerhalb von ``sly_Core``.
So gut wie alle sind nur noch inhaltslose Proxies, sodass
``sly_Core::setCurrentArticle()`` nur ein Alias für
``sly_Core::getContainer()->setCurrentArticle()`` ist. Soweit möglich sollten
die Methoden in ``sly_Core`` vermieden werden.

CSRF-Schutz
"""""""""""

Sally vergibt beginnend mit dieser Version für jeden Nutzer ein CSRF-Token, das
in der Session abgelegt und für deren gesamte Lebenszeit gültig ist. Dieses
Token muss für sämtliche Aktionen im Backend, die den Zustand des Systems
verändern, im Request enthalten sein. Damit es nicht in irgendwelchen Logs
landet, kann es ausschließlich in POST-Requests übermittelt werden, womit auch
sämtliche statusändernden Funktionen nun via POST stattfinden.

Die einzige Ausnahme von dieser Regel stellt ein Login am Backend dar, da Sally
für noch nicht eingeloggte Benutzer keine Session öffnet. Außerdem ist ein Login
ein eher uninteressantes CSRF-Target, da ein Angriff den Nutzernamen und das
Passwort erfordert. Mit diesem Wissen sind allerdings ganz andere Dinge möglich.
Außerdem verwendet das neue Setup keinen CSRF-Schutz, da es ebenfalls keine
Session öffnet.

Der Weg, ein für die gesamte Session gültiges Token zu verwenden, wurde bewusst
gewählt. Er stellt einen guten Kompromiss zwischen Sicherheit und Usability dar,
bei dem Formulare problemlos mehrfach abgeschickt werden können und keine
Probleme beim Einsatz mehrerer Browser-Tabs auftreten.

Um das Durchführen von POST-Requests zu vereinfachen, führt Sally die
HTML-Klasse ``sly-postlink`` ein. Jeder Link, der diese Klasse besitzt, wird von
Sallys JavaScript abgefangen und in Form eines POSTs (über ein erzeugtes
verstecktes Formular) abgeschickt. Dabei werden alle in der URL enthaltenen
Parameter als hidden Inputs verschickt. Das Token wird dabei automatisch aus
einem Meta-Tag bezogen und darf keinesfalls in der URL auftauchen.

Die Überprüfung des Tokens geschieht nicht automatisch, sondern muss von Hand
z.B. im Controller und dessen ``checkPermission()``-Methode erfolgen. AddOns
sind dementsprechend nicht automatisch in 0.8 geschützt, sondern müssen dafür
erweitert werden. Ein für alle POST-Request geltender CSRF-Schutz ist eine zu
heftige Einschränkung des Systems und wurde daher bewusst nicht implementiert.
Die Überprüfung kann über die neu eingeführte Klasse ``sly_Util_Csrf`` erfolgen,
die einfache Helper zur Verfügung stellt.

Das CSRF-Token wird automatisch in alle von ``sly_Form`` erzeugten Formulare
als ``sly-csrf-token`` eingebettet. Formulare, die via GET verschickt werden
sollen, müssen es explizit abschalten, da das Formular andernfalls das Rendern
mit einer Exception ablehnt.

Backend-Routing
"""""""""""""""

Im Backend kommt nun ebenso wie im Frontend ein Router zum Einsatz, der
virtuelle URLs auflösen und generieren kann. Standardmäßig gibt es zwei Routen,
die auch für das Erzeugen von URLs verwendet werden:

* ``backend/:controller/?`` (entspricht ``index.php?page=controller``)
* ``backend/:controller/:action/?`` (entspricht ``index.php?page=controller&func=action``)

Die volle URL zum Anlegen eines neuen Nutzers lautet damit
``example.com/backend/user/add``, die URL zum Bearbeiten ist
``example.com/backend/user/edit?id=42``. Technisch werden die Platzhalter in den
Routen als GET-Parameter im Request-Objekt angelegt. Bei der URL zum Anlegen
eines Artikels existiert dort also der GET-Parameter ``page`` mit dem Wert
``user``.

Um passende URLs zu erzeugen, kann ebenfalls der Router verwendet werden. Er
wird dafür für alle Views, die von Controllern über die geerbte
``render()``-Methode gerendert werden, in der Variable ``$_router``
bereitgestellt.

.. sourcecode:: php

  <?

  // './user' wenn der aktuelle Controller 'user' ist
  $_router->getUrl(null);

  // './user'
  $_router->getUrl('user');

  // './user/add'
  $_router->getUrl('user', 'add');

  // './user/add?foo=bar'
  $_router->getUrl('user', 'add', array('foo' => 'bar'));

  // './user/add?foo=bar&amp;foo2=bar'
  $_router->getUrl('user', 'add', array('foo' => 'bar', 'foo2' => 'bar'));

  // './user/add?foo=bar&foo2=bar'
  $_router->getUrl('user', 'add', array('foo' => 'bar', 'foo2' => 'bar'), '&');
  $_router->getPlainUrl('user', 'add', array('foo' => 'bar', 'foo2' => 'bar'));

  // 'http://www.example.com/backend/user'
  $_router->getAbsoluteUrl('user');

Die alten URLs in Form von ``index.php?page=...&func=...`` werden weiterhin
unterstützt.

Request-Objekt
""""""""""""""

Analog zum in Version 0.7 eingeführten Response-Objekt (``sly_Response``) bringt
Sally nun mit ``sly_Request`` eine entsprechende, an Symfony2 angelehnte
Abstraktion für den Request mit. Es enthält alle Request-Inhalte (GET, POST,
Cookies, Header, Uploads und ``$_SERVER``) und macht die alten globalen
Funktionen ``sly_get()``, ``sly_post()`` etc. überflüssig. Die Funktionen sind
damit ab diesem Release deprecated, werden vermutlich aber noch nicht in 0.9
entfernt werden.

Das Request-Objekt steht allen Controllern automatisch über die geerbte
``getRequest()``-Methode zur Verfügung und kann vom Container ebenfalls via
``getRequest()`` abgerufen werden.

.. sourcecode:: php

  <?

  // sly_get('foo', 'string', 'bar');
  $request->get('foo', 'string', 'bar');
  $request->get->get('foo', 'string', 'bar');

  // sly_post('foo', 'string', 'bar');
  $request->post('foo', 'string', 'bar');
  $request->post->get('foo', 'string', 'bar');

  // sly_request und sly_cookie funktionieren analog,
  // ebenso die Array-Varianten (sly_getArray(), ...)

  // $_SERVER['HTTP_FOO_HEADER']
  $request->header('foo-header');
  $request->header('Foo-Header');
  $request->header('FOO_HEADER');
  $request->server('HTTP_FOO_HEADER');

  // von Symfony2 übernommen
  $request->getClientIp();
  $request->getScheme();
  $request->getPort();
  $request->getRequestUri();
  // ...

An allen Stellen, an denen Daten aus dem Request benötigt werden, kann nun
optional eine Instanz von ``sly_Request`` übergeben werden. Wird keine
übergeben, so wird die globale aus dem Container verwendet. Entsprechende
Methoden sind unter anderem ``sly_Form->render()``, ``sly_Table->render()`` und
``sly_Util_Csrf::checkToken()``.

Stateless Session
"""""""""""""""""

Die bisher in ``sly_Util_Session`` implementierten statische Methoden (mit
Ausname von ``start()``) sind nun deprecated, da die Session zukünftig über eine
Instanz von ``sly_Session`` (Container: ``getSession()``) verwaltet wird. Dieses
Objekt enthält analoge, allerdings non-static Methoden bereit und sollte
anstelle des Utils verwendet werden.

Änderungen seit dem RC1
-----------------------

RC 2
""""

Im zweiten Release Candidate haben sich noch einige Änderungen und Feinschliff
ergeben, die vor allem durch die Entwicklung der Sally-Console bedingt wurden.

.. warning::

  Bei Projekt-Updates vom RC1 reicht daher ein ``composer update`` nicht aus, um
  alle Änderungen des RC2 zu erhalten. Zusätzlich müssen die
  :file:`composer.json` und die :file:`index.php` manuell aktualisiert werden.

Core
^^^^

* Das Bootstraping des Cores wurde runderneuert und ist nun flexibler
  einsetzbar. Dabei hat sich auch die :file:`index.php` im Projektroot
  geändert.

  * Apps sind nun selber dafür verantwortlich, das Error-Handling zu
    initialisieren.
  * Die :file:`master.php` wurde entfernt. Das Autoloading (und nur das) kann
    über die neue :file:`autoload.php` initialisiert werden.
  * Das Filtern von ``register_globals`` und ``magic_quotes_gpc`` wird von der
    neuen :file:`request-filter.php` übernommen.
  * Das eigentliche Bootstrapen (Einrichten des Containers, Laden der
    Konfiguration) ist in ``sly_Core::boot()`` verschoben wurden.

* Dank Updates für Composer kann nun der Sally-kompatible Autoloader auch
  erzeugt/erneuert werden, wenn ``composer dump-autoload`` ausgeführt wird.
* AddOns erhalten nun den DI-Container als vordefinierte Variable ``$container``
  in ihre :file:`boot.php`, :file:`install.php` und :file:`uninstall.php`
  reingegeben. Die entsprechenden Methoden am AddOn-Manager wurden um die
  optionale Angabe des zu verwendenden Containers erweitert.
* Die Konfiguration ``DEVELOPER_MODE`` wurde durch ``environment`` ersetzt.

  * ``environment`` kann einen beliebigen String (wie ``dev`` oder ``prod``)
    enthalten.
  * Apps steuern selbst, welches Environment verwendet werden soll, wobei bis
    auf die Sally Console alle Apps das Environment aus der Konfiguration
    verwenden.
  * Es gilt, dass jedes Environment außer ``prod`` als "Entwicklermodus"
    angesehen wird (``sly_Core::isDeveloperMode()`` existiert also weiterhin).
  * Im Backend existiert weiterhin die altbekannte
    Checkbox, die nun zwischen ``dev`` und ``prod`` umschaltet.
  * Das Environment kann über ``->getEnvironment()`` vom Container abgerufen
    werden.
  * Offensichtlich hat das Setzen von ``DEVELOPER_MODE`` nun keinen Effekt mehr.

* ``SLY_START_TIME`` wurde entfernt und durch den Wert ``sly-start-time`` am
  Container ersetzt.
* ``SLY_IS_TESTING`` wurde vollständig entfernt.
* ``sly_Util_Cache`` wurde vollständig entfernt. Es gibt keinen Grund, ihre
  Funktionalität nicht über ein AddOn nachzurüsten.
* ``sly_DB_PDO_Connection::getDriverInstance()`` wurde statisch ergänzt. Von
  einer bestehenden Verbindung kann nun über ``->getDriver()`` der Driver
  abgerufen werden.
* Benutzernamen können nun bis zu 128 Zeichen lang sein.
* Bugfix: ErrorHandler konnten nicht am ``sly_Container`` gesetzt werden, da
  ein nicht existierendes Interface erfordert wurde.
* Bugfix: Conditional Comments für JavaScript wurden nicht korrekt eingerückt.

Backend
^^^^^^^

* Die mitgelieferte Version von Modernizr unterstützt nun folgende weitere
  Checks: ``canvas_todataurl_type``, ``contenteditable``, ``contextmenu``,
  ``css_displaytable``, ``css_remunit``, ``file_api``, ``forms_fileinput``,
  ``forms_formattribute``, ``file_filesystem``, ``forms_placeholder``,
  ``forms_validation``, ``ie8compat``, ``json``, ``requestanimationframe``,
  ``script_async`` und ``script_defer``.

* ``sly_Helper_Modernizr`` ist nun nicht mehr statisch, sondern muss unter
  Angabe eines ``sly_Request``-Objekts instantiiert werden.
* Die Workarounds für Popups unter Chrome 18 & 20 wurden entfernt.
* Bugfix: Artikelslices konnten nicht gelöscht werden.

Sonstiges
^^^^^^^^^

* Die Lizenzabfrage wurde aus dem Setup entfernt.
* Das Setup kann nun über den ``sly:install``-Befehl auf der Sally Console
  ausgeführt werden.

API-Änderungen
--------------

Im Folgenden werden soweit möglich alle API-Änderungen zwischen dem 0.7- und dem
0.8-Branch beschrieben.

Backend
"""""""

* Modernizr wurde auf 2.6.2 aktualisiert.
* Das Setup wurde entfernt und in eine eigene App ausgelagert.
* Das CSRF-Token wird als Meta-Tag mit dem Namen ``sly-csrf-token`` dem Head
  hinzugefügt.
* Links, die die Klasse ``sly-postlink`` haben, werden per JavaScript
  automatisch beim Klick in versteckte Formulare umgewandelt und als
  POST-Request abgeschickt. Das CSRF-Token wird dabei automatisch eingefügt und
  darf keinesfalls in der URL des Links auftauchen.
* Die ``render()``-Methode in ``sly_Controller_Backend`` setzt, wenn nicht
  bereits in den ``$params`` gesetzt, immer den Backend-Router als Variable
  ``$_router`` hinzu, sodass der Router in allen Views zur Verfügung steht.
* Beim Cache-leeren ist eine Option zum Re-Initialisieren sämtlicher AddOns
  hinzugekommen. Sie ist standardmäßig nicht ausgewählt.
* In ``sly_Popup_Helper->init()`` können nun der aktuelle Request und der
  Event-Dispatcher explizit angegeben werden.
* ``sly_Layout_Backend``

  * der Konstruktor erfordert nun drei Instanzen:
    ``__construct(sly_I18N $i18n, sly_Configuration $config, sly_Request $request)``
  * ``setCurrentPage()`` wurde um die optionale Angabe des aktuellen Nutzers
    erweitert: ``setCurrentPage($page, sly_Model_User $user = null)``
  * Über ``setRouter(sly_Router_Backend)`` kann der zu verwendende Router
    überschrieben werden.

Core
""""

* Es gibt nun nur noch einen einzelnen Bootcache für alle Apps.

  * ``sly_Util_BootCache::init()`` erfordert kein ``$environment`` mehr, ebenso
    ``::recreate()``, ``::getCacheFile()`` und ``::createCacheFile()``.
  * Aus den beiden BootCache-Events wurde das einzelne
    ``SLY_BOOTCACHE_CLASSES``-Event.

* Über die Konfiguration ``LESS_IMPORT_DIRS`` können eine Liste von
  Import-Dirs für lessphp definiert werden.
* ``sly_App_Interface``

  * ``dispatch()`` und ``getController()`` wurden entfernt.
  * ``getContainer()`` und ``isBackend()`` wurden hinzugefügt.

* In ``sly_Controller_Base`` wurden folgende Methoden ergänzt:

  * ``->getContainer()``
  * ``->setContainer(sly_Container $container)``
  * ``->getRequest()``
  * ``->setRequest(sly_Request $request)``

* Der Konstruktor von ``sly_DB_PDO_Persistence`` wurde um ``$prefix = ''``
  erweitert.
* ``sly_Model_User``

  * ``->setPassword()`` erlaubt nun keinen leeren String mehr.
  * ``->setRights()`` wurde entfernt
  * ``->setAttribute($key, $value)``, ``->getAttribute($key, $default = null)``,
    ``->setIsAdmin($flag)``, ``->setStartPage($startPage)`` und
    ``->setBackendLocale($backendLocale)`` wurden ergänzt.

* ``sly_Response_Action->execute()`` erfordert nun eine
  ``sly_Dispatcher``-Instanz.
* ``sly_Response_Stream->send()`` wurde auf
  ``send(sly_Request $request = null, sly_Event_IDispatcher $dispatcher = null)``
  erweitert. Ebenso wurde ``->isNotModified()`` um die optionale Angabe des
  Requests erweitert.
* ``sly_Service_File_Base->remove($file)`` wurde hinzugefügt und löscht neben
  der Originaldatei ``$file`` auch die dazugehörige Cache-Datei.
* ``sly_Service_AddOn->getRequiredSallyVersions()`` wurde in
  ``getRequiredSallyVersion()`` umbenannt. Statt einer Liste von Versionen
  wird dabei 1:1 das in der :file:`composer.json` eines AddOns angegebene
  Requirement, z.B. ``~0.7``, zurückgegeben.
* ``sly_Service_Factory``

  * Die gesamte Klasse ist deprecated, da sie vollständig vom Container
    abgelöst wurde. Sämtliche Methoden sind reine Proxies auf den Container.
  * Die generische ``getService()``-Methode sollte, obgleich sie im Container
    ebenfalls vorhanden ist, keinesfalls zum Abrufen der im Core fest
    verankerten Services (diejenigen, die auch bisher an der Factory eine
    dedizierte Getter-Methode hatten) verwendet werden. Es kann hierbei nicht
    garantiert werden, dass ``$container->getService('template')`` der gleichen
    Instanz wie ``$container->getTemplateService()`` entspricht.

* ``sly_Service_User``

  * Bei ``->add()`` wurde ``string $rights`` als Parameter durch
    ``array $attributes`` ersetzt.
  * Beim Logout über ``->logout()`` werden alle Inhalte der aktuellen
    Sally-Installation aus der Session entfernt (vorher wurde nur ``UID``
    entfernt).

* ``sly_Service_VersionParser``

  * ist eine 1:1-Adaption von Composers ``VersionParser``-Klasse, mit dem
    Unterschied, dass sie PHP 5.2-kompatibel ist und ein paar wenige
    Sonderfeatures von Composer nicht enthalten sind.
  * Sally kann damit die Requirements von AddOns besser und korrekter parsen.
    AddOn-Autoren müssen nicht mehr unbedingt eine Liste kompatibler Versionen
    angeben, sondern können alle Ausdrücke verwenden, die Composer unterstützt.

* Die folgenden Methoden wurden um ``sly_Request $request = null`` als weiteren
  Parameter erweitert.

  * ``sly_Table_Column->render()``
  * ``sly_Table->render()``
  * ``sly_Table->renderHeader()``
  * ``sly_Table->getSortKey()``
  * ``sly_Table->getDirection()``
  * ``sly_Table::isDragAndDropMode()``
  * ``sly_Table::getPagingParameters()``
  * ``sly_Table::getSearchParameters()``
  * ``sly_Table::getSortingParameters()``

* ``sly_Util_ArrayObject`` wurde als neue Container-Klasse (nicht mit dem
  DI-Container zu verwechseln!) angelegt. Im Unterschied zu ``sly_Util_Array``
  unterstützt sie jedoch keine verschachtelten Pfade, dafür aber das
  Normalisieren von Keys. Die Klasse kommt beim Request-Objekt zum Einsatz, um
  HTTP-Header und dergleichen zu normalisieren.
* ``sly_Util_Csrf`` ist hinzugekommen und stellt Methoden zum Setzen und
  Überprüfen von CSRF-Tokens zur Verfügung. Insbesondere
  ``sly_Util_Csrf::checkToken()`` ist dabei für AddOn-Entwickler von Relevanz.
* ``sly_Util_FlashMessage``

  * ``::store()`` und ``::removeFromSession()`` wurden um den optionalen
    Parameter ``sly_Session $session`` erweitert.
  * In ``::readFromSession()`` muss nun zusätzlich eine ``sly_Session``-Instanz
    übergeben werden.

* ``sly_Util_HTTP``

  * ``::tempRedirect()`` wurde als Shortcut für ``::redirect()`` mit
    ``$status = 302`` ergänzt.
  * ``::queryString()`` wurde um den weiteren Parameter
    ``$prependDivider = true`` ergänzt.

* ``sly_Util_Password::getRandomData()`` wurde um den optionalen Parameter
  ``$base64Encode = false`` erweitert.
* ``sly_Util_Requirements`` wurde aus dem Core entfernt und in die neue
  Setup-App migriert. Sie sollte nicht mehr als API angesehen werden.
* Die meisten Methoden in ``sly_Util_Session`` sind nur noch Proxies zu der
  globalen ``sly_Session``-Instanz. Da die Session im Frontend wichtig ist,
  wurde das Util beibehalten und vorerst **nicht** als deprecated markiert.
  AddOns sollten allerdings nicht mehr das Util, sondern die Session aus dem
  Container verwenden.
* Das Vorgabeargument für ``$default`` in ``sly_Util_Session::get()`` wurde von
  einem leeren String auf ``null`` geändert.
* ``sly_Util_Template`` wurde um ``::renderFile()`` zum kontext-sicheren
  Includen von Dateien ergänzt.
* In ``sly_Authorisation::hasPermission()`` kann nun optional der zu verwendende
  User-Service übergeben werden.
* Die ``sly_Cache::factory()``-Methode enthält kein spezielles Handling für
  Unit-Tests mehr. Auch muss nun die zu erzeugende Strategie explizit angegeben
  werden, da ``sly_Cache`` nicht mehr statisch weiß, welche Strategie relevant
  ist.
* ``sly_Dispatcher`` wurde ergänzt und übernimmt nun das Dispatching, das früher
  in den einzelnen Apps implementiert war. Er dient damit als Grundlage für ein
  generisches Dispatching und befreit neue Apps von der lästigen Arbeit, das
  Verfahren selbst zu implementieren oder sich von einer bestehenden App
  abzuleiten und damit eine Abhängigkeit einzuführen.
* ``sly_I18N`` merkt sich hinzugefügte Sprachdateien und verhindert, dass
  Dateien mehrfach geladen werden. Außerdem werden beim Wechseln der Locales
  alle bisher geladenen Sprachdateien in der jeweils neuen Sprache geladen.
* ``sly_Loader`` sollte soweit möglich nicht mehr verwendet werden.
  Stattdessen steht in ``sly_Container->getClassLoader()`` der von Composer
  generierte Loader zur Verfügung, dessen Einsatz empfohlen wird. ``sly_Loader``
  wird nur für das Laden von Klassen, die mit einem Unterstrich beginnen,
  benötigt.
* ``sly_Log::setLogDirectory()`` versucht nun das Verzeichnis anzulegen, wenn
  es nicht bereits existiert.
* In ``sly_Request`` sind die meisten Methoden nun fluent gestaltet und geben
  daher das Response-Objekt selbst zurück.
* Die :file:`master.php` wurde wie folgt geändert:

  * Die Konstante ``SLY_HTDOCS_PATH`` wurde entfernt.
  * Es wird nicht mehr implizit ein Output Buffer gestartet.
  * Alle Konstanten bis auf ``SLY_COREFOLDER`` können vordefiniert werden.
  * Der System-Container wird initialisiert und in ``sly_Core`` registriert.
  * Die erstellten Variablen werden vor Ende des Scripts aus dem Global Scope
    entfernt.

sly_Core
^^^^^^^^

* Die meisten Getter und Setter sind nun nur noch simple Proxies, die auf den
  in ``sly_Core`` verwalteten Container zeigen. Die folgenden Methoden haben
  keine 1:1-Entsprechung im Container und bieten daher weiterhin einen (kleinen)
  Mehrwert:

  * ``::getContainer()`` zum Abrufen und
    ``::setContainer(sly_Container $container)`` zum Setzen des Containers.
  * ``::getCurrentLanguage()`` kombiniert weiterhin die aktuelle Sprache und
    den Language-Service (die beide einzeln im Container verfügbar sind). Ebenso
    verhält es sich mit ``::getCurrentArticle()``.
  * ``::setDispatcher()`` liefert weiterhin im Gegensatz zum Container den
    vorherigen Dispatcher zurück.
  * ``::isBackend()`` fragt den Backend-Status von der aktuellen App ab (es gibt
    kein ``->isBackend()`` im Container).
  * Alle Getter, die sich auf einzelne Konfigurations-Elemente beziehen
    (``::getDefaultLocale()``, ``::getProjectName()`` etc.).
  * ``::loadAddons()`` lädt weiterhin die AddOns und feuert das
    ``SLY_ADDONS_LOADED``-Event.
  * ``::clearCache()`` kombiniert weiterhin die verschiedenen Stellen, deren
    Cache geleert werden kann.

* ``->getNavigation()`` wurde entfernt. Die Navigation muss vom Backend-Layout
  abgerufen werden.
* ``->getCurrentPage()`` wurde ebenfalls entfernt.
* ``::isSetup()`` wurde ergänzt.

Konfiguration
^^^^^^^^^^^^^

* Die Konfiguration wird im Produktivmodus nun noch stärker gecacht.
* Der Konstruktur von ``sly_Configuration`` nimmt nun einen File-Service sowie
  das Verzeichnis, in dem die Konfigurationsdateien geschrieben werden sollen,
  entgegen.
* ``->loadDevelop()`` wurde in ``->loadDevelopConfig()`` umbenannt.
* ``->clearCache()`` wurde hinzugefügt.
* Alle Methoden, die Daten in die Konfiguration schreiben (Setter) geben nun
  nicht mehr den gesetzten Wert, sondern ``true`` oder ``false`` zurück.

Routing
^^^^^^^

* Router sind nun nicht mehr zustandsbehaftet, d.h. beim Matchen eines
  Requests wird das Ergebnis nicht mehr im Router abgelegt, sondern es wird
  der gematchte Request um die gefundenen Werte erweitert. Damit können
  Router-Instanzen wiederverwendet werden und gleichzeitig ist die
  Auflösung der Routen für alle weiteren Schritte transparent. Ein in der URL
  gefundener Platzhalter ``foo`` steht damit als regulärer GET-Parameter zur
  Verfügung.
* In Controllern sollten dementsprechend die URL-Parameter direkt vom Request
  (``$this->getRequest()->get('myparam', ...)``) abgerufen anstatt auf den
  verwendeten Router zugegriffen werden.
* ``sly_Router_Interface`` hat sich vollständig verändert:

  * ``getController()`` und ``getAction()`` wurden entfernt.
  * ``match(sly_Request $request)`` wurde hinzugefügt.
  * ``addRoute($route, array $values)`` wurde hinzugefügt.
  * ``getRoutes()`` wurde hinzugefügt.
  * ``clearRoutes()`` wurde hinzugefügt.

* ``sly_Router_Base`` wurde analog angepasst:

  * ``hasMatch()`` und ``get()`` wurden entfernt.
  * ``getRequestUri()`` ist nicht mehr public und erwartet nun ein
    ``sly_Request``-Objekt als Parameter.
  * Ein Platzhalter wie ``:foo`` wird nun nicht mehr nach
    ``[a-z_][a-z0-9-_]*``, sondern nach ``[a-z0-9_]*`` übersetzt. Damit sind
    leere Werte ebenso erlaubt wie Werte, die mit einer Ziffer beginnen. Dies
    ist nötig, damit URLs wie ``/article/edit/1/`` nicht über eine von Hand
    zusammengebastelte Regex gematcht werden müssen. Mit der Entwicklung der
    REST-API für Sally wird dies ein häufiger Use-Case sein.

Datenbank
^^^^^^^^^

* Die Datenbank-Spalte ``rights`` in ``sly_user`` wurde in ``attributes``
  umbenannt und enthält nun ein JSON-kodiertes Objekt mit den Eigenschaften des
  Nutzers.
* Anstelle des Spalten-Typs ``json`` muss nun innerhalb der Models und ihrer
  ``$_attributes`` der Typ ``array`` verwendet werden.

Formular-Framework
^^^^^^^^^^^^^^^^^^

* Die folgenden Methoden im Formular-Framework wurden um einen optionalen
  Parameter ``sly_Request $request = null`` ergänzt:

  * ``sly_Form_ElementBase->getDisplayValueHelper()``
  * ``sly_Fieldset->render()``
  * ``sly_Form->render()``
  * ``sly_Form_Helper::parseFormValue()``

* Das CSRF-Token wird immer in Formulare eingebettet, es sei denn, es wird via
  ``sly_Form->setCsrfEnabled(false)`` deaktiviert. Diese Deaktivierung muss für
  GET-Formulare explizit geschehen.
* ``sly_Form->getMethod()`` wurde ergänzt.

Frontend
""""""""

* Im Artikel-Controller wird der erzeugte Artikel-Content nicht mehr im
  Anschluss an ``SLY_ARTICLE_OUTPUT`` ausgegeben, sondern direkt am
  Response-Objekt gesetzt. Es hat damit keinen Zweck mehr, sich auf
  ``OUTPUT_FILTER`` zu registrieren, um Artikel nachzuebarbeiten. Man muss sich
  auf (das eh besser dafür geeignete) ``SLY_ARTICLE_OUTPUT``-Event registrieren.

Deprecated
""""""""""

======================================== ===========================================
alt                                      neu
======================================== ===========================================
``sly_DB_Persistence::getInstance()``    ``sly_Container->getPersistence()``
``sly_Model_User->hasRight()``           ``->hasPermission()``
``sly_Service_Factory::getService()``    ``sly_Container->getService()``
``sly_Service_Factory::get***Service()`` ``sly_Container->get***Service()``
``sly_Util_Session::reset()``            ``sly_Session->delete()``
======================================== ===========================================

Entfernte API
"""""""""""""

================================================= ==============================================
entfernt                                          Alternative
================================================= ==============================================
``sly_Cache::disable()``                          --
``sly_Cache::enable()``                           --
``sly_Cache::getInstance()``                      --
``sly_Cache::getStrategy()``                      ``sly_Container->getConfig()->get('CACHING_STRATEGY')``
``sly_Cache::getFallbackStrategy()``              ``sly_Container->getConfig()->get('FALLBACK_CACHING_STRATEGY')``
``sly_Configuration->loadDevelop()``              ``->loadDevelopConfig()``
``sly_Core::getNavigation()``                     ``sly_Container->getLayout()->getNavigation()`` (nur im Backend)
``sly_Core::getCurrentPage()``                    ``sly_Container->getApplication()->getCurrentControllerName()``
``sly_Loader::getClassCount()``                   --
``sly_Model_ArticleSlice->getPrior()``            ``->getPosition()``
``sly_Model_Base_Article->getCatPrior()``         ``->getCatPosition()``
``sly_Model_Base_Article->getPrior()``            ``->getPosition()``
``sly_Model_Base_Article->setCatPrior()``         ``->setCatPosition()``
``sly_Model_Base_Article->setPrior()``            ``->setPosition()``
``sly_Model_User->setRights()``                   ``->setIsAdmin()``, ...
``sly_Service_AddOn->getRequiredSallyVersions()`` ``->getRequiredSallyVersion()``
``sly_Util_Requirements``                         --
``sly_get()``                                     ``sly_Request->get()``
``sly_post()``                                    ``sly_Request->post()``
``sly_request()``                                 ``sly_Request->request()``
``sly_cookie()``                                  ``sly_Request->cookie()``
``sly_getArray()``                                ``sly_Request->getArray()``
``sly_postArray()``                               ``sly_Request->postArray()``
``sly_requestArray()``                            ``sly_Request->requestArray()``
================================================= ==============================================
