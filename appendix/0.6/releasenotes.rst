Release-Notes (BETA)
====================

.. note::

  Dieses Dokument ist noch nicht vollständig. Angaben können sich ohne
  Ankündigung bis zum Release noch ändern.

Beta-Release
------------

Bei dem aktuellen Release handelt es sich um eine Vorschau auf die kommende
0.6-Version. Auch wenn die API bereits recht festgeklopft ist, sind Änderungen
bis zur Finalversion durchaus wahrscheinlich.

Wir freuen uns über *jedes* Feedback. Probiert die neue Version aus und sagt
uns, was noch nicht stimmt, keinen Sinn ergibt, wo Dokumentation dringend fehlt
oder auch was euch gefallen hat. Vor allem die **Slice-Helper** sind bisher
recht dürftig und freuen sich über Vorschläge zur Erweiterung -- welche
Operationen führt ihr häufig mit Slicewerten durch? Wofür würden sich Helper gut
machen?

Läuft Sally auf eurem Webspace? Gibt es Probleme bei der Installation? Stimmen
Beschriftungen nicht oder werden Formulare nicht mit korrektem Fokus
initialisiert? Funktioniert das JavaScript auch im IE8? Machen die neuen Apps
Probleme? -- *Alle kleinen und großen Fehler sind von Interesse.*

Kommentare können via Ticket, eMail, Tweet, Google+-Kommentar oder Brieftaube
eingeschickt werden. Wir freuen uns auch über eine lebenslange Versorgung mit
`Sally-Energydrinks <https://plus.google.com/u/0/b/114660281857431220675/114660281857431220675/posts/2StWXjoZwNJ>`_
;-)

Release Notes
-------------

.. centered:: -- zwischen Featurewahn und Produktpflege ;) --

Das Sally-Team freut sich, die Verfügbarkeit von **SallyCMS 0.6** bekannt zu
geben. Dieses Release stellt einen großen Schritt in Richtung GPL-Freiheit,
Vereinheitlichung bestehender Features und neues Backend dar. Seit der
Veröffentlichung von Version 0.5 im August sind knapp **500 Commits** von
**4 Committern** in die Entwicklung geflossen.

Der grobe :doc:`Ablauf eines Updates auf 0.6 <migrate>` wird auf einer extra
Seite beschrieben.

**Sally im Web**

* `Downloads <https://projects.webvariants.de/projects/sallycms/files>`_
* `Google+ <https://plus.google.com/b/114660281857431220675/>`_ und
  `Twitter <https://twitter.com/#!/webvariants>`_
* `Repository <https://bitbucket.org/SallyCMS/0.6/>`_ und
  `Code-Statistik bei Ohloh <http://www.ohloh.net/p/sallycms>`_
* `Bugtracker <https://projects.webvariants.de/projects/sallycms/issues/>`_ und
  `Forum <https://projects.webvariants.de/projects/sallycms/boards/>`_

Änderungen
----------

Im Folgenden sollen kurz die Neuerungen in diesem Release beschrieben werden.

data hier und data da
"""""""""""""""""""""

In Sally 0.5 haben wir das :file:`data`-Verzeichnis in das
:file:`sally`-Verzeichnis verschoben. Wir wollten den gesamten "Sally-Stuff" in
einem einzelnen Verzeichnis bündeln (um die Trennung zwischen Sally und Projekt
hervorzuheben). Wie sich herausstellte, machte dies bei Deployments immer wieder
Probleme. Außerdem waren damit die URLs zum Medienpool unnötig lang
(``sally/data/mediapool/...``). Gleichzeitig liegen in :file:`data` zwar *auch*
Sally-Dateien, primär ist :file:`data` aber definitiv wahrscheinlich zwischen
den beiden Welten.

Aus diesen (und anderen) Gründen verschieben wir in 0.6 das
:file:`data`-Verzeichnis wieder in den Projektroot. Damit kann das gesamte
:file:`sally`-Verzeichnis über einen einzelnen Symlink bereitgestellt werden.
Außerdem verläuft das Deployment von Sally-Projekten etwas stressfreier.

Die für 0.5 gemachten Änderungen an AddOns, Modulen und Templates "dürfen" also
wieder rückgängig gemacht werden. Dafür handelt es sich dabei diesmal auch um
die einzige Änderung an der :doc:`Verzeichnisstruktur </general/birdseye>`.

Rechtesystem
""""""""""""

Das von REDAXO übernommene Rechtesystem wurde in dieser Version vollständig
durch ein abstraktes System ersetzt. Dabei wird vom Core nur die Schnittstelle
definiert, über die sich externe "Authorisation-Provider" im System anmelden
können.

Diese Änderung bedeutet, dass Sally selbst keine Rechte mehr verwaltet (sondern
diese nur noch von externen Quellen, sprich AddOns, abruft). Benutzer haben nur
noch das Admin-Flag und somit kann ihnen nur noch Zugriff auf *alles* oder
*nichts* gewährt werden.

Um trotzdem zwischen Administratoren und Redakteuren zu unterscheiden, haben wir
ein rollenbasiertes Rechtesystem in Form des `rbac-AddOns`_ implementiert. Das
AddOn ermöglicht es, einzelne Rechte an Rollen (die einander enthalten können)
zu knüpfen. Benutzer werden dann einer oder mehreren Rollen zugewiesen.

.. _`rbac-AddOns`: https://projects.webvariants.de/

Die Konfiguration der Rechte hat sich dadurch grundlegend geändert. Die
altbekannten Keys ``perm``, ``extperm`` und ``extraperm`` sind nicht mehr
verfügbar, stattdessen müssen Rechte in Form von Tokens und Contexts definiert
werden. Für ein AddOn "mysuperaddon" könnte dies wie folgt in der
:file:`globals.yml` geschehen:

.. sourcecode:: yaml

  authorisation:                        # an diesen Key muss alles gebunden werden
    mysuperaddon:                       # Kontext-Name
      title: 'Mein super AddOn'         # Wird in der Rechteverwaltung angezeigt
      tokens:                           # enthält Liste aller Rechte
        manage: 'Daten verwalten'       # 1. Recht
        export: 'Daten exportieren'     # ...
        config: 'Konfiguration ändern'

    # Es können beliebig viele Kontexte definiert werden.
    # Hier kommt Kontext 'anothergroup'
    anothergroup:
      title: 'Mein super AddOn (erweitert)'
      tokens:
        refund: 'Geld auszahlen'
        dominate: 'Weltherrschaft'

Abgefragt werden die Rechte dann wie folgt:

.. sourcecode:: php

  <?
  $user = getUserFromAnywhereYouLike();
  $user->hasRight('mysuperaddon', 'manage');   // true oder false
  $user->hasRight('anothergroup', 'dominate'); // true oder false

Rechte können noch komplexer definiert werden, um beispielsweise Rechte pro
Datenelement (wie einem Termin oder einem Produkt im Shop) festzulegen. Dies
wird aber an geeigneter Stelle dokumentiert und geht über dieses Dokument
hinaus.

App-Infrastruktur
"""""""""""""""""

Die bisher in großen Teilen in den beiden :file:`index.php`-Scripts
implementierten "Anwendungen" des Sally-Kernsystems (Backend und Frontend) sind
nun in Form von Klassen implement: ``sly_App_Backend`` und ``sly_App_Frontend``.
Diese Klassen kümmern sich um das "Hochfahren" des Kernsystems, ermitteln des
auszuführenden Controllers und dann die Ausführung des Controllers.

Mit diesem Umbau gehen eine Reihe einschneidender Änderungen einher:

**Dispatching in den Apps**
  Bisher war das Dispatching (das Ermitteln des Controllers und Ausführen der
  angefragten Action) Teil der Controller selbst (in ``sly_Controller_Base``
  implementiert). Diese Zuständigkeit wurde nun in die Apps verlagert und dort
  von ``sly_App_Base`` vorimplementiert. Controller sind damit ausschließlich
  für ihre eigene Aktionen verantwortlich.

