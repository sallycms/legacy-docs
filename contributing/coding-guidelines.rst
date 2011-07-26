Coding-Guidelines
=================

Spielregeln
-----------

* Code muss mit PHP 5.1 und MySQL 5.0 (mit InnoDB) kompatibel sein.
* ``error_reporting`` = ``E_ALL | E_STICT | E_NOTICE`` (für PHP 5.3-Nutzer
  sollte auch ``E_DEPRECATED`` aktiviert sein)
* ``display_errors`` = ``On``
* Dateien sind als UTF-8 ohne BOM zu verfassen.
* Warnungen und Notices sind die kleinen Schwestern von Fatal und Error und
  sollten ausgemerzt werden, bevor sie ihe Brüder rufen.
* Trailing Whitespace sollte vom Editor beim Speichern entfernt werden.
* **Benutze Tabs zur Einrückung und Leerzeichen zum Ausrichten deines Codes!**

PHP
---

.. literalinclude:: guideline.php
   :language: php

SQL
---

.. literalinclude:: guideline.sql
   :language: sql

Stelle sicher, dass dein SQL keine Zeilenumbrüche enthält, wenn du es
PHP-seitig zusammensetzt. Das macht es schwer möglich, den SQL-Log im Fehlerfall
auszuwerten. Verwende lieber

.. sourcecode:: php

  <?
  $query =
      'SELECT * FROM mytable WHERE 1 AND '.
      'x = 4 AND foo = "bar"';

JavaScript
----------

.. literalinclude:: guideline.js
   :language: js

XHTML
-----

.. literalinclude:: guideline.html
   :language: html

CSS
---

CSS wird automatisch via `CSScaffold <http://github.com/sunny/csscaffold>`_
verarbeitet. Daher sind Dinge wie verschachtelte Selektoren oder andere
Spielereien möglich, die jeden CSS-Parser aus dem Konzept bringen. Nicht
wundern, wenn das Syntax-Highlighting im Editor der Wahl nicht mehr zu
gebrauchen ist.

.. literalinclude:: guideline.css
   :language: css

Das obige Beispiel-CSS würde (unter Missachtung einer CSS-Validierung) folgendes ergeben:

.. sourcecode:: css

  .class .tab-indented #my-id{color:blue;margin:10px;background:red}
  .class .tab-indented .short{single:definition}
  .class .tab-indented .wee{another:def}
  .class .tab-indented .tiny{please:endthis}
  .class-pay-attention{hard-to:find-this-classname}
