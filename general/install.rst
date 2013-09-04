Installation
============

Dieser Guide beschreibt die Installation des Basissystems von SallyCMS.

Sally steht in zwei verschiedenen Ausführungen bereit:

**Standard**
  Die Standard-Version enthält ausschließlich das Kernsystem und muss, bevor
  sie installiert werden kann, erst mittels Composer_ eingerichtet werden. Dabei
  werden die benötigten Bibliotheken runtergeladen und installiert.
  Diese Variante ist für alle Nutzer empfohlen, da sie es erlaubt, automatisch
  Aktualisierungen für Sally und die verwendeten AddOns zu erhalten.

**Starterkit**
  Für Nutzer, die kein Composer verwenden können oder wollen, steht auch noch
  eine Starterkit-Version bereit. Hier sind bereits die nötigen Bibliotheken
  sowie einige ausgewählte "Standard"-AddOns enthalten.
  Es ist problemlos möglich, mit einem Starterkit zu beginnen und später
  Composer einzusetzen, um Aktualisierungen oder AddOns zu erhalten.

.. _Composer: http://getcomposer.org/

Systemvoraussetzungen
---------------------

* PHP 5.3.2 (SallyCMS ist vollständig mit PHP 5.3 bis 5.5 kompatibel)

  * :envvar:`register_globals` und :envvar:`magic_quotes_gpc` sollten
    deaktiviert sein.
  * Die Standard-Module von PHP werden benötigt: mbstring, PCRE,
    zlib, gd, PDO, json, DateTime, ...

* MySQL 5.0 oder MariaDB 5.0
* Apache 2.2

  * `mod_rewrite <http://httpd.apache.org/docs/2.2/mod/mod_rewrite.html>`_
    wird zwingend vorausgesetzt.

Die Performance eines Projekts kann je nach Umfang deutlich durch den Einsatz
eines Opcode-Caches wie APC oder den in PHP 5.5 integrierten OpCache gesteigert
werden. Zusätzlich kann das Caching von Daten statt im Dateisystem auch in einer
Reihe von dafür ausgelegten Komponenten stattfinden, wie z.B. APC, eine
MySQL-Datenbank, ein Redis- oder Memcached-Server o.ä.

Wir empfehlen APC unter Windows und APC mit Memcached auf Produktivsystemen. In
verteilten Umgebungen kann ein zentraler MySQL-Server eine gute Wahl zu sein
(Memcached kann durch seine Latenz bei vielen Zugriffen deutlich langsamer
sein).

Projekt starten
---------------

#. Lade den Code herunter. Dazu gibt es mehrere Möglichkeiten:

   * Lade ein `fertiges Download-Archiv <https://bitbucket.org/SallyCMS/sallycms/downloads>`_
     herunter. Hier findest du auch die Starterkit-Downloads.
   * Klone mit Mercurial das `Sally-Repository bei Bitbucket <https://bitbucket.org/SallyCMS/sallycms>`_.
     Stelle dabei sicher, im Anschluss auf den richtigen Branch (z. B. ``0.9``)
     oder eine stabile Version (z. B. ``v0.9.0``) zu aktualisieren, um keine
     Überraschungen zu erleben. Mit einem Klon erhälst du automatisch die
     `Standard-Version`.

#. Falls kein Starterkit verwendet wurde, muss Composer einmal aufgerufen
   werden. Die :file:`composer.phar` kann auf der Composer-Website kostenlos
   heruntergeladen werden und sollte im Hauptverzeichnis von Sally abgelegt
   werden. Danach kann sie aufgerufen werden::

   $ php composer.phar install

#. Stelle sicher, dass Sally beim ersten Aufruf das Verzeichnis :file:`data`
   erstellen kann, falls es nicht vorhanden ist. :file:`data` und alle darin
   enthaltenen Verzeichnisse sollten auf *guten* Servern ``chmod 664`` haben.
   Server, bei denen Webserver und FTP als verschiedene User laufen, benötigen
   ``chmod 0777``. Auf Windows-Rechnern gibt es keine Probleme mit den
   Dateiberechtigungen.
