Frontend & Backend
==================

Eine Website, die mit SallyCMs erstellt wird, trennt grundsätzlich zwischen zwei
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

Backend
-------

Im Backend werden von den Redakteuren die eigentlichen Inhalte der Website
eingepflegt. Hier können Artikel und Kategorien angelegt sowie je nach Projekt
weitere Einstellungen vorgenommen werden.

Das Backend ist generell über ``/backend`` zu erreichen (beispielsweise über
``http://www.meinewebsite.de/backend``). Der Zugang ist nur vorher
authorisierten Benutzern gestattet, die sich über Benutzername und Passwort
anmelden müssen.

Im Gegensatz zum Frontend sieht das Backend über alle Projekte hinweg identisch
aus. Dies erlaubt es externen Komponenten, das Backend mit eigenen Seiten und
Formularen zu erweitern und stellt dabei einen konsitenten Look&Feel sicher.

Im Backend sind eine Reihe von Unterseiten immer verfügbar, wie beispielsweise
die Strukturverwaltung oder der Medienpool. Je nach Konfiguration, Ausbaustufe
eines Projekts oder Benutzerrechten können weitere Seiten hinzukommen oder auch
nicht verfügbar sein.
