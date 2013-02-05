Release-Notes
=============

.. centered:: -- Composer, Dependency Injection & Other Goodies --

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

API-Änderungen
--------------

Im Folgenden werden soweit möglich alle API-Änderungen zwischen dem 0.7- und dem
0.8-Branch beschrieben.

**TODO**
