Release-Notes
=============

.. note::

  Dieses Dokument ist noch nicht vollständig. Angaben können sich ohne
  Ankündigung bis zum Release noch ändern.

.. centered:: -- zwischen Featurewahn und Produktpflege ;) --

Das Sally-Team freut sich, die Verfügbarkeit von **SallyCMS 0.6** bekannt zu
geben. Dieses Release stellt einen großen Schritt in Richtung GPL-Freiheit,
Vereinheitlichung bestehender Features und neues Backend dar. Seit der
Veröffentlichung von Version 0.5 im August sind knapp **500 Commits** von
**4 Committern** in die Entwicklung geflossen.

Der grobe :doc:`Ablauf eines Updates auf 0.6 <migrate>` wird auf einer extra
Seite beschrieben.

Features
--------

Systemvoraussetzungen
---------------------

Beginnend mit Version 0.6 gestalten sich die Voraussetzungen wie folgt:

* PHP 5.2+ (bisher: 5.1)
* JSON- und DateTime-Support müssen in PHP verfügbar sein.
* ``short_open_tags`` wird nicht mehr benötigt.

API-Änderungen
--------------

Im Folgenden werden soweit möglich alle API-Änderungen zwischen dem 0.5- und dem
0.6-Branch beschrieben.

Konfiguration
"""""""""""""

* ``RELOGINDELAY``, ``BLOCKED_EXTENSIONS`` und ``START_PAGE`` wurden in
  statische Konfiguration des Backends überführt (sind aber weiterhin auf die
  gleiche Weise abrufbar).
* ``MEDIAPOOL/BLOCKED_EXTENSIONS`` wurde in statische Konfiguration des Backends
  überführt und in ``BLOCKED_EXTENSIONS`` umbenannt.
* ``USE_MD5`` wurde entfernt.
* Die Permissions werden jetzt nicht mehr über ``PERM``, ``EXTPERM`` und
  ``EXTRAPERM`` gesteuert, sondern über das neue Authorisation-System (siehe
  Abschnitt weiter oben).

Globale Variablen
"""""""""""""""""

* Die Konstante ``IS_SALLY`` wurde entfernt.

Datei(system)
"""""""""""""

.. note::

  Siehe dazu auch die :doc:`Verzeichnisstruktur </general/birdseye>`.

* Das :file:`data`-Verzeichnis wurde wieder (wie in Sally 0.4) in das
  Wurzelverzeichnis des Projekts verschoben.
* Alle Funktionssammlungen in :file:`sally/core/functions` wurden entfernt.

Datenbank
"""""""""

* Alle Felder, die ``prior`` im Namen hatten, wurden in ``pos`` umbenannt.
* Es werden getrennte Installationsscripts pro DBMS mitgeliefert. Die
  :file:`user.sql` wurde entfernt.

Die Datenbank kann über die folgenden SQL-Statements aktualisiert werden.
Bestehende Daten gehen dabei nicht verloren.

.. sourcecode:: mysql

  ALTER TABLE `sly_article` CHANGE COLUMN `catprior` `catpos` INT(11) NOT NULL AFTER `catname`;
  ALTER TABLE `sly_article` CHANGE COLUMN `prior` `pos` INT(11) NOT NULL AFTER `startpage`;
  ALTER TABLE `sly_article_slice` CHANGE COLUMN `prior` `pos` INT(11) NOT NULL AFTER `startpage`;

