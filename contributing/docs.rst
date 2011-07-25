An der Dokumentation mitarbeiten
================================

Die Dokumentation wird in Form eines `Mercurial-Repositories auf Bitbucket
<http://bitbucket.org/SallyCMS/docs>`_ verwaltet. Wir verwenden `Sphinx
<http://sphinx.pocoo.org/>`_ zum Erzeugen der eigentlichen HTML-Dokumente.

Um die Dokumentation zu erweitern, können grundlegend die gleichen Möglichkeiten
wie beim :doc:`Beisteuern von Code <core>` genutzt werden, wobei auch hier Forks
und anschließende Pull Requests bevorzugt werden sollten.

Genaue Guidelines zur Arbeit an der Doku müssen sich erst noch herausbilden.

Einrichtung
-----------

Dein System benötigt **Python 2** (ggf. funktioniert auch Version 3, das wurde
aber bisher nicht getestet) sowie einige weitere Pakete.

Windows
^^^^^^^

#. Installiere `Python <http://www.python.org/>`_.
#. Öffne eine Admin-Konsole.
#. Wechsle in das ``Scripts``-Verzeichnis deiner Python-Installation (zum
   Beispiel :file:`C:\\Python-2.6\\Scripts`).
#. Führe die folgenden Befehle aus:

   ::

      easy_install-2.6 Sphinx
      easy_install-2.6 docutils
      easy_install-2.6 Jinja2
      easy_install-2.6 Pygments

   Falls die Befehle fehlschlagen, führe sie einfach noch einmal aus.

Linux / OSX
^^^^^^^^^^^

#. Konsultiere die Dokumentation deines Paketsystems, um Python, Sphinx,
   docutils, Jinja2 und Pygments zu installieren.

HTML erzeugen
-------------

#. Klone dir das `Doku-Repository <http://bitbucket.org/SallyCMS/docs>`_.
#. Wechsle auf der Konsole dorthin.
#. Aktualisiere die Arbeitskopie auf den Stand, den zu erzeugen möchtest.

   ::

      $ hg branches
      0.5     15:1259b8aea8c8
      0.4     12:2943ef28d977

      $ hg update 0.5

#. Führe Sphinx aus.

   ::

      make html

#. Die erzeugten Dateien befinden sich im Verzeichnis :file:`_build/html`.
