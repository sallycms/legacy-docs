Changelog
=========

0.8.3 (18. Dezember 2013)
-------------------------

.. note::

  Das Upgrade auf lessphp 0.4 stellt einen :doc:`BC-Break <bc-breaks>` dar.

* Sally verwendet nun lessphp 0.4.*.
* Sally erlaubt nun das Hashing von Passwörtern nur noch bis zu einer Länge von
  4096 Zeichen. Dies dient zur Verhinderung von DoS-Attacken auf den Server.
* ``sly_Service_Medium::findMediaByExtension()`` unterstützt nun eine
  Sortierung.
* Attribute an ``sly_Layout``-Instanzen können nun auch keinen Wert besitzen und
  somit zu ``<html foo bar>`` führen. Gleichzeitig werden die Attribute für das
  ``<html>``-Tag nun auch über das Objekt verwaltet. Damit ist es einfacher
  möglich, JavaScript-Frameworks wie AngularJS zu verwenden.
* ``SLY_ADDONS_LOADED`` enthält nun den Container als zusätzlichen Parameter.
* ``sly_DB_PDO_Persistence::query()`` gibt nun die Persistence-Instanz selbst
  zurück.
* Bugfix: Migrierte Passwörter konnten nicht verwendet werden.
* Bugfix: Es werden nur noch AddOn-Abhängigkeiten vom AddOn-Service ausgewertet.
  Damit wird es möglich, dass ein AddOn z.B. ``guzzle/http`` benötigt und ein
  weiteres ``guzzle/guzzle``. Da ``guzzle/guzzle`` die kleinere HTTP-only-Library
  beinhaltet, ist im Projekt nur die große, vollständige Library vorhanden. Ohne
  tiefgreifendes Verarbeiten der Composer-Infos wäre es Sally unmöglich zu
  erkennen, dass das Requirement auf ``guzzle/http`` erfüllt ist.
* Bugfix: Ein fehlgeschlagener Login führt nun nicht mehr zu einer
  Login-Schleife beim nächsten Versuch.
* Bugfix: Die Zeitzone wird nun auch als ``php.ini``-Wert gesetzt.
* Bugfix: ``readonly`` und ``disabled`` wurden am DateTime-Formularelement nicht
  verarbeitet.
* weitere kleine Fixes

0.8.2 (29. August 2013)
-----------------------

* Bugfix: Der Sync-Controller vom Medienpool verwendete PHP 5.3-Synatx.
* Bugfix: Noch ein Versuch, das Routing stabil auf allen Hostern zu gestalten.
* Bugfix: Notice wenn keine Session geöffnet und dennoch auf
  ``sly_Util_Session`` zugegriffen wurde.
* Bugfix: Lief Sally mit einem Deutschen Locale, so wurde unter bestimmten
  Umständen ungültiges YAML erzeugt, wenn die Daten Float-Werte enthielten.
* Bugfix: Condition Evaluators erhielten nicht den korrekten Parameternamen
  übergeben.
* Bugfix: Der Pager auf der Nutzerseite funktionierte nicht.
* Der Router wird nun unbenannte Gruppen nicht mehr capturen (d.h. es gibt
  keinen ``0``-Parameter in ``$_GET`` mehr).
* Wird eine URL nicht vollständig aufgelöst (durch eine
  realurl-Implementierung), so wird versucht zumindest die Sprache korrekt zu
  ermitteln.
* Die Prüfung, ob ein Artikel ein Template besitzt, wird im Frontend später
  ausgeführt, damit AddOns noch in ``SLY_CURRENT_ARTICLE`` auf den aufgerufenen
  Artikel zugreifen können.
* Zu langer Content (Artikelnamen) kann nun in Modulen und der Linkmap im
  Backend nicht mehr das Layout zerreißen.

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