**Frontend-Controller**
  Da die Apps nun dispatchen, kommt dieser Mechanismus auch im Frontend zum
  Einsatz. In den meisten Fällen wird der Artikel-Controller verwendet, der
  dann den aktuellen Artikel ermittelt (und im ``sly_Core`` registriert) und
  anzeigt. Es sind aber auch weitere Controller (wie für RSS-Feeds,
  XML-Sitemaps etc.) möglich (die von AddOns oder im
  :file:`develop/lib`-Verzeichnis mitgebracht werden können). Auch der
  Asset-Cache läuft nun zum Teil als Controller statt.

**Routing**
  Zum Ermitteln des aktuellen Controllers kommt im Backend weiterhin der
  URL-Parameter ``page`` zum Einsatz, hier ändert sich also nichts. Im Frontend
  wird standardmäßig nach den Mustern ``/sally/:controller/:action/`` und
  ``/sally/:controller`` gesucht. So würde die URL ``example.com/sally/feed``
  zum Controller ``sly_Controller_Frontend_Feed`` führen (und die
  ``indexAction()`` ausführen) und ``example.com/sally/feed/subscribe`` dann die
  ``subscribeAction()`` ausführen.

  Das Routing kann von AddOns erweitert werden, entweder um eigene Routen oder
  durch eine ganz eigene Router-Instanz, die erweitertes URL-Matching vornehmen
  kann.

**Controller**
  Controller müssen das Interface ``sly_Controller_Interface`` implementieren.
  Backend-Controller müssen weiterhin ``sly_Controller_[Page]`` heißen,
  Frontend-Controller müssen ``sly_Controller_Frontend_[Page]`` heißen.

**Action-Methoden**
  Da das Dispatchen nun in den Apps stattfindet, müssen die Action-Methoden
  **public** sein. Um sie von ggf. anderen öffentlichen Methoden zu
  unterscheiden (ein Controller könnte öffentliche Methoden auch für
  Event-Handler verwenden), müssen sie nach dem Schema ``[action]Action``
  benannt sein (zum Beispiel ``indexAction``, ``addAction`` etc.).

``checkPermission($action)``
  Die ``checkPermission()``-Methode muss nun auch **public** sein und den
  Parameter ``$action`` zumindest formell entgegennehmen.

**init und teardown**
  Die beiden früher verfügbaren Helper-Methoden, die beim Dispatching direkt
  vor (``init()``) bzw. nach (``teardown()``) ausgeführt wurden, existieren
  nicht mehr. Es wird direkt die jeweilige Action-Methode ausgeführt. Wer eine
  Initialisierung vornehmen möchte, sollte dazu seine eigene ``init()``-Methode
  selbst in den Actions aufrufen.

**Responses und Ausgabe**
  Action-Methoden können entweder wie bisher den Content direkt ausgeben. Sie
  können allerdings auch ihre Antwort in Form einer ``sly_Response``-Instanz
  zurückgeben. In diesem Fall wird ihre Ausgabe ignoriert (der Output-Buffer
  wird verworfen). Auf diese Weise können Actions auch komplexere Inhalte mit
  Headern und Status-Code zurückliefern, den Listener später noch verarbeiten
  können.

  Es ist damit jetzt empfohlen, jede nicht-HTML-Ausgabe in ein
  ``sly_Response``-Objekt zu verpacken und zurückzugeben. **Controller-Methoden
  sollten niemals Header direkt setzen und einfach mit die() wegsterben.**
  Generierte Inhalte wie RSS-Feeds oder auch Bilder sollten in Responses
  verpackt zurückgegeben werden, damit jeder Sally-Aufruf sauber bis zum Ende
  durchlaufen kann.

Es ist möglich, eigene Apps zu entwickeln, die beispielsweise weniger oder gar
keine AddOns laden. So könnte es eine Cronjob-App geben, die beim Einsatz von
Sally in browserlosen Umgebungen optimiert ist.

Das App-System steht noch ganz am Anfang seiner Entwicklung und wir freuen uns
über Feedback und Vorschläge zur Verbesserung :-)

.. warning::

  Um es noch einmal deutlicher zu schreiben: Der anzuzeigende Artikel wird im
  Frontend erst vom Artikel-Controller ermittelt. Bevor dieser nicht das Event
  ``SLY_CURRENT_ARTICLE`` feuert, weiß *niemand*, welcher Artikel angezeigt
  werden soll. Calls zu Methoden wie ``sly_Core::getCurrentArticle()`` enden
  damit in ``null``-Werten.

.. warning::

  Das Gleiche gilt für das Layout, das im Backend erst von der App gesetzt
  werden muss (ist bei ``ADDONS_INCLUDED`` bereits verfügbar). Im Frontend ist
  es die **alleinige Aufgabe** des Frontend-Codes (Templates & Module), ein
  Layout zu setzen oder überhaupt zu verwenden. Bei ``sly_Core::getLayout()``
  kann es also kein Layout geben!

.. note::

  Der aktuelle Artikel steht wie bisher bei ``ADDONS_INCLUDED`` noch nicht
  bereit und AddOns sollten auf ``SLY_CONTROLLER_FOUND`` warten (wird im
  Frontend und Backend ausgeführt). ``PAGE_CHECKED`` ist deprecated und wird in
  einem zukünftigen Release entfernt.

Slice-Handling
""""""""""""""

Die Verarbeitung von Slices wurde völlig umgebaut und verwendet nun keine
Platzhalter mehr, die von Sally durch PHP-Code ersetzt werden müssen.
Stattdessen sind Module reiner PHP/HTML-Code, sodass Module ab sofort direkt
über ``include`` eingebunden werden.

Statt der altbekannten Platzhalter (wie ``SLY_SLICE_VALUE[myvalue]``) gibt es
nun ein ``sly_Slice_Values``-Objekt in jedem Slice, über das auf die Werte des
Slices zugegriffen werden kann. Dabei ist zu beachten, dass Werte nun
*unabhängig* von ihren Formularelementen gespeichert werden. Das heißt, dass man
Formular-Eingabe und die Auswertung der Werte komplett trennen kann (ein über
ein Link-Widget eingegebener Artikel muss nicht als Artikel im Slice verwendet
werden).

Außerdem wurde das Rendering der Eingaben von Modulen umgebaut. Wo früher noch
``SLY_LINK_WIDGET[x]`` ein Link-Widget gerendert hat, muss jetzt ``sly_Form``
oder plain HTML zum Einsatz kommen. Das erlaubt es, jedes beliebige
Formularelement auch in Slices zu verwenden und trotzdem im Notfall noch direkt
HTML schreiben zu können. Es bedeutet auch, dass Module nun einheitlicher im
Backend dargestellt werden, da bei Verwendung von ``sly_Form`` ein Großteil des
eigentlichen Renderns von Sally übernommen wird.

Ein Beispiel-Modul verdeutlicht die Änderung. Hier das **test.input.php**-Modul:

.. sourcecode:: php

  <?
  /**
   * @sly  name   textfield
   * @sly  title  Textfeld
   */

  // $values wird von Sally vordefiniert und erlaubt via ->get(), einen
  // Slicewert abzurufen (egal, wie dessen Eingabe aussehen mag).

  $text = $values->get('mytext'); // beim ersten Anzeigen des Moduls ist dieser Wert null

  // Jetzt kann das Formular zusammengesetzt werden. Hier beispielsweise
  // eine einfache Textarea.

  $textarea = new sly_Form_Textarea('mytext', 'Text', $text);

  // Formularelemente werden dann in das ebenfalls von Sally vordefinierte
  // $form-Objekt gepackt. Sally kümmert sich im Anschluss selber darum, das
  // Formular zu rendern, sodass...

  $form->add($textarea);

  // ... hier das Modul bereits beendet ist.

Die **Ausgabe** ist denkbar einfach:

.. sourcecode:: php

  <?
  /**
   * @sly  name   textfield
   * @sly  title  Textfeld
   */

  print $values->get('mytext');

