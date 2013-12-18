Release-Notes
=============

.. centered:: -- Back to the Future & Sally in the Cloud with Diamonds --

Der Tradition folgend freut sich das Sally-Team, die Verfügbarkeit von
**SallyCMS 0.9** bekannzugeben. Dieser Milestone konzentriert sich auf einige
wenige, dafür aber tiefgreifende Umbauten und stellt das erste Release dar, das
**mindestens PHP 5.3** erfordert.

Das größte neue Feature in diesem Release ist mit Sicherheit die
**Versionierung von Artikelinhalten**, die es erlaubt, jederzeit auf frühere
Versionen zuzugreifen und diese ggf. anstatt der aktuellen Version online zu
schalten. Außerdem ist der Medienpool nun virtualisiert und kann daher in einem
**Cloud-fähig**\ en Storage wie einem S3-Bucket oder einer Dropbox liegen.
Abgesehen von diesen großen Punkten bringt 0.9 noch das runderneuerte
**BabelCache 2.0** mit, verwendet nativ den Composer-Autoloader, liefert Assets
ohne den alten, problematischen Asset-Service aus und speichert mehr Daten in
der Datenbank statt auf der lokalen Serverplatte.

Der grobe :doc:`Ablauf eines Updates auf 0.9 <migrate>` wird auf einer extra
Seite beschrieben.

**Sally im Web**

* `Downloads <https://bitbucket.org/SallyCMS/sallycms/downloads>`_
* `Google+ <https://plus.google.com/b/114660281857431220675/>`_ und
  `Twitter <https://twitter.com/#!/webvariants>`_
* `Repository <https://bitbucket.org/SallyCMS/sallycms/>`_ und
  `Code-Statistik bei Ohloh <http://www.ohloh.net/p/sallycms>`_
* `Bugtracker <https://bitbucket.org/SallyCMS/sallycms/issues/>`_ und
  `Forum <https://projects.webvariants.de/projects/sallycms/boards/>`_

Wir freuen uns über *jedes* Feedback. Kommentare können via Ticket_, eMail_,
Tweet oder Google+-Kommentar eingeschickt werden. :-)

.. _Ticket: https://bitbucket.org/SallyCMS/sallycms/issues/
.. _eMail:  info@sallycms.de

Änderungen
----------

Im Folgenden sollen kurz die Neuerungen in diesem Release beschrieben werden.

Versionierung
"""""""""""""

Virtuelles Dateisystem
""""""""""""""""""""""

PHP 5.3+
""""""""

BabelCache 2.0
""""""""""""""

API-Änderungen
--------------

Im Folgenden werden soweit möglich alle API-Änderungen zwischen dem 0.8- und dem
0.9-Branch beschrieben.

Backend
"""""""

Core
""""

Frontend
""""""""
