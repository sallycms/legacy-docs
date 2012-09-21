Release-Notes
=============

.. centered:: -- Composer, LESS is more & no more GPL --

.. note::

  Version 0.7 befindet sich noch im Release Candidate-Stadium und ist noch nicht
  für den produktiven Einsatz geeignet. Die hier genannten Details können sich
  bis zum finalen Release jederzeit ändern.

Gut ein halbes Jahr nach dem Release der letzten großen Major-Version freut sich
das Sally-Team, nun die Verfügbarkeit des ersten *Release Candidates* von
SallyCMS 0.7 bekanntzugeben. Das neue Major Release konzentriert sich vor allem
auf die `Composer <https://getcomposer.org>`_-Integration, über die zukünftig
AddOns, Plugins und weitere Bibliotheken in Sally integriert werden, sowie den
Wechsel von Scaffold hin zu `LESS <http://lesscss.org/>`_. Gleichzeitig stellt
es das erste Release dar, dass **vollständig MIT-lizenziert** ist.

Der grobe :doc:`Ablauf eines Updates auf 0.7 <migrate>` wird auf einer extra
Seite beschrieben. Der Migrationsleitfaden wird bis zum finalen Release noch
vervollständigt.

**Sally im Web**

* `Downloads <https://projects.webvariants.de/projects/sallycms/files>`_
* `Google+ <https://plus.google.com/b/114660281857431220675/>`_ und
  `Twitter <https://twitter.com/#!/webvariants>`_
* `Repository <https://bitbucket.org/SallyCMS/trunk/>`_ und
  `Code-Statistik bei Ohloh <http://www.ohloh.net/p/sallycms>`_
* `Bugtracker <https://projects.webvariants.de/projects/sallycms/issues/>`_ und
  `Forum <https://projects.webvariants.de/projects/sallycms/boards/>`_

Wir freuen uns über *jedes* Feedback. Kommentare können via Ticket_, eMail_,
Tweet oder Google+-Kommentar eingeschickt werden. :-)

.. _Ticket: https://projects.webvariants.de/projects/sallycms/issues
.. _eMail:  info@sallycms.de

Änderungen
----------

Im Folgenden sollen kurz die Neuerungen in diesem Release beschrieben werden.

Composer-Integration
""""""""""""""""""""

Die Umstellung auf Composer ist sicherlich die deutlichste Änderung an diesem
Release, da sie die Art und Weise verändert, wie Sally externe Bibliotheken
(BabelCache, sfYaml, ...) sowie AddOns und Plugins einbindet, installiert und
aktualisiert.

Bisher waren die benötigten Bibliotheken als Kopie im Sally-Repository
enthalten. Nun werden sie erst beim Installieren eines Projekts aus dem Netz
heruntergeladen und installiert. Ebenso wird mit AddOns verfahren.

Eine vollständige Erklärung von Composer sprengt den Rahmen der Release Notes
und soll daher nicht stattfinden. Im Netz gibt es eine ganze Reihe nützlicher
Artikel und Websites zu Composer:

* `Die Composer-Website <http://getcomposer.org/>`_
* `Composer: What & Why (Part 1) <http://nelm.io/blog/2011/12/composer-part-1-what-why/>`_
  und `Part 2 <http://nelm.io/blog/2011/12/composer-part-2-impact/>`_

Wir möchten betonen, dass **niemand zum Einsatz von Composer gezwungen** wird.
Es ist weiterhin möglich, Projekte gänzlich ohne Composer aufzusetzen, zu
entwickeln und deployen. Im Abschnitt *Non-Composer* weiter unten sind dazu
weitere Details.

*Die folgenden Ausführungen nehmen an, dass der Leser mit Composer grundlegend
vertraut ist.*

Voraussetzungen
^^^^^^^^^^^^^^^

Composer erfordert **PHP 5.3** und wird von der Shell/Kommandozeile ausgeführt.
Es ist daher erforderlich, systemweit eine 5.3-Installation verfügbar zu haben,
die unter anderem auch die **phar-Erweiterung** aktiviert haben muss.

Dies wirkt sich **nicht auf die Kompatibilität von Sally** selbst aus. Sally
erfordert weiterhin nur PHP 5.2.1+.

Gute Hoster bieten SSH und PHP 5.3 an, sodass auch das Deployment eines Projekts
(und dessen Updates) via Composer erfolgen können. Auf Servern, die kein SSH
anbieten und/oder nur PHP 5.2 anbieten, wird man daher die AddOns mitdeployen
("hochladen") müssen.

Einen großen Nachteil müssen wir aufgrund der Sally-Kompatibilität allerdings in
Kauf nehmen: Der von Composer generierte Autoloader wird in Sally nicht
verwendet. Das Issue, einen `5.2-kompatiblen Autoloader zu generieren <https://github.com/composer/composer/issues/612>`_,
haben wir bereits erstellt, aber bis zur finalen Version von Composer wird noch
einige Zeit ins Land gehen. Für 0.7 haben wir uns daher entschieden,
grundsätzlich auf den Autoloader zu verzichten und ausschließlich ``sly_Loader``
zu verwenden.

Abgesehen von den Abhängigkeiten von Composer selbst haben ggf. auch die
benötigten Bibliotheken/AddOns eines Projektes noch Abhängigkeiten. Dies können
zum Einen bestimmte PHP-Extensions sein. Zum Anderen kann es sein, dass AddOns
z.B. nur über Github verfügbar sind und daher zum Herunterladen auf dem System
ebenfalls Git installiert sein muss. Das Gleiche gilt natürlich auch für
Mercurial, aber das haben wir ja alle eh installiert, nicht wahr?

Für **stabile** Releases gilt diese Einschränkung glücklicherweise nicht, da
diese immer als ZIP-Dateien heruntergeladen werden und so kein VCS installiert
sein muss. Wer jedoch die Entwicklerversion verwenden möchte, muss die nötigen
Tools installieren.

Installation
^^^^^^^^^^^^

Wir empfehlen, Composer systemweit zu installieren, um nicht in jedem Projekt
eine Kopie der :file:`composer.phar` zu haben. So muss man auch nur eine
einzelne Datei aktuell halten.