JavaScript
""""""""""

Die in 0.5 eingeführten Erweiterungen wurden noch einmal verfeinert und wie
folgt geändert:

* ``sly.openMediapool(subpage, value, callback)`` nimmt zwei weitere Parameter
  zum Einschränken der Dateitypen und Kategorien entgegen. Beide sind optional.
* ``sly.openLinkmap(subpage, value, callback)`` nimmt zwei weitere Parameter
  zum Einschränken der Artikeltypen und Kategorien entgegen. Beide sind
  optional.
* ``sly.inherit(subClass, baseClass)`` ist nun ein öffentlicher Helper, um zwei
  Prototypen zu verketten (also eine Klasse in JavaScript abzuleiten).
* ``sly.initWidgets(context)`` kann dazu verwendet werden, nachträglich via
  DOM-Operationen eingefügte Widgets zu initialisieren.

Globale Funktionen
""""""""""""""""""

* Die folgenden Typen, die bei ``sly_settype()`` (meistens über ``sly_get()``
  oder ``sly_post()`` genutzt) verwendet werden konnten, wurden entfernt:

  * ``rex-*`` (wurden nicht alle entsprechend validiert und waren daher
    irreführend)
  * ``uinteger``, ``uint``, ``udouble``, ``ufloat``, ``ureal``

* ``rex_send_article()``, ``rex_send_content()``, ``rex_send_last_modified()``
  und ``rex_send_etag()`` wurden entfernt. Die Optionen wurden soweit möglich
  in das ``sly_Response``-Objekt verlegt, das von den Apps zurückgegeben und
  an den Client gesendet wird.
* Slice-Funktionen

  * ``rex_moveSliceUp()`` und ``rex_moveSliceDown()`` wurden entfernt.
  * ``rex_moveSlice()`` wurde in ``sly_Service_ArticleSlice->move()`` verlegt.
  * ``rex_deleteArticleSlice()`` wurde in ``sly_Service_ArticleSlice->deleteById()``
    verlegt.
  * ``rex_slice_module_exists()`` wurde entfernt und durch
    ``sly_Util_ArticleSlice::getModule`` ersetzt

* Artikel-Funktionen

  * ``rex_article2startpage()`` wurde entfernt und durch
    ``sly_Service_Article->convertToStartArticle()`` ersetzt.
  * ``rex_copyContent()`` wurde entfernt und durch
    ``sly_Service_Article->copyContent()`` ersetzt.
  * ``rex_copyArticle()`` wurde entfernt und durch
    ``sly_Service_Article->copy()`` ersetzt.
  * ``rex_moveArticle()`` wurde entfernt und durch
    ``sly_Service_Article->move()`` ersetzt.
  * ``rex_moveCategory()`` wurde entfernt und durch
    ``sly_Service_Category->move()`` ersetzt.
  * ``rex_deleteArticle()`` wurde entfernt und durch
    ``sly_Service_Article->delete()`` ersetzt.

* Cache-Funktionen

  * ``rex_generateAll()`` wurde entfernt und durch ``sly_Core::clearCache()``
    ersetzt.
  * ``rex_deleteCacheArticle()`` wurde entfernt.

* Globals

  * ``_rex_array_key_cast()`` wurde entfernt und durch ``sly_setarraytype()``
    ersetzt.
  * ``_rex_cast_var()`` wurde entfernt und durch ``sly_settype()`` ersetzt.

* Sonstige

  * ``rex_translate()`` wurde durch ``sly_translate()`` umbenannt. Die neue
    Funktion wendet nicht mehr automatisch ``sly_html()`` auf die Übersetzung
    an!
  * ``rex_copyDir()`` wurde entfernt und durch ``sly_Util_Directory->copyTo()``
    ersetzt.
  * ``rex_message()``, ``rex_info()``, ``rex_warning()`` und
    ``rex_split_string()`` wurden entfernt.
  * ``sly_isEmpty()`` wurde entfernt.
  * ``t()`` verwendet nun immer das global ``sly_I18N``-Objekt, der Fallback auf
    das Translator-AddOn wurde entfernt.

Core-API
""""""""

* ``Services_JSON`` wurde entfernt, da nun in PHP vorhandener JSON-Support
  vorausgesetzt wird. Damit einher geht auch das Verschwinden der Funktion
  ``json_get_service()``.
* ``OOArticleSlice`` wurde entfernt und durch ``sly_Service_ArticleSlice``
  ersetzt.
* Alle ``rex_var``-Klassen wurden entfernt.
* ``sly_App_Base`` wurde als Basisklasse für alle Apps ergänzt. Apps müssen
  allerdings nur ``sly_App_Interface`` implementieren.
* **Auth-System**

  * Das Interface ``sly_Authorisation_Provider`` hat sich geändert: die Signatur
    lautet nun ``hasPermission($userId, $context, $token, $value = true)``.
  * Das Interface ``sly_Authorisation_ListProvider`` wurde hinzugefügt. Eine
    Implementierung in ``sly_Authorisation_ArticleListProvider`` für den
    ``article``-Kontext wurde ergänzt.
  * Die folgenden Methoden wurden in ``sly_Authorisation`` geändert:

    * ``::getRights()`` wurde entfernt.
    * ``::getExtendedRights()`` wurde entfernt.
    * ``::getExtraRights()`` wurde entfernt.
    * ``::getObjectRights()`` wurde entfernt.
    * ``::getConfig()`` wurde hinzugefügt.

* **Controller**

  * ``sly_Controller_Base`` wurde deutlich ausgedünnt und enthält jetzt keinen
    Aspekt des Dispatchens mehr:

    * Die Konstanten ``PAGEPARAM``, ``SUBPAGEPARAM`` und ``ACTIONPARAM`` wurden
      entfernt. Die dazugehörigen Getter-Methoden wurden ebenfalls entfernt.
    * Der protected Konstruktor wurde entfernt; Controller sollen einfach zu
      instanziierende Klassen sein.
    * ``::getPage()`` wurde entfernt, ebenso ``::setCurrentPage()``,
      ``::factory()`` und ``::dispatch()``.
    * Die ``init()`` und ``teardown()``-Methodenstubs wurden entfernt, da sie
      beim Dispatchen auch nicht mehr automatisch aufgerufen werden würden.
    * ``index()`` und ``checkPermission()`` sind keine zu implementierenden
      abstrakten Methoden mehr (``checkPermission()`` wird allerdings vom
      Interface ``sly_Controller_Interface`` vorausgesetzt).

  * ``sly_Controller_Exception`` ist nun eine ``sly_Exception``.
  * ``sly_Controller_Interface`` wurde hinzugefügt und verlangt eine
    ``public function checkPermission($action)``.

* **Datenbank-Zugriff**

  * ``sly_DB_Importer`` behandelt die ``user``-Tabelle nun nicht mehr explizit.
    Fehlt sie, fehlt sie (da es auch keine ``user.sql`` mehr gibt).
  * ``sly_DB_Persistence->all()`` wurde als abstrakte Methode hinzugefügt und
    steht daher in ``sly_DB_PDO_Persistence`` als Methode zur Verfügung. Sie
    gibt das resamte Resultset in Form von einem Array von assoziativen Arrays
    zurück.
  * Das Attribut ``MYSQL_ATTR_USE_BUFFERED_QUERY`` wird nur noch gesetzt, wenn
    MySQL als Treiber verwendet wird.
  * ``sly_DB_PDO_Driver`` wurde erweitert:

    * ``->getPDOOptions()`` muss eine Liste von PDO-Optionen zurückgeben.
    * ``->getPDOAttributes()`` muss eine Liste von PDO-Attributen zurückgeben.
    * ``->getCreateDatabaseSQL()`` muss das SQL-Statement zum Anlegen einer
      Datenbank zurückgeben. Ist in Oracle by Design nicht implementiert.

  * ``sly_DB_PDO_Persistence`` wurde erweitert:

    * ``->getConnection()`` gibt das ``sly_DB_PDO_Connection``-Objekt zurück.
    * ``->getPDO()`` gibt das ``PDO``-Objekt zurück.
    * ``->transactional()`` erlaubt es, einen Callback in einer Transaktion
      auszuführen. Sollte bereits eine Transaktion aktiv sein, wird der Callback
      direkt ausgeführt. Bei einer Exception wird die aktive Transaktion
      zurückgerollt und die Exception weitergeworfen.
    * ``->all()`` gibt das gesamte Resultset zurück.
    * ``->rewind()`` wirft eine Exception anstatt eine Warnung zu generieren.

* **Error-Handling**

  * Das Interface ``sly_ErrorHandler`` schreibt nun zusätzlich die Methode
    ``handleException(Exception $e)`` vor.
  * Der Development-Errorhandler implementiert ``handleException()``, indem er
    die Exception ausgibt und wegstirbt.

* **Event-Dispatcher**

  * Der Konstruktor von ``sly_Event_Dispatcher`` ist nun public. Die systemweite
    Instanz wird von ``sly_Core`` gehalten. Die ``::getInstance()`` wurde daher
    entfernt.
  * Die Methode ``register()`` nimmt nun den neuen Parameter ``$first = false``
    entgegen. Wird er auf true gesetzt, wird der Listener **vor** die
    bestehenden Listener gesetzt. *(Diese Möglichkeit sollte als letzter Ausweg
    angesehen werden, nicht als Alltagswerkzeug!)*

* **Models**

  * ``sly_Model_Base_Article``

    * ``->getCatPosition()`` wurde hinzugefügt, ``->getCatPrior()`` ist
      deprecated. Dito für die dazugehörigen Setter.
    * ``->getPosition()`` wurde hinzugefügt, ``->getPrior()`` ist deprecated.
      Dito für die dazugehörigen Setter.

  * ``sly_Model_Article->printContent()`` wurde entfernt.
  * ``sly_Model_Article->getArticle()`` wurde entfernt (``->getContent()``
    nutzen)
  * ``sly_Model_ArticleSlice`` wurde als Ersatz für ``OOArticleSlice``
    hinzugefügt. Die alte OO-API ist nicht mehr verfügbar.
  * ``sly_Model_Slice``

    * ``->addValue()`` hat keinen Parameter ``$type`` mehr. Dito für
      ``->getValue()``.
    * ``->setValues()`` und ``->getValues()`` wurden hinzugefügt.

  * ``sly_Model_SliceValue->getType()`` und ``->setType()`` wurden entfernt.
  * ``sly_Model_User``

    * ``->getRightsAsArray()`` wurde entfernt.
    * ``->toggleRight()`` wurde entfernt.
    * ``->hasRight()`` hat sich geändert:
      ``->hasRight($context, $right, $value = true)`` (siehe dazu weiter oben
      die Beschreibung zum Rechtesystem).

* In ``sly_Registry_Registry`` wurde der Parameter ``$default`` für die
  ``->get()``-Methode hinzugefügt.
* ``sly_Response`` wurde hinzugefügt, zusammen mit dem Interface
  ``sly_Response_Action`` und der Klasse ``sly_Response_Forward``.
* ``sly_Router_Base`` wurde hinzugefügt, zusammen mit dem Interface
  ``sly_Router_Interface``.
* **Slices**

  * ``sly_Slice_Renderer``, ``sly_Slice_Helper``, ``sly_Slice_Values`` und
    ``sly_Slice_Form`` wurden hinzugefügt.

* ``sly_Table``-Instanzen können nur eine Liste von CSS-Klassen enthalten. Dazu
  kamen die Methoden ``->addClass()``, ``->clearClasses()`` und
  ``->getClasses()`` hinzu.
* **Konfiguration**

  * Der Konstruktor von ``sly_Configuration`` ist nun public. Die systemweite
    Instanz wird von ``sly_Core`` gehalten. Die ``::getInstance()`` wurde daher
    entfernt.

* **sly_Core**

  * ``::setCurrentApp(sly_App_Interface $app)`` und ``::getCurrentApp()`` wurden
    hinzugefügt.
  * ``::setCurrentClang()`` erlaubt ``null`` als Eingabe, um die aktuelle
    Sprache zurückzusetzen. Dito für ``::getCurrentArticleId()``.
  * ``::getCurrentClang()`` und ``::getCurrentArticleId()`` ermitteln die
    aktuellen Werte nicht mehr selber, sondern geben die von der jeweiligen App
    gesetzten Werte zurück. AddOns sollten also aufpassen, dass es ab jetzt
    möglich ist, dass die Methoden ``null`` zurückgeben.
  * ``::registerVarType()``, ``::getVarTypes()`` und ``::registerCoreVarTypes()``
    wurden entfernt.
  * ``::getLayout()`` gibt ebenfalls nur noch ein vorher über die neue Methode
    ``::setLayout()`` gesetztes Layout zurück.
  * ``::getTablePrefix()`` wurde hinzugefügt.
  * ``::getNavigation()`` ist jetzt deprecated und sollte nicht mehr verwendet
    werden. Alternative: ``sly_Core::getLayout()->getNavigation()`` (im Backend)
  * ``::setResponse()`` und ``::getResponse()`` wurden hinzugefügt.
  * ``::getCurrentPage()`` ist jetzt deprecated, verhält sich aber weiter wie
    gewohnt. Neuer Code sollte ``::getCurrentControllerName()`` verwenden, die
    auch im Frontend den Controllernamen zurückgibt.
  * ``::getCurrentController()`` wurde hinzugefügt und gibt die
    Controller-Instanz zurück.
  * ``::clearCache()`` wurde hinzugefügt.

* ``sly_I18N->setLocale()`` wurde in ``->setPHPLocale()`` umbenannt, da die neue
  ``->setLocale()``-Methode den Locale-Wert (z.B. ``"de_de"``) in dem Objekt
  ändert (also ein normaler Setter ist).
* ``sly_Layout->setContent($content)`` wurde hinzugefügt.
* JavaScript wird in allen Layouts nun by Default vor dem schließenden Body-Tag
  ausgegeben. Dies betrifft noch nicht das Backend, da das Backend die Methoden
  des Layouts entsprechend überschreibt.
* **Utilities**

  * ``sly_Util_Array->merge()`` wurde entfernt.
  * ``sly_Util_Article::getUrl($articleId, $clang, $params)`` wurde hinzugefügt.
  * ``sly_Util_ArticleSlice::getModule($article_slice_id)`` wurde hinzugefügt.
  * ``sly_Util_Category::canReadCategory($user, $categoryId)`` wurde hinzugefügt.
  * ``sly_Util_HTTP::getAbsoluteUrl()`` kann nun auch explizit HTTPS-URLs
    erzeugt. Ebenso ``::getUrl()``.
  * ``sly_Util_Mime::getType($filename)`` kann auch mit Pseudo-Dateinamen
    aufgerufen werden (da von der Datei eh nur die Dateiendung interessiert).
  * ``sly_Util_Password::hash()`` ignoriert ``'0'`` oder ``0`` nicht mehr als
    Salt (nur leere Strings werden ignoriert).
  * ``sly_Util_Requirements`` wurde gekürzt: ``->gd()``, ``->xmlReader()``,
    ``->xmlWriter()``, ``->curl()``, ``->allowURLfopen()``,
    ``->shortOpenTags()``, ``->registerGlobals()`` und ``->magicQuotes()``
    wurden entfernt.
  * ``sly_Util_Slice`` wurde entfernt.
  * ``sly_Util_String`` verwendet die Multibyte-Funktionen soweit möglich.
  * ``sly_Util_String::preg_startsWith()`` wurde entfernt.
  * ``sly_Util_String::formatTimespan($seconds)`` wurde hinzugefügt.
  * ``sly_Util_Template`` wurde hinzugefügt.

* Der XHTML5-Head generiert nun kein ``xmlns``-Attribut mehr.

Services
""""""""

* ``sly_Service_Template_Exception`` wurde hinzugefügt.
* **AddOn- und Plugin-Service**

  * ``->loadConfig()`` und ``->loadStatic()`` sind nicht mehr public.
  * Die von ``->getSupportPageEx()`` zurückgelieferten Links verwenden den Namen
    des Autors für den Linktext.
  * ``->getRequirements()``, ``->getRequiredSallyVersions()``,
    ``->isCompatible()`` und ``->loadComponents()`` wurden hinzugefügt.
  * ``->loadAddon()`` und ``->loadPlugin()`` können über den neuen Parameter
    ``$force`` dazu gebracht werden, auch nicht installierte und aktivierte
    AddOns zu laden (für Unit-Tests). *(Sollte sparsam verwendet werden!)*

* **Artikel-Service**

  * ``->getMaxPosition($categoryID)`` wurde hinzugefügt.
  * ``->copy($id, $target)`` wurde hinzugefügt.
  * ``->move($id, $target)`` wurde hinzugefügt.
  * ``->convertToStartArticle($articleID)`` wurde hinzugefügt.
  * ``->copyContent($srcID, $dstID, $srcClang, $dstClang, $revision)`` wurde
    hinzugefügt.
  * ``->getStati()`` wurde in ``->getStates()`` umbenannt.
  * ``->deleteCache($id, $clang)`` wurde hinzugefügt.
  * ``->deleteListCache()`` wurde hinzugefügt.
  * ``->findArticlesByType()`` wird nun gecacht.

* **Kategorie-Service**

  * ``->getMaxPosition($parentID)`` wurde hinzugefügt.
  * ``->findTree($parentID, $clang)`` wurde hinzugefügt.
  * ``->move($categoryID, $targetID)`` wurde hinzugefügt.
  * ``->getStati()`` wurde in ``->getStates()`` umbenannt.
  * ``->deleteCache($id, $clang)`` wurde hinzugefügt.
  * ``->deleteListCache()`` wurde hinzugefügt.

* ``sly_Service_ArticleSlice`` wurde hinzugefügt.
* ``sly_Service_Factory::getArticleSliceService()`` wurde hinzugefügt.
* **Artikeltyp-Service**

  * ``const VIRTUAL_ALL_SLOT`` wurde hinzugefügt.
  * ``->getModules()`` wurde hinzugefügt (und im Template-Service entfernt).
  * ``->hasModule()`` wurde hinzugefügt (und im Template-Service entfernt).

* **Asset-Service**

  * ``->process($file, $encoding)`` erfragt Datei und Encoding vom Aufrufer
    (dem Asssetcache-Controller) und wirft bei Fehlern eine
    ``sly_Authorisation_Exception``.
  * ``->clearCache()`` hat keine Parameter mehr.

* ``sly_Service_MediaCategory->findTree($parentID, $clang)`` wurde hinzugefügt.
* **Modul-Service**

  * ``->getActions()`` wurde entfernt.
  * ``->getTemplates()`` wurde entfernt.
  * ``->hasTemplate()`` wurde entfernt.

* **Template-Service**

  * ``->getCacheFolder()``, ``->getGenerated()`` und ``->getCacheFile()``
    wurden entfernt.
  * ``->getModules()`` und ``->hasModule()`` wurden entfernt.
  * ``->isActive()`` wurde entfernt.

* **SliceValue-Service**

  * ``->save()`` wurde hinzugefügt.
  * ``->find()`` wurde hinzugefügt.
  * ``->findBySliceFinder()`` hat keinen Parameter ``$type`` mehr.

* **User-Service**

  * ``->add($login, $password, $active, $rights)`` wurde hinzugefügt.
  * ``->findById($id)`` wurde hinzugefügt.

Formular-Framework
""""""""""""""""""

* **sly_Form**

  * ``->setFocus()`` kann nun auch mit einem ``sly_Form_ElementBase``-Objekt
    aufgerufen werden.
  * ``->findElementByID()`` wurde hinzugefügt, um ein Element anhand seiner ID
    auszulesen.

* **sly_Form_Fieldset**

  * Fieldsets können nun eine Liste von zusätzlichen Attributen für das
    ``<fieldset>``-Tag verwalten.
  * ``->setAttribute()`` und ``->getAttribute()`` wurden hinzugefügt.

* ``sly_Form_Helper::getLanguageSelect($name, $user, $id)`` wurde hinzugefügt.
* **sly_Form_ElementBase**

  * ``->removeClass()``, ``->removeOuterClass()`` und ``->removeFormRowClass()``
    wurden hinzugefügt.
  * ``->setRequired()`` wurde hinzugefügt.

* ``sly_Form_Select_Base->setSelected()`` wurde hinzugefügt.
* **Widgets**

  * Es wurden Basisklassen für die Widgets in ``sly_Form_Widget_LinkBase`` und
    ``sly_Form_Widget_MediaBase`` hinzugefügt.
  * Link-Widgets (einzel & Liste)

    * ``->filterByCategory($cat, $recursive)`` wurde hinzugefügt. Darüber
      können die erlaubten Kategorien in der Linkmap eingeschränkt werden.
    * ``->filterByCategories($cats, $recursive)`` wurde als Helper für den
      wiederholten Aufruf von ``filterByCategory()`` hinzugefügt.
    * ``->filterByArticleTypes($types)`` wurde hinzugefügt. Darüber
      können die erlaubten Artikeltypen in der Linkmap eingeschränkt werden.
    * Für beide Filter gibt es Clearer: ``->clearCategoryFilter()`` und
      ``->clearArticleTypeFilter()``

  * Media-Widgets (einzel & Liste)

    * ``->filterByCategory($cat, $recursive)`` wurde hinzugefügt. Darüber
      können die erlaubten Kategorien im Medienpool eingeschränkt werden.
    * ``->filterByCategories($cats, $recursive)`` wurde hinzugefügt.
    * ``->filterByFiletypes($types)`` wurde hinzugefügt. Darüber
      können die erlaubten Dateitypen (angegeben als Liste von Dateiendungen) im
      Medienpool eingeschränkt werden.
    * Für beide Filter gibt es Clearer: ``->clearCategoryFilter()`` und
      ``->clearFiletypeFilter()``

* **Views**

  * Das fokussierte Element wird per Default über das ``autofucus``-Attribut
    gekennzeichnet. Es existiert ein JavaScript-Fallback, der bei alten Browsern
    ``.focus()`` aufruft.
  * Elemente liegen jetzt nicht mehr in einem ``<p>``, sondern einem ``<div>``.
  * Checkbox- oder Radiobox-Gruppen zeigen die "alle/keine"-Links nicht mehr an,
    wenn es nur ein Element gibt.
  * Die speziellen Widget-CSS-Relationen (``rel``-Attribute an den Icons) wurden
    in Klassen umgeformt (``rel="up"`` wurde zu ``class="fct-up"``).

Frontend-App
""""""""""""

* Das Frontend wurde als App re-implementiert. Dabei entstanden die folgenden
  Klassen:

  * ``sly_App_Frontend``
  * ``sly_Controller_Frontend_Article``
  * ``sly_Controller_Frontend_Base``
  * ``sly_Controller_Frontend_Asset``

* Es wurden Sprachdateien für die im Frontend von der App möglichen
  Fehlermeldungen -- es wird das Standard-Backendlocale verwendet, bevor z.B.
  der Artikel-Controller das Locale bestimmt hat.

Backend-App
"""""""""""