``$values`` definiert noch ein paar weitere Helper, die den Modulen nervigen
Code ersparen sollen (wie ``->getArticle($valueKey)``, das für einen Slicewert
einen Artikel zurückgibt).

AddOn-Verwaltung
""""""""""""""""

Die klassische AddOn-Verwaltung über die Tabelle im Backend wurde abgeschafft
und durch eine auf die tatsächlich möglichen Interaktionen abgestimmte UI
ersetzt.

Die einzelnen Aktionen werden in Ajax-Requests ausgeführt, damit beim
Installieren vieler AddOns nicht ständig die Einträge in der Tabelle neu
fokussiert werden müssen, weil die Seite neu lud. Dabei werden alle Einträge in
der Liste entsprechend aktualisiert (d.h. AddOns mit Abhängigkeiten werden
sofort installierbar und die deaktivieten Buttons verschwinden).

Außerdem werden AddOns nun, wenn sie installiert werden sofort aktiviert. Der
Use-Case, ein AddOn zwischen Installation und Aktivierung erst noch zu
konfigurieren kam extrem selten vor und wurde vom Core auch nicht erzwungen,
womit AddOns eh darauf hin implementiert sein müssen, dass sie mit fehlender
Konfiguration aktiviert werden.

Sally liest nun auch die statischen Informationen von AddOns aus, die nicht
geladen wurden. Damit ist es möglich, in der AddOn-Verwaltung exakte
Informationen anzuzeigen. So werden fehlende Abhängigkeiten nicht erst beim
Installationsversuch geblockt, sondern wirken sich direktauf die UI aus. Die
Information dient ebenfalls dazu, die **inkl. Abhängigkeiten installieren**-Funktion
bereitzustellen -- über diese werden mit einem Klick ein AddOn und alle
rekursiven Abhängigkeiten installiert.

Das neue Backend ist ein erster Versuch, die AddOn-Verwaltung zu vereinfachen.
Wir freuen uns über jedes Feedback dazu :-)

Modul-Konfiguration
"""""""""""""""""""

In Sally 0.4 und 0.5 wurden die erlaubten Module innerhalb von Templates
definiert (``@sly modules ...``). Das hat zwar gut funktioniert, war nicht so
flexibel, wie wir es gern hätten. So mussten in manchen Fällen Templates
kopiert werden, nur um für einen anderen Artikeltypen andere Module zu erlauben.

Aus diesem Grund haben wir diese Definition nun an den *Artikeltypen* geknüpft.
Da bereits in den Templates YAML zum Einsatz kam, können bestehende
``@sly modules``-Angaben quasi 1:1 übernommen werden.

Die Konfiguration der Artikeltypen könnte damit wie folgt aussehen:

.. sourcecode:: yaml

  ARTICLE_TYPES:
    default:
      title: Standardseite
      template: default
      modules: {leftcol: [editor], rightcol: [teaser]}
    job:
      title: Stellenangebot
      template: default
      modules: [editor, download, pdf]
    news:
      title: Newsbeitrag
      template: twocolumn
      custom: Eigene Key-Value-Pairs sind beliebig ergänzbar

.. note::

  Die Definition der Slots bleibt weiterhin in den Templates. Der Entwickler ist
  selber dafür verantwortlich, die Angaben in Templates und der
  Artikeltyp-Konfiguration synchron zu halten.

Mehrsprachigkeit
""""""""""""""""

Die Sprachdateien von Sally wurden stark überarbeitet. Bisher bestanden sie aus
einer Mischung aus natürlichsprachlichen Keys
(``your_operation_has_been_stopped``) und generischen, teils gruppierten Keys
(``content_meta_function_29``). Dies verhinderte Wiederverwendung von schon
bestehenden Übersetzungen und machte teilweise sogar den Formular-Code schwer
zu verstehen, ohne die Übersetzungen zu kennen. Außerdem stellte sich bei der
Überarbeitung heraus, dass tatsächlich viele Angaben mehrfach übersetzt wurden.
Auch gab es gänzlich unsinnige Übersetzungen wie ``copy_article``, das mit
"in Kategorie" übersetzt wurde...

Um hier eine klare Richtung vorzugeben und gleichzeitig mal gründlich
aufzuräumen haben wir Unmengen an Übersetzungs-Keys geändert. Keys werden nun
**immer natürlichsprachlich** gewählt. Außerdem folgen die Keys Mustern wie
``[object]_was_[verb]`` oder ``cannot_[verb]_[object]``.

Als Resultat dieser Aktion wurden 10 KB Sprachinhalte entfernt (obwohl auch
viele neue Einträge neu hinzu kamen). Im Backend haben sich an vielen Stellen
die Beschriftungen und Meldungen leicht geändert. Keine Angst, die Umgewöhnung
ist einfach :-)

Visual Cleanup
""""""""""""""

Viel Mühe wurde ebenfalls in das allgemeine Markup und Styling des Backends
gesteckt. So wurden unzählige kleine Glitches und Fehlerchen behoben (so sind
jetzt beispielsweise die unteren Ecken der Artikeltabelle in der Strukturansicht
auch dann abgerundet, wenn man im Root den ersten Artikel hinzufügt). Viele
Stellen sehen deswegen "irgendwie anders" aus, was durch die Reduktion der
CSS-Stile hervorgerufen wird.

Viele CSS-Regeln wurden vereinfacht (so kann ``.sly-form-text`` überall benutzt
werden, auch außerhalb von ``.sly-form``-Elementen) und weniger spezifisch
gemacht. AddOns können nun einfacher das Styling von Sally für einzelne Elemente
übernehmen: einem Button muss nur die Klasse ``.sly-button`` gegeben werden,
damit er wie ein Sally-Button aussieht.

Entfernt wurden außerdem viele unnötige Hilfsklassen, wie ``.rex-tx1`` oder
``.rex-hl2``. Nie wieder soll es Markup wie ``<h3 class="rex-hl2">`` in Sally
geben.

Abgesehen davon wurde die Linkmap visuell überarbeitet und zeigt nun endlich
einen zumindest sauber gerenderten Kategoriebaum an (auch wenn er noch nicht
ajaxifiziert ist). Der Footer wurde kleiner gestaltet, die Kontrast beim Datum
und der Scriptlaufzeit (die jetzt im Format ``1sek 240ms`` angezeigt wird) wurde
etwas erhöht.

In der Strukturansicht wird nun die Position der Artikel und Kategorien nicht
mehr standardmäßig angezeigt (da sie durch die Reihenfolge der Elemente bereits
redundant ist). Erst beim Bearbeiten von Einträgen wird sie angezeigt. Für die
Eingabe der neuen Position kommt ein ``<input type="number">`` zum Einsatz, was
Fehleingaben praktisch ausschließen sollte.