Die systemweite Kopie sollte logischerweise im ``PATH`` des Systems auffindbar
sein. In vielen Fällen kann es praktikabel sein, sie in das gleiche Verzeichnis
zu legen, in dem auch die :file:`php.exe` liegt (auf Windows-Systemen).

Unter Windows kann/sollte man ebenfalls die ``*.phar``-Extension mit dem
installierten PHP-Binary (z.B. aus XAMP) verknüpfen. Dabei sollte man unbedingt
beachten, die Verknüpfung via ``regedit`` um ``%*`` zu erweitern, damit auch
die Optionen korrekt an PHP übergeben werden. Ein gültiger Eintrag wäre zum
Beispiel ``"C:\xamp\php\php.exe" "%1" %*`` (im Schlüssel
``HKEY_CLASSES_ROOT\phar_auto_file\shell\open\command``). Ja, wer Windows nutzt,
muss etwas Schmerzen in Kauf nehmen, um den ganzen Komfort von Composer zu
genießen.

Workflow-Änderungen
^^^^^^^^^^^^^^^^^^^

Um ein Sally-Projekt zu starten, sollte man nun wie folgt vorgehen, um von allen
Vorteilen zu profitieren:

- Man klont sich das Sally-Repository direkt von Bitbucket oder Github.
- Im Klon öffnet man die :file:`composer.json` und fügt alle benötigten AddOns
  unter ``require`` ein.
- Ab auf die Shell und alles installieren lassen: ``composer.phar install``
- Sally im Browser aufrufen und installieren.
- Profit!

Nach der Installation können jederzeit Updates eingespielt werden, indem einfach
``composer.phar update`` ausgeführt wird. That's it.

Technische Aspekte
^^^^^^^^^^^^^^^^^^

Die externen Biblotheken werden dabei nach :file:`sally/vendor/` installiert und
sollten nicht mit in ein Repository eingecheckt werden (für die Nutzer, die ihre
Sally-Projekte brav mit Mercurial oder Git verwalten). Das Verzeichnis taucht
daher auch im Ignore-Filter von Sally auf.

Da AddOns zukünftig ebenfalls über Composer heruntergeladen, installiert und
**aktualisiert** werden *können*, folgen sie zukünftig dem gleichen Namensschema
und Workflow. Das heißt, dass auch die AddOns eines Projekts nicht mit
eingecheckt werden sollten.

.. note::

  Bibliotheken und AddOns, die **nicht** über Composer installiert werden (z.B.
  weil sie nicht in einem geeigneten Repository zur Verfügung stehen), können
  (und sollten) hingegen in das Projekt-Repository eingecheckt werden.

  Auf lange Sicht sollte allerdings immer versucht werden, die Infrastruktur zu
  nutzen, die Composer & Sally bieten. Das kommt allen Nutzern zugute, wenn
  AddOns als Open Source veröffentlicht werden.

  Die `Composer-Dokumentation <http://getcomposer.org/doc/02-libraries.md>`_ und
  die :doc:`Sally-Doku </addon-devel>` zeigen, wie einfach es ist, ein AddOn
  Composer-kompatibel zu machen.

Namensschema
~~~~~~~~~~~~

Die Änderung des Namensschemas für AddOns ist sicherlich die deutlichste in
diesem Release. Im Gegensatz zu normalen Bibliotheken werden AddOns zwar wie
gewohnt nach :file:`sally/addons/` installiert, allerdings **müssen**\ [*]_
sie ebenso wie reguläre Composer-Pakete nach dem Schema **vendor/addonname**
benannt werden. Außerdem sollten dabei **keine Unterstriche** zum Einsatz
kommen.

So wurden die Sally-AddOns wie folgt umbenannt:

* **sallycms/be-search** *(be_search)*
* **sallycms/image-resize** *(image_resize)*
* **sallycms/import-export** *(import_export)*

So liegt BE-Search nun in :file:`sally/addons/sallycms/be-search`. Dies wirkt
sich ebenfalls auf alle Stellen aus, an denen ein AddOn referenziert wird:

* Der AddOn-Service verlangt in seinen Methoden den vollen Namen des AddOns,
  zum Beispiel ``->install('sallycms/be-search')``.
* Die Assets eines AddOns liegen in :file:`data/dyn/public/vendor/addonname`.
* Abhängigkeiten eines AddOns müssen ebenfalls die vollständigen AddOn-Namen
  (bzw. Paketnamen, da Abhängigkeiten eine *Composerdefinition* sind und nicht
  mehr Sally-spezifisch) verwenden.

.. [*] Tatsächlich können AddOns auch weiterhin ``meinaddon`` heißen und kein
       Vendor-Präfix besitzen, allerdings raten wir **dringend** davon ab und
       werden sicherlich in späteren Releases diesen Fallback entfernen.
       Schließlich wollen wir gute "Composer Citizens" sein und mit gutem
       Beispiel vorangehen.

Non-Composer
~~~~~~~~~~~~

Wie bereits angesprochen ist es problemlos möglich, auf Composer zu verzichten.
Zu diesem Zweck wird das Starterkit zukünftig in zwei Varianten angeboten:

* **Variante 1** enthält keine Bibliotheken- und AddOn-Kopien, sondern nur eine
  entsprechend vorbereitete :file:`composer.json`.
* **Variante 2** enthält eine Kopie aller Bibliotheken und AddOns und sieht
  daher aus wie die altbekannten <0.7-Starterkits.

AddOns können dann weiterhin in Variante 2 an die richtigen Stellen entpackt und
genutzt werden.

Wir möchten jedoch dazu raten, sich mit Composer vertraut zu machen und es
wenigstens mal auszuprobieren. Wir sind von den Möglichkeiten und dem Komfort
begeistert und sehen einen deutlichen Trend in der PHP-Community, Composer als
de-facto Standard anzunehmen und PEAR endlich zu beerben.

