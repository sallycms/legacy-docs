Übersicht
=========

Das Backend ist mit einem beliebigen Webbrowser generell über ``/backend`` zu
erreichen (beispielsweise über ``http://www.meinewebsite.de/backend``).

.. figure:: /_static/backend-login.png
   :align: center
   :scale: 75%
   :width: 1044
   :height: 716
   :alt: Login-Seite des Backends

   Login-Seite des Backends einer Beispiel-Website

Anmelden
--------

Der Zugang zum Backend erfordert einen Benutzernamen und ein Passwort. Diese
beiden Angaben werden generell vom Administrator an die Redakteure verteilt.
Nach einem erfolgreichen Login gelangt man zur Strukturansicht. Hier werden die
meisten Inhalte der Website verwaltet.

Abmelden
--------

Wenn die Arbeit im CMS abgeschlossen ist, sollte die laufende Sitzung immer
über den "Abmelden"-Link im oberen Bereich beendet werden. Dies verhindert, dass
andere Personen, die Zugang zum Rechner haben, unberechtigterweise noch
Operationen durchführen können.

Aufbau
------

.. figure:: /_static/backend-structure.png
   :align: center
   :alt: Strukturansicht der Sally-Demoseite

   Strukturansicht der Sally-Demoseite

Das Backend teilt sich in die folgenden groben Bereiche auf:

* **oben** ist die Kopfzeile, in der man zum :doc:`eigenen Profil <profile>`,
  der Website oder zum Logout gelangt. Über "Zur Website" kann das
  :doc:`Frontend <../environments>` erreicht werden.
* **links** ist das Menü zu sehen, das sich in die beiden Gruppen "Basis" und
  "AddOns" aufteilt. Einige der Menüpunkte können beim Aufruf noch Unterpunkte
  enthalten, über die weitere Funktionen zugänglich sind.
* **rechts** ist der Inhaltsbereich, der den größten Teil des Backend einnimmt
  und je nach Unterseite anders gestaltet ist. Im obigen Bild ist die
  :doc:`Strukturansicht <structure>` zu sehen, bei der die Kategorien und
  Artikel in Form von Tabellen aufgelistet werden.
* **unten** ist die Fußzeile platziert, in der die Laufzeit (die Zeit, die Sally
  benötigte, um die Seite zu generieren) sowie das aktuelle Datum angezeigt
  werden.

.. note::

  Je nach Benutzerrechten und Projekt kann es sein, dass mehr oder weniger
  Menüpunkte zu sehen sind. Redakteure haben generell eingeschränkte
  Zugriffsrechte und dürfen beispielsweise die :doc:`Systemseite <system>`
  nicht verwenden, während Administratoren auf alle Bereiche uneingeschränkten
  Zugriff haben.
