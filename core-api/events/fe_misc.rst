Frontend-App
============

Die folgenden Events werden von der Frontend-App ausgeführt.

.. slyevent:: SLY_FRONTEND_ROUTER
  :type:    filter
  :in:      sly_Router_Base
  :out:     sly_Router_Base
  :since:   0.6
  :subject: der Router der Frontend-App
  :params:
    app  (sly_App_Frontend)

  Dieses Event dient dazu, die einzelnen Routen der AddOns zu sammeln. Der
  Router ist am Anfang leer (enthält keine Routen) und sollte von den Listenern
  nach und nach befüllt werden. Im Anschluss wird auf einen Match geprüft.

  Der Router dient **nicht** dazu, den aktuellen Artikel zu ermitteln.
  Stattdessen wird hier erst entschieden, welcher Controller zum Einsatz kommen
  soll. Das Auflösen des Artikels wird später in ``SLY_RESOLVE_ARTICLE`` vom
  Artikel-Controller durchgeführt.
