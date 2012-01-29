Autoloading
===========

SallyCMS enthält einen Autoloader, der dafür zuständig ist, sämtliche
Core-Klassen sowie Bibliotheken und AddOn-Klassen zu laden. Seine
Implementierung basiert ursprünglich auf `EuropaPHP <http://europaphp.org/>`_
und ist mit dem `PSR-0 Final Proposal
<http://groups.google.com/group/php-standards/web/psr-0-final-proposal>`_ der
PHP Standards Working Group kompatibel. Er ist damit in der Lage, die meisten
Bibliotheken wie das Zend Framework oder symfony automatisch einzubinden.

Arbeitsweise
------------

Der Loader enthält eine Reihe von Loadpfaden, die angeben, wo einzelne
Klassen(sammlungen) liegen. Beim Laden einer Klasse wird er jeden Unterstrich
durch einen Slash ersetzen und ``.php`` anfügen (so wird aus
``sly_Model_Article`` das Pfadfragment :file:`sly/Model/Article.php`). Im
Anschluss wird er dieses Fragment an jeden ihm bekannten Pfad anhängen und
prüfen, ob die Datei vorhanden ist. Falls ja, wird sie eingebunden.

Case Collisions
^^^^^^^^^^^^^^^

Der o.g. Algorithmus ist **case sensitive**, wird also die Klasse ``Foo`` nicht
in der Datei :file:`foo.php` finden. Dies ist im Prinzip nur unter Windows
problematisch, da NTFS **case insensitive** arbeitet und so bei Tippfehlern
Probleme entstehen, die erst beim Deployment auf ein unioxides Dateisystem
bemerkt werden.

.. note::

  Prominente Beispiele dafür sind ``sly_Util_YAML`` oder ``sly_Model_Base_Id``.

API
---

Meistens wird in der :file:`config.inc.php` eines AddOns mit dem Loader
interagiert. Dabei wird dem System mitgeteilt, wo die Klassen eines AddOns zu
finden sind.

.. sourcecode:: php

  <?
  $mypath = SLY_ADDONFOLDER.'/myaddon';
  sly_Loader::addLoadPath($mypath.'/lib');

Caching
-------

``sly_Loader`` wird alle gefundenen Klassen automatisch cachen, um nicht bei
jedem Seitenaufruf die Dateien immer wieder neu suchen zu müssen. Damit ist es
kein Problem, dass beim Einbinden von Bibliotheken im System 30 oder mehr Pfade
bekannt sind, da nach einigen Seitenaufrufen alle Klassen bekannt sind und das
Dateisystem nicht mehr ständig abgegrast werden muss.

Dies bedeutet aber auch, dass der Cache im Backend geleert werden muss, wenn
eine Klasse verschoben wurde.