#. Rufe das von dir erstellte Projekt im Browser auf, z. B. via
   ``http://localhost/mein-projekt/``. Du solltest dann automatisch zum Setup
   weitergeleitet werden.

Häufige Startprobleme
---------------------

**Das Verzeichnis data kann nicht erzeugt werden.**
  Auf Servern, bei denen (S)FTP und Apache/PHP nicht in der gleichen Gruppe
  liegen, kann es passieren, dass Sally (PHP) keine Erlaubnis hat, im
  Projektverzeichnis das :file:`data`-Verzeichnis anzulegen. In diesem Fall
  hilft es, das Verzeichnis manuell anzulegen und ihm testweise die Rechte
  ``664`` zu geben. Wenn dann die Installation funktioniert: super! Andernfalls
  müssen die Rechte notgedrungen auf ``777`` gesetzt werden.

**CSS oder JavaScript werden nicht geladen.**
  Auf manchen Servern ist es nötig, eine ``RewriteBase``-Direktive in die
  :file:`.htaccess`-Datei einzutragen. Der genaue Wert hängt von der
  Konfiguration des Hosters ab und kann dort erfragt werden.

Installation
------------

Während des Setups ist es möglich, zu vorherigen Schritten zurückzuspringen und
Angaben zu korrigieren. Man kann nur zum nächsten Schritt gelangen, wenn alle
Angaben korrekt konfiguriert sind.

Konfiguration
^^^^^^^^^^^^^

.. image:: /_static/step1.png

Im ersten Schritt wird das Projekt konfiguriert. Gib ihm einen Namen und wähle
die Zeitzone, mit der Zeiten im Backend angezeigt werden sollen. Außerdem muss
hier der Datenbankzugang konfiguriert werden.

.. note::

  Auch wenn es im Setup so klingt, als wären die anderen DBMS neben MySQL eine
  gefährliche, aber mögliche Wahl: Dem ist nicht so. Du musst MySQL auswählen.

.. note::

  Du kannst auch problemlos MariaDB anstatt MySQL verwenden. Im Setup wählt
  man dabei hingegen trotzdem MySQL aus.

Zusätzlich werden im ersten Schritt noch die Eckdaten des Servers (PHP-Version,
erlaubte Scriptlaufzeit sowie erlaubter Speicherverbrauch) ausgegeben.

Einrichtung
^^^^^^^^^^^

.. image:: /_static/step2.png

Auf dieser Seite wird die eben konfigurierte Datenbank eingerichtet. Dabei
werden Tabellen angelegt und ggf. ein Admin-Nutzer angelegt oder aktualisiert.
Je nach Zustand der Datenbank sind im oberen Bereich verschiedene Optionen
zugänglich. Ebenso erscheint die Checkbox `keinen Benutzer anlegen` nur, wenn es
mindestens einen Admin-Nutzer bereits gibt.

Die Umrandung des Passwort-Feldes deutet auf die Stärke des vergebenen Passworts
hin. Im Zweifelsfall kann der nebenstehende Button genutzt werden, um ein
recht gutes, zufälliges Passwort zu erzeugen.

.. warning::

  Das Passwort sollte man sich merken, da man ohne es nicht ins Backend kommen
  wird. Vergisst man es oder hat sich aus Versehen vertippt, so steht weiter
  unten beschrieben, wie man das Setup re-aktiviert. Im re-aktivierten Setup
  kann dann direkt zum zweiten Schritt gegangen und ein neues Passwort vergeben
  werden.

Profit!
^^^^^^^

.. image:: /_static/step3.png

Herzlichen Glückwunsch, du hast SallyCMS installiert! Du kannst dich nun
einloggen und mit der Einrichtung des Projekts loslegen.

Setup neustarten
----------------

Sollte es einmal notwendig sein, das Setup neu zu durchlaufen, kann dies
entweder im Backend (auf der Systemseite) ausgelöst werden, oder in der
:file:`data/config/sly_local.yml` angestoßen werden. Dort muss der Key
``setup`` auf ``true`` gesetzt werden.

.. sourcecode:: yaml

  setup: true
  projectname: 'Mein superduftes Projekt'
  # ...
