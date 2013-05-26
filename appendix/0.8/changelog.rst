Changelog
=========

0.8.1 (26. Mai 2013)
--------------------

.. note::

  Tippfehler in 0.8.0 führen zu kleinen :doc:`BC-Breaks <bc-breaks>`.

* Das Routing auf die Sally-Apps wird nun nicht mehr über Umgebungsvariablen
  vorgenommen, da sich die Methode als zu unzuverlässig und problematisch auf
  einigen Hostern erwiesen hat. Bestehende Projekte funktionieren weiter und
  können durch Aktualisieren der :file:`.htaccess` und :file:`index.php` von
  der neuen Methode profitieren. Neue Projekte verwenden automatisch die neue
  :file:`sally/core/detect-app.php`.

Core
^^^^

* Listener auf ``SLY_SLICE_PRE_RENDER`` erhalten die Modulwerte als ``values``
  zusätzlich reingegeben und können nun (indem sie einen String zurückgeben)
  den fertigen Modul-Output zurückgeben und so die Ausführung des Moduls
  unterbrechen. Ebenso stehen nun in ``SLY_SLICE_POST_RENDER`` die Modulwerte
  zur Verfügung.
* ``sly_Form_Input_Number`` akzeptiert in ``setMin()`` und ``setMax()`` nun auch
  ``null``, um die Beschränkungen zurückzusetzen.
* Der Konstruktor von ``sly_Form_Container`` kann nun den ``$content`` direkt
  entgegennehmen.
* Bugfix: ``sly_Model_User->setAttrubute()`` heißt nun korrekt
  ``setAttribute()``.
* Bugfix: Zwei Tippfehler hatten den Core PHP 5.3 only gemacht.
* Bugfix: Der Cache wurde nicht korrekt geleert, wenn ein Artikel zu einem
  Startartikel umgewandelt wurde.
* weitere kleine Fixes

Backend
^^^^^^^

* ``getCurrentUser()`` steht nun allen Backend-Controllern, die sich von
  ``sly_Controller_Backend`` ableiten, zur Verfügung.
* Die nutzbare Breite von Formular-Labels wurde von 145 auf 140 Pixel reduziert,
  um etwas Abstand zwischen Label und Formularelement zu erzwingen.
* Die Angabe zur letzten Aktualisierung werden nun in der Medienpool-Übersicht
  nicht mehr angezeigt. Außerdem werden etwas kleinere Thumbnails erzeugt.
* Die Dateien im Medienpool werden nun nach ihrem Namen sortiert.
* Bugfix: Probleme in der Strukturansicht, wenn kein Zugriff auf die erste
  Systemsprache bestand.
* Bugfix: ``sly_Helper_Message::renderFlashMessage()`` erwartet nun korrekt eine
  Instanz von ``sly_Util_FlashMessage``.
* Bugfix: Die vom Nutzer gesetzte Backendsprache wurde nicht beachtet.
* Bugfix: Das Locale der Backendsprache wurde nicht gesetzt.
* Bugfix: Das Deutsche Datumsformat war defekt.
* Bugfix: Der Kategoriefilter im Medienpool funktionierte nicht.
* Bugfix: Eine leere Auswahl bei der Modulauswahl führt nicht mehr zu einem
  Fehler.
* Bugfix: Die Erkennung von Dateien, die in Verwendung sind, wurde verbessert
  und sollte weniger False Positives erzeugen.

Setup
^^^^^

* Ein Tippfehler wurde korrigiert.

0.8.0 (17. März 2013)
---------------------

* :doc:`Major Feature Release <releasenotes>`
