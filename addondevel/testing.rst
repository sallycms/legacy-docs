AddOn-Entwicklung: Unit-Tests
=============================

Sally verwendet für die Tests des Cores PHPUnit_, um automatisiert die einzelnen
APIs zu testen. Zu diesem Zweck wird die Backend-App in einem "Offline-Modus"
geladen und danach anstatt die Tests ausgeführt anstatt einen angefragten
Controller zu suchen und auszuführen. Das hat den Vorteil, dass die Tests auch
ohne Browser von Werkzeugen wie phpUnderControl_ ausgeführt werden können.

Der gleiche Mechanismus steht AddOns ebenfalls zur Verfügung. Damit ist es sehr
einfach, in einem AddOn-Paket auch Tests mitzuliefern, ohne sich groß um die
dahinterstehende Infrastruktur zu kümmern.

.. _PHPUnit: https://github.com/sebastianbergmann/phpunit/
.. _phpUnderControl: http://phpundercontrol.org/

Grundlagen
----------

Grundsätzlich ist es möglich, die von PHPUnit bereitgestellten Klassen (wie
``PHPUnit_Framework_TestCase``) direkt zu verwenden. Allerdings wird empfohlen,
die eigenen Testcases von ``sly_BaseTest`` abzuleiten. Im Moment stehen darüber
einige Hilfsmethoden zum Umgang mit Sally bereit, später könnte sie allerdings
auch das Bootstraping (siehe unten) übernehmen.

Tests, die sich direkt von PHPUnit ableiten, haben per se keinen Zugriff auf die
Datenbank von Sally -- auch hier hilft es, sich von ``sly_BaseTest`` abzuleiten
(die Klasse kümmert sich um die Weiterreichung der Datenbankverbindung von Sally
an PHPUnit).

Boostraping
-----------

Sally stellt ein Script zur Verfügung, um eine "Offline"-Version hochzufahren.
AddOns wird empfohlen, dieses Script einfach einzubinden und danach die eigenen
Tests zu starten.

Zu diesem Zweck kann ein AddOn wie folgt aufgebaut sein.

::

  /
  +- assets/
  +- lib/
  +- tests/
  |  +- MyAddon/
  |  |  +- BasicTest.php
  |  |  +- HardcoreTest.php
  |  |  +- NightlyTest.php
  |  |  +- ...
  |  +- bootstrap.php
  |  +- run.sh
  +- config.inc.php
  +- static.yml

bootstrap.php
^^^^^^^^^^^^^

Die bootstrap.php ist verantwortlich dafür, Sally hochzufahren und die zu
verwendende Umgebung zu definieren. Dabei kann beispielsweise der Pfad zu den
AddOns auf ein anderes als ``sally/addon`` umgeleitet werden, ebenso der Pfad
zum Develop-Verzeichnis oder der Medienpool. Dies ist besonders nützlich, wenn
Tests bestimmte Module benötigen.

Eine minimale Version könnte wie folgt aussehen:

.. sourcecode:: php

  <?php

  $here      = dirname(__FILE__);
  $sallyRoot = realpath(__DIR__.'/../../../../');

  // set our own environment (all of them are optional)
  define('SLY_ADDONFOLDER',   $sallyRoot.'/sally/addons');
  define('SLY_DEVELOPFOLDER', $sallyRoot.'/develop');
  define('SLY_MEDIAFOLDER',   $sallyRoot.'/data/mediapool');

  // bootstrap the tests
  require $sallyRoot.'/sally/tests/bootstrap.php';

  // make tests autoloadable
  sly_Loader::addLoadPath(dirname(__FILE__));

run.sh
^^^^^^

Diese Datei steht beispielhaft für ein Script, dass die Tests auf der Shell
ausführt. Es kann sich dabei genauso gut um eine Windows-Batchfile handeln.

Beim Aufruf von PHPUnit ist nur zu beachten, dass das bootstrap-Script korrekt
angegeben wird.

::

  phpunit --strict --bootstrap bootstrap.php %* tests

Unter Windows sollte dem Aufruf ``call`` vorangestellt werden, damit das Script
bis zum Ende von PHPUnit wartet:

::

  @echo off
  call phpunit --strict --bootstrap bootstrap.php %* tests

eigene Tests
^^^^^^^^^^^^

Die eigenen Tests können nun frei im ``tests``-Verzeichnis organisiert werden
(und müssen dabei den normalen Regeln des Sally-Autoloaders folgen). Ein
minimaler Testcase könnte dabei wie folgt aussehen:

.. sourcecode:: php

  <?php

  class MyAddon_BasicTest extends sly_BaseTest {
     protected function getDataSetName() {
        return 'pristine-sally';
     }

     protected function getRequiredComponents() {
        return array('developer_utils', 'metainfo');
     }

     public function testGetArticle() {
        $this->assertTrue(true);
     }
  }

Die obigen Methoden werden im Folgenden beschrieben.

Unit-Test API
-------------

Allen Tests, die sich von ``sly_BaseTest`` ableiten, steht die folgende API zur
Verfügung:

``loadComponent($component)``
  Mit dieser Methode kann ein AddOn oder Plugin explizit geladen werden, selbst
  wenn es nicht installiert oder aktiviert ist. Die benötigten AddOn wird man
  allerdings meistens eher über die zu implementierende ``getRequiredComponents()``
  angeben.

Es müssen dabei die folgenden zwei Methoden implementiert werden (im obigen
Beispiel sieht man zwei gültige Implementierungen).

``protected function getDataSetName()``
  Muss entweder ``pristine-sally`` für eine leere Sally-Installation mit nur
  einem Backend-Benutzer oder ``sally-demopage``, um die Datenbank mit dem
  Inhalt der Sally-Demopage befüllen zu lassen.

Außerdem können die folgenden Methoden re-implementiert werden:

``protected function getRequiredComponents()``
  Muss ein Array mit den zu ladenden Komponenten zurückgeben. Abhängigkeiten
  werden nicht beachtet und müssen daher bereits aufgelöst in der Liste
  vollständig notiert werden.

``protected function getAdditionalDataSets()``
  Muss ein Array mit weiteren Datasets zurückgeben. Die Datasets müssen native
  PHPUnit-Dataset-Instanzen sein, die im Anschluss an das Core-Dataset (siehe
  ``getDataSetName()``) geladen werden sollen.
