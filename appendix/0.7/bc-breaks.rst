Kompatibilitätsinformationen
============================

Auf dieser Seite werden alle rückwärts-inkompatiblen API-Änderungen aus allen
0.7-Releases dokumentiert.

0.7.1 -> 0.7.2
--------------

* ``sly_Core`` erlaubt es, den Dispatcher durch eine neue Instanz zu ersetzen.
  Dispatcher müssen das neue Interface ``sly_Event_IDispatcher`` implementieren.
  Alle Methoden, die bisher per Type-Hint ein Objekt vom Typ
  ``sly_Event_Dispatcher`` verlangten, sollten aktualisiert werden.
* Sally lädt nun nur noch ``.yml``- und ``.yaml``-Dateien aus dem
  ``develop``-Verzeichnis.
* ``sly_Service_Factory::getSliceValueService()`` wurde entfernt, da es den
  Service nicht mehr gibt.

0.7.2 -> 0.7.next
-----------------

* Das wird die Zeit zeigen...