AddOn-Aufräumarbeiten
"""""""""""""""""""""

Im Zuge des Umbaus auf Composer haben wir ebenfalls bei den AddOns einige
weitere Änderungen vorgenommen.

* Die Systemdateien von AddOns wurden umbenannt, um endlich von dem alten,
  unsinnigen Namensschema wegzukommen:

  * :file:`config.inc.php` → :file:`boot.php`
  * :file:`install.inc.php` → :file:`install.php`
  * :file:`uninstall.inc.php` → :file:`uninstall.php`
  * :file:`help.inc.php` → :file:`help.php`

* Um AddOns Composer-kompatibel zu machen, müssen sie eine :file:`composer.json`
  besitzen. Dort werden Name, Autor, Abhängigkeiten etc. verwaltet. Sally nutzt
  diese Angaben ebenfalls, sodass sie nicht mehr in der :file:`static.yml`
  notiert werden.
* Die :file:`static.yml` existiert weiterhin und kann wie gewohnt für
  *zusätzliche* Konfigurationen genutzt werden, die weiterhin beim Laden eines
  AddOns in die Sally-Konfiguration geladen werden.

Weitere Details zum genauen Aufbau der :file:`composer.json` und welche Werte
von besonderer Bedeutung sind, sind in der :doc:`Dokumentation </addon-devel>`
zu finden.

Außerdem wurde der Fallback, bei dem ein Menüpunkt in der Navigation eingefügt
wird, wenn ein AddOn die Angaben ``page`` und/oder ``name`` in seiner
Konfiguration hatten, entfernt. Erweiterungen des Menüs müssen immer über die
Backend-API erfolgen.

Innerhalb von Sally wird außerdem der Begriff "component" nicht mehr verwendet.
AddOns heißen nun auch im Code "addons", da die Unterscheidung zwischen AddOns
und Plugins entfernt wurde und nun kein Oberbegriff mehr nötig ist. Mehr
Hinweise zu Plugins und was aus ihnen geworden ist, liefert der nächste
Abschnitt.

Plugins
"""""""

Die Umstellung auf Composer sorgt dafür, dass innerhalb eines Pakets keine
Unterpakete vorhanden sein dürfen. Insofern kann ein AddOn keine Plugins mehr
enthalten.

Stattdessen müssen Plugins als eigenständige Composer-Pakete und damit
eigenständige AddOns entwickelt werden. So wird aus dem ``debugger``-Plugin für
realURL2 nun das Paket ``webvariants/realurl2-debugger`` und liegt in einem
eigenen Repository.

Natürlich funktioniert hier weiterhin das ``require``-System von Composer. Ein
"Plugin" wird also immer sein dazugehöriges AddOn (sowie eventuell weitere
benötigte AddOns) eintragen.

Um im Backend wie gewohnt als "Unter-Komponente" von realURL2 angezeigt zu
werden, kann ein "Plugin" in seiner :file:`composer.json` das Eltern-AddOn in
``extra/sallycms/parent`` angeben:

.. sourcecode:: javascript

  {
    "name": "webvariants/realurl2-debugger",
    "require": {
      "webvariants/realurl2": "*"
    },
    "extra": {
      "sallycms": {
        "parent": "webvariants/realurl2"
      }
    }
  }

.. note::

  Diese Angabe wirkt sich **ausschließlich auf die Anzeige** im Backend aus. Sie
  erzeugt keine Abhängigkeit zum Eltern-AddOn!

Der Begriff "Plugin" ist für Sally damit nicht mehr definiert. An den
betroffenen Stellen im Backend wird stattdessen im Code von ``sub-addon`` bzw.
``child`` gesprochen.

Ein großer Vorteil dieser Umstellung ist, dass "Plugins" nun nicht mehr im
Original-Repository eines AddOns auftauchen müssen. So kann es "Plugins" für
beliebige AddOns geben, ohne dass der Original-Autor sie in seine Quellen
übernehmen muss.

LESS statt Scaffold
"""""""""""""""""""

Ein Sorgenkind in Sally war schon lange das integrierte Scaffold. Die Bibliothek
wird nicht weiterentwickelt und ist ein Gestrüpp aus Patches. Außerdem ist es
umständlich, Scaffold als API und nicht als Proxy-Script zu verwenden.

Aus diesem Grund steigt Sally auf `LESS <http://lesscss.org/>`_ (genauer gesagt
auf `lessphp <https://github.com/leafo/lessphp>`_) um. Damit haben wir eine
stabile, einfach zu nutzende Bibliothek, die genau das macht, was sie soll.

Die Umstellung erfordert, dass LESS-Dateien auch wirklich :file:`.less` genannt
werden, andernfalls würde lessphp Includes und dergleichen nicht verarbeiten.
Netterweise ermöglicht das jedem ordentlichen Editor (\*hust\*,
`Sublime <http://www.sublimetext.com/>`_, \*hust\*) ein sauberes
Syntax-Highlighting.

Da lessphp selbst keine Mixins vordefiniert, bringt Sally ein zusätzliches
`Paket <https://bitbucket.org/SallyCMS/less-mixins>`_ mit, in dem eine ganze
Reihe Mixins bereitstehen. Diese können einfach über ``@import 'mixins.less';``
eingebunden und genutzt werden.

Wer weiterhin Scaffold nutzen muss/möchte (vor allem für bestehende Projekte,
die migriert werden, könnte dies von Bedeutung sein), kann über das
`webvariants/scaffold-AddOn <https://bitbucket.org/webvariants/scaffold>`_
das alte Verhalten in 0.7 nutzen. Scaffold wird weiterhin ausschließlich auf
:file:`.css`-Dateien angewandt, sodass parallel LESS und Scaffold zum Einsatz
kommen können.

Frontend-Nutzung
""""""""""""""""

Es hat sich gezeigt, dass immer häufiger aus dem Frontend heraus Änderungen am
Inhalt einer Sally-Website vorgenommen werden. Sei es durch gänzlich neue Apps,
durch eigene Frontend-Controller oder schlicht aus Templates heraus. Wir freuen
uns über diesen kreativen Einsatz der verfügbaren API und machen es mit Version
0.7 noch einfacher, sie aus Nicht-Backend-Code heraus zu verwenden.

Ein großes Problem war bisher, dass für viele Operationen (Anlegen von Artikeln,
Hochladen von Dateien in den Medienpool etc.) ein Nutzerkontext benötigt wurde.
Schließlich muss an jedem Artikel der ``createuser`` und ``updateuser`` gesetzt
werden. Da im Frontend jedoch standardmäßig niemand eingeloggt ist (und es in
den meisten Fällen nicht einmal eine aktive Session gibt), gibt es hier häufig
Probleme. Die Probleme gingen so weit, dass man für bestimmte Service-Methoden
einen aktuellen Nutzer vortäuschen und in der Session eine Nutzer-ID ablegen
musste.

