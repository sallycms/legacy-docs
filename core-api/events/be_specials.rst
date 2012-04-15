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
