Error Handling
==============

Sally enthält ab Version 0.5 einen einfachen, integrierten Error Handler, der
primär für den Produktivbetrieb gedacht ist und aufgetretene Fehler abfängt und
loggt. Damit wird sichergestellt, dass die Besucher einer Seite keine
Fehlermeldungen von PHP oder (im schlimmsten Fall) den Stacktrace einer
ungefangenen Exception sehen.

Konfiguration
-------------

Der Error Handler hat keine besondere Konfiguration. Er wird über die
Einstellung **Entwicklermodus** konfiguriert. Die in den beiden Umgebungen
verwendeten Error-Levels können im Moment nicht konfiguriert werden.

Entwicklungsumgebung
--------------------

Wenn der Entwicklermodus aktiv ist, wird ein Null-Errorhandler geladen, der nur
das `Error-Reporting <http://www.php.net/manual/en/function.error-reporting.php>`_
auf ``E_ALL | E_STRICT | E_DEPRECATED`` setzt und die Anzeige von Fehlern
einschaltet. Es findet sonst keine besondere Behandlung von Fehlern statt.

Produktivumgebung
-----------------

In dieser Umgebung werden Fehler nicht mehr angezeigt, sondern nur noch über
:doc:`sly_Log <logging>` geloggt. Die Logdatei befindet sich damit in
:file:`sally/data/dyn/internal/sally/logs/errors.log`. Die Logdatei wird beim
Erreichen von 1 MB rotiert, wobei maximal 10 Dateien aufgehoben werden (siehe
sly_Log-Doku).

.. note::

  Das Logging über die PHP-Einstellung ``log_errors`` wird ebenfalls
  **abgeschaltet**.

Fehlerseite
^^^^^^^^^^^

Wenn fatale Fehler auftreten, wird der Seitenaufbau abgebrochen und eine
neutrale Fehlerseite angezeigt (inklusive eines HTTP 500 Headers). Die
Fehlerseite ist fest und für alle Projekte gleich.

Wer sie überschreiben möchte, kann eine Datei :file:`develop/error.phtml`
anlegen, die dann anstelle der Sally-Version eingebunden wird. In der Datei
steht die Variable ``$errors`` zur Verfügung, die entweder eine Exception ist,
oder ein Array mit den Infos zu dem Fehler, der zum Abbruch geführt hat. In der
benutzerdefinierten Fehlerseite sollte keinesfalls großflächig auf *irgendeine*
API zugegriffen werden: Die Datei wird eingebunden, wenn das Kind bereits in den
Brunnen gefallen ist. Dass noch Teile der API von Sally oder einem AddOn
funktionieren, kann nicht garantiert werden. Hier sollte man also so wenig wie
möglich PHP-Code einsetzen.

API
---

Der Sally-Error-handler kann über ``sly_Core::getErrorHandler()`` abgerufen und
über ``::setErrorHandler()`` überschrieben werden. Damit der neue Error Handler
auch von PHP verwendet wird, muss er dann noch initialisiert werden.

Im Folgenden soll gezeigt werden, wie der native Error Handler mit einem eigenen
überschrieben werden kann. Der eigene Handler soll dann die Fehler nicht loggen,
sondern eine speziellere Prozedur durchlaufen (die sich der Autor gerade nicht
ausdenken kann).

.. sourcecode:: php

  <?
  // der eigene Error Handler muss dieses Interface implementieren
  class MyErrorHandler implements sly_ErrorHandler {
     public function init() {
        // setze das gewünschte Error-Reporting
        // und registriere sich selbst als Error Handler

        // error_reporting(...);
        set_error_handler(array($this, 'handleError'));
        set_exception_handler(array($this, 'handleException'));
     }

     public function uninit() {
        restore_exception_handler();
        restore_error_handler();
     }


     /**
      * @param int    $severity
      * @param string $message
      * @param string $file
      * @param int    $line
      * @param array  $context
      */
     public function handleError($severity, $message, $file, $line, array $context) {
        // Hier muss noch einmal das Error Level geprüft werden, da die Methode auch
        // aufgerufen wird, wenn das Error Handling über @ unterdrückt wird.

        $errorLevel = error_reporting();

        if ($severity & $errorLevel) {
           // Error Handling hier
        }
     }

     /**
      * @param Exception $exception
      */
     public function handleException(Exception $exception) {
        // Error Handling hier
     }
  }

Diese eigene Klasse kann dann (z.B. von einem AddOn) wie folgt registriert
werden:

.. sourcecode:: php

  <?
  $myHandler  = new MyErrorHandler();
  $oldHandler = sly_Core::getErrorHandler();

  // alten Handler "abschalten" (muss *vor* dem init() des neuen Handlers passieren!)
  $oldHandler->uninit();

  // neuen Handler einschalten
  $myHandler->init();

  // im System bekannt machen
  sly_Core::setErrorHandler($myHandler);
