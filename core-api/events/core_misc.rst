Sonstige Core-Events
====================

.. slyevent:: SLY_ADDONS_LOADED
  :type:    notify
  :in:      sly_Container
  :since:   0.7.0
  :subject: der verwendete Container

  Dieses Event wird ausgelöst, nachdem der Systemkern alle aktivierten AddOns
  und Plugins geladen hat. In den meisten Fällen es ist ratsam,
  Initialisierungen von AddOns mindestens bis zu diesem Event aufzuschieben.
  Das ermöglicht es, dass alle Event-Listener bereits registriert sind.

  Dieses Event hieß vor 0.7 ``ADDONS_INCLUDED``. Seit Version 0.8.3 wird der
  Container übergeben, vorher war das Subject ``null``.

.. =============================================================================

.. slyevent:: OUTPUT_FILTER
  :type:    filter
  :in:      string
  :out:     string
  :subject: der vollständige, generierte HTML-Code
  :params:  environment (string) 'frontend' oder 'backend'

  ermöglicht eine letzte Korrktur/Erweiterung der Ausgabe, bevor sie an den
  Client gesendet wird

.. =============================================================================

.. slyevent:: SLY_DB_IMPORTER_AFTER
  :type:    notify
  :in:      sly_DB_Dump
  :subject: der eingespielte Dump
  :params:
    filename  (string)  der Dateiname des eingespielten Dumps
    filesize  (int)     die Dateigröße des Dumps in Byte

  Dieses Event wird ausgelöst, nachdem ein Datenbank-Dump importiert wurde. Es
  wird auch während der Sally-Setups ausgeführt, allerdings kann zu diesem
  Zeitpunkt noch niemand lauschen.

  AddOns mit komplexen Daten (insbesondere solche, deren Daten auf
  Konfigurationsdateien basieren) sollten auf dieses Event lauschen und dann
  ihre Daten überprüfen / neu aufbauen. So kann es passieren, dass bspws.
  Metadaten von Artikeln fehlen, weil die Konfiguration zwischenzeitlich
  erweitert wurde. In diesem Fall müsste das dafür zuständige AddOn (Metainfo)
  bei diesem Event die überschüssigen Daten entfernen und fehlende ergänzen.

  Im Anschluss an dieses Event wird der Cache geleert (es wird ``SLY_CACHE_CLEARED``
  ausgeführt).

.. =============================================================================

.. slyevent:: SLY_DB_IMPORTER_BEFORE
  :type:    notify
  :in:      sly_DB_Dump
  :subject: der einzuspielende Dump
  :params:
    filename (string)  der Dateiname des eingespielten Dumps
    filesize (int)     die Dateigröße des Dumps in Byte

  Dieses Event wird ausgelöst, bevor ein Datenbank-Dump importiert wurde.
  Listener können nur die später auszugebende Erfolgsnachricht um eigene Infos
  erweitern. In den meisten Fällen wird man sich eher in
  ``SLY_DB_IMPORTER_AFTER`` hängen wollen.

.. =============================================================================

.. slyevent:: SLY_LISTENERS_REGISTERED
  :type:    notify
  :in:      null
  :subject: N/A

  Dieses Event wird ausgelöst, nachdem der Systemkern alle
  :doc:`Event-Listener </frontend-devel/listeners>` aus den
  Konfigurationsdateien (``LISTENERS``) registriert hat.

.. =============================================================================

.. slyevent:: SLY_MAIL_CLASS
  :type:    filter
  :in:      string
  :out:     string
  :subject: der Klassenname, initial ``'sly_Mail'``

  Über dieses Event kann der Name der Klasse, über die eine eMail verschickt
  wird, angepasst werden. So können PHPMailer oder Swiftmailer in Sally
  integriert werden, ohne dass die Mail verschickenden Komponenten davon etwas
  bemerken.

.. =============================================================================

.. slyevent:: SLY_CACHE_CLEARED
  :type:    notify
  :since:   0.6
  :in:      null
  :subject: N/A

  Wird ausgeführt, nachdem der Core-Cache (Artikel, Templates, ...) geleert
  wurde. Alle Bestandteile des Systems, die Daten in irgendeiner Art cachen,
  sollten auf dieses Event reagieren und ihren Cache **vollständig** leeren.
  Früher war dieses Event als ``ALL_GENERATED`` bekannt.

  Seit Version 0.7 ist dieses Event ein **notify**-Event. Listener müssen ihre
  Meldungen seither über die Flash-Message ausgeben.

.. note::

  Im laufenden Betrieb sollte es nie nötig sein, dieses Event auszulösen, um
  Caches zu invalidieren.

.. =============================================================================

.. slyevent:: SLY_SEND_RESPONSE
  :type:    notify
  :since:   0.6
  :in:      sly_Response
  :subject: die zu sendende Response

  Wird ausgeführt kurz bevor die Response schlussendlich an den Client
  geschickt wird. Listeners sollten in diesem Event keine Änderungen mehr am
  Inhalt vornehmen, sondern nur lesend auf die Response zugreifen.

.. =============================================================================

.. slyevent:: SLY_DEVELOP_REFRESHED
  :type:    notify
  :in:      null
  :subject: N/A

  Wird ausgeführt nachdem die Develop-Inhalte (Templates und Module)
  synchronisiert wurden (nur, wenn sich tatsächlich etwas geändert hat, nicht
  bei jedem Request).