Unit-Tests
""""""""""

Wir haben die Entwicklung der Tests für die Sally-API (ein ganz besonders von
allen Entwicklern geliebter Bereich der Projektentwicklung!) stark
vorangetrieben und jetzt eine sehr gute Basis für noch viele weitere Tests. Die
Tests haben bereits einige Bugs in Sally aufgedeckt (vor allem in den
Artikel-bezogenen Funktionen) und wir sind sicher, dass wir noch mehr mit ihnen
finden werden.

Wir sind jetzt bei stolzen 280 Testcases mit insgesamt 633 Assertions. Ein guter
Anfang. :-)

Die gleichen Mechanismus, die wir im Core nutzen, stellen wir auch AddOns zur
Verfügung. Mit ersten Tests zu starten ist damit so einfach wie es die
:doc:`Dokumentation </addon-devel/extended/testing>` beschreibt.

Systemvoraussetzungen
---------------------

Beginnend mit Version 0.6 gestalten sich die Voraussetzungen wie folgt:

* PHP 5.2+ (bisher: 5.1)
* JSON- und DateTime-Support müssen in PHP verfügbar sein.
* ``short_open_tags`` wird nicht mehr benötigt.

Änderungen seit 0.6 beta
------------------------

* alle Modul- und Artikeltypstrings, die im Backend angezeigt werden, können via
  ``translate:...`` übersetzt werden.
* ``sly_Controller_Base->render()`` hat einen dritten Parameter
  ``$returnOutput`` erhalten, über den der Output Buffer abgeschaltet werden
  kann (nützlich, wenn der Inhalt des Views eh ausgegeben werden soll).
* Sende einen ``Connection: close``-Header, wenn der Client nicht explizit einen
  ``Keep-Alive``-Header sendet.
* Der checked-Status kann jetzt im Konstruktor von Checkboxen und Radioboxen
  über einen weiteren Parameter direkt gesetzt werden.
* Die Standard-Sortierreihenfolge kann nun beim Aufruf von
  ``sly_Table::getSortingParameters()`` mit angegeben werden.
* Die beiden Standard-Routen (``/sally/:controller/:action`` und
  ``/sally/:controller``) wurden wieder entfernt. AddOns, die Controller im
  Frontend erreichbar machen wollen, müssen diese nun immer selbstständig im
  Router anmelden.
* Die Frontend-App erlaubt nun via ``getRouter()`` Zugriff auf den verwendeten
  Router (und damit auch auf dessen Match und weitere Daten, siehe folgender
  Punk).
* Der Base-Router nimmt nun ein assoziatives Array von Route => Values entgegen.
  In den Values (ebenfalls ein ass. Array) können weitere Werte abgelegt werden,
  die über ``->get()`` abgefragt werden können.
* Klassennamen können nun mit einem Unterstrich versehen werden, ohne dass dafür
  eine extra Präfix-Regel notwendig ist. ``_Foo_Bar`` löst nun nicht mehr nach
  ``load/path//Foo/Bar``, sondern ``load/path/_Foo/Bar`` auf.
* Der Hilfetext von Formularelementen kann nun auch optional HTML enthalten (das
  muss allerdings erst pro Formularelement gesetzt werden).
* Das gesamte Formularframework hat nun ein "Fluid Interface".
* Die empfohlene MySQL-Version wurde auf 5.1 erhöht.
* Output-Modulen wird das aktuelle Slice als ``$slice`` übergeben.
* Bugfix: fehlende Permissions für AddOns ohne eigene Auth-Config
* Bugfix: doppelter Header im AddOn-Backend wenn kein JavaScript verfügbar ist.
* Bugfix: ``sly_Router_Interface`` fehlte im Bootcache.
* Bugfix: 403-Header sollte nur bei fehlgeschlagenen Logins gesendet werden,
  bei Requests auf ``example.com/backend``.
* Bugfix: Plugins wurden im Produktivmodus nicht geladen.
* Bugfix: ``ht()`` beachtete die weiteren Parameter neben dem i18n-Key nicht.
* Bugfix: In einigen Sonderfällen war die Linkmap nicht korrekt gestylt.
* Bugfix: ``sly_Router_Base->getAction()`` gab den falschen Wert zurück.
* Bugfix: Der Systemvoraussetzungscheck im Setup war nicht mehr korrekt
  gestylt.
* Bugfix: Auf der Content-Seite im Backend fehlte der aktuelle Artikelkontext
  (``sly_Core::getCurrentArticle()`` war immer ``null``).
* Bugfix: Templates können wieder über Conditions gefiltert werden.
* Bugfix: Dateien im Medienpool konnten nicht gelöscht werden.
* weitere kleinere Verbesserungen

API-Änderungen
--------------

Im Folgenden werden soweit möglich alle API-Änderungen zwischen dem 0.5- und dem
0.6-Branch beschrieben.

Konfiguration
"""""""""""""

* ``RELOGINDELAY``, ``BLOCKED_EXTENSIONS`` und ``START_PAGE`` wurden in
  statische Konfiguration des Backends überführt (sind aber weiterhin auf die
  gleiche Weise abrufbar).
* ``MEDIAPOOL/BLOCKED_EXTENSIONS`` wurde in statische Konfiguration des Backends
  überführt und in ``BLOCKED_EXTENSIONS`` umbenannt.
* ``USE_MD5`` wurde entfernt.
* Die Permissions werden jetzt nicht mehr über ``PERM``, ``EXTPERM`` und
  ``EXTRAPERM`` gesteuert, sondern über das neue Authorisation-System (siehe
  Abschnitt weiter oben).
* Artikeltypen und Module können jetzt über ``translate:...`` übersetzt werden.

Globale Variablen
"""""""""""""""""

* Die Konstante ``IS_SALLY`` wurde entfernt.

Datei(system)
"""""""""""""

.. note::

  Siehe dazu auch die :doc:`Verzeichnisstruktur </general/birdseye>`.

* Das :file:`data`-Verzeichnis wurde wieder (wie in Sally 0.4) in das
  Wurzelverzeichnis des Projekts verschoben.
* Alle Funktionssammlungen in :file:`sally/core/functions` wurden entfernt.

Datenbank
"""""""""

* Es werden getrennte Installationsscripts pro DBMS mitgeliefert. Die
  :file:`user.sql` wurde entfernt.
* Alle Felder, die ``prior`` im Namen hatten, wurden in ``pos`` umbenannt.
* Slice-Werte werden nun immer als JSON-Strings abgespeichert.
* Alle weiteren Anpassungen lassen sich aus dem untenstehenden SQL ableiten.

Die Datenbank kann über die folgenden SQL-Statements aktualisiert werden.
Bestehende Daten gehen dabei nicht verloren.

.. sourcecode:: mysql

  ALTER TABLE `sly_article` CHANGE COLUMN `catprior` `catpos` INT UNSIGNED NOT NULL;
  ALTER TABLE `sly_article` CHANGE COLUMN `prior` `pos` INT UNSIGNED NOT NULL;
  ALTER TABLE `sly_article_slice` CHANGE COLUMN `prior` `pos` INT UNSIGNED NOT NULL;
  ALTER TABLE `sly_file` CHANGE COLUMN `filesize` `filesize` INT UNSIGNED NOT NULL;
  ALTER TABLE `sly_file_category` CHANGE COLUMN `attributes` `attributes` TEXT NULL;
  ALTER TABLE `sly_slice_value` DROP COLUMN `type`;
  ALTER TABLE `sly_user` CHANGE COLUMN `name` `name` VARCHAR(255) NULL;
  ALTER TABLE `sly_user` CHANGE COLUMN `description` `description` VARCHAR(255) NULL;

.. note::

  Ein PHP-Script, das die JSON-Konvertierung der Slicewerte vornimmt, ist im
  :doc:`Migrationsleitfaden <migrate>` gegeben.

.. note::

  Abgesehen von diesen Änderungen kann eine bestehende 0.5-Datenbank problemlos
  mit Sally 0.6 verwendet werden.

JavaScript
""""""""""

Die in 0.5 eingeführten Erweiterungen wurden noch einmal verfeinert und wie
folgt geändert:

* ``sly.openMediapool(subpage, value, callback)`` nimmt zwei weitere Parameter
  zum Einschränken der Dateitypen und Kategorien entgegen. Beide sind optional.
* ``sly.openLinkmap(subpage, value, callback)`` nimmt zwei weitere Parameter
  zum Einschränken der Artikeltypen und Kategorien entgegen. Beide sind
  optional.
* ``sly.inherit(subClass, baseClass)`` ist nun ein öffentlicher Helper, um zwei
  Prototypen zu verketten (also eine Klasse in JavaScript abzuleiten).
* ``sly.initWidgets(context)`` kann dazu verwendet werden, nachträglich via
  DOM-Operationen eingefügte Widgets zu initialisieren.

Globale Funktionen
""""""""""""""""""

