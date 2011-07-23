Update-Mechanismus für AddOns / Plugins
=======================================

Beginnend mit SallyCMS *v0.3.1* wird es AddOns (und Plugins) ermöglicht,
automatisch zu erkennen, ob Updates nötig sind.

Zu diesem Zweck wird Sally die Versionsnummer jedes AddOns in die
Projektkonfiguration übernehmen. Wird ein AddOn aktualisiert, erkennt SallyCMS
die geänderte Version und löst automatisch ein Update aus. AddOns können selber
steuern, was dann passieren soll.

Versionsnummer angeben
----------------------

Die Version kann wie folgt angegeben werden:

* In der :file:`static.yml` des AddOns kann sie als ``version: 1.2.3`` notiert
  werden (**empfohlen**).
* Im AddOn-Verzeichnis kann eine Datei namens :file:`version` abgelegt werden,
  die ausschließlich (!) die Version enthalten sollte (ohne Leerzeile am Ende).

Es ist stark zu empfehlen, die :file:`static.yml`-Variante zu verwenden, da die
Version bei jedem Request (Frontend und Backend) abgerufen und verglichen wird.
In der YAML-Datei wird sie automatisch in PHP-Code gecached und zusammen mit dem
AddOn geladen. Steht sie nur in der gesonderten Datei, muss diese immer und
immer wieder geöffnet und eingelesen werden.

Updates behandeln
-----------------

Wird eine abweichende Versionsnummer (egal, ob jünger oder älter) festgestellt,
wird eine Datei namens :file:`update.inc.php` im AddOn-Verzeichnis gesucht.
Falls sie vorhanden ist, wird sie eingebunden, **bevor das AddOn geladen wird**.

In diesem Script kann entweder ein Flag gesetzt werden, damit das AddOn nach dem
Laden das Update ausführen kann. Alternativ können natürlich dort sofort schon
die nötigen Änderungen ausgeführt werden. Wenn kein Update möglich ist, sollte
die :file:`update.inc.php` mit ``die()`` aussteigen.

Die aktuelle/letzte Version kann wie folgt ermittelt werden:

.. sourcecode:: php

  <?
  $service    = sly_Service_Factory::getAddOnService();
  $oldVersion = $service->getKnownVersion('myaddon');
  $newVersion = $service->getVersion('myaddon');

Wenn die :file:`update.inc.php` abgearbeitet ist, wird automatisch die neue
Version in die Projektkonfiguration übertragen.