* jQuery wurde auf 1.7.1 aktualisiert, jQuery UI auf 1.8.17.
* Alle CSS-Klassen, die noch ``rex-`` im Namen hatten, wurde in ``sly-``
  umbenannt. Viele Klassen wurden auch entfernt und durch neue ersetzt.
* Assets müssen aufgrund der geänderten Verzeichnisstruktur nun wieder via
  ``../data/dyn/public/......`` verlinkt werden.
* Das mitgelieferte jQuery UI-Theme wurde mehr an das Backenddesign angepasst.
* Es wurden einige Icons aus den Assets entfernt.
* Die Sprachdateien des Backends wurden in großen Teilen umgebaut. Statt teils
  generischer Keys (``content_function_x``) kommen nun durchgängig sprechende
  Keys (``delete_article``) zum Einsatz. Es sind viele neue Verben hinzugekommen
  und AddOns sollten versuchen, wenn mögliche die mitgelieferten Übersetzungen
  zu verwenden.
* ``sly_App_Backend`` wurde hinzugefügt und übernimmt alle Aufgaben der Backend-
  Anwendung.
* Die ``specials``-Seite wurde in ``system`` umbenannt.
* Beim Installieren von AddOns und Plugins werden diese auch sofort aktiviert.
* Die Linkmap kann auf einzelne Kategorien (auf Wunsch rekursiv) eingeschränkt
  werden. Ebenso können die Artikeltypen vorausgewählt werden. Das Gleiche gilt
  für das Medienpool-Popup (hier natürlich mit Dateitypen statt Artikeltypen).