* Die folgenden Typen, die bei ``sly_settype()`` (meistens über ``sly_get()``
  oder ``sly_post()`` genutzt) verwendet werden konnten, wurden entfernt:

  * ``rex-*`` (wurden nicht alle entsprechend validiert und waren daher
    irreführend)
  * ``uinteger``, ``uint``, ``udouble``, ``ufloat``, ``ureal``

* ``rex_send_article()``, ``rex_send_content()``, ``rex_send_last_modified()``
  und ``rex_send_etag()`` wurden entfernt. Die Optionen wurden soweit möglich
  in das ``sly_Response``-Objekt verlegt, das von den Apps zurückgegeben und
  an den Client gesendet wird.
* Slice-Funktionen

  * ``rex_moveSliceUp()`` und ``rex_moveSliceDown()`` wurden entfernt.
  * ``rex_moveSlice()`` wurde in ``sly_Service_ArticleSlice->move()`` verlegt.
  * ``rex_deleteArticleSlice()`` wurde in ``sly_Service_ArticleSlice->deleteById()``
    verlegt.
  * ``rex_slice_module_exists()`` wurde entfernt und durch
    ``sly_Util_ArticleSlice::getModule`` ersetzt

* Artikel-Funktionen

  * ``rex_article2startpage()`` wurde entfernt und durch
    ``sly_Service_Article->convertToStartArticle()`` ersetzt.
  * ``rex_copyContent()`` wurde entfernt und durch
    ``sly_Service_Article->copyContent()`` ersetzt.
  * ``rex_copyArticle()`` wurde entfernt und durch
    ``sly_Service_Article->copy()`` ersetzt.
  * ``rex_moveArticle()`` wurde entfernt und durch
    ``sly_Service_Article->move()`` ersetzt.
  * ``rex_moveCategory()`` wurde entfernt und durch
    ``sly_Service_Category->move()`` ersetzt.
  * ``rex_deleteArticle()`` wurde entfernt und durch
    ``sly_Service_Article->delete()`` ersetzt.

* Cache-Funktionen

  * ``rex_generateAll()`` wurde entfernt und durch ``sly_Core::clearCache()``
    ersetzt.
  * ``rex_deleteCacheArticle()`` wurde entfernt.

* Globals

  * ``_rex_array_key_cast()`` wurde entfernt und durch ``sly_setarraytype()``
    ersetzt.
  * ``_rex_cast_var()`` wurde entfernt und durch ``sly_settype()`` ersetzt.

* Sonstige

  * ``rex_translate()`` wurde durch ``sly_translate()`` umbenannt. Die neue
    Funktion wendet nicht mehr automatisch ``sly_html()`` auf die Übersetzung
    an!
  * ``rex_copyDir()`` wurde entfernt und durch ``sly_Util_Directory->copyTo()``
    ersetzt.
  * ``rex_message()``, ``rex_info()``, ``rex_warning()`` und
    ``rex_split_string()`` wurden entfernt.
  * ``sly_isEmpty()`` wurde entfernt.
  * ``t()`` verwendet nun immer das global ``sly_I18N``-Objekt, der Fallback auf
    das Translator-AddOn wurde entfernt.

Core-API
""""""""

* ``Services_JSON`` wurde entfernt, da nun in PHP vorhandener JSON-Support
  vorausgesetzt wird. Damit einher geht auch das Verschwinden der Funktion
  ``json_get_service()``.
* ``OOArticleSlice`` wurde entfernt und durch ``sly_Service_ArticleSlice``
  ersetzt.
* Alle ``rex_var``-Klassen wurden entfernt.
* ``sly_App_Base`` wurde als Basisklasse für alle Apps ergänzt. Apps müssen
  allerdings nur ``sly_App_Interface`` implementieren.
* **Auth-System**

  * Das Interface ``sly_Authorisation_Provider`` hat sich geändert: die Signatur
    lautet nun ``hasPermission($userId, $context, $token, $value = true)``.
  * Das Interface ``sly_Authorisation_ListProvider`` wurde hinzugefügt. Eine
    Implementierung in ``sly_Authorisation_ArticleListProvider`` für den
    ``article``-Kontext wurde ergänzt.
  * Die folgenden Methoden wurden in ``sly_Authorisation`` geändert:

    * ``::getRights()`` wurde entfernt.
    * ``::getExtendedRights()`` wurde entfernt.
    * ``::getExtraRights()`` wurde entfernt.
    * ``::getObjectRights()`` wurde entfernt.
    * ``::getConfig()`` wurde hinzugefügt.

* **Controller**

  * ``sly_Controller_Base`` wurde deutlich ausgedünnt und enthält jetzt keinen
    Aspekt des Dispatchens mehr:

    * Die Konstanten ``PAGEPARAM``, ``SUBPAGEPARAM`` und ``ACTIONPARAM`` wurden
      entfernt. Die dazugehörigen Getter-Methoden wurden ebenfalls entfernt.
    * Der protected Konstruktor wurde entfernt; Controller sollen einfach zu
      instanziierende Klassen sein.
    * ``::getPage()`` wurde entfernt, ebenso ``::setCurrentPage()``,
      ``::factory()`` und ``::dispatch()``.
    * Die ``init()`` und ``teardown()``-Methodenstubs wurden entfernt, da sie
      beim Dispatchen auch nicht mehr automatisch aufgerufen werden würden.
    * ``index()`` und ``checkPermission()`` sind keine zu implementierenden
      abstrakten Methoden mehr (``checkPermission()`` wird allerdings vom
      Interface ``sly_Controller_Interface`` vorausgesetzt).

  * ``sly_Controller_Exception`` ist nun eine ``sly_Exception``.
  * ``sly_Controller_Interface`` wurde hinzugefügt und verlangt eine
    ``public function checkPermission($action)``.

* **Datenbank-Zugriff**

  * ``sly_DB_Importer`` behandelt die ``user``-Tabelle nun nicht mehr explizit.
    Fehlt sie, fehlt sie (da es auch keine ``user.sql`` mehr gibt).
  * ``sly_DB_Persistence->all()`` wurde als abstrakte Methode hinzugefügt und
    steht daher in ``sly_DB_PDO_Persistence`` als Methode zur Verfügung. Sie
    gibt das resamte Resultset in Form von einem Array von assoziativen Arrays
    zurück.
  * Das Attribut ``MYSQL_ATTR_USE_BUFFERED_QUERY`` wird nur noch gesetzt, wenn
    MySQL als Treiber verwendet wird.
  * ``sly_DB_PDO_Driver`` wurde erweitert:

    * ``->getPDOOptions()`` muss eine Liste von PDO-Optionen zurückgeben.
    * ``->getPDOAttributes()`` muss eine Liste von PDO-Attributen zurückgeben.
    * ``->getCreateDatabaseSQL()`` muss das SQL-Statement zum Anlegen einer
      Datenbank zurückgeben. Ist in Oracle by Design nicht implementiert.

  * ``sly_DB_PDO_Persistence`` wurde erweitert:

    * ``->getConnection()`` gibt das ``sly_DB_PDO_Connection``-Objekt zurück.
    * ``->getPDO()`` gibt das ``PDO``-Objekt zurück.
    * ``->transactional()`` erlaubt es, einen Callback in einer Transaktion
      auszuführen. Sollte bereits eine Transaktion aktiv sein, wird der Callback
      direkt ausgeführt. Bei einer Exception wird die aktive Transaktion
      zurückgerollt und die Exception weitergeworfen.
    * ``->all()`` gibt das gesamte Resultset zurück.
    * ``->rewind()`` wirft eine Exception anstatt eine Warnung zu generieren.

* **Error-Handling**

  * Das Interface ``sly_ErrorHandler`` schreibt nun zusätzlich die Methode
    ``handleException(Exception $e)`` vor.
  * Der Development-Errorhandler implementiert ``handleException()``, indem er
    die Exception ausgibt und wegstirbt.