In Sally 0.7 ist es daher möglich, bei allen relevanten Service-Methoden einen
Nutzer explizit anzugeben. So könnte man aus dem Frontend heraus einen Artikel
wie folgt anlegen:

.. sourcecode:: php

  <?
  $user    = sly_Util_User::findByLogin('dummyuser');
  $service = sly_Service_Factory::getArticleService();

  $service->add(0, 'Hallo Welt!', true, -1, $user);

Damit wird der Nutzer **dummyuser** (den man im Backend anlegen muss und im
Idealfall mit keinerlei Rechten ausstatten sollte) als Autor des Artikels
verwendet. Somit entfällt das lästige Arbeiten mit
``sly_Util_Session::set('UID', ...)`` und man muss sich keine Sorgen mehr über
aus Versehen geöffnete Sessions und eingeloggte Nutzer machen. Obiger Code würde
**keine** Session öffnen und auch keinen Login durchführen!

.. warning::

  Während der Entwicklung sollte man allerdings unbedingt darauf achten, nicht
  aus Versehen im Backend eingeloggt zu sein, während man seinen Frontend-Code
  testet: Wird **kein** Nutzer angegeben, so versucht Sally, den eingeloggten
  Nutzer zu verwenden (so zum Beispiel im Backend). Ist man selbst eingeloggt,
  funktioniert der Code. Kommt später ein echter, nicht eingeloggter, Besucher,
  so explodiert der Code. Zum Testen sollte also unbedingt ein zweiter Browser
  oder ein paralleles Browserprofil zum Einsatz kommen, um solche
  versehentlichen Fehler auszuschließen.

Alle Service-Methoden, die nun einen optionalen Nutzer entgegennehmen, geben
diesen ebenfalls in den Events als weiteren Parameter an. Event-Listener können
so genau ermitteln, welcher Nutzer bei der Operation zum Einsatz kam.

jQuery UI
"""""""""

Sally enthält seit langer Zeit eine Kopie von `jQuery UI <http://jqueryui.org>`_
in der Backend-Anwendung. Da aus unbegründeter Traffic-Sparsamkeit die Module
in einzelne Dateien ausgelagert wurden, war die Pflege immer eine lästige
Aufgabe. Gleichzeitig nutzte Sally nur einen Bruchteil der Bibliothek (für den
Datepicker und den Slider-Input).

Aus diesem Grund wurde jQuery UI nun aus Sally entfernt und durch
`jQuery Tools <http://jquerytools.org/>`_ ersetzt. Das spart mehr als 150 KB
und eine Menge Pflege-Aufwand, da nur eine einzelne Datei in den Assets liegt.

Dies wirkt sich nicht auf die PHP-API der Formular-Elemente aus.

Sollte sich herausstellen, dass jQuery UI im Backend für AddOns praktisch ist,
wird mit Sicherheit jemand ein AddOn schreiben, das die Bibliothek mitbringt.

GPL-Freiheit
""""""""""""

Was ist dazu noch groß zu sagen. Nachdem 0.6 bereits einen großen Schritt in
diese Richtung unternommen hatte, indem die RexVars entfernt wurden, schließt
Sally 0.7 nun den Prozess endgültig ab.

.. centered:: **Sally ist nun vollständig unter MIT-Lizenz verfügbar.**

Die alte :file:`_lizenz.txt` wurde daher entfernt, beim Setup erscheint nun die
(auf Deutsch und Englisch verfügbare) MIT-Lizenz.

Der gesamte Prozess hat uns stolze 33 Monate gekostet (im
`Dezember 2009 <https://bitbucket.org/SallyCMS/trunk/changesets/tip/0>`_ haben
wir geforkt). ;-)

.. _innodb:

InnoDB
""""""

Bisher verwendete Sally MyISAM als Storage unter MySQL, wohingegen viele AddOns
bereits InnoDB (und damit Goodies wie Transaktionen) nutzen. Um Sally zukünftig
ebenfalls mit Transaktionen zu versehen, wechseln wir nun ebenfalls auf InnoDB.

Da Transaktionen automatisch committet werden, wenn eine
nicht-transaktionsfähige Tabelle vewendet wird, *zwingen* wir nun auch AddOns
dazu, InnoDB zu verwenden. Andernfalls können wir zum Beispiel beim Anlegen
eines Artikels nicht sicherstellen, dass die Transaktion, die Sally öffnet,
nicht aus Versehen von einem AddOn unterbrochen wird, das auf das Event
``SLY_ART_ADDED`` lauscht und Datenbank-Queries ausführt.

Zu diesem Zweck scant Sally die :file:`install.sql` und verweigert die
Installation, wenn MyISAM gefunden wird. Gleichzeitig setzt es die
Default-Engine auf InnoDB, sodass ``CREATE TABLE``-Statements ohne
``ENGINE``-Angabe automatisch InnoDB verwenden.

Da es noch durchaus gültige Anwendungsfälle für MyISAM gibt (Volltextsuche und
gute Eignung für Logging-Tabellen), gibt es eine Ausnahme für AddOns: Wenn
ein AddOn explizit den Konfigurationseintrag ``allow_mysiam`` in seiner
:file:`composer.json` gesetzt hat, darf es MyISAM-Tabellen anlegen. Wir haben
diese Hürde eingebaut, versehentliche MyISAM-Tabellen zu vermeiden und den
Entwickler deutlich auf die Konsequenzen hinzuweisen.

*Deutlicher Hinweis auf die Konsequenzen:*
  Man sollte wirklich genau wissen, was man tut und in welchem Kontext man
  Queries auf MyISAM ausführt. Andernfalls kann die Integrität der Datenbank
  leiden.

Flash-Message
"""""""""""""

In einigen Events war es bisher üblich, dass sich die Listener die Erfolgs-
oder Fehlermeldungen als String durchreichen müssen. Ein prominentes Beispiel
dafür ist ``SLY_CACHE_CLEARED``.

Diese Unsinnigkeit verhinderte, dass man eine bestehende Methode wie
``MyAddOn::clearCache()`` als Listener angeben kann, ohne dass die Methode
sinnloserweise ein ``$params``-Array entgegennehmen und davon das ``subject``
zurückgeben muss, obwohl es damit überhaupt nichts anfangen kann und will.

In Sally 0.7 kommt daher nun ein neues Objekt zum Einsatz: Die
**Flash-Message**. Der ``sly_Core`` hält eine für alle nutzbare Instanz bereit,
auf die über ``sly_Core::getFlashMessage()`` zugegriffen werden kann. In diesem
Objekt können über ``->addInfo()`` und ``->addWarning()`` (und noch einige
andere Helfer) Meldungen für das Backend hinterlegt werden.

Dies erlaubt es, in den betroffenen Events den Rückgabewert für einen echten
*Ergebniswert* zu verwenden, anstatt ihn für eine UI-Meldung zu missbrauchen.
Vorbei sind die Zeiten, in denen API-Methoden ein Array aus ``msg`` und
``error`` zurückgeben.

Das Objekt wird in der Nutzersession abgelegt, sodass Meldungen auch Redirects
überleben. So kann man ein abgeschicktes Formular (POST-Request) auswerten, ein
Event feuern, dabei in der Flash-Message die Meldungen sammeln, zur Übersicht
weiterleiten (GET-Request) und dann erst die Meldungen anzeigen. So kann man
doppelt abgeschickte Formulare effektiv vermeiden und teils auch den Controller
übersichtlicher gestalten.

Meldungen bleiben solange im Flash-Message-Objekt, bis sie gerendert wurden. Zum
Rendern steht ``sly_Helper_Message::renderFlashMessage()`` zur Verfügung.

Passwort-Hashing
""""""""""""""""

