Tipps & Tricks
==============

Auf dieser Seite sollen ein paar Best Practices und kleine Tipps gegeben werden,
die das Leben mit SallyCMS einfacher machen.

.. note::

  Diese Seite freut sich ganz besonders über Neuzugänge!

Template einbinden
------------------

Um in einem Template (oder einem Modul) ein anderes Template einzubinden, kann
man entweder ein normales include oder den Template-Service verwenden.

.. sourcecode:: php

  <?
  // naiver Ansatz, nicht empfohlen
  include SLY_DEVELOPFOLDER.'/templates/mytemplate.php';

  // Um immer kompatibel zu bleiben (falls sich mal das Verzeichnis
  // ändert oder Templates speziell verarbeitet werden müssen, bevor
  // sie eingebunden werden können), sollte man das Utility verwenden:
  sly_Util_Template::render('mytemplate', array('variable' => 'wert', 'var' => 12));