* **Event-Dispatcher**

  * Der Konstruktor von ``sly_Event_Dispatcher`` ist nun public. Die systemweite
    Instanz wird von ``sly_Core`` gehalten. Die ``::getInstance()`` wurde daher
    entfernt.
  * Die Methode ``register()`` nimmt nun den neuen Parameter ``$first = false``
    entgegen. Wird er auf true gesetzt, wird der Listener **vor** die
    bestehenden Listener gesetzt. *(Diese Möglichkeit sollte als letzter Ausweg
    angesehen werden, nicht als Alltagswerkzeug!)*

* **Models**

  * ``sly_Model_Base_Article``

    * ``->getCatPosition()`` wurde hinzugefügt, ``->getCatPrior()`` ist
      deprecated. Dito für die dazugehörigen Setter.
    * ``->getPosition()`` wurde hinzugefügt, ``->getPrior()`` ist deprecated.
      Dito für die dazugehörigen Setter.

  * ``sly_Model_Article->printContent()`` wurde entfernt.
  * ``sly_Model_Article->getArticle()`` wurde entfernt (``->getContent()``
    nutzen)
  * ``sly_Model_ArticleSlice`` wurde als Ersatz für ``OOArticleSlice``
    hinzugefügt. Die alte OO-API ist nicht mehr verfügbar.
  * ``sly_Model_Slice``

    * ``->addValue()`` hat keinen Parameter ``$type`` mehr. Dito für
      ``->getValue()``.
    * ``->setValues()`` und ``->getValues()`` wurden hinzugefügt.

  * ``sly_Model_SliceValue->getType()`` und ``->setType()`` wurden entfernt.
  * ``sly_Model_User``

    * ``->getRightsAsArray()`` wurde entfernt.
    * ``->toggleRight()`` wurde entfernt.
    * ``->hasRight()`` hat sich geändert:
      ``->hasRight($context, $right, $value = true)`` (siehe dazu weiter oben
      die Beschreibung zum Rechtesystem).

* In ``sly_Registry_Registry`` wurde der Parameter ``$default`` für die
  ``->get()``-Methode hinzugefügt.
* ``sly_Response`` wurde hinzugefügt, zusammen mit dem Interface
  ``sly_Response_Action`` und der Klasse ``sly_Response_Forward``.
* ``sly_Router_Base`` wurde hinzugefügt, zusammen mit dem Interface
  ``sly_Router_Interface``.
* **Slices**

  * ``sly_Slice_Renderer``, ``sly_Slice_Helper``, ``sly_Slice_Values`` und
    ``sly_Slice_Form`` wurden hinzugefügt.

* ``sly_Table``-Instanzen können nur eine Liste von CSS-Klassen enthalten. Dazu
  kamen die Methoden ``->addClass()``, ``->clearClasses()`` und
  ``->getClasses()`` hinzu.
* **Konfiguration**

  * Der Konstruktor von ``sly_Configuration`` ist nun public. Die systemweite
    Instanz wird von ``sly_Core`` gehalten. Die ``::getInstance()`` wurde daher
    entfernt.

* **sly_Core**

  * ``::setCurrentApp(sly_App_Interface $app)`` und ``::getCurrentApp()`` wurden
    hinzugefügt.
  * ``::setCurrentClang()`` erlaubt ``null`` als Eingabe, um die aktuelle
    Sprache zurückzusetzen. Dito für ``::getCurrentArticleId()``.
  * ``::getCurrentClang()`` und ``::getCurrentArticleId()`` ermitteln die
    aktuellen Werte nicht mehr selber, sondern geben die von der jeweiligen App
    gesetzten Werte zurück. AddOns sollten also aufpassen, dass es ab jetzt
    möglich ist, dass die Methoden ``null`` zurückgeben.
  * ``::registerVarType()``, ``::getVarTypes()`` und ``::registerCoreVarTypes()``
    wurden entfernt.
  * ``::getLayout()`` gibt ebenfalls nur noch ein vorher über die neue Methode
    ``::setLayout()`` gesetztes Layout zurück.
  * ``::getTablePrefix()`` wurde hinzugefügt.
  * ``::getNavigation()`` ist jetzt deprecated und sollte nicht mehr verwendet
    werden. Alternative: ``sly_Core::getLayout()->getNavigation()`` (im Backend)
  * ``::setResponse()`` und ``::getResponse()`` wurden hinzugefügt.
  * ``::getCurrentPage()`` ist jetzt deprecated, verhält sich aber weiter wie
    gewohnt. Neuer Code sollte ``::getCurrentControllerName()`` verwenden, die
    auch im Frontend den Controllernamen zurückgibt.
  * ``::getCurrentController()`` wurde hinzugefügt und gibt die
    Controller-Instanz zurück.
  * ``::clearCache()`` wurde hinzugefügt.

* ``sly_I18N->setLocale()`` wurde in ``->setPHPLocale()`` umbenannt, da die neue
  ``->setLocale()``-Methode den Locale-Wert (z.B. ``"de_de"``) in dem Objekt
  ändert (also ein normaler Setter ist).
* ``sly_Layout->setContent($content)`` wurde hinzugefügt.
* JavaScript wird in allen Layouts nun by Default vor dem schließenden Body-Tag
  ausgegeben. Dies betrifft noch nicht das Backend, da das Backend die Methoden
  des Layouts entsprechend überschreibt.
* **Utilities**

  * ``sly_Util_Array->merge()`` wurde entfernt.
  * ``sly_Util_Article::getUrl($articleId, $clang, $params)`` wurde hinzugefügt.
  * ``sly_Util_ArticleSlice::getModule($article_slice_id)`` wurde hinzugefügt.
  * ``sly_Util_Category::canReadCategory($user, $categoryId)`` wurde hinzugefügt.
  * ``sly_Util_HTTP::getAbsoluteUrl()`` kann nun auch explizit HTTPS-URLs
    erzeugt. Ebenso ``::getUrl()``.
  * ``sly_Util_Mime::getType($filename)`` kann auch mit Pseudo-Dateinamen
    aufgerufen werden (da von der Datei eh nur die Dateiendung interessiert).
  * ``sly_Util_Password::hash()`` ignoriert ``'0'`` oder ``0`` nicht mehr als
    Salt (nur leere Strings werden ignoriert).
  * ``sly_Util_Requirements`` wurde gekürzt: ``->gd()``, ``->xmlReader()``,
    ``->xmlWriter()``, ``->curl()``, ``->allowURLfopen()``,
    ``->shortOpenTags()``, ``->registerGlobals()`` und ``->magicQuotes()``
    wurden entfernt.
  * ``sly_Util_Slice`` wurde entfernt.
  * ``sly_Util_String`` verwendet die Multibyte-Funktionen soweit möglich.
  * ``sly_Util_String::preg_startsWith()`` wurde entfernt.
  * ``sly_Util_String::formatTimespan($seconds)`` wurde hinzugefügt.
  * ``sly_Util_Template`` wurde hinzugefügt.

* Der XHTML5-Head generiert nun kein ``xmlns``-Attribut mehr.

Services
""""""""

* ``sly_Service_Template_Exception`` wurde hinzugefügt.
* **AddOn- und Plugin-Service**

  * ``->loadConfig()`` und ``->loadStatic()`` sind nicht mehr public.
  * Die von ``->getSupportPageEx()`` zurückgelieferten Links verwenden den Namen
    des Autors für den Linktext.
  * ``->getRequirements()``, ``->getRequiredSallyVersions()``,
    ``->isCompatible()`` und ``->loadComponents()`` wurden hinzugefügt.
  * ``->loadAddon()`` und ``->loadPlugin()`` können über den neuen Parameter
    ``$force`` dazu gebracht werden, auch nicht installierte und aktivierte
    AddOns zu laden (für Unit-Tests). *(Sollte sparsam verwendet werden!)*

