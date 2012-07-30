Release-Notes
=============

.. centered:: -- Composer, LESS is more & no more GPL --

.. note::

  Version 0.7 befindet sich noch im Beta-Stadium und ist noch nicht für den
  produktiven Einsatz geeignet. Die hier genannten Details können sich bis zum
  finalen Release jederzeit ändern.

Gut ein halbes Jahr nach dem Release der letzten großen Major-Version freut sich
das Sally-Team, nun die Verfügbarkeit der ersten *Beta* von SallyCMS 0.7
bekanntzugeben. Das neue Major Release konzentriert sich vor allem auf die
`Composer <https://getcomposer.org>`_-Integration, über die zukünftig AddOns,
Plugins und weitere Bibliotheken in Sally integriert werden, sowie den Wechsel
von Scaffold hin zu `LESS <http://lesscss.org/>`_. Gleichzeitig stellt es das
erste Release dar, dass **vollständig MIT-lizenziert** ist.

Der grobe :doc:`Ablauf eines Updates auf 0.7 <migrate>` wird auf einer extra
Seite beschrieben.

**Sally im Web**

* `Downloads <https://projects.webvariants.de/projects/sallycms/files>`_
* `Google+ <https://plus.google.com/b/114660281857431220675/>`_ und
  `Twitter <https://twitter.com/#!/webvariants>`_
* `Repository <https://bitbucket.org/SallyCMS/0.7/>`_ und
  `Code-Statistik bei Ohloh <http://www.ohloh.net/p/sallycms>`_
* `Bugtracker <https://projects.webvariants.de/projects/sallycms/issues/>`_ und
  `Forum <https://projects.webvariants.de/projects/sallycms/boards/>`_

Wir freuen uns über *jedes* Feedback. Kommentare können via Ticket, eMail,
Tweet oder Google+-Kommentar eingeschickt werden. :-)

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
