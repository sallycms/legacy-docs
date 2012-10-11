Installation
============

Dieser Guide beschreibt die Installation des Basissystems von SallyCMS.

Sally steht in zwei verschiedenen Ausführungen bereit:

**Composer**
  Die Composer-Version enthält ausschließlich das Kernsystem und muss, bevor
  sie installiert werden kann, erst mittels Composer_ eingerichtet werden. Dabei
  werden die benötigten Bibliotheken runtergeladen und installiert.
  Diese Variante ist für alle Nutzer empfohlen, da sie es erlaubt, automatisch
  Aktualisierungen für Sally und die verwendeten AddOns zu erhalten.

**Standalone**
  Für Nutzer, die kein Composer verwenden können oder wollen, steht auch noch
  eine Standalone-Version bereit. Hier sind bereits die nötigen Bibliotheken
  enthalten (nicht jedoch eventuelle AddOns).
  Es ist problemlos möglich, mit einem Standalone-Paket zu beginnen und später
  Composer einzusetzen, um Aktualisierungen oder AddOns zu erhalten.

.. _Composer: http://getcomposer.org/

Systemvoraussetzungen
---------------------

* PHP 5.2 (SallyCMS ist vollständig mit PHP 5.2 bis 5.4 kompatibel)

  * :envvar:`register_globals` und :envvar:`magic_quotes_gpc` sollten
    deaktiviert sein.
  * Die Standard-Module von PHP werden benötigt: mbstring, PCRE,
    zlib, gd, PDO, json, DateTime, ...
  * Für den Einsatz von Composer ist PHP 5.3+ notwendig. Für das reine
    Ausführen von Sally ist dabei weiterhin 5.2 benötigt; Composer kommt nur
    "außerhalb" von Sally zum Verwalten der Abhängigkeiten zum Einsatz. Ein
    Composer-Projekt kann also problemlos auf Servern mit PHP 5.2 deployt
    werden.

* MySQL 5.0 oder MariaDB 5.0
* Apache 2.2

  * `mod_rewrite <http://httpd.apache.org/docs/2.2/mod/mod_rewrite.html>`_,
    `mod_headers <http://httpd.apache.org/docs/2.2/mod/mod_headers.html>`_ und
    `mod_setenvif <http://httpd.apache.org/docs/2.2/mod/mod_setenvif.html>`_
    werden zwingend vorausgesetzt.

Optional kann SallyCMS die folgenden Komponenten verwenden, um die Performance
zu steigern:

* XCache, APC, Zend Data Server, eAccelerator
* Memcache (php_memcache), Memcached (php_memcached)

Wir empfehlen APC unter Windows und APC mit Memcached auf Produktivsystemen.

Projekt starten
---------------

#. Lade den Code herunter. Dazu gibt es mehrere Möglichkeiten:

   * Lade ein `fertiges Download-Archiv <https://projects.webvariants.de/projects/sallycms/files>`_ herunter.
   * Klone mit Mercurial das `Sally-Repository bei Bitbucket <https://bitbucket.org/SallyCMS/0.7>`_.
   * Klone mit Git das `Sally-Repository bei GitHub <https://github.com/sallycms/0.7>`_.

   Beachte, dass die Repositories die benötigten Bibliotheken nicht enthalten
   und daher Composer verwendet werden muss, um daraus lauffähige Projekte zu
   erstellen.
#. Falls keine Standalone-Variante verwendet wurde, muss Composer einmal
   aufgerufen werden. Die :file:`composer.phar` kann auf der Composer-Website
   kostenlos heruntergeladen werden und sollte im Hauptverzeichnis von Sally
   abgelegt werden. Danach kann sie aufgerufen werden::

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

  Wenn eine ``RewriteBase`` gesetzt wurde, muss diese auch im Asset-Cache von
  Sally eingetragen werden. Dazu hat Sally nach dem ersten Aufruf des Systems
  bereits die Datei :file:`data/dyn/public/sally/static-cache/.htaccess`
  angelegt. Wenn in der Frontend-:file:`.htaccess` die Basis ``/myproject/``
  eingetragen wurde, muss im Asset-Cache die Basis
  ``/myproject/data/dyn/public/sally/static-cache/`` notiert werden.

Installation
------------

Sprachauswahl
^^^^^^^^^^^^^

.. image:: /_static/step0.png

Wähle die Sprache, mit der die Installation ablaufen soll.

Lizenzabkommen
^^^^^^^^^^^^^^

.. image:: /_static/step1.png

Akzeptiere die Lizenz. Du musst hier der MIT zustimmen, die für den Systemkern
sowie alle AddOns von SallyCMS (BE-Search, Import/Export und Image-Resize) gilt.
AddOns können natürlich ggf. andere Lizenzen einsetzen.

Schritt 1: Systemvoraussetzungen
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. image:: /_static/step2.png

In diesem Schritt wird die Konfiguration des Servers geprüft. Treten Probleme
auf, die eine Installation verhindern, kannst du den Vorgang ab diesem Punkt
nicht fortsetzen. Wenn es keine Probleme gibt, wird dieser Schritt automatisch
übersprungen und du zum Datenbank-Setup weitergeleitet.

Schritt 2: Datenbankinformationen
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. image:: /_static/step3.png

Hier musst du die Zugangsdaten zur Datenbank eintragen. Nach dem Abschicken
des Formulars werden die Daten geprüft und bei einem Fehler wird eine Nachricht
erscheinen und das Formular wieder erscheinen.

.. note::

  Auch wenn es bei der Datenbank-Einrichtung so klingt, als wären die anderen
  DBMS neben MySQL eine gefährliche, aber mögliche Wahl: Dem ist nicht so. Du
  musst MySQL auswählen.

.. note::

  Du kannst auch problemlos MariaDB anstatt MySQL verwenden. Im Setup wählt
  man dabei hingegen trotzdem MySQL aus.

Schritt 3: Datenbank einrichten
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. image:: /_static/step4.png

Wähle, ob du eine leere Datenbank neu einrichten, eine bestehende überschreiben
oder eine bestehende beibehalten möchtest. Für Neu-Installationen musst du die
erste Option auswählen.

Schritt 4: Allgemeine Einstellungen
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. image:: /_static/step5.png

In diesem Schritt kannst du einige Informationen zu deinem Projekt angeben.

* Der **Projektname** wird als Titel des Backends verwendet.
* Die **Zeitzone** dient dazu, Problemen auf PHP 5.3-Systemen vorzubeugen (da
  dort eine Zeitzone gesetzt werden muss).

Schritt 5: Adminaccount anlegen
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. image:: /_static/step6.png

Nun hast du noch die Möglichkeit, den ersten Account einzurichten. Wähle
einen Benutzernamen und ein sicheres Passwort. Sollte bereits ein Admin-Account
existieren, hast du nun die Möglichkeit, dessen Passwort neu zu setzen.

Abschluss
^^^^^^^^^

.. image:: /_static/step7.png

Herzlichen Glückwunsch, du hast SallyCMS installiert! Du kannst dich nun
einloggen und mit der Einrichtung des Projekts loslegen.

Setup neustarten
----------------

Sollte es einmal notwendig sein, das Setup neu zu durchlaufen, kann dies
entweder im Backend (auf der Systemseite) ausgelöst werden, oder in der
:file:`data/config/sly_local.yml` angestoßen werden. Dort muss der Key
``SETUP`` auf ``true`` gesetzt werden.

.. sourcecode:: yaml

  SETUP: true
  PROJECTNAME: 'Mein superduftes Projekt'
  # ...
