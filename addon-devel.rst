AddOns entwickeln
=================

AddOns sind Erweiterungen für SallyCMS, die sowohl im Frontend als auch im
Backend bei jedem Request geladen (ausgeführt) werden. AddOns können daher
wesentlich tiefer ins System eingreifen als es Module oder Templates könnten.

AddOns können beispielsweise eigene Backend-Seiten anlegen, ihre eigenen
Datenbank-Tabellen oder Backend-Assets mitbringen oder andere spannende Dinge
tun.

AddOns müssen im Verzeichnis :file:`sally/addons` abgelegt werden. Pro AddOn
existiert dort ein Verzeichnis, indem sich alle Bestandteile eines AddOns
befinden.

Meistens werden AddOns nicht nur für ein einzelnes Projekt entwickelt, sondern
in einer generischen Form, die die Wiederverwendung in anderen Projeken erlaubt.

.. toctree::
   :maxdepth: 2

   addon-devel/structure
   addon-devel/controllers
   addon-devel/be-navigation
   addon-devel/be-layout
   addon-devel/i18n
   addon-devel/extended
