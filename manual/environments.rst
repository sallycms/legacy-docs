Frontend & Backend
==================

Eine Website, die mit SallyCMS erstellt wird, trennt grundsätzlich zwischen zwei
verschiedenen Umgebungen: Das **Frontend** für Besucher und das **Backend** für
die Redakteure und Administratoren.

Frontend
--------

Das Frontend ist der Bereich, den die Besucher der Website im Allgemeinen sehen.
Hier werden die im Backend eingegebenen Inhalte in dem Design der Website
angezeigt und dieser Teil ist es auch, den Suchmaschinen sehen und in ihre
Indexe aufnehmen.

Die Gestaltung des Frontends ist in Sally *vollständig* dem Entwickler
(Integrator) überlassen. Es stehen viele Helfer bereit, um beispielsweise
Navigationen zu erstellen, aber das konkrete Aussehen und Verhalten wird von
Sally in keinster Weise vorgegeben. Entwickler sind frei darin, das Markup und
die URL-Struktur zu wählen und ganz nach ihren Wünschen (bzw. den Anforderungen
des Projekts) anzupassen.

Weiterführende Informationen *für Entwickler*:

* :doc:`Develop-System </frontend-devel/develop>`
* :doc:`Assets (CSS, JavaScript, ...) </frontend-devel/assets>`
* :doc:`Events </frontend-devel/listeners>`

Backend
-------

Im Backend werden von den Redakteuren die eigentlichen Inhalte der Website
eingepflegt. Hier können Artikel und Kategorien angelegt sowie je nach Projekt
weitere Einstellungen vorgenommen werden.

.. note::

  In anderen CMS wird dieser Bereich auch "Admin Control Panel" oder
  "Administration" genannt.

Das Backend ist mit einem beliebigen Webbrowser generell über ``/backend`` zu
erreichen (beispielsweise über ``http://www.meinewebsite.de/backend``). Der
Zugang ist nur vorher authorisierten Benutzern gestattet, die sich über
Benutzername und Passwort anmelden müssen. Benutzerkonten werden vom
Administrator beim Einrichten der Website angelegt.

.. figure:: /_static/backend-login.png
   :align: center
   :scale: 75%
   :width: 1044
   :height: 716
   :alt: Login-Seite des Backends

   Login-Seite des Backends einer Beispiel-Website

Im Gegensatz zum Frontend sieht das Backend über alle Projekte hinweg identisch
aus. Dies erlaubt es externen Komponenten, das Backend mit eigenen Seiten und
Formularen zu erweitern und stellt dabei einen konsistenten "Look&Feel" sicher.

.. note::

  Natürlich ist es möglich, das Backend anzupassen, eigenes CSS/JS zu laden oder
  sogar eigene Backend-Seiten anzulegen. In den meisten Fällen wird das Backend
  jedoch nicht umgestaltet.

Nach einem erfolgreichen Login gelangt man zur sogenannten **Strukturansicht**,
die ebenfalls im Menü über **Struktur** zu erreichen ist. Die Strukturverwaltung
ist der zentrale Ausgangspunkt der redaktionellen Arbeit.

Im Backend sind eine Reihe von Unterseiten immer verfügbar, wie beispielsweise
die Strukturverwaltung oder der Medienpool. Je nach Konfiguration, Ausbaustufe
eines Projekts oder Benutzerrechten können weitere Seiten hinzukommen oder auch
nicht verfügbar sein.

Weiterführende Informationen:

* :doc:`Backend-Übersicht <be-overview>`
* :doc:`Assets (CSS, JavaScript, ...) </frontend-devel/assets>`
* :doc:`Events </frontend-devel/listeners>`
