Änderungen gegenüber REDAXO
===========================

.. note::

  Die folgenden Hinweise beziehen sich auf REDAXO 4.

master.inc.php?
---------------

Die lokale Konfiguration (das sind die Daten, die bei jeder Installation anders
sind, wie zum Beispiel die Datenbank-Zugangsdaten) wird in der Datei
:file:`data/config/sly_local.yml` als gespeichert.

Die projektspezifische Konfiguration (die, die sich nicht pro Host, wohl aber
pro Projekt unterscheidet) liegt in der Datei
:file:`data/config/sly_project.yml`. Um sie mitzusichern, muss im
Import/Export-AddOn das Häkchen bei "Konfiguration" gesetzt werden.

Magic Quotes
------------

Im Gegensatz zu REDAXO nutzt SallyCMS **keine Magic Quotes** mehr. Die
:file:`master.inc.php` wird sie, falls sie noch aktiviert sind, entfernen.

Sollten Sie sich darauf verlassen, dass Daten in ``$_POST`` (und den anderen
Superglobalen) mit Quotes versehen sind, sollten Sie dringend umlernen. Magic
Quotes werden in PHP 6 endgültig entfernt und boten noch nie echten Schutz gegen
SQL-Injections.

Sollten Sie bisher schon die Magic Quotes von REDAXO wieder entfernt haben (um
zum Beispiel ``mysql_real_escape_string`` zu verwenden), können Sie sich den
Schritt in SallyCMS sparen. Außerdem ist das Escapen von Variablen durch den
Einsatz von ``sly_DB_PDO_Persistence`` meist eh unnötig, da Prepared Statements
zum Einsatz kommen.

Ist es doch einmal nötig, Daten zu escapen, kann ``quote()`` verwendet werden:

.. sourcecode:: php

  <?
  $sql = sly_DB_Persistence::getInstance();
  $var = $sql->quote('myvalue');

Beachten Sie, dass die Funktion bereits die Quotes um den String hinzufügt (d.h.
obiger Aufruf ergibt den String ``'myvalue'`` (inkl. der beiden Quotes!)).

Passwörter
----------

SallyCMS verwendet einen Salt, um das Speichern der Passwörter noch sicherer zu
machen. Aus diesem Grund ist es auch nicht mehr möglich, die "Verschlüsselung"
der Passwörter abzuschalten. Es wird immer **SHA-1** verwendet.

Der Salt ist für normale Backend-Benutzer immer der Wert von ``INSTNAME``, der
bei der Installation erzeugt wird und in etwa wie *sly20100610292355* aussieht.
Damit ergeben sich **für das gleiche Passwort unterschiedliche Hashes**.

Als Konsequenz können die Passwörter der Benutzer-Accounts nicht zwischen
verschiedenen Installation ausgetauscht werden. Ein einfacher SQL-Dump der
``sly_user``-Tabelle würde nichts bringen (man könnte sich nicht einmal im
Backend einloggen, da das eigene Admin-Passwort nicht mehr passt und der
richtige Hash auch nicht ohne Weiteres ermittelt werden kann.)

Im einfachsten Fall gleicht man, wenn die Accounts übertragen werden müssen, den
Wert der ``INSTNAME`` in :file:`data/config/sly_local.yml` an den aus der
Quell-Installation an.