* **Artikel-Service**

  * ``->getMaxPosition($categoryID)`` wurde hinzugefügt.
  * ``->copy($id, $target)`` wurde hinzugefügt.
  * ``->move($id, $target)`` wurde hinzugefügt.
  * ``->convertToStartArticle($articleID)`` wurde hinzugefügt.
  * ``->copyContent($srcID, $dstID, $srcClang, $dstClang, $revision)`` wurde
    hinzugefügt.
  * ``->getStati()`` wurde in ``->getStates()`` umbenannt.
  * ``->deleteCache($id, $clang)`` wurde hinzugefügt.
  * ``->deleteListCache()`` wurde hinzugefügt.
  * ``->findArticlesByType()`` wird nun gecacht.

* **Kategorie-Service**

  * ``->getMaxPosition($parentID)`` wurde hinzugefügt.
  * ``->findTree($parentID, $clang)`` wurde hinzugefügt.
  * ``->move($categoryID, $targetID)`` wurde hinzugefügt.
  * ``->getStati()`` wurde in ``->getStates()`` umbenannt.
  * ``->deleteCache($id, $clang)`` wurde hinzugefügt.
  * ``->deleteListCache()`` wurde hinzugefügt.

* ``sly_Service_ArticleSlice`` wurde hinzugefügt.
* ``sly_Service_Factory::getArticleSliceService()`` wurde hinzugefügt.
* **Artikeltyp-Service**

  * ``const VIRTUAL_ALL_SLOT`` wurde hinzugefügt.
  * ``->getModules()`` wurde hinzugefügt (und im Template-Service entfernt).
  * ``->hasModule()`` wurde hinzugefügt (und im Template-Service entfernt).

* **Asset-Service**

  * ``->process($file, $encoding)`` erfragt Datei und Encoding vom Aufrufer
    (dem Asssetcache-Controller) und wirft bei Fehlern eine
    ``sly_Authorisation_Exception``.
  * ``->clearCache()`` hat keine Parameter mehr.

* ``sly_Service_MediaCategory->findTree($parentID, $clang)`` wurde hinzugefügt.
* **Modul-Service**

  * ``->getActions()`` wurde entfernt.
  * ``->getTemplates()`` wurde entfernt.
  * ``->hasTemplate()`` wurde entfernt.

* **Template-Service**

  * ``->getCacheFolder()``, ``->getGenerated()`` und ``->getCacheFile()``
    wurden entfernt.
  * ``->getModules()`` und ``->hasModule()`` wurden entfernt.
  * ``->isActive()`` wurde entfernt.

* **SliceValue-Service**

  * ``->save()`` wurde hinzugefügt.
  * ``->find()`` wurde hinzugefügt.
  * ``->findBySliceFinder()`` hat keinen Parameter ``$type`` mehr.

* **User-Service**

  * ``->add($login, $password, $active, $rights)`` wurde hinzugefügt.
  * ``->findById($id)`` wurde hinzugefügt.

Formular-Framework
""""""""""""""""""

* **sly_Form**

  * ``->setFocus()`` kann nun auch mit einem ``sly_Form_ElementBase``-Objekt
    aufgerufen werden.
  * ``->findElementByID()`` wurde hinzugefügt, um ein Element anhand seiner ID
    auszulesen.

* **sly_Form_Fieldset**

  * Fieldsets können nun eine Liste von zusätzlichen Attributen für das
    ``<fieldset>``-Tag verwalten.
  * ``->setAttribute()`` und ``->getAttribute()`` wurden hinzugefügt.

* ``sly_Form_Helper::getLanguageSelect($name, $user, $id)`` wurde hinzugefügt.
* **sly_Form_ElementBase**

  * ``->removeClass()``, ``->removeOuterClass()`` und ``->removeFormRowClass()``
    wurden hinzugefügt.
  * ``->setRequired()`` wurde hinzugefügt.

* ``sly_Form_Select_Base->setSelected()`` wurde hinzugefügt.
* **Widgets**

  * Es wurden Basisklassen für die Widgets in ``sly_Form_Widget_LinkBase`` und
    ``sly_Form_Widget_MediaBase`` hinzugefügt.
  * Link-Widgets (einzel & Liste)

    * ``->filterByCategory($cat, $recursive)`` wurde hinzugefügt. Darüber
      können die erlaubten Kategorien in der Linkmap eingeschränkt werden.
    * ``->filterByCategories($cats, $recursive)`` wurde als Helper für den
      wiederholten Aufruf von ``filterByCategory()`` hinzugefügt.
    * ``->filterByArticleTypes($types)`` wurde hinzugefügt. Darüber
      können die erlaubten Artikeltypen in der Linkmap eingeschränkt werden.
    * Für beide Filter gibt es Clearer: ``->clearCategoryFilter()`` und
      ``->clearArticleTypeFilter()``

  * Media-Widgets (einzel & Liste)

    * ``->filterByCategory($cat, $recursive)`` wurde hinzugefügt. Darüber
      können die erlaubten Kategorien im Medienpool eingeschränkt werden.
    * ``->filterByCategories($cats, $recursive)`` wurde hinzugefügt.
    * ``->filterByFiletypes($types)`` wurde hinzugefügt. Darüber
      können die erlaubten Dateitypen (angegeben als Liste von Dateiendungen) im
      Medienpool eingeschränkt werden.
    * Für beide Filter gibt es Clearer: ``->clearCategoryFilter()`` und
      ``->clearFiletypeFilter()``

* **Views**

  * Das fokussierte Element wird per Default über das ``autofucus``-Attribut
    gekennzeichnet. Es existiert ein JavaScript-Fallback, der bei alten Browsern
    ``.focus()`` aufruft.
  * Elemente liegen jetzt nicht mehr in einem ``<p>``, sondern einem ``<div>``.
  * Checkbox- oder Radiobox-Gruppen zeigen die "alle/keine"-Links nicht mehr an,
    wenn es nur ein Element gibt.
  * Die speziellen Widget-CSS-Relationen (``rel``-Attribute an den Icons) wurden
    in Klassen umgeformt (``rel="up"`` wurde zu ``class="fct-up"``).

Frontend-App
""""""""""""

* Das Frontend wurde als App re-implementiert. Dabei entstanden die folgenden
  Klassen:

  * ``sly_App_Frontend``
  * ``sly_Controller_Frontend_Article``
  * ``sly_Controller_Frontend_Base``
  * ``sly_Controller_Frontend_Asset``

* Es wurden Sprachdateien für die im Frontend von der App möglichen
  Fehlermeldungen -- es wird das Standard-Backendlocale verwendet, bevor z.B.
  der Artikel-Controller das Locale bestimmt hat.

