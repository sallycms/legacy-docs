Sonstige Core-Events
====================

.. slyevent:: __AUTOLOAD
  :type:    until
  :in:      string
  :out:     void
  :since:   0.1.0
  :subject: der volle Name der zu ladenden Klasse

  Dieses Event wird ausgelöst, wenn eine zu ladende Klasse von ``sly_Loader``
  nicht gefunden werden konnte. Listener können hierüber Klassen laden, die
  nicht dem Standard-Layout für Klassennamen folgen.

  Der Rückgabewert des Events wird nicht weiter ausgewertet, es ist also
  irrelevant, was ein Listener zurückgibt, wenn er eine Klasse geladen hat.

.. warning::

  Die Verwendung dieses Events ist *deprecated*, da es sich hierbei mehr um ein
  Relikt aus REDAXO 4.2-Zeiten handelt. Alle Komponenten des Systems sollten
  ihre Klassen in einer autoloadbaren Struktur mitbringen.

.. =============================================================================

.. slyevent:: ADDONS_INCLUDED
  :type:    notify
  :in:      null
  :subject: N/A

  Dieses Event wird ausgelöst, nachdem der Systemkern alle aktivierten AddOns
  und Plugins geladen hat. In den meisten Fällen es ist ratsam,
  Initialisierungen von AddOns mindestens bis zu diesem Event aufzuschieben.
  Das ermöglicht es, dass alle Event-Listener bereits registriert sind.

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

.. slyevent:: OUTPUT_FILTER_CACHE
  :type:    notify
  :in:      string
  :subject: der finale HTML-Code

  Nachdem Listener in ``OUTPUT_FILTER`` ihre letzten Änderungen vorgenommen
  haben, ist das Subject in diesem Event readonly und eignet sich daher ideal
  zum Cachen der Seite. Zwischen diesem Event und dem Senden des Inhalts an den
  Client besteht keine Möglichkeit mehr, den Inhalt zu verändern.

.. =============================================================================

.. slyevent:: SLY_DB_IMPORTER_AFTER
  :type:    filter
  :in:      string
  :out:     string
  :subject: die Erfolgsnachricht vom Core
  :params:
    dump     (sly_DB_Dump)  der eingespielte Dump
    filename (string)       der Dateiname des eingespielten Dumps
    filesize (int)          die Dateigröße des Dumps in Byte

  Dieses Event wird ausgelöst, nachdem ein Datenbank-Dump importiert wurde. Es
  wird auch während der Sally-Setups ausgeführt, allerdings kann zu diesem
  Zeitpunkt noch niemand lauschen.

  AddOns mit komplexen Daten (insbesondere solche, deren Daten auf
  Konfigurationsdateien basieren) sollten auf dieses Event lauschen und dann
  ihre Daten überprüfen / neu aufbauen. So kann es passieren, dass bspws.
  Metadaten von Artikeln fehlen, weil die Konfiguration zwischenzeitlich
  erweitert wurde. In diesem Fall müsste das dafür zuständige AddOn (Metainfo)
  bei diesem Event die überschüssigen Daten entfernen und fehlende ergänzen.

  Im Anschluss an dieses Event wird der Cache geleert (es wird ``ALL_GENERATED``
  ausgeführt).

.. =============================================================================

.. slyevent:: SLY_DB_IMPORTER_BEFORE
  :type:    filter
  :in:      string
  :out:     string
  :subject: Hinweisnachricht (initial ein leerer String)
  :params:
    dump     (sly_DB_Dump)  der eingespielte Dump
    filename (string)       der Dateiname des eingespielten Dumps
    filesize (int)          die Dateigröße des Dumps in Byte

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
  :doc:`Event-Listener </developing/listeners>` aus den Konfigurationsdateien
  (``LISTENERS``) registriert hat.

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

.. slyevent:: SLY_PRE_PROCESS_ARTICLE
  :type:    filter
  :in:      sly_Model_Article
  :out:     sly_Model_Article
  :subject: der ermittelte Artikel (die meisten realurl-Implementierungen
            haben bereits den Request abgearbeitet, sodass hier beispielsweise
            bei RealURL2 bereits der richtige Artikel bereitsteht)

  gibt Listenern und AddOns eine letzte Chance, den anzuzeigenden Artikel zu
  verändern, bevor dessen Template schlussendlich eingebunden und ausgeführt
  wird
