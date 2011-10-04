Logging
=======

Sally enthält eine einfache Logging-Klasse, die in den meisten Fällen alle
Bedürfe abdecken sollte.

API
---

Das System arbeitet auf Basis von Singletons, wobei jeweils ein Singleton pro
Logdatei erstellt wird.

.. sourcecode:: php

  <?
  $log = sly_Log::getInstance('mylog');

Grundlagen
^^^^^^^^^^

Der obige Code erstellt eine Logdatei namens :file:`mylog.log` (Endung wird
automatisch angefügt!) im Verzeichnis :file:`sally/data/dyn/internal/sally/logs`.
Über diese Instanz können nun Daten ausgegeben werden.

.. sourcecode:: php

  <?
  $log->info('Info-Nachricht');
  $log->warning('Warnung');
  $log->error('Fehlermeldung');

  // alle drei Methoden sind Shortcuts für
  $log->log($level, 'Nachricht'); // $level kann sly_Log::LEVEL_INFO, ... sein

Format ändern
^^^^^^^^^^^^^

Standardmäßig werden alle Nachrichten im Format
``[%date% %time%] %typename%: %message%`` (``sly_Log::FORMAT_SIMPLE``)
ausgegeben. Alternativ können auch die anderen beiden vordefinierten Formate
verwendet werden:

* ``FORMAT_EXTENDED``: ``[%date% %time%] %typename%: %message% (IP: %ip%, Hostname: %hostname%)`` (ideal, wenn Informationen zum Request benötigt werden)
* ``FORMAT_CALLER``: ``[%date% %time%] %typename%: %message% (%caller%, %called%)`` (falls die aufrufende Methode von Belang ist)

Das Format kann über ``->setFormat()`` gewechselt werden. Dabei können entweder
die o.g. Konstanten oder ein eigener Format-String verwendet werden.

.. sourcecode:: php

  <?
  $log->setFormat('[%date%]: %message%');

Variablen ausgeben
^^^^^^^^^^^^^^^^^^

Richtig interessant wird ``sly_Log`` erst, wenn man direkt Variablen ausgeben
kann. Einfache, skalare Werte (Strings, Zahlen) sind natürlich kein Problem, die
könnte man auch via ``->info()`` ausgeben. Komplizierter wird es, wenn man
Arrays, Objekte oder Booleans ausgeben möchte. In diesem Fall ist ``->dump()``
der beste Freund des Entwicklers:

.. sourcecode:: php

  <?
  // erster Parameter ist der Name der Variable, ohne das Dollarzeichen (frei wählbar, muss nichts mit der zu dumpenden Variable zu tun haben)
  // zweiter Parameter ist der eigentliche Wert
  $log->dump('myvar', true); // erzeugt "2011-06-06: $myvar = true"

  $obj = new stdClass();
  $log->dump('my_object', $obj);

  $log->dump('a', array(1,2,3));

``sly_Log`` wird sein Bestes versuchen, den übergebenen Wert in einer möglichst
gut lesbaren Form auszugeben.

Weitere Methoden
^^^^^^^^^^^^^^^^

Ein Log kann auch geleert werden:

.. sourcecode:: php

  <?
  $log->clear();

... oder komplett gelöscht werden:

.. sourcecode:: php

  <?
  $log->remove();

Log-Rotation
------------

Logs können automatisch beim Erreichen von einer bestimmten Dateigröße rotiert
und komprimiert (wenn möglich) werden. Die Anzahl der Dateien, die ausbewahrt
werden, kann ebenfalls gesteuert werden. Die Rotation sollte direkt beim Abrufen
des Singletons eingestellt werden, wenn sie benötigt wird:

.. sourcecode:: php

  <?
  $log      = sly_Log::getInstance('mylog');
  $maxSize  = 1048576; // 1 MB in Byte
  $maxFiles = 10;

  $log->enableRotation($maxSize, $maxFiles);

Die Rotation findet automatisch statt, wenn in die Logdatei geschrieben wird.