* Das Markup der Linkmap hat sich in großen Teilen geändert.
* ``sly_Layout_Backend`` leitet sich jetzt von ``sly_Layout_XHTML5`` ab.

  * Dem ``<body>``-Tag werden die Klassen ``sly-0``, ``sly-0_6`` und ``sly-0_6_0``
    hinzugefügt.
  * Die ID des ``<body>``-Tags wurde von ``rex-page...`` in ``sly-page-...``
    umbenannt.
  * Bei ``pageHeader()`` muss nun die Liste der Submenü-Seiten nicht mehr mit
    übergeben werden. Die Navigation wird sich an der Backend-Navigation
    orientieren und die Seiten daher automatisch ermitteln.
  * ``pageHeader()`` erwartet ein Page-Objekt oder ein Array von assoziativen
    Arrays mit den Menü-Daten (früher wurde ein Array von normalen Arrays
    erwartet). Die assoziativen Arrays können die Keys ``page``, ``label``,
    ``forced``, ``extra`` und ``class`` enthalten.

    * ``forced`` (boolean) legt fest, ob der Menüeintrag als aktiv angezeigt
      werden soll.
    * ``extra`` (array) sind weitere Parameter für den Link, die auch bei der
      Ermittlung der aktiven Seite herangezogen werden.
    * ``class`` (string) sind die CSS-Klassen für die erzeugten ``<li>``-Tags.

  * An den generierten Links im Submenü werden die Klassen ``sly-first``,
    ``sly-last`` und ``sly-active`` verwendet.
  * Die Navigation kann direkt von der Layout-Instanz abgerufen werden:
    ``$layout->getNavigation()``