Sally verwendete seit einiger Zeit SHA-1-Hashes, die 1.000mal iteriert und mit
einem nutzerspezifischen Salt (dem ``createdate``) versehen. Dies war vor
einigen Jahren noch sicher, heute jedoch im Angesicht von Clouds und
GPU-Clustern nicht mehr state-of-the-art.

Aus diesem Grund haben wir uns entschieden, das Hashing-Verfahren zu verbessern
und jeweils die Technik zu nutzen, die auf einem Host verfügbar ist. Ab PHP 5.3
steht die optimale Variante (bcrypt) immer zur Verfügung. Ist bcrypt nicht
verfügbar, wird PBKDF2 ausprobiert. Steht dieser Algorithmus ebenso nicht zur
Verfügung (wenn die ``hash``-Erweiterung fehlt), wird auf SHA-1 zurückgegriffen.

Diese Änderung führt zu einer deutlich verbesserten Sicherheit der Hashes, da
auch die Salts nun Zufallsstrings und kein erratbarer Werte mehr darstellen.

Sie führt allerdings auch dazu, dass ein Datenbank-Dump (mit enthaltenen
Nutzerkonten) potentiell auf einem anderen Server nicht nutzbar ist: Wurde auf
dem Quellsystem PHP 5.3 verwendet, enthält die Datenbank bcrypt-Hashes. Ist dies
auf dem Zielsystem nicht verfügbar, ist kein Login möglich.

Gleichzeitig werden Hashes immer auf das beste mögliche Verfahren upgegradet.
Wird also auf einem PHP 5.3-System ein Dump eingespielt, der SHA-1-Passwörter
enthält, werden diese beim Login der Benutzer (dem einzigen Zeitpunkt, zu dem
das Passwort im Klartext bekannt ist) automatisch neu berechnet und durch
bessere Hashes ersetzt.

Änderungen seit dem RC1
-----------------------

Release Candidate 2
"""""""""""""""""""

* In den meisten Service-Methoden (``sly_Service_Article->add()``, ``->edit()``
  etc.) kam ein weiterer, optionaler Parameter ``$user`` hinzu. Über diesen
  kann im Service ein expliziter Nutzerkontext hergestellt werden, sodass auch
  aus dem Frontend heraus, wo niemand eingeloggt ist, Content verwaltet werden
  kann. Damit müssen keine Logins mehr gefälscht und die Session manipuliert
  werden, um diese Methoden aus dem Frontend heraus zu nutzen.
* ``sly_Util_Medium::upload()`` wurde ebenfalls um einen ``$user``-Parameter
  erweitert.
* Innerhalb der Services kommen mehr Transaktionen zum Einsatz, um die
  Konsistenz der Datenbank zu gewährleisten.
* Die Konstrukturen der meisten Services nehmen nun ihre Abhängigkeiten direkt
  entgegen. Die Factory kümmert sich um die korrekte Instanziierung. Wer
  Services von Hand instanziieren möchte, muss nun alle abhängigen Services
  ebenso korrekt zusammensetzen. Diese "Mini Dependency Injection" erlaubt es,
  den Code ausführlicher und v.a. einfacher zu testen.
* Im Formular auf der Systemseite wird nun der Name des Backend-Locales anstatt
  des Locales (de_de) angezeigt.
* Der Parameter ``$default`` wurde von ``sly_ini_get()`` entfernt, da es nicht
  möglich ist, ein konsistentes Verhalten in PHP 5.2 und 5.3+ zu ermöglichen.
* AddOns liegen nun standardmäßig im Mercurial-Ignorefilter.
* ``sly_DB_PDO_Persistence->isTransRunning()`` wurde hinzufügt.
* Alle submittende Buttons eines Formulars (submit, apply, delete) erhalten nun
  die CSS-Klasse ``.sly-form-submit``. Dies behebt u.a. Probleme mit dem
  WYMeditor.
* alle Bugfixes aus dem 0.6-Branch
* weitere kleinere Korrekturen

Release Candidate 3
"""""""""""""""""""

* Die Setup-Prozedur war defekt, sofern auf dem System nicht zufällig ein
  MySQL-Nutzer namens "sally" ohne gesetztes Passwort existierte.

API-Änderungen
--------------

Im Folgenden werden soweit möglich alle API-Änderungen zwischen dem 0.6- und dem
0.7-Branch beschrieben.

Backend
"""""""

* In allen Sprachdateien wurden Keys mit ``component_`` in ``addon_`` umbenannt.

Assets
^^^^^^

* Alle CSS-Dateien wurden nach LESS portiert und heißen nun ``.less``.
* Der Autocompleter (:file:`assets/js/jquery.autocomplete.min.js`) wurde
  entfernt.
