Änderungen einsenden
====================

.. note::

  Diese Seite bezieht sich auf das Kernsystem. Informationen über die
  Dokumentation finden sich :doc:`auf einer anderen Seite <docs>`.

Bevor wir zu den Wegen kommen, wie Änderungen schlussendlich an uns geschickt
werden können, hier noch ein paar Hinweise / Guidelines:

* Achte darauf, dass dein Name korrekt angegeben (in Mercurial konfiguriert ist)
  ist. Wir verwenden das Format ``Voller Name <email@provider>``.
* Halte Änderungen klein und überschaubar. Niemand will einen 50KB großen Patch
  durchsehen. Jeder Commit/Patch sollte so inhaltlich abgeschlossen wie möglich
  sein. Es ist absolut OK, bei drei geänderten Zeilen in drei Dateien auch drei
  Commits zu machen, wenn die Änderungen nichts miteinander zu tun haben.
* Wenn möglich, verfasse Code-Doku und Commit-Nachricht auf Englisch.
* Bezeichner im Code müssen Englisch benannt werden und sollten dem folgenden
  Schema folgen:

  * ``variable``
  * ``reallyLongVariable``
  * ``MY_CONSTANT``
  * ``class MyClass``
  * ``function myFunctionOrMethod``
  * :doc:`vollständige Coding-Guidelines <coding-guidelines>`

* Verwende **kein** Namenspräfix oder sonstige Markierung in der
  Commit-Nachricht ("[xrstf]", "[i18n]", "[Backend]" oder dergleichen).
* Stelle sicher, dass deine Commits / Patches auf einer aktuellen Sally-Revision
  basieren. Führe notfalls
  `rebase <http://mercurial.selenic.com/wiki/RebaseExtension#Integration_with_pull>`_
  aus, um deine Änderungen zu aktualisieren. Konflikte beim Einspielen werden
  wir nicht beheben: Es sind deine Änderungen, von denen **du** die meiste
  Ahnung hast.
* Wenn möglich, sag uns, zu welchem Branch deine Änderung gehört. Neue Features
  werden immer in den Trunk aufgenommen, während Bugfixes soweit als möglich in
  Branches gemacht werden.
* Eingesendeter Code wird in SallyCMS unter MIT-Lizenz veröffentlicht.
  **GPL-Code ist damit nicht erlaubt.**

Clone & Pull-Request auf Bitbucket (empfohlen)
----------------------------------------------

Der vermutlich einfachste Weg, Änderungen beizusteuern, besteht darin, SallyCMS
auf Bitbucket zu klonen und in deinem eigenen Klon zu arbeiten. Du hast damit
die gesamte Projektgeschichte von Sally auf deinem Rechner und bist damit
unabhängig von dem offiziellen Repository. Natürlich kannst (und solltest)
deinen Klon jederzeit aktualisieren, indem du einen Pull auf das offizielle
Repository durchführst.

Wenn du mit deinen Änderungen fertig bist, pushe sie auf Bitbucket. Dort kannst
du uns dann einen Pull-Request senden. Diesem gehen wir dann nach, schauen uns
die Änderungen an und importieren sie dann in das offizielle Repository.

Clone & Eigenes Hosting
-----------------------

Natürlich kannst du deinen Klon von Sally auch auf einem anderen für uns
zugänglichen Ort platzieren. Solange wir auf diesen Ort mit Mercurial zugreifen
können, ist das in Ordnung. In dem Fall müsste uns der Pull-Request auf andere
Art erreichen: E-Mail, Twitter, ...

Patches einsenden
-----------------

Wenn kein Hosting gewünscht ist, können uns auch Patches geschickt werden. Diese
sollten im Idealfall von Mercurial erzeugt worden sein, allerdings sind die
Patches jedes anderen VCS auch OK. Patches sollten per E-Mail eingeschickt
werden und jeweils als Anhang beigefügt werden.

Achte darauf, dass bestimmte Operationen wie das Löschen oder Umbenennen von
Dateien in Mercurial nur dann im Patch auftauchen, wenn das erweiterte
Git-Format aktiviert ist.

Sonstiges
---------

Wenn wirklich gar nicht anders möglich, können kleine Änderungen und Einzeiler
natürlich auch formlos via E-Mail eingeschickt werden. Dabei kann allerdings
nicht sichergestellt werden, dass du als Autor auftauchst, da wir selten Lust
und Nerv haben, den Autor in TortoiseHg umzustellen.