* Die Navigation des Backends wird im Konstruktor von
  ``sly_Layout_Navigation_Backend`` eingerichtet. Backend-Seiten, die nicht im
  Menü zu sehen sind, werden auch nicht mehr der Navigation hinzugefügt.
* ``sly_Layout_Navigation_Backend->createGroup()`` wurde entfernt.
* ``sly_Layout_Navigation_Subpage``-Instanzen können eine Liste von weiteren
  Parametern erhalten. Diese Parameter werden an die URL zum Controller
  angefügt und beim Ermitteln der aktuellen Seite ausgewertet. So ist es
  möglich, mit einem Controller mehrere Backend-Seiten im Menü anzuzeigen (ohne
  dass es zu Konflikten in der Anzeige kommt).

  * neue Methode: ``->getExtraParams()``
  * neue Methode: ``->getForcedStatus()``
  * neue Methode: ``->setExtraParams(array $params)``
  * neue Methode: ``->matches($subpagePageParam, array $extraParams = array())``

* Die AddOn-Verwaltung wurde neu implementiert und nutzt Ajax, um die vielen
  Reloads der Seite zu vermeiden. Damit gehen keine größeren API-Änderungen
  einher.
* Die IDs von Artikeln/Dateien werden nicht mehr für Admins extra angezeigt, da
  es auch kein Benutzerrecht für den "erweiterten Modus" mehr gibt.

