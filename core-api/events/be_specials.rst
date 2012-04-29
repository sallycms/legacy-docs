Systemseite
===========

.. slyevent:: SLY_SETTINGS_UPDATED
  :type:    notify
  :in:      null
  :subject: N/A
  :params:
    originals (array)  assoziatives Array (seit v0.6.3)

  Wird ausgeführt, nachdem die auf der Systemseite angegebenen Einstellungen
  (Startartikel, Caching-Strategie, ...) gespeichert wurden. ``originals`` ist
  ein assoziatives Array, das die ursprüngliche Werte für die folgenden
  Konfigurationselemente enthält: ``START_ARTICLE_ID``, ``NOTFOUND_ARTICLE_ID``,
  ``DEFAULT_CLANG_ID``, ``DEFAULT_ARTICLE_TYPE``, ``DEVELOPER_MODE``,
  ``DEFAULT_LOCALE``, ``PROJECTNAME``, ``CACHING_STRATEGY``, ``TIMEZONE``.

.. slyevent:: SLY_SYSTEM_CACHES
  :type:    filter
  :in:      sly_Form_Select_Checkbox
  :out:     sly_Form_Select_Checkbox
  :subject: das Formularelement für alle Checkboxen
  :since:   0.6.4

  Dieses Event wird von der Systemseite ausgeführt, um AddOns die Möglichkeit
  zu geben, ihre Cache-löschen-Aktionen konfigurierbar zu machen. AddOns können
  neue Elemente zum Checkbox-Element hinzufügen und diese dann abfragen, um
  beispielsweise nicht immer ihren eigenen Cache zu leeren.

  Ob eine Checkbox schlussendlich ausgewählt wurde, kann vom System-Controller
  erfragt werden.

Der folgende Code demonstriert, wie dieses Event genutzt werden kann.

.. sourcecode:: php

  <?
  // klassisches Registrieren auf die Events
  $dispatcher = sly_Core::dispatcher();
  $dispatcher->register('SLY_SYSTEM_CACHES', 'addMyCacheOptions');
  $dispatcher->register('SLY_CACHE_CLEARED', 'clearMyCache');

  // Listener, um die Checkbox-Liste zu erweitern
  function addMyCacheOptions(array $params) {
     $select   = $params['subject'];
     $selected = $select->getValue();

     // eigene Optionen ergänzen
     $select->addValue('myaddon',  'Datencache von myaddon löschen');
     $select->addValue('myaddon2', 'Daten gründlich prüfen & Datenbank neu aufbauen (dauert Ewigkeiten)');

     // Vorauswahl der eigenen Optionen (optional)
     $selected[] = 'myaddon';
     $selected[] = 'myaddon2';

     // selected-Status am Formularlement aktualisieren
     $select->setSelected($selected);

     // fertig
     return $select;
  }

  // eigentlicher Listener für das Cache-leeren
  // WICHTIG: Das Event SLY_CACHE_CLEARED kann von überall aus aufgerufen werden.
  // Dieser Listener darf sich also nicht darauf verlassen, dass jemand im
  // Backend auf den Button geklickt hat. Wird das Cache-leeren per API
  // ausgelöst (jemand ruft sly_Core::clearCache() auf), sollten AddOns
  // immer *alle* Aufräumarbeiten ausführen, die sie mitbringen.
  function clearMyCache(array $params) {
    $isSystem   = sly_Core::getCurrentControllerName() === 'system';
    $controller = sly_Core::getCurrentController();
    $clearData  = !$isSystem || $controller->isCacheSelected('myaddon');
    $rebuild    = !$isSystem || $controller->isCacheSelected('myaddon2');

    if ($clearData) {
      sly_Core::cache()->flush('myaddon', true);
    }

    if ($rebuild) {
      // phase 1
      doVeryComplexDatabaseChecks();

      // phase 2
      // ?

      // phase 3
      profit();
    }

    return $params['subject'];
  }
