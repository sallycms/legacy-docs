Frontend-Layout
===============

Um Websites mit Sally zu erstellen, kann in den :doc:`Templates <templates>`
einfaches (X)HTML geschrieben werden.

.. literalinclude:: template.layout0.php
   :language: php

Während das absolut legitim ist, macht man es sich damit nur unnötig schwer.
Gerade, wenn :doc:`Module <modules>` CSS/JS-Dateien in den HTML-Kopf einfügen
wollen, wird es mit diesem Ansatz kompliziert (Stichwort:
``SLY_RESPONSE_SEND``-Event).

Einfacher ist es, die in Sally vorimplementierten Layouts zu verwenden. Diese
geben (wie man denken könnte) kein spezielles *Design* vor, sondern kümmern sich
ausschließlich um das Verwalten des HTML-Kopfes. Wer bereits AddOns entwickelt
hat, weiß bereits, wie ihre API zu bedienen ist, da auch Sally im Backend die
gleichen Klassen verwendet.

Beispiel
--------

Ein einfaches Beispiel soll die Vorteile dieses Ansatzes zeigen. Wir bauen eine
einfache XHTML-Website, indem wir ``sly_Layout_XHTML`` verwenden. Die
Vorgehensweise ist dabei, das Layout-Objekt zu initialisieren, dann einen Buffer
für die eigentliche Ausgabe (den ``<body>`` der Seite) zu öffnen und am Ende den
Inhalt des Buffers zusammen mit dem generierten ``<head>`` auszugeben.

.. literalinclude:: template.layout1.php
   :language: php

Dieser Aufbau ermöglicht es, in Modulen den HTML-Kopf auf einfachste Weise zu
verändern.

.. literalinclude:: template.layout2.php
   :language: php

Ein anderes Layout verwenden
----------------------------

Sally bringt von Haus aus ein XHTML 1.0 und ein XHTML5-Layout mit. Beide lassen
sich identisch verwenden, wobei das XHTML5-Layout ("HTML 5 in XML-Syntax")
weitere Methoden wie z.B. zum Setzen des Manifests anbietet.

Natürlich kann man auch sein eigenes Layout verwenden, indem man seine eigene
Klasse von ``sly_Layout`` erben lässt. In den meisen Fällen wird das eigene
jedoch XHTML-ähnlich sein, sodass man eher von ``sly_Layout_XHTML`` oder
``sly_Layout_XHTML5`` erben sollte. Dies macht es auch einfacher, das gleiche
Layout in mehreren Templates zu verwenden, ohne den immer gleichen
Initialisierungscode zu kopieren.

Das eigene Layout sollte in :file:`develop/lib` abgelegt werden und kann
beliebig benannt werden. Für unser Beispiel nennen wir es ``FrontendLayout`` und
müssen es daher in der Datei :file:`develop/lib/FrontendLayout.php` ablegen,
damit Sally es automatisch findet.

.. literalinclude:: template.layout3.php
   :language: php

Damit sehen unsere Templates nun wie folgt aus:

.. literalinclude:: template.layout4.php
   :language: php

Da das eigene Layout vom Design unabhängig ist, kann man es problemlos in
anderen Projekten wiederverwenden. Komplexe Frontend-Arbeiten (wie das Setzen
von Meta-Angaben zu SEO-Zwecken) können so einmal vorimplementiert und dann
immer wieder verwendet werden. Außerdem kann man seine eigene Layout-Klasse auch
mit weiteren Helper-Methoden ausstatten, wenn man bestimmte Funktionen häufiger
benötigt.

.. warning::

  Auch wenn es verlockend scheint, auch den Aufruf von ``sly_Core::setLayout()``
  einfach im Layout anstatt im Template zu erledigen, sollte man diesem Gedanken
  niemals folgen: Es ist nicht die Aufgabe des Layouts, sich irgendwo anzumelden
  und wenn man später die eigene API unittesten möchte, können derartige
  API-Calls schnell problematisch werden.

  Eine Möglichkeit, sich den API-Call dennoch im Template zu ersparen, wäre es,
  eine Helper-Klasse zu verwenden, die das Layout instanziiert und registriert.
  Das `Starterkit <https://bitbucket.org/SallyCMS/demo/src/tip/develop/lib/FrontendHelper.php>`_
  zeigt, wie eine mögliche Lösung aussehen könnte.
