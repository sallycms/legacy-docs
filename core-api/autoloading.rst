Autoloading
===========

SallyCMS enthält einen Autoloader, der dafür zuständig ist, sämtliche
Core-Klassen sowie Bibliotheken und AddOn-Klassen zu laden. Zu diesem Zweck wird
der von Composer_ generierte Autoloader verwendet, der Klassen nach dem PSR-0
Schema sowie über eine Classmap laden kann.

.. _Composer: http://getcomposer.org/

Konfiguration
-------------

Der Autoloader zieht seine Informationen aus der :file:`composer.json` aller
im Projekt genutzten Pakete (d.h. auch die Datei im Projektroot). Die
`Composer-Dokumentation`_ enthält weitere Hinweise zur Konfiguration.

Neben den Paketen ist auch ``develop/lib`` standardmäßig im Autoloader
enthalten. Sally stellt dabei sicher, dass dieses Verzeichnis das erste ist, in
dem nach Klassen gesucht wird. Dies erlaubt es, beliebige Klassen
projektspezifisch zu überschreiben.

.. _Composer-Dokumentation: http://getcomposer.org/doc/04-schema.md#autoload

PHP-API
-------

Der Class-Loader kann vom :doc:`Container <di-container>` abgerufen werden,
falls dynamisch Änderungen an dessen Konfiguration vorgenommen werden müssen.

.. sourcecode:: php

  <?
  $container = sly_Core::getContainer();
  $loader    = $container['sly-classloader'];

  // neuen Pfad hinzufügen
  $loader->add('', '/full/path/to/the/source');

.. note::

  Bei der Entwicklung von AddOns ist es oft hilfreich, diese manuell zu klonen
  und nicht über Composer zu installieren. In diesem Fall sind die Klassen des
  AddOns allerdings nicht dem Autoloader bekannt und das AddOn kann nicht
  funktionieren.

  Der beste Weg, diesem zu begegnen, ist dabei, die Pfade des AddOns von Hand
  in der :file:`index.php` des Projekts dem Autoloader hinzuzufügen. Der
  Class-Loader ist dort praktischerweise direkt verfügbar.
