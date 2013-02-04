Release-Notes
=============

.. centered:: -- Composer, Dependency Injection & Other Goodies --

Knapp fünf Monate nach dem Release der letzten großen Major-Version freut sich
das Sally-Team, nun die Verfügbarkeit von **SallyCMS 0.8** bekanntzugeben. Das
neue Major Release treibt vor allem die Composer-Integration weiter voran und
führt dazu ein neues, an Symfony2 angelegtes Repository-System ein.

Neben der verbesserten Composer-Integration bringt Version 0.8 ebenfalls noch
ein von Grund auf **neu entwickeltes Setup**, einen
**Dependency Injection**-Container, einen integrierten **CSRF-Schutz** sowie ein
flexibles **Backend-Routing** mit.

Der grobe :doc:`Ablauf eines Updates auf 0.8 <migrate>` wird auf einer extra
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

Composer & Apps
"""""""""""""""

Beginnend mit Version 0.7 wurden sämtliche AddOns und externe Libraries über
Composer installiert. Diese Integration wird in 0.8 noch vertieft, indem nun
auch Sally selbst über Composer installiert sowie der automatisch generierte
Autloader genutzt werden.

Repositories
^^^^^^^^^^^^

Um Sally selbst als externe Library zu betrachten, können Projekte nicht mehr
selbst ein Klon von Sally sein, sondern ein eigenständiges Repository. Dies
entspricht dem Aufbau eines Symfony2-Projekts, bei dem ``symfony/symfony``
ebenfalls erst nachinstalliert wird.

In Sally gibt es fortan eine "Standard-Distribution", deren Paketname
``sallycms/sallycms`` ist. In diesem `Repository <https://bitbucket.org/SallyCMS/sallycms/>`_
gibt es nur die :file:`index.php` und weitere Dateien im Root sowie die
:file:`composer.json`. Die Standard-Distribution ist damit die Grundlage für
neue Projekte und kann entweder heruntergeladen oder geklont werden. Die bisher
bekannten Downloads (Starterkit, Minimal, ...) gibt es dabei weiterhin.

Die Standard-Distribution enthält Abhängigkeiten zu den neuen, in einzelne
Repositories aufgeteilten Sally-Apps, darunter:

* ``sallycms/core``
* ``sallycms/backend``
* ``sallycms/frontend``
* ``sallycms/setup``

Bis auf das Setup gibt es dabei keine großen Neuerungen. Die Apps werden wie
bisher nach ``sally/`` installiert, der Core liegt also in ``sally/core``. Dies
gilt für alle Pakete vom Typ ``sallycms-app``: Es wird immer nur der hintere
Teil des Paketnamens verwendet und statt nach ``sally/vendor/`` nach ``sally/``
installiert. Aus diesem Grund gibt es aus Sicht der Verzeichnisstruktur keine
Änderungen in Version 0.8. AddOns müssen nicht auf ein neues Verzeichnissystem
umgestellt werden.

``sallycms/setup`` ist eine neue App, auf die in einem späteren Abschnitt
eingegangen werden soll.

Der Umbau auf einzelne App-Repositories sorgt dafür, dass zukünftig bei einem
``composer update`` ebenfalls Sally aktualisiert werden kann. Ausgenommen davon
sind die Inhalte des Root-Pakets (``sallycms/sallycms``), aber da die
:file:`index.php` und anderen Dateien wenig Spannendes enthalten, ist das
Verschmerzlich. Bei einer neuen Hauptversion (0.9) können im Zweifelsfall nötige
Änderungen von Hand vorgenommen werden.

Wie in Version 0.7 gehabt, wird ein Projekt dann gestartet, indem weitere
Abhängigkeiten (AddOns) in die :file:`composer.json` eingetragen und installiert
werden.

Autoloading
^^^^^^^^^^^

Im Normalfall generiert Composer einen PHP 5.3-kompatiblen Autoloader, den Sally
nicht verwenden kann (können schon, nur nicht voraussetzen). Um dennoch von den
Vorteilen dieses Autoloaders zu profitieren, haben wir mit
``xrstf/composer-php52`` ein Hilfspaket eingeführt, das zusätzlich zum
originalen Autoloader eine 5.2-kompatible Variante erstellt. Dieser Autoloader
wird in Sally 0.8 als primärer Autoloader verwendet.

Der alte Autoloader, ``sly_Loader``, existiert weiterhin und kann vorerst weiter
verwendet werden, ist aber deprecated. Seine einzige Daseinsberechtigung ist
das Laden von Klassen, deren Name mit einem führenden Unterstrich beginnt. Für
alle anderen Situation ist der Composer-Autoloader von nun an the way to go.

Für AddOn-Autoren gilt, dass sie die ``autoload``-Konfiguration ihrer AddOns
sauber erstellen sollten, da sie mit Version 0.9 noch wichtiger werden sollen.
Gleichzeitig können AddOns, die ihre :file:`composer.json` korrekt definiert
haben, sich die Aufrufe zu ``sly_Loader`` in ihrer :file:`boot.php` sparen.

.. warning::

  Diese Änderung bewirkt ebenfalls, dass grundsätzlich alle Klassen von allen
  AddOns jederzeit bekannt sind, selbst wenn diese nicht in Sally installiert
  und aktiviert sind. Ein ``class_exists('My_AddOn_Class')`` ist damit keine
  geeignete Methode mehr, zu überprüfen, ob ein AddOn aktiviert ist!

Neues Setup
"""""""""""

**TODO**

DI-Container
""""""""""""

**TODO**

CSRF-Schutz
"""""""""""

**TODO**

Backend-Routing
"""""""""""""""

**TODO**

API-Änderungen
--------------

Im Folgenden werden soweit möglich alle API-Änderungen zwischen dem 0.7- und dem
0.8-Branch beschrieben.

**TODO**