* jQuery UI wurde entfernt.
* jQuery wurde auf v1.8.2 aktualisiert.
* jQuery Tools v1.2.7 wurde hinzugefügt. Die Implementierungen für den
  Datepicker und den Slider wurden neugeschrieben.
* `js-iso8601 <https://github.com/csnover/js-iso8601>`_ wurde hinzugefügt, um
  korrektes Handling der Datumsangaben im neugeschriebenen Datepicker zu
  ermöglichen.
* Es wurde rudimentärer Support für Sprachdateien in JavaScript ergänzt. Das
  Backend nutzt jetzt ``(locale).js``-Dateien, um einige Texte zu übersetzen.

Konfiguration
^^^^^^^^^^^^^

* Es wurde ein Recht für den Zugriff auf die Struktur ergänzt
  (``pages/structure``).
* Die bestehenden ``transitional``-Rechte wurde entfernt und in neue Tokens
  migriert.

Controller
^^^^^^^^^^

* Die AddOn-Hilfeseiten sind nun auch für Nutzer zugänglich, die das Recht
  ``pages/addons`` haben.
* Admins können den Medienpool nutzen, ohne das Recht ``pages/mediapool`` zu
  haben.
* Der AddOn-Controller wurde komplett neu geschrieben.
* Der Content-Controller wurde in großen Teilen neu geschrieben.
* Die aktuelle Medienkategorie-ID wird im Medienpool nun nicht mehr als
  ``rex_file_category``, sondern als ``category`` im Query-String übermittelt.
  Dies betrifft auch den Namen des Session-Keys, in dem die Kategorie hinterlegt
  wird.
* Setup-Prozedur

  * Im Setup wird nun die MIT-Lizenz angezeigt, die in den Sprachdateien
    lokalisiert vorliegt.
  * Die empfohlene PHP-Version wurde auf 5.4 erhöht.

* Der Mechanismus, über ``page`` und ``name``-Angaben in der :file:`static.yml`
  einen Menüpunkt anzulegen, wurde entfernt. AddOns müssen immer die PHP-API
  verwenden, um die Navigation zu erweitern.

API
^^^

* ``sly_App_Backend::redirect($page, $params)`` wurde hinzugefügt, um in
  Controllern einfacher zu einer anderen Action via HTTP-Redirect weiterzuleiten.
  Insbesondere beim Einsatz der Flash-Messages, bei der eine Erfolgsmeldung auch
  über einen Redirect hinweg überlebt, wird das praktisch.
* ``sly_Helper_Message::renderFlashMessage($message)`` wurde hinzugefügt, um den
  Inhalt einer Flash-Message zu rendern (sic!).
* ``sly_Helper_Package`` wurde hinzugefügt und bringt bisher nur eine einzige
  Methode mit ``::getSupportPage($package)``.

