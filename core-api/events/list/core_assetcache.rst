Asset-Cache
===========

Die vom Asset-Cache gefeuerten Events dienen dazu, geschützte (private) Dateien
zu ermitteln und kodierte Namen (wie bei Image-Resize) aufzulösen.

Die Namen der Events stehen als Klassenkonstanten bereit und sollten auch
darüber referenziert werden.

.. sourcecode:: php

  <?

  class sly_Service_Asset {
    const EVENT_PROCESS_ASSET        = 'SLY_CACHE_PROCESS_ASSET';
    const EVENT_REVALIDATE_ASSETS    = 'SLY_CACHE_REVALIDATE_ASSETS';
    const EVENT_GET_PROTECTED_ASSETS = 'SLY_CACHE_GET_PROTECTED_ASSETS';
    const EVENT_IS_PROTECTED_ASSET   = 'SLY_CACHE_IS_PROTECTED_ASSET';

    // ...
  }

  // Beispiel
  sly_Core::dispatcher()->register(sly_Service_Asset::EVENT_IS_PROTECTED_ASSET, 'mylistener');

.. slyevent:: SLY_CACHE_PROCESS_ASSET
  :type:    filter
  :in:      string
  :out:     string
  :subject: der volle Name & Pfad zur zu verarbeitenden Datei

  Dieses Event dient dazu, sich in die eigentliche Verarbeitung einer Datei
  einzuhängen. Listener erhalten als Subject den Pfad zur Datei und sollten ihre
  Verarbeitung so anlegen, dass sie ihr Ergebnis in einer temporäre Datei
  schreiben, deren Name dann an den nächsten Listener weitergegeben wird (und am
  Ende der Rückgabewert ist).

  Sollte es für das Event keine Listener geben, wird die Originaldatei
  ungeändert in den Cache gelegt.

.. =============================================================================

.. slyevent:: SLY_CACHE_REVALIDATE_ASSETS
  :type:    filter
  :in:      array
  :out:     array
  :subject: eine Liste von Dateinamen

  Dieses Event dient dazu, virtuelle Dateinamen aufzulösen. Es dient vor allem
  dazu, Image-Resize zu helfen, virtuelle Namen wie
  ``imageresize/500w__foo.jpg`` wieder in ``sally/data/mediapool/foo.jpg``
  aufzulösen, damit der Asset-Cache prüfen kann, ob die Cachedatei aktuell ist.

  In der aktuellen Implementierung erhält jeder Listener ein Array mit genau
  einer Datei. In einer späteren, optimierten Version kann es jedoch gut
  passieren, dass Listener nicht 5x mit jeweils einer Datei, sondern 1x mit
  5 Dateien aufgerufen werden. Listener sollten also unbedingt **alle** Dateien
  im Subject bearbeiten, selbst wenn es momentan immer nur eine sein kann.

  Jedes Element im Subject ist ein relativer Pfad (ausgehend vom Sally-Root)
  und die Listeners sollten auch jeweils relative Pfade zurückgeben (der
  Asset-Cache wird automatisch ``SLY_BASE`` davorsetzen).

.. =============================================================================

.. slyevent:: SLY_CACHE_GET_PROTECTED_ASSETS
  :type:    filter
  :in:      array
  :out:     array
  :subject: eine Liste von relativen Dateipfaden

  Über dieses Event können Listener dem Asset-Cache eine Liste von Dateien
  geben, die geschützt im Cache abgelegt werden sollen. Sie sind dann nicht ohne
  Weiteres aufzurufen (siehe dazu die Asset-Cache-Dokumentation).

  Listener müssen in diesem Event **alle** Dateien angeben, die geschützt sind.

.. =============================================================================

.. slyevent:: SLY_CACHE_IS_PROTECTED_ASSET
  :type:    filter
  :in:      boolean
  :out:     boolean
  :subject: ``true`` für "geschützt", ``false`` für "öffentlich"
  :params:
    file  (string)  der relative Pfad zur Datei

  In diesem Event müssen Listener entscheiden, ob eine einzelne Datei geschützt
  oder öffentlich ist. Anhand welcher Kriterien sie das feststellen ist ihre
  Sache.