Backend-App
"""""""""""

* jQuery wurde auf 1.7.1 aktualisiert, jQuery UI auf 1.8.17.
* Alle CSS-Klassen, die noch ``rex-`` im Namen hatten, wurde in ``sly-``
  umbenannt. Viele Klassen wurden auch entfernt und durch neue ersetzt.
* Assets müssen aufgrund der geänderten Verzeichnisstruktur nun wieder via
  ``../data/dyn/public/......`` verlinkt werden.
* Das mitgelieferte jQuery UI-Theme wurde mehr an das Backenddesign angepasst.
* Es wurden einige Icons aus den Assets entfernt.
* Die Sprachdateien des Backends wurden in großen Teilen umgebaut. Statt teils
  generischer Keys (``content_function_x``) kommen nun durchgängig sprechende
  Keys (``delete_article``) zum Einsatz. Es sind viele neue Verben hinzugekommen
  und AddOns sollten versuchen, wenn mögliche die mitgelieferten Übersetzungen
  zu verwenden.
* ``sly_App_Backend`` wurde hinzugefügt und übernimmt alle Aufgaben der Backend-
  Anwendung.
* Die ``specials``-Seite wurde in ``system`` umbenannt.
* Beim Installieren von AddOns und Plugins werden diese auch sofort aktiviert.
* Die Linkmap kann auf einzelne Kategorien (auf Wunsch rekursiv) eingeschränkt
  werden. Ebenso können die Artikeltypen vorausgewählt werden. Das Gleiche gilt
  für das Medienpool-Popup (hier natürlich mit Dateitypen statt Artikeltypen).
* Das Markup der Linkmap hat sich in großen Teilen geändert.
* ``sly_Layout_Backend`` leitet sich jetzt von ``sly_Layout_XHTML5`` ab.

  * Dem ``<body>``-Tag werden die Klassen ``sly-0``, ``sly-0_6`` und ``sly-0_6_0``
    hinzugefügt.
  * Die ID des ``<body>``-Tags wurde von ``rex-page...`` in ``sly-page-...``
    umbenannt.
  * Bei ``pageHeader()`` muss nun die Liste der Submenü-Seiten nicht mehr mit
    übergeben werden. Die Navigation wird sich an der Backend-Navigation
    orientieren und die Seiten daher automatisch ermitteln.
  * ``pageHeader()`` erwartet ein Page-Objekt oder ein Array von assoziativen
    Arrays mit den Menü-Daten (früher wurde ein Array von normalen Arrays
    erwartet). Die assoziativen Arrays können die Keys ``page``, ``label``,
    ``forced``, ``extra`` und ``class`` enthalten.

    * ``forced`` (boolean) legt fest, ob der Menüeintrag als aktiv angezeigt
      werden soll.
    * ``extra`` (array) sind weitere Parameter für den Link, die auch bei der
      Ermittlung der aktiven Seite herangezogen werden.
    * ``class`` (string) sind die CSS-Klassen für die erzeugten ``<li>``-Tags.

  * An den generierten Links im Submenü werden die Klassen ``sly-first``,
    ``sly-last`` und ``sly-active`` verwendet.
  * Die Navigation kann direkt von der Layout-Instanz abgerufen werden:
    ``$layout->getNavigation()``

* Die Navigation des Backends wird im Konstruktor von
  ``sly_Layout_Navigation_Backend`` eingerichtet. Backend-Seiten, die nicht im
  Menü zu sehen sind, werden auch nicht mehr der Navigation hinzugefügt.
* ``sly_Layout_Navigation_Backend->createGroup()`` wurde entfernt.
* ``sly_Layout_Navigation_Subpage``-Instanzen können eine Liste von weiteren
  Parametern erhalten. Diese Parameter werden an die URL zum Controller
  angefügt und beim Ermitteln der aktuellen Seite ausgewertet. So ist es
  möglich, mit einem Controller mehrere Backend-Seiten im Menü anzuzeigen (ohne
  dass es zu Konflikten in der Anzeige kommt).

  * neue Methode: ``->getExtraParams()``
  * neue Methode: ``->getForcedStatus()``
  * neue Methode: ``->setExtraParams(array $params)``
  * neue Methode: ``->matches($subpagePageParam, array $extraParams = array())``

* Die AddOn-Verwaltung wurde neu implementiert und nutzt Ajax, um die vielen
  Reloads der Seite zu vermeiden. Damit gehen keine größeren API-Änderungen
  einher.
* Die IDs von Artikeln/Dateien werden nicht mehr für Admins extra angezeigt, da
  es auch kein Benutzerrecht für den "erweiterten Modus" mehr gibt.

Events
""""""

* ``ALL_GENERATED`` wurde in ``SLY_CACHE_CLEARED`` umbenannt.
* ``PAGE_CHECKED`` wird vom Core ausgeführt und wurde als deprecated markiert.
  Neuer Code sollte eher ``SLY_CONTROLLER_FOUND`` nutzen:
* ``SLY_CONTROLLER_FOUND`` wird ausgeführt, wenn der Controller ermittelt wurde.
  Dem Event wird die Controller-Instanz als Subject übergeben, sowie der Name
  (``name``), die App-Instanz (``app``) und die auszuführende Action
  (``action``) als weitere Parameter.
* Über das Filter-Event ``SLY_FRONTEND_ROUTER`` können Listener den Router im
  Frontend mit eigenen Routen erweitern oder sogar die Instanz ganz austauschen.
  Ein vorbereiteter ``sly_Router_Base`` wird als Subject, die App als ``app``
  übergeben.
* Das Event ``OUTPUT_FILTER_CACHE`` wurde entfernt. Stattdessen können AddOns
  jetzt die finale Ausgabe an den Client in ``SLY_RESPONSE_SEND`` (erhält das
  Response-Objekt als Subject) abgreifen.
* Das Subject von ``SLY_MEDIAPOOL_MENU`` ist nun das Backend-Seiten-Objekt
  (``sly_Layout_Navigation_Page``) anstatt des Submenüs als Array. Listeners
  müssen die API des Objekts nutzen, um das Menü zu erweitern.
* ``SLY_OOMEDIA_IS_IN_USE`` wurde in ``SLY_MEDIA_USAGES`` umbenannt.
* ``SLY_PAGE_USER_SUBPAGES`` wurde entfernt (AddOns sollten einfach die
  Backend-Navigation entsprechend erweitern). Dito für ``SLY_SPECIALS_MENU``.
* ``SLY_SLICE_POSTVIEW_ADD`` wird immer ein leeres Array als Subject übergeben.
* Das Event ``PAGE_MEDIAPOOL_MENU`` wurde in ``SLY_MEDIAPOOL_MENU`` umbenannt.
  Statt dem Submenü wird dem Event als Subject das Navigation-Page-Objekt des
  Medienpools übergeben.
* Im Event ``SLY_ART_CONTENT_COPIED`` wird kein ``start_slice`` mehr übergeben,
  da beim Kopieren des Inhalts nun immer **alle** Slices kopiert werden.
* ``SLY_ART_COPIED`` erhält nun den kopierten Artikel als Subject und nur noch
  den Quellartikel als ``source``. Alle weiteren Parameter wurden entfernt.
* ``CLANG_ARTICLE_GENERATED`` wurde entfernt.
* ``SLY_PRE_PROCESS_ARTICLE`` wurde entfernt und durch das Notify-Event
  ``SLY_CURRENT_ARTICLE`` ersetzt, in dem Listener den anzuzeigenden Artikel
  nicht mehr verändern dürfen.
* Der Artikel-Controller feuert das Filter-Event ``SLY_ARTICLE_OUTPUT``, über
  das Listener direkt auf die Ausgabe im Frontend zugreifen können. In vielen
  Fällen wollen AddOns nur die Frontend-Ausgabe von Templates verändern, anstatt
  auch Ausgaben wie RSS-Feeds oder Bilder zu verarbeiten. Hier macht es dann
  Sinn, einfach auf ``SLY_ARTICLE_OUTPUT`` zu lauschen.
* Das Filter-Event ``SLY_RESOLVE_ARTICLE`` wird vom Artikel-Controller gefeuert,
  um den aktuellen Artikel zu ermitteln. Das Subject ist anfangs null, ein
  erfolgreicher Listener sollte ein ``sly_Model_Article``-Objekt zurückgeben.
  Listener, die bereits ein Objekt als Eingabe erhalten sollten dieses
  ungeändert weiterreichen. Wird kein Artikel gefunden, wird der
  NotFound-Artikel angezeigt.

rex_vars
""""""""

* wurden vollständig und ersatzlos entfernt
* ``sly_Slice_Values`` und ``sly_Slice_Helper`` stellen nun die Hilfs-API zur
  Verfügung (siehe Feature-Beschreibung am Anfang der Seite oder die
  :doc:`Dokumentation </frontend-devel/develop/slicehelper>`).

Unit-Tests
""""""""""

* Die Zahl der Testcases wurde 280 mit insgesamt 633 Assertions erhöht.
* Für AddOns steht ein Bootstraping von Sally sowie eine Basis-Klasse für
  Testcases bereit. Siehe auch die :doc:`Unit-Test Dokumentation </addon-devel/extended/testing>`.

Sonstiges
"""""""""

* Die mitgelieferte :file:`.htaccess` enthält nun bereits die Catch-All-Regeln,
  die bisher von realurl-AddOns extra hinzugefügt werden mussten.
* Das ``internal_encoding`` (``mbstring``-Extension) wird auf ``UTF-8`` gesetzt.
