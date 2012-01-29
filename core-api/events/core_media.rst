Medium-Models
=============

.. slyevent:: SLY_OOMEDIA_IS_IN_USE
  :type:    filter
  :in:      array
  :out:     array
  :subject: die vom Core ermittelten Nutzungen des Mediums
  :params:
    filename (string)                der Dateiname
    media    (``sly_Model_Medium``)  das Medium-Objekt

  Über dieses Event kann ein Listener die Liste derjenigen Objekte, die das
  Medium referenzieren, erweitert werden. So können auch gänzlich fremde Inhalte
  (beispielsweise Produkte aus varisale) dafür sorgen, dass der Medienpool das
  Löschen einer Datei verhindert, da sie noch benötigt wird.

  Jedes Element im (Subject sowie Rückgabewert) ist wiederum ein Array, das aus
  den Elementen ``title`` (Anzeigetitel), ``type`` (beliebiger String, der zur
  Unterscheidung zwischen Elementen mit gleicher ID dient, beispielsweise
  ``'myobject'``), ``id`` (die ID des referenzierenden Elements), ``clang``
  (die Sprach-ID), ``link`` (ein relativer Link zur Backendseite, auf der die
  Referenz zum Bild bearbeitet/entfernt werden kann, beispielsweise
  ``index.php?page=...&id=...``) besteht.
