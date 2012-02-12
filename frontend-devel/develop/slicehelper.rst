Slice-Helper
============

In jedem Modul stehen einige vordefinierte Variablen zur Verfügung, die Zugriff
auf die Slice-Werte ermöglichen oder beim Aufbau des Formulars helfen.

Formulare (``$form``)
---------------------

Jeder Modul-**Eingabe** steht die Variable ``$form`` zur Verfügung. Dabei
handelt es sich um eine Instanz von ``sly_Slice_Form``. Modulen wird empfohlen,
ihre gesamte Eingabe über Sally-Formularelemente zu gestalten und dabei dieses
Objekt als Container zu verwenden.

.. note::

  Das Formular wird im Anschluss automatisch von Sally gerendert. Um dies zu
  unterbinden, kann ``$form`` auf ``null`` gesetzt werden.

Die Besonderheit des Slice-Formulars ist, dass es alle Elemente automatisch in
``slicevalue[XXX]`` umbenennt (wobei ``XXX`` der Originalname des Elements ist).
Entwickler müssen sich also nicht selbst um den Namen kümmern, sondern können
kurze, sprechende Name verwenden.

Abgesehen von dieser Änderung verhält sich das Slice-Formular exakt so wie jedes
andere Formular in Sally, das mit ``sly_Form`` umgesetzt wird. Das heißt, dass
auch alle Formularelemente problemlos verwendet werden können.

Slice-Werte (``$values``)
-------------------------

Module können über den Helper ``$values`` auf die gespeicherten Werte zugreifen.
Werte werden dabei immer als rohe Daten (Eingaben aus Linkmaps sind
beispielsweise Artikel-IDs und keine Artikel-Objekte) zurückgegeben.

Die einzige Methode, die der Helper im Moment kennt, ist ``get($key, $default)``.

Artikel-Slice (``$slice``)
--------------------------

Im **Ausgabe**-Teil eines Moduls steht zusätzlich die Variable ``$slice`` zur
Verfügung, über die das Modul beispielsweie den aktuellen Slot ermitteln kann.
``$slice`` ist dabei eine Instanz von ``sly_Model_ISlice``.

.. note::

  Der Eingabe-Teil eines Moduls kann in Version 0.6 den Slot nicht per API
  ermitteln. Wird also im Modul diese Information benötigt, muss sie abseits
  der gepflastern Wege über ``sly_request('slot', 'string')`` ermittelt werden.
