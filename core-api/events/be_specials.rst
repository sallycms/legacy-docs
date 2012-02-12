Systemseite
===========

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