Events
""""""

* ``ALL_GENERATED`` wurde in ``SLY_CACHE_CLEARED`` umbenannt.
* ``PAGE_CHECKED`` wird vom Core ausgeführt und wurde als deprecated markiert.
  Neuer Code sollte eher ``SLY_CONTROLLER_FOUND`` nutzen:
* ``SLY_CONTROLLER_FOUND`` wird ausgeführt, wenn der Controller ermittelt wurde.
  Dem Event wird die Controller-Instanz als Subject übergeben, sowie der Name
  (``name``), die App-Instanz (``app``) und die auszuführende Action
  (``action``) als weitere Parameter.
* Über das Filter-Event ``SLY_FRONTEND_ROUTER`` können Listener den Router im
  Frontend mit eigenen Routen erweitern oder sogar die Instanz ganz austauschen.
  Ein vorbereiteter ``sly_Router_Base`` wird als Subject, die App als ``app``
  übergeben.
* Das Event ``OUTPUT_FILTER_CACHE`` wurde entfernt. Stattdessen können AddOns
  jetzt die finale Ausgabe an den Client in ``SLY_RESPONSE_SEND`` (erhält das
  Response-Objekt als Subject) abgreifen.
* Das Subject von ``SLY_MEDIAPOOL_MENU`` ist nun das Backend-Seiten-Objekt
  (``sly_Layout_Navigation_Page``) anstatt des Submenüs als Array. Listeners
  müssen die API des Objekts nutzen, um das Menü zu erweitern.
