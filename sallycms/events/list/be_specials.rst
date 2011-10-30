Systemseite
===========

.. hlist::
   :columns: 3

   * :ref:`page-content-header`

.. slyevent:: SLY_SPECIALS_MENU
  :type:    filter
  :in:      array
  :out:     array
  :subject: die vom Core vorgegebenen Menüpunkte
  :params:
    page (``sly_Layout_Navigation_Page``)  das Navigationsobjekt für die Systemseite

  wird ausgeführt, bevor das Submenü der Systemseite ausgegeben wird

.. =============================================================================

.. slyevent:: SLY_SETTINGS_UPDATED
  :type:    notify
  :in:      null
  :subject: N/A

  Wird ausgeführt, nachdem die auf der Systemseite angegebenen Einstellungen
  (Startartikel, Caching-Strategie, ...) gespeichert wurden.

.. =============================================================================

.. slyevent:: ALL_GENERATED
  :type:    filter
  :in:      string
  :out:     string
  :subject: die Erfolgsnachricht

  Wird ausgeführt, nachdem der Core-Cache (Artikel, Templates, ...) geleert
  wurde. Alle Bestandteile des Systems, die Daten in irgendeiner Art cachen,
  sollten auf dieses Event reagieren und ihren Cache **vollständig** leeren.

.. note::

  Im laufenden Betrieb sollte es nie nötig sein, dieses Event auszulösen, um
  Caches zu invalidieren.
