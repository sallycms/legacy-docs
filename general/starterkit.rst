Starterkit
==========

Das Starterkit ist eine schnelle und einfache Art, mit der Entwicklung eines
Sally-Projekts zu beginnen oder Sally erst einmal kennenzulernen. Außerdem zeigt
es einige Best Practices in der Projektentwicklung.

Dazu sind im Starterkit enthalten:

* ein minimales Frontend

  * einfache Navigation
  * Header und Footer basierend auf Global Settings
  * Spamschutz im CKEditor-Content
  * simples XHTML5-Layout

* ein wenig Demo-Content (Artikel, Kategorien)
* einige "Standard"-AddOns

  * Der `CKEditor <https://bitbucket.org/mediastuttgart/ckeditor>`_
    stellt einen umfangreichen Editor für das Backend zur Verfügung.
  * `realURL2 <https://bitbucket.org/webvariants/realurl2>`_ kümmert sich um die
    sprechenden, "SEO-freundlichen" URLs.
  * `BE-Search <https://bitbucket.org/SallyCMS/be-search>`_ vereinfacht die
    Navigation in der Strukturansicht.
  * `Image Resize <https://bitbucket.org/SallyCMS/image-resize>`_ kann Bilder im
    Frontend verkleinern und zuschneiden.
  * `Metainfo <https://bitbucket.org/webvariants/meta-infos>`_ dient zur
    Verwaltung der Metainformationen (sic!) an Artikeln, Kategorien, Medien und
    Nutzern.
  * `Global Settings <https://bitbucket.org/webvariants/global-settings>`_
    dient zur Verwaltung von Einstellungen, wie zum Beispiel speziellen
    Artikeln, bestimmten Texten, eMail-Adressen, etc.
  * Das `rbac-AddOn <https://bitbucket.org/webvariants/rbac>`_ stellt
    Berechtigungen für Backend-Nutzer auf Basis von Benutzerollen zur Verfügung.
    Das dazugehörige `rbac-treeview-AddOn <https://bitbucket.org/webvariants/rbac-treeview>`_
    sorgt für eine optimierte Anzeige der vielen Optionen beim Bearbeiten einer
    Rolle.
  * Der `Deployer <https://bitbucket.org/webvariants/deployer>`_ dient
    dazu, über ``sly_Layout`` eingebundene CSS/JS-Dateien automatisch
    zusammenzufassen und zu minimieren. Dies geschieht für den Entwickler
    transparent.
  * `Import/Export <https://bitbucket.org/SallyCMS/import-export>`_ dient zum
    Sichern der Datenbank und der Konfiguration.
  * `Developer Utils <https://bitbucket.org/webvariants/developer-utils>`_
    ist ein AddOn, das eine Sammlung zusätzlicher Bibliotheken bereitstellt (wie
    z.B. ``WV_Sally``, die Datentypen und weitere).

Die Installation des Starterkits verläuft quasi analog zur
:doc:`regulären Installation <install>`.
