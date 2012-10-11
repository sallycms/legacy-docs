AddOns entwickeln
=================

AddOns sind Erweiterungen für SallyCMS, die sowohl im Frontend als auch im
Backend bei jedem Seitenaufruf geladen (ausgeführt) werden. AddOns können daher
wesentlich tiefer ins System eingreifen als es Module oder Templates könnten.

AddOns können beispielsweise eigene Backend-Seiten anlegen, ihre eigenen
Datenbank-Tabellen oder Backend-Assets mitbringen oder andere spannende Dinge
tun.

Technisch sind AddOns immer gültige `Composer`_-Pakete vom Typ
``sallycms-addon``. Dies bedeutet, dass sie immer nach dem Schema
**vendor/addonname** (z.B. *sallycms/import-export* oder *initech/stapler*)
benannt sein müssen.

.. _Composer: http://getcomposer.org/

AddOns werden im Verzeichnis :file:`sally/addons` abgelegt. Dieses Verzeichnis
folgt der Standard Composer-Struktur und enthält daher pro Vendor ein
Verzeichnis, in dem dann die eigentlichen AddOns liegen. Eine Installation von
Sally könnte die folgenden AddOns enthalten:

::

  /
  +- assets/
  +- data/
  +- sally
     +- addons
     |  +- sallycms
     |  |  +- be-search        <- sallycms/be-search
     |  |  +- import-export    <- sallycms/import-export
     |  +- initech
     |  |  +- stapler          <- initech/stapler
     |  +- webvariants
     |     + deployer          <- webvariants/deployer
     |     + wymeditor         <- webvariants/wymeditor
     +- core
     +- ...

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
