Profilseite
===========

Das *eigene* Profil kann über den kleinen Link im oberen Bereich des Backends
erreicht werden. Dort können dann das eigene Passwort, Sprache oder Zeitzone
bearbeitet werden.

.. figure:: /_static/backend-profile.png
   :align: center
   :alt: Profilseite im Backend

   Profilseite im Backend

Folgende Angaben sind einzusehen und teilweise auch änderbar:

**Benutzername**
  Dies ist der eigene Benutzername. Da Sally intern Daten mit diesem Namen
  verknüpft, kann er nicht nachträglich verändert werden.

**Passwort**
  Sally speichert Passwörter grundsätzlich niemals im Klartext ab und kann es
  daher im Backend auch nicht anzeigen. Über das Eingabefeld kann allerdings
  ein neues Passwort gewählt werden, wenn gewünscht. Das Feld sollte
  leergelassen werden, wenn das Passwort nicht geändert werden soll.

  .. warning::

    Passwörter sollten niemals weitergegeben werden. Gleichzeitig sollten sich
    niemals mehrere Personen ein einzelnes Benutzerkonto teilen.

  .. note::

    Wir empfehlen, statt eines einfachen Passworts lieber eine ganze
    **Passphrase** zu verwenden. So ist zum Beispiel der Satz *"Ich bin Max und
    dies ist mein ultrasicheres Passwort."* deutlich sicherer und vor allem
    einfacher zu merken als *thx1138yq*. Gleichzeitig empfehlen wir den Einsatz
    eines Passwort-Managers wie `KeePass <http://keepass.info/>`_, um die
    Zugangsdaten sicher und komfortabel abzulegen. KeePass ist freie Software,
    kostenlos und kann auch kommerziell uneingeschränkt eingesetzt werden.

**Name**
  Dies ist der eigene, volle Name.

**Beschreibung**
  Hier kann eine Beschreibung für den eigenen Account eingegeben werden. Dies
  ist primär für Administratoren von Relevanz, um kleine Notizen zu hinterlegen.

**Backendsprache**
  Das Sally-Backend ist in *Deutsch* und *Englisch* verfügbar. Hier kann die
  anzuzeigende Sprache umgestellt werden. Statt einer expliziten Sprache kann
  auch der *(Projektstandard)* ausgewählt werden.

  .. note::

    Die Backend-Sprache betrifft nicht die eigentlichen **Inhalte** der Seite,
    sondern ändert nur die Sprache der Benutzeroberfläche ab. Dass Sally nur
    zwei Sprachen im Backend anbietet bedeutet nicht, dass die Website nicht
    in beliebig vielen Sprachen gepflegt werden kann. Die im Inhaltssprachen
    werden auf der :doc:`Systemseite <system/languages>` gepflegt (was in der
    Regel Aufgabe des Integrators beim Erstellen der Website ist).

**Zeitzone**
  Hier kann aus einer Reihe von Zeitzonen die passende ausgewählt werden. Dies
  beeinflusst hauptsächlich die angezeigten Datumsangaben, die dann in die
  eigene Zeitzone umgerechnet werden (so kann ein Benutzer in Deutschland
  einen Artikel um 15 Uhr bearbeiten und ein Benutzer in England sieht diese
  Zeit durch die andere Zeit als 13 Uhr).

.. note::

  Um andere Benutzerkonten zu bearbeiten, muss der Zugriff auf die
  :doc:`Benutzerseite <users>` gewährt werden. Dort können dann die Konten und
  Benutzerrechte verwaltet werden. Dies ist in der Regel jedoch Aufgabe des
  Administrators.
