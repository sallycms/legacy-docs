An der Dokumentation mitarbeiten
================================

Die Dokumentation wird in Form eines `Mercurial-Repositories auf Bitbucket
<http://bitbucket.org/SallyCMS/docs>`_ verwaltet. Wir verwenden `Sphinx
<http://sphinx.pocoo.org/>`_ zum Erzeugen der eigentlichen HTML-Dokumente.

Um die Dokumentation zu erweitern, können grundlegend die gleichen Möglichkeiten
wie beim :doc:`Beisteuern von Code <core>` genutzt werden, wobei auch hier Forks
und anschließende Pull Requests bevorzugt werden sollten.

Genaue Guidelines zur Arbeit an der Doku müssen sich erst noch herausbilden.
Eine :doc:`Beispieldatei <sample>` ist verfügbar und erklärt die wichtigsten
Formatierungen.

Hier bereits einige Regeln für Neueinsteiger:

* Alle Dateien sind als **UTF-8** (ohne Byte-Order-Mark) zu verfassen.
* Zeilen dürfen nicht länger als **80 Zeichen** sein. Gute Editoren bieten eine
  grafische Anzeige dieser Grenze.

  * Dies gilt natürlich nicht für Quellcodes.
  * Wenn durch einen Link oder eine URL diese Grenze überschreitet, ist das
    *in Ausnahmefällen* auch okay. Bitte setzt euren Verstand ein und versucht,
    ein harmonisches Gesamtbild zu erreichen.

* Zeilenumbrüche sind als **Unix-Linebreaks** zu schreiben (``\n``).
* Längere Quellcodes sollten über ``literalinclude`` eingebunden werden.
* Commit-Nachrichten sollten **Englisch**, kurz und aussagekräftig sein. Mache
  ggf. mehrere kleine Commits, wenn du an verschiedenen Stellen arbeitest.
* Beachte die Warnungen von Sphinx!

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

#. Wenn du bereits eine Doku erzeugt hast, stelle nach einem Branch-Wechsel
   unbedingt sicher, dass du **alle** Dateien in :file:`_build` löscht, da dort
   auch Cache-Dateien liegen, die Sphinx sonst verwirren könnten.

   ::

      $ rm -rf build/*

#. Führe Sphinx aus.

   ::

      $ make html

#. Die erzeugten Dateien befinden sich im Verzeichnis :file:`_build/html`.
