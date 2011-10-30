Sonstige Core-Events
====================

.. hlist::
   :columns: 3

   * :ref:`page-content-header`

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

.. slyevent:: SLY_LISTENERS_REGISTERED
  :type:    notify
  :in:      null
  :subject: N/A

  Dieses Event wird ausgelöst, nachdem der Systemkern alle
  :doc:`Event-Listener </developing/listeners>` aus den Konfigurationsdateien
  (``LISTENERS``) registriert hat.

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