* ``SLY_OOMEDIA_IS_IN_USE`` wurde in ``SLY_MEDIA_USAGES`` umbenannt.
* ``SLY_PAGE_USER_SUBPAGES`` wurde entfernt (AddOns sollten einfach die
  Backend-Navigation entsprechend erweitern). Dito für ``SLY_SPECIALS_MENU``.
* ``SLY_SLICE_POSTVIEW_ADD`` wird immer ein leeres Array als Subject übergeben.
* Das Event ``PAGE_MEDIAPOOL_MENU`` wurde in ``SLY_MEDIAPOOL_MENU`` umbenannt.
  Statt dem Submenü wird dem Event als Subject das Navigation-Page-Objekt des
  Medienpools übergeben.
* Im Event ``SLY_ART_CONTENT_COPIED`` wird kein ``start_slice`` mehr übergeben,
  da beim Kopieren des Inhalts nun immer **alle** Slices kopiert werden.
* ``SLY_ART_COPIED`` erhält nun den kopierten Artikel als Subject und nur noch
  den Quellartikel als ``source``. Alle weiteren Parameter wurden entfernt.
* ``CLANG_ARTICLE_GENERATED`` wurde entfernt.
* ``SLY_PRE_PROCESS_ARTICLE`` wurde entfernt und durch das Notify-Event
  ``SLY_CURRENT_ARTICLE`` ersetzt, in dem Listener den anzuzeigenden Artikel
  nicht mehr verändern dürfen.
