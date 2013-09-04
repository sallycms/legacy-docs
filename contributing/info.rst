Änderungen beisteuern
=====================

Du willst uns helfen? Super! Um dir und uns unnötige Arbeit zu ersparen, hier
ein paar Notizen darüber, wie man am leichtesten Änderungen beisteuern kann.

Allgemein gilt: Sende Pull-Requests, Patches usw. an **sally@webvariants.de**.

Struktur des Projekts
---------------------

* Wir verwenden `Mercurial <http://mercurial.selenic.com/>`_ als
  Versionskontrollsystem.
* Das offizielle Projekt-Repository befindet sich bei `Bitbucket
  <http://www.bitbucket.org/SallyCMS/sallycms>`_. Neben dem Projekt gibt es noch
  einzelne Repositories für den Core_, das Backend_, das Frontend_ und
  natürlich auch die einzelnen AddOns. Die Dokumentation_ liegt ebenfalls in
  einem eigenen Repository.
* Versionen folgen dem Konzept der `Semantischen Versionierung`_, mit der
  Abweichung, dass wir Majorsprünge in Minorversionen machen (es gibt also
  API-Breaks zwischen 0.8 und 0.9).
* Die einzelnen Minor-Releases werden in einzelnen Branches versioniert, d.h.
  es gibt einen ``0.9``-Branch, einen ``0.8-Branch`` usw.
* Änderungen aus einem Branch müssen immer in den nächst "höheren" Branch
  gemerged werden (d.h. Änderungen in 0.2 müssen in 0.3 gemerged werden, danach
  muss 0.3 in 0.4 gemerged werden, .... und das dann am Ende in den
  ``default``-Branch).

.. _Core:          http://www.bitbucket.org/SallyCMS/sallycms-core
.. _Backend:       http://www.bitbucket.org/SallyCMS/sallycms-backend
.. _Frontend:      http://www.bitbucket.org/SallyCMS/sallycms-frontend
.. _Dokumentation: http://www.bitbucket.org/SallyCMS/docs
.. _Semantischen Versionierung: http://www.semver.og/

Die folgende Grafik veranschaulicht das Branchen in SallyCMS:

.. image:: /_static/branching.png

Dieses System sorgt dafür, dass Fixes in älteren Versionen immer ihren Weg in
aktuellere Versionen finden. Das sollte dazu führen, dass ein Release von 0.2
automatisch auch durch das Zurückmergen korrigierte Versionen von 0.3, 0.4 usw.
nach sich zieht.
