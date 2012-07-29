Release-Notes
=============

.. centered:: -- Composer & LESS is more --

.. note::

  Version 0.7 befindet sich noch im Beta-Stadium und ist noch nicht für den
  produktiven Einsatz geeignet. Die hier genannten Details können sich bis zum
  finalen Release jederzeit ändern.

Gut ein halbes Jahr nach dem Release der letzten großen Major-Version freut sich
das Sally-Team, nun die Verfügbarkeit der ersten *Beta* von SallyCMS 0.7
bekanntzugeben. Das neue Major Release konzentriert sich vor allem auf die
`Composer <https://getcomposer.org>`_-Integration, über die zukünftig AddOns,
Plugins und weitere Bibliotheken in Sally integriert werden, sowie den Wechsel
von Scaffold hin zu `LESS <http://lesscss.org/>`_.

Der grobe :doc:`Ablauf eines Updates auf 0.7 <migrate>` wird auf einer extra
Seite beschrieben.

**Sally im Web**

* `Downloads <https://projects.webvariants.de/projects/sallycms/files>`_
* `Google+ <https://plus.google.com/b/114660281857431220675/>`_ und
  `Twitter <https://twitter.com/#!/webvariants>`_
* `Repository <https://bitbucket.org/SallyCMS/0.7/>`_ und
  `Code-Statistik bei Ohloh <http://www.ohloh.net/p/sallycms>`_
* `Bugtracker <https://projects.webvariants.de/projects/sallycms/issues/>`_ und
  `Forum <https://projects.webvariants.de/projects/sallycms/boards/>`_

Wir freuen uns über *jedes* Feedback. Kommentare können via Ticket, eMail,
Tweet oder Google+-Kommentar eingeschickt werden. :-)

Änderungen
----------

Im Folgenden sollen kurz die Neuerungen in diesem Release beschrieben werden.

Composer-Integration
""""""""""""""""""""

Die Umstellung auf Composer ist sicherlich die deutlichste Änderung an diesem
Release, da sie die Art und Weise verändert, wie Sally externe Bibliotheken
(BabelCache, sfYaml, ...) sowie AddOns und Plugins einbindet, installiert und
aktualisiert.

Bisher waren die benötigten Bibliotheken als Kopie im Sally-Repository
enthalten. Nun werden sie erst beim Installieren eines Projekts aus dem Netz
heruntergeladen und installiert. Ebenso wird mit AddOns verfahren.

Eine vollständige Erklärung von Composer sprengt den Rahmen der Release Notes
und soll daher nicht stattfinden. Im Netz gibt es eine ganze Reihe nützlicher
Artikel und Websites zu Composer:

* `Die Composer-Website <http://getcomposer.org/>`_
* `Composer: What & Why (Part 1) <http://nelm.io/blog/2011/12/composer-part-1-what-why/>`_
  und `Part 2 <http://nelm.io/blog/2011/12/composer-part-2-impact/>`_