* Der Artikel-Controller feuert das Filter-Event ``SLY_ARTICLE_OUTPUT``, über
  das Listener direkt auf die Ausgabe im Frontend zugreifen können. In vielen
  Fällen wollen AddOns nur die Frontend-Ausgabe von Templates verändern, anstatt
  auch Ausgaben wie RSS-Feeds oder Bilder zu verarbeiten. Hier macht es dann
  Sinn, einfach auf ``SLY_ARTICLE_OUTPUT`` zu lauschen.
* Das Filter-Event ``SLY_RESOLVE_ARTICLE`` wird vom Artikel-Controller gefeuert,
  um den aktuellen Artikel zu ermitteln. Das Subject ist anfangs null, ein
  erfolgreicher Listener sollte ein ``sly_Model_Article``-Objekt zurückgeben.
  Listener, die bereits ein Objekt als Eingabe erhalten sollten dieses
  ungeändert weiterreichen. Wird kein Artikel gefunden, wird der
  NotFound-Artikel angezeigt.

rex_vars
""""""""

* wurden vollständig und ersatzlos entfernt
* ``sly_Slice_Values`` und ``sly_Slice_Helper`` stellen nun die Hilfs-API zur
  Verfügung (siehe Feature-Beschreibung am Anfang der Seite oder die
  :doc:`Dokumentation </frontend-devel/develop/slicehelper>`).

Unit-Tests
""""""""""

* Die Zahl der Testcases wurde 280 mit insgesamt 633 Assertions erhöht.
* Für AddOns steht ein Bootstraping von Sally sowie eine Basis-Klasse für
  Testcases bereit. Siehe auch die :doc:`Unit-Test Dokumentation </addon-devel/extended/testing>`.

Sonstiges
"""""""""

* Die mitgelieferte :file:`.htaccess` enthält nun bereits die Catch-All-Regeln,
  die bisher von realurl-AddOns extra hinzugefügt werden mussten.
* Das ``internal_encoding`` (``mbstring``-Extension) wird auf ``UTF-8`` gesetzt.
