Änderungen beisteuern
=====================

Du willst uns helfen? Super! Um dir und uns unnötige Arbeit zu ersparen, hier
ein paar Notizen darüber, wie man am leichtesten Änderungen beisteuern kann.

Allgemein gilt: Sende Pull-Requests, Patches usw. an **sally@webvariants.de**.

Struktur des Projekts
---------------------

* Das offizielle Projekt-Repository befindet sich bei `Bitbucket
  <http://www.bitbucket.org/SallyCMS/trunk>`_ (Trunk). Wir verwenden
  `Mercurial <http://mercurial.selenic.com/>`_ als Versionskontrollsystem.
* Die einzelnen Minor-Releases werden in einzelnen Branches, die wir als Clones
  vom Trunk verwalten, versioniert.
* Die einzelnen Branches werden ebenfalls bei Bitbucket gehosted:

  * `0.4-Branch <http://www.bitbucket.org/SallyCMS/0.4/>`_
  * `0.3-Branch <http://www.bitbucket.org/SallyCMS/0.3/>`_
  * `0.2-Branch <http://www.bitbucket.org/SallyCMS/0.2/>`_

* Änderungen aus einem Branch müssen immer in den nächst "höheren" Branch
  gemerged werden (d.h. Änderungen in 0.2 müssen in 0.3 gemerged werden, danach
  muss 0.3 in 0.4 gemerged werden, .... und das dann am Ende in den Trunk).

Die folgende Grafik veranschaulicht das Branchen in SallyCMS:

.. image:: /_static/branching.png

Dieses System sorgt dafür, dass jede Sally-Version aus dem Trunk erzeugt werden
kann, da dieser sämtliche Änderungen (und damit auch Tags) aus den Branches
enthält. Gleichzeitig taucht ein Fix für eine alte Version auch in jedem anderen
Branch auf.

Das sollte dazu führen, dass ein Release von 0.2 automatisch auch durch das
Zurückmergen korrigierte Versionen von 0.3, 0.4 usw. nach sich zieht.

Weitere Informationen
---------------------

  * :doc:`Code für das Kernsystem beisteuern <core>`
  * :doc:`An der Dokumentation mitarbeiten <docs>`
