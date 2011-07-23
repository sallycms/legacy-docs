Installationshinweise
=====================

Systemvoraussetzungen
---------------------

* PHP 5.1 (SallyCMS ist vollständig mit PHP 5.3 kompatibel)

  * :envvar:`short_open_tags` muss aktiviert sein (wird im Setup automatisch
    geprüft).
  * :envvar:`register_globals` und :envvar:`magic_quotes_gpc` sollten
    deaktiviert sein.

* MySQL 5.0
* Apache

  * Seit SallyCMS 0.4.2 wird `mod_rewrite <http://httpd.apache.org/docs/2.0/mod/mod_rewrite.html>`_
    zwingend vorausgesetzt.

Upload
------

#. Entpacken Sie das heruntergladene Archiv auf Ihren Rechner.
#. Laden Sie alle Dateien bis auf das :file:`tests`- und das
   :file:`docs`-Verzeichnis aus dem Download-Archiv auf Ihren Webspace.
#. Stellen Sie sicher, dass Sally beim ersten Aufruf das Verzeichnis
   :file:`data` erstellen kann, falls es nicht vorhanden ist. :file:`data` und
   alle darin enthaltenen Verzeichnisse sollten ``chmod 0777`` haben.
#. Rufen Sie das von Ihnen erstellte Verzeichnis im Browser auf, z. B. via
   http://example.com/sally/. Sie sollten dann automatisch zum Setup
   weitergeleitet werden.

Installation
------------

Sprachauswahl
^^^^^^^^^^^^^

.. image:: /_static/step0.png

Wählen Sie die Sprache, mit der die Installation ablaufen soll.

Lizenzabkommen
^^^^^^^^^^^^^^

.. image:: /_static/step1.png

Akzeptieren Sie die Lizenz. Sie müssen hier der GPL zustimmen, da Sally noch
nicht ausschließlich aus MIT-lizensiertem Code besteht.

Schritt 1: Systemvoraussetzungen
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. image:: /_static/step2.png

In diesem Schritt wird die Konfiguration des Servers geprüft. Treten Probleme
auf, die eine Installation verhindern, können Sie den Vorgang ab diesem Punkt
nicht fortsetzen. Andernfalls bestätigen Sie den Schritt und gehen zur
Datenbank-Einrichtung weiter.

Schritt 2: Datenbankinformationen
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. image:: /_static/step3.png

Hier müssen Sie die Zugangsdaten zur Datenbank eintragen. Nach dem Abschicken
des Formulars werden die Daten geprüft und bei einem Fehler wird eine Nachricht
erscheinen und das Formular wieder erscheinen.

.. note::

  Auch wenn es bei der Datenbank-Einrichtung so klingt, als wären die anderen
  DBMS neben MySQL eine gefährliche, aber mögliche Wahl: Dem ist nicht so. Sie
  müssen MySQL auswählen.

Schritt 3: Datenbank einrichten
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. image:: /_static/step4.png

Wählen Sie, ob Sie eine leere Datenbank neu einrichten, eine bestehende
überschreiben oder eine bestehende beibehalten möchten. Für Neu-Installationen
müssen Sie die erste Option auswählen.

Schritt 4: Allgemeine Einstellungen
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. image:: /_static/step5.png

In diesem Schritt können Sie einige Informationen zu Ihrem Projekt angeben.

* Der **Server** wird im Moment von Sally selbst nicht ausgewertet, könnte aber
  von URL-Rewriter-AddOns verwendet werden.
* Die **Serverbezeichnung** wird als Titel des Backends verwendet.
* Die **Fehler E-Mailadresse** wird ebenfalls nicht vom Sally-Core ausgewertet.
* Die **Zeitzone** dient dazu, Problemen auf PHP 5.3-Systemen vorzubeugen (da
  dort eine Zeitzone gesetzt werden muss).

Schritt 5: Adminaccount anlegen
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. image:: /_static/step6.png

Nun haben Sie noch die Möglichkeit, den erste Account einzurichten. Wählen Sie
einen Benutzernamen und ein sicheres Passwort. Sollte bereits ein Admin-Account
existieren, haben Sie nun die Möglichkeit, dessen Passwort neu zu setzen.

Abschluss
^^^^^^^^^

.. image:: /_static/step7.png

Herzlichen Glückwunsch, Sie haben SallyCMS installiert! Sie können sich nun
einloggen und mit der Einrichtung des Projekts loslegen.

Setup neustarten
----------------

Sollte es einmal notwendig sein, das Setup neu zu durchlaufen, kann dies
entweder im Backend (auf der Systemseite) ausgelöst werden, oder in der
:file:`data/config/sly_local.yml` angestoßen werden. Dort muss der Key ``SETUP``
auf ``true`` gesetzt werden.::

  SETUP: true
  SERVER: example.com
  SERVERNAME: 'Mein superduftes Projekt'
  ERROR_EMAIL: webadmin``example.com
  # ...
