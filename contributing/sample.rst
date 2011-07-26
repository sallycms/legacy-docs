Beispieldatei
=============

Diese Seite enthält keinen sinnvollen Inhalt und dient nur dazu, die
Formatierung von reStructuredText zu erklären. In der Sidebar auf der linken
Seite befindet sich ein "Show Source"-Link, über den die Quelldatei auch im
Browser eingesehen werden kann.

*Here we go*

Überschrift zweiter Ordnung
---------------------------

Überschrift dritter Ordnung
^^^^^^^^^^^^^^^^^^^^^^^^^^^

Überschrift vierter Ordnung
"""""""""""""""""""""""""""

Stelle sicher, dass du immer so viele Markierungszeichen verwendest, wie deine
Überschrift lang ist. Pro Dokument sollte nur eine Überschrift erster Ordnung
(gekennzeichnet mit ``====``) vorkommen.

Inline-Formatierung
-------------------

Inline-Formatierungen sind einfach. Text kann *kursiv* (``*kursiv*``), **fett**
(``**fett**``) oder ``monotype`` (````monotype````) sein. Durchstreichung ist
nicht möglich.

.. note::

  Inline-Formatierungen können nicht verschachtelt werden. Dies ist übrigens
  eine **Note** (Titel kann im Dokument selber nicht angepasst werden).

Absätze werden über Leerzeilen zwischen ihnen gekennzeichnet.

Listen
------

Listen können ebenfalls recht einfach gesetzt werden. Nummerierte und nicht
nummerierte Listen können beliebig verschachtelt werden, wobei jede Ebene von
anderen über eine Leerzeile abgetrennt werden muss.

* foo
* bar

  * sub 1
  * sub 2

    #. nummeriert 1
    #. nummeriert 2

 * sub 3

In Listen sind auch Absätze von Texten möglich.

* Hallo welt.

  Ich bin ein zweiter Absatz im ersten Listenpunkt.
* Ich bin der zweite Listenpunkt.

  ::

    Codebeispiel

Code
----

Code und dergleichen wird eingerückt und über ein im vorangegangenen Absatz
gesetztes ``::`` gekennzeichnet. ::

  Code Zeile 1
  Code Zeile 2

Wenn der Absatz mit einem Doppelpunkt endet (ist oft der Fall, wenn Sätze wie
"Folgender Code demonstriert dies:" Codebeispiele einleiten), kann die
Markierung auch in einem eigenen Absatz gesetzt werden.

::

  Mein Code

Highlighting
^^^^^^^^^^^^

Highlighting ist über **Pygments** möglich und kann wie folgt verwendet werden.
Dabei entfält die ``::``-Markierung, da der Code über die
``sourcecode``-Direktive gesetzt wird.

.. sourcecode:: php

  <? // <-- Das startende PHP-Tag ist wichtig!
  print "Hallo";

.. sourcecode:: mysql

  SELECT 'Yeah!';

.. sourcecode:: html

  <html>
  <head>
    <title>foo!</title>
    <link rel="..." />

Längerer Quellcode kann über die Direktive ``literalinclude`` eingebunden
werden. Dies ist insbesondere nützlich, wenn die Einrückung des Codes sich mit
der von reSt beißt. Zeilennummern können optional eingeschaltet werden.

.. literalinclude:: guideline.sql
   :language: sql
   :linenos:

Direktiven
----------

Direkten erlauben es auch, Hinweise, Warnungen und dergleichen zu setzen.

.. note::

  Ich bin eine Notiz.

.. warning::

  Ich bin eine Warnung. Beachte mich!

Verlinkungen
------------

Es wird zwischen internen und externen Links unterschieden. Interne Links werden
mit ``:doc:`` als Präfix versehen und bestehen entweder nur aus dem Pfad zur
Zieldatei (relativ zum aktuellen Dokument, absolute Pfade sind möglich, indem
dem Pfad ein ``/`` vorangestellt wird) oder aus einem Pfad und einem Titel. Wird
der Titel nicht angegeben, wird der Wert der ersten Überschrift aus dem
Zieldokument verwendet.

Ein Beispiel: ``:doc:`path/to/document```. Man beachte die Backticks. Soll der
Titel angegeben werden, sehen Links wie folgt aus:
``:doc:`Linktitel </absolute/path>```.

Externe URLs funktionieren genau so wie interne, nur dass ihnen noch ein
Unterstrich angefügt wird und sie nicht mit ``:doc:`` geschrieben werden:
```Linktitel <http://www.google.com/>`_``.

.. note::

  Alle Dokumente, die in der Dokumentation enthalten sind, müssen innerhalb
  einer ``:toctree:``-Direktive genannt werden. Die Doku enthält mindestens eine
  solche Direktive in der :file:`index.rst`-Datei. Dort ist nur eine flache
  Liste möglich, weswegen das Inhaltsverzeichnis auch manuell gesetzt wurde.

Sonstiges
---------

Es sind noch viele weitere Formatierungen möglich. So sollten Dateinamen und
Verzeichnisse nicht über ````filename````, sondern ``:file:`filename``` gesetzt
werden. Eine Übersicht über die verfügbaren Direktiven liefert die
`Sphinx-Dokumentation <http://sphinx.pocoo.org/rest.html>`_.