Core
""""

Konfiguration
^^^^^^^^^^^^^

* Die Konfiguration von AddOns wird nun nicht mehr unter ``ADDON`` abgelegt,
  sondern unter ``addons``.
* Da ``/`` in der Sally-Konfiguration von besonderer Bedeutung als Pfadtrenner
  ist, wird der Slash im Namen von AddOns durch ``:`` ersetzt, sodass z.B. der
  ``install``-Key von Image-Resize unter ``addons/sallycms:image-resize/install``
  zu erreichen ist.
* Es ist nun einfacher, eine vom Standard abweichende Verbindung zu einem
  Memcached-Daemon aufzubauen. Dazu kann ``babelcache/memcached`` überschrieben
  und ein andere Tupel aus Host und Port definiert werden.

API
^^^

* **Datenbank**

  * Datenbank-Dumps müssen nun eine Composer-kompatible Versionsangabe erhalten.
    Das bedeutet, dass ``-- Sally Database Dump Version 0.7`` wirklich nur
    Version 0.7.0 meint, nicht aber spätere Bugfix-Releases. Stattdessen muss
    ``-- Sally Database Dump Version 0.7.*`` notiert werden. Das wird vom
    Import/Export-AddOn weiterhin erledigt.
  * ``sly_DB_Importer``

    * größtenteils neu implementiert um Speicherbedarf zu reduzieren
    * ``import()`` gibt nichts mehr zurück, sondern wirft Exceptions im
      Fehlerfall.

  * ``sly_DB_PDO_Persistence->isTransRunning()`` wurde hinzufügt.

* Die Konstante ``SLY_VENDORFOLDER`` wurde hinzugefügt. Sie enthält den
  vollständigen Pfad zum :file:`sally/vendor`-Verzeichnis.
* Der Standardwert für die globalen ``sly_*``-Funktionen zum Zugriff auf die
  Superglobalen wurde von ``''`` (leerer String) zu ``null`` geändert. Hier ist
  zu beachten, dass der Standardwert weiterhin **nicht gecastet** wird, wenn er
  zurückgegeben wird (Casts finden nur statt, wenn der gesuchte Key in den
  Superglobalen gefunden wurde). Dies entspricht dem Verhalten frührerer
  Sally-Versionen.
* Der Parameter ``$default`` wurde von ``sly_ini_get()`` entfernt, da es nicht
  möglich ist, ein konsistentes Verhalten in PHP 5.2 und 5.3+ zu ermöglichen.
* **Models**

  * ``sly_Model_ArticleSlice``

    * ``->setSlice($slice)``, ``->setSlot($slot)``, ``->setArticle($article)``
      und ``->setRevision($rev)`` wurden hinzugefügt.

  * ``sly_Model_ArticleSlice``, ``sly_Model_Slice`` sowie ``sly_Model_ISlice``:

    * ``->setSlice($slice)``, ``->setSlot($slot)``, ``->setArticle($article)``
      und ``->setRevision($rev)`` wurden hinzugefügt.
    * ``->addValue()`` wurde in ``->setValue()`` umbenannt.
    * ``getValue()`` kann nun optional als zweiten Parameter einen ``$default``
      entgegennehmen.
    * ``->flushValues()`` wurde entfernt.

  * ``sly_Model_SliceValue`` wurde entfernt.
  * ``sly_Model_User``

    * ``->getAllowedCategories()`` wurde entfernt, da seit 0.6 defekt.
    * ``->getAllowedMediaCategories()`` wurde entfernt, da seit 0.6 defekt.
    * ``->getAllowedModules()`` wurde entfernt, da seit 0.6 defekt.
    * ``->hasStructureRight()`` wurde entfernt.

  * Innerhalb von Models können nun die Typen ``date`` und ``datetime`` für die
    Attribute in ``$_attributes`` verwendet werden, um transparent die
    UNIX-Timestamp auf PHP-Seite in ``DATETIME`` für die Datenbank umzuwandeln.
  * Alle Setter für Datumsangaben (``->setCreateDate()`` et al.) können nun
    entweder mit einem UNIX-Timestamp als ``int`` oder einem String der Form
    ``'YYYY-MM-DD HH:MM:SS'`` aufgerufen werden.
  * ``->setUpdateColumns()`` und ``->setCreateColumns()`` können auch mit dem
    Loginnamen eines Nutzers als String aufgerufen werden.

* **AddOnsystem**

  * Die bestehenden Services wurden durch die folgenden neuen ersetzt:

    * ``sly_Service_Package`` sieht nur Composer-Pakete und kümmert sich darum,
      deren :file:`composer.json` auszuwerten.
    * ``sly_Service_AddOn`` dient dem Zugriff auf AddOn-Eigenschaften sowie
      deren Konfiguration. Hier finden sich weiterhin Methoden wie
      ``->isInstalled()``, ``->getAuthor()`` etc.
    * ``sly_Service_AddOn_Manager`` implementiert die Statusübergänge von
      AddOns. Hier sind ``->install()``, ``->activate()`` etc. implementiert.

  * Der Package-Service kann in der Service-Factory für zwei verschiedene
    Verzeichnisse abgerufen werden:

    * ``::getAddOnPackageService()`` liefert einen Package-Service, der
      :file:`sally/addons/` liest.
    * ``::getVendorPackageService()`` liefert einen Package-Service, der
      :file:`sally/vendor/` liest.

  * AddOns müssen nun immer über ihren vollen Namen innerhalb der Services
    referenziert werden. Es heißt also ``->isInstalled('sallycms/be-search')``.

* **Services**

  * Da neben YAML-Dateien für die Konfiguration nun auch JSON-Dateien (von
    Composer) eingelesen werden müssen, wurde ein ``sly_Util_JSON`` ergänzt.
    Dieses Utility basiert nun ebenso wie ``sly_Util_YAML`` auf den File-Services:
    Die Logik, Dateien einzulesen, zu parsen und ihren geparsten Inhalt so lange
    zu cachen, bis die Originaldatei sich ändert, ist nun in
    ``sly_Service_File_Base`` implementiert.
  * Die Services wurden um neue Komfort-Methoden ergänzt. Grundsätzlich wurden
    Methoden nach dem Schema ``deleteBy[Modelname]`` ergänzt:

    * Allen Id-Model-Services (Artikel, Kategorien, Medien, Benutzer, ...) steht
      nun eine ``->deleteById($id)``-Methode zur Verfügung.
    * ``sly_Service_Article->deleteByArticle($article)`` wurde ergänzt.
    * ``sly_Service_ArticleSlice->deleteByArticleSlice($slice)`` wurde ergänzt.
    * ``sly_Service_Category->deleteByCategory($cat)`` wurde ergänzt.
    * ``sly_Service_Language->deleteByLanguage($language)`` wurde ergänzt.
    * ``sly_Service_MediaCategory->deleteByCategory($cat)`` wurde ergänzt.
    * ``sly_Service_Medium->deleteByMedium($medium)`` wurde ergänzt.
    * ``sly_Service_Slice->deleteBySlice($slice)`` wurde ergänzt.
    * ``sly_Service_User->deleteByUser($user)`` wurde ergänzt.
    * ``->delete()`` wurde bei den folgenden Services in ``->deleteById()``
      umbenannt (``->delete()`` ist nun wieder die geerbte Implementierung vom
      Base-Service):

      * ``sly_Service_Article``
      * ``sly_Service_Category``
      * ``sly_Service_MediaCategory``
      * ``sly_Service_Medium``

    * Folgende Service-Methoden wurden um einen weiteren Parameter,
      ``sly_Model_User $user = null`` erweitert, um bei einem Aufruf aus dem
      Frontend heraus einen expliziten Nutzerkontext zu ermöglichen:

      * ``sly_Service_Article``:
        ``add()``, ``changeStatus()``, ``convertToStartArticle()``, ``copy()``, ``copyContent()``, ``edit()``, ``move()``, ``setType()``
      * ``sly_Service_ArticleSlice->move()``
      * ``sly_Service_Category``: ``add()``, ``changeStatus()``, ``edit()``, ``move()``
      * ``sly_Service_MediaCategory``: ``add()``, ``update()``
      * ``sly_Service_Medium``: ``add()``, ``update()``
      * ``sly_Service_User``: ``add()``, ``create()``, ``save()``

  * ``sly_Service_ArticleSlice->findByArticleClangSlot()`` wurde ergänzt.
  * ``sly_Service_ArticleSlice->add()`` wurde ergänzt.
  * Der Parameter ``$clang`` wurde von ``sly_Service_ArticleSlice->move()``
    entfernt.
  * ``sly_Service_ArticleSlice->processScaffold()`` wurde durch
    ``->processLessCSS()`` ersetzt.
  * ``sly_Service_User->setCurrentUser($user)`` wurde ergänzt.
  * Die Konstrukturen der meisten Services nehmen nun ihre Abhängigkeiten direkt
    entgegen. Die Factory kümmert sich um die korrekte Instanziierung. Wer
    Services von Hand instanziieren möchte, muss nun alle abhängigen Services
    ebenso korrekt zusammensetzen. Diese "Mini Dependency Injection" erlaubt es,
    den Code ausführlicher und v.a. einfacher zu testen.
  * Innerhalb der Services kommen mehr Transaktionen zum Einsatz, um die
    Konsistenz der Datenbank zu gewährleisten.

* **Utilities**

  * ``sly_Util_AddOn`` wurde ergänzt und bringt eine ganze Reihe Komfort-Methoden
    mit:

    * ``::isInstalled($addon)``
    * ``::isAvailable($addon)``
    * ``::assetBaseUri($addon)``
    * ``::publicDirectory($addon)``
    * ...

  * ``sly_Util_Article::findNotFoundArticle()`` wurde ergänzt.
  * ``sly_Util_Composer`` wurde ergänzt und kümmert sich darum, die
    :file:`composer.json`-Dateien einzulesen und auszuwerten.
  * ``sly_Util_FlashMessage`` wurde ergänzt.
  * ``sly_Util_Password`` wurde neu implementiert, um die verbesserten Hashes zu
    nutzen. Das Interface ist prinzipiell gleich geblieben.
  * ``sly_Util_User::getPasswordHash()`` wurde entfernt.
  * ``sly_Util_Versions::isCompatible()`` wurde ergänzt und führt einen
    Versionscheck analog zu Composer durch.
  * ``sly_Util_Medium::upload()`` wurde um einen optionalen ``$user``-Parameter
    erweitert.
  * ``sly_Util_Template::renderAsString()`` wurde hinzugefügt.

* Der alte Dateisystem-Cache (``BabelCache_Filesystem``) ist nicht mehr im
  Backend verfügbar, da er nie sinnvoller ist als der
  ``BabelCache_Filesystem_Plain``. Dieser wird nun im Backend als "Filesystem"
  bezeichnet.
* ``sly_Core::getFlashMessage()`` wurde ergänzt.
* ``sly_cookie()`` wurde analog zu ``sly_get()`` etc. hinzugefügt.

Frontend
""""""""

* ``sly_Util_Navigation`` wurde aus dem Core in die Frontend-App verlagert.

Events
""""""

* ``ADDONS_INCLUDED`` wurde in ``SLY_ADDONS_LOADED`` umbenannt.
* ``SLY_CACHE_CLEARED`` ist nun ein **notify-Event**. Eventuelle Erfolgs- oder
  Fehlermeldungen müssen in der globalen Flash-Message hinterlegt werden, da
  der Rückgabewert der Listener nun nicht mehr von Relevanz ist.
* ``SLY_DB_IMPORTER_BEFORE`` ist nun ein **notify-Event** und erhält den
  Dump nicht als als ``dump``, sondern als Subject. Ebenso wurde mit
  ``SLY_DB_IMPORTER_AFTER`` verfahren.
* ``CLANG_UPDATED`` wurde ergänzt und wird nach dem Speichern einer Sprache
  ausgeführt.
* ``CLANG_ADDED`` erhält nun nicht mehr einen leeren String, sondern die neue
  Sprache als Subject übergeben. Meldungen müssen über die Flash-Message
  ausgegeben werden. Dies gilt ebenso für ``CLANG_DELETED``.
* Die folgenden Events wurden um einen ``user``-Parameter erweitert, der den
  Nutzer enthält, mit dem eine Aktion ausgeführt wurde. Insbesondere wenn ein
  Event im Frontend gefeuert wurde, ist dies relevant, damit Listener wissen,
  welcher Nutzer relevant ist:

  * ``SLY_ART_ADDED``
  * ``SLY_ART_CONTENT_COPIED``
  * ``SLY_ART_COPIED``
  * ``SLY_ART_MOVED``
  * ``SLY_ART_STATUS``
  * ``SLY_ART_TO_STARTPAGE``
  * ``SLY_ART_TYPE``
  * ``SLY_ART_UPDATED``
  * ``SLY_CAT_ADDED``
  * ``SLY_CAT_MOVED``
  * ``SLY_CAT_STATUS``
  * ``SLY_CAT_UPDATED``
  * ``SLY_MEDIA_ADDED``
  * ``SLY_MEDIA_UPDATED``
  * ``SLY_MEDIACAT_ADDED``
  * ``SLY_MEDIACAT_UPDATED``
  * ``SLY_SLICE_MOVED``
  * ``SLY_USER_ADDED``
  * ``SLY_USER_UPDATED``

* Events können in bestimmten Fällen die eigentliche Aktion, wegen der sie
  ausgeführt wurden, abbrechen, indem aus einem Listener heraus eine Exception
  geworfen wird. Hierbei ist unbedingt zu beachten, dass dies zwar die
  Sally-Transaktion rückgängig gemacht, in der auch alle Listener ausgeführt
  werden, es aber trotzdem sein kann, dass ein anderer Listener (also ein
  anderes AddOn) nicht problemlos damit zurecht kommt, dass die Transaktion
  abgebrochen wird! Für alle nicht genannten Events gilt, dass sie entweder
  nicht im Kontext einer Transaktion oder **nach** der Transkation ausgeführt
  werden. Die betroffenen Events sind:

  * ``CLANG_DELETED``
  * ``SLY_ART_ADDED``
  * ``SLY_ART_COPIED``
  * ``SLY_ART_MOVED``
  * ``SLY_CAT_ADDED``

* ``SLY_BE_LOGIN`` und ``SLY_BE_LOGOUT`` wurden hinzugefügt. Es sind jeweils
  ``notify``-Events, die den betroffenen Nutzer als Subject mitbringen.

Datenbank
"""""""""

* Alle Spalten, die bisher UNIX-Timestamps enthielten, verwenden jetzt den
  nativen Datums-Datentyp des jeweiligen DBMS (z.B. ``DATETIME`` in MySQL).
* Innerhalb von PHP werden weiterhin UNIX-Timestamps verwendet. Die Umwandlung
  findet automatisch im Model-Service für alle Sally-Models transparent statt.
* Alle Sally-Tabellen verwenden InnoDB als Storage-Engine. Dies gilt, sofern
  nicht ausdrücklich anders gewünscht, auch für AddOns. Siehe :ref:`innodb` für
  mehr Informationen.
* Das Feld für den Passwort-Hash von Benutzern heißt nun ``password`` und ist
  128 Zeichen lang, um den neuen, komplexeren Hashes gerecht zu werden.
* Die Tabelle ``sly_slice_value`` wurde entfernt. Slice-Werte werden nun direkt
  am Slice in einer neuen Spalte, ``serialized_values LONGTEXT NOT NULL``,
  gespeichert. Die Daten liegt dort als JSON-kodiertes Array vor.

Im :doc:`migrate` finden sich SQL-Scripts und ein Migrationsscript in PHP, um
bei der Umstellung zu helfen.
