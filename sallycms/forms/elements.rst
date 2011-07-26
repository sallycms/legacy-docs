Formularelemente
================

Bevor auf die einzelnen Elemente eingegangen werden soll, soll die Struktur dargelegt werden.

Struktur
--------

* ``sly_Form_ElementBase``

  * ``sly_Form_ButtonBar``
  * ``sly_Form_Container``
  * ``sly_Form_DateTime``
  * ``sly_Form_Fragment``
  * ``sly_Form_Freeform``
  * ``sly_Form_Input_Base``

    * ``sly_Form_Input_Button``
    * ``sly_Form_Input_Checkbox``
    * ``sly_Form_Input_File``
    * ``sly_Form_Input_Password``
    * ``sly_Form_Input_Radio``
    * ``sly_Form_Input_Text``

  * ``sly_Form_Select_Base``

    * ``sly_Form_Select_Checkbox``
    * ``sly_Form_Select_DropDown``
    * ``sly_Form_Select_Radio``

  * ``sly_Form_Text``
  * ``sly_Form_Textarea``
  * ``sly_Form_Widget``

    * ``sly_Form_Widget_LinkButton``
    * ``sly_Form_Widget_LinkListButton``
    * ``sly_Form_Widget_MediaButton``
    * ``sly_Form_Widget_MediaListButton``

Gemeinsame API
--------------

Alle Formular-Elemente haben eine gemeinsame Basis, sodass ihnen jeweils eine
Reihe von Methoden zur Verfügung stehen. Außerdem gilt allgemein, dass die ID
eines Elements dem Namen entspricht, falls sie nicht explizit angegeben wurde.

+------------------------------------+----------------------------------------------------------------------------------------------------------+
| Methode                            | Beschreibung                                                                                             |
+====================================+==========================================================================================================+
| ``getName()``                      | gibt den Namen des Elements zurück                                                                       |
+------------------------------------+----------------------------------------------------------------------------------------------------------+
| ``getID()``                        | gibt die ID des Elements zurück                                                                          |
+------------------------------------+----------------------------------------------------------------------------------------------------------+
| ``getLabel()``                     | gibt das Label des Elements zurück                                                                       |
+------------------------------------+----------------------------------------------------------------------------------------------------------+
| ``setAttribute($name, $value)``    | setzt ein HTML-Attribut (für einige stehen spezielle Methoden zur Verfügung!)                            |
+------------------------------------+----------------------------------------------------------------------------------------------------------+
| ``getAttribute($name)``            | gibt ein Attribut des Elements zurück                                                                    |
+------------------------------------+----------------------------------------------------------------------------------------------------------+
| ``removeAttribute($name)``         | entfernt ein Attribut vom Element                                                                        |
+------------------------------------+----------------------------------------------------------------------------------------------------------+
| ``addClass($class)``               | fügt eine oder mehrere CSS-Klassen hin; stellt Eindeutigkeit sicher                                      |
+------------------------------------+----------------------------------------------------------------------------------------------------------+
| ``addStyle($style)``               | fügt einen oder mehrere CSS-Stile hin; stellt Eindeutigkeit sicher                                       |
+------------------------------------+----------------------------------------------------------------------------------------------------------+
| ``setDisabled($disabled)``         | steuert das disabled-Attribut                                                                            |
+------------------------------------+----------------------------------------------------------------------------------------------------------+
| ``setHelpText($helpText)``         | setzt den Hilfetexte, der direkt unter dem Element in kleiner Schrift angezeigt wird (kein HTML erlaubt) |
+------------------------------------+----------------------------------------------------------------------------------------------------------+
| ``setLabel($label)``               | setzt das Label                                                                                          |
+------------------------------------+----------------------------------------------------------------------------------------------------------+
| ``setMultilingual($multilingual)`` | macht das Element ein- oder mehrsprachig                                                                 |
+------------------------------------+----------------------------------------------------------------------------------------------------------+

Einfache Eingabefelder
----------------------

sly_Form_Input_Text (Eingabefeld)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. sourcecode:: php

  <? public function __construct($name, $label, $value = '', $id = null)

Ein einfaches Eingabefeld, ohne besondere weitere Eigenschaften. Plain and
simple. Eingabefelder nehmen üblicherweise die gesamte Breite ein, können aber
über CSS schmaler gehalten werden, um noch etwas Text (die sog. "Annotation")
rechts von ihnen anzuzeigen. Das eignet sich für Eingaben, bei denen eine
Einheit angegeben werden soll.

+--------------------------------+--------------------------------------+
| Methode                        | Beschreibung                         |
+================================+======================================+
| ``setMaxLength($len)``         | setzt die Maximallänge               |
+--------------------------------+--------------------------------------+
| ``setReadOnly($readonly)``     | steuert das readonly-Attribut        |
+--------------------------------+--------------------------------------+
| ``setSize($size)``             | steuert das size-Attribut            |
+--------------------------------+--------------------------------------+
| ``setAnnotation($annotation)`` | setzt den Text neben den Eingabefeld |
+--------------------------------+--------------------------------------+

.. sourcecode:: php

  <?
  $text = new sly_Form_Input_Text('myfield', 'Mein Feld', 'wert');
  $text->setAnnotation('EUR');
  $text->addStyle('width:50px');

sly_Form_Input_Password (Passwort-Feld)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. sourcecode:: php

  <? public function __construct($name, $label, $value = '', $id = null)

Ein Eingabefeld für Passwörter. Dies ist das einzige Element, das by default die
eingegebenen Daten bei der Re-Anzeige des Formulars **nicht** wieder anzeigt.

.. sourcecode:: php

  <?
  $password = new sly_Form_Input_Password('myfield', 'Mein Feld', 'wert');

sly_Form_Input_Checkbox (Checkbox)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. sourcecode:: php

  <? public function __construct($name, $label, $value, $description = 'ja', $id = null)

Eine einzelne Checkbox. Enthält das Checkbox-Element und etwas Text. Der Status
kann nicht im Konstruktor gesetzt werden, zu diesem Zweck muss die
``setChecked()``-Methode aufgerufen werden.

.. sourcecode:: php

  <?
  $checkbox = new sly_Form_Input_Checkbox('myfield', 'Mein Feld', '1', 'Beschreibungstext');
  $checkbox->setChecked(true);

sly_Form_Input_Radio (Radiobox)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. sourcecode:: php

  <? public function __construct($name, $label, $value, $description = 'ja', $id = null)

Eine einzelne Radiobox. Ist nur nützlich, wenn man noch weitere Radioboxen mit
dem gleichen Namen im Formular hat. Der Status kann nicht im Konstruktor gesetzt
werden, zu diesem Zweck muss die ``setChecked()``-Methode aufgerufen werden.

In den meisten Fällen will man nicht diese Klasse, sondern
``sly_Form_Select_Radio`` verwenden, das eine Gruppe von Radioboxen anzeigt
(siehe unten).

.. sourcecode:: php

  <?
  $radio = new sly_Form_Input_Radio('myfield', 'Mein Feld', '1', 'Option A');
  $radio->setChecked(true);

sly_Form_Input_Button (Schaltfläche)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. sourcecode:: php

  <? public function __construct($type, $name, $value)

Eine einfacher Button, wird meist in Kombination mit der ButtonBar (siehe unten)
oder in den ``setXXButton()``-Methoden eines Formulars verwendet.

.. sourcecode:: php

  <?
  $button = new sly_Form_Input_Button('submit', 'submit', 'Speichern');

sly_Form_Input_File (Upload-Eingabefeld)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. sourcecode:: php

  <? public function __construct($name, $label, $id = null)

Ein Eingabefeld, in dem der Benutzer eine Datei von seinem Rechner auswählen
kann. Wenn es verwendet wird, muss im Formular über ``setEncType()`` der
Encoding-Typ geändert werden, damit der Upload funktionieren kann.

.. sourcecode:: php

  <?
  $upload = new sly_Form_Input_File('myfile', 'Datei');

Auswahlfelder
-------------

Allen Auswahlfeldern ist die folgende API gemein:

+----------------------------+-------------------------------------------------+
| Methode                    | Beschreibung                                    |
+============================+=================================================+
| ``setValues($values)``     | setzt die Liste der zur Auswahl stehenden Werte |
+----------------------------+-------------------------------------------------+
| ``addValue($key, $value)`` | fügt einen neuen Wert ein                       |
+----------------------------+-------------------------------------------------+
| ``getValues()``            | gibt die aktuelle Werteliste zurück             |
+----------------------------+-------------------------------------------------+

sly_Form_Select_DropDown (Selectbox)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. sourcecode:: php

  <? public function __construct($name, $label, $value, $values, $id = null)

Eine Selectbox, die eine Menge von Werten anbietet. Es wird in ``$values`` immer
eine assoziative Liste von Werten erwartet. Selectboxen können beliebig hoch
sein (``size``-Attribut) und auch eine Mehrfach-Auswahl (``multiple``-Attribut)
verwenden.

+----------------------------+-----------------------------------+
| Methode                    | Beschreibung                      |
+============================+===================================+
| ``setMultiple($multiple)`` | steuert das ``multiple``-Attribut |
+----------------------------+-----------------------------------+
| ``setSize($size)``         | steuert das ``size``-Attribut     |
+----------------------------+-----------------------------------+

.. sourcecode:: php

  <?
  $values      = array('perm1' => 'Permission 1', 'perm2' => 'Permission 2');
  $selected    = array('perm1'); // Muss ein Array sein!
  $permissions = new sly_Form_Select_DropDown('myselect', 'Permissions', $selected, $values);

sly_Form_Select_Checkbox (Liste von Checkboxen)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. sourcecode:: php

  <? public function __construct($name, $label, $value, $values, $id = null)

Eine Gruppe von Checkboxen. Dieses Element ist von Natur aus multi-Select und
erlaubt, dass auch 0 Elemente auswählt sind.

.. sourcecode:: php

  <?
  $values      = array('perm1' => 'Permission 1', 'perm2' => 'Permission 2');
  $selected    = array('perm1'); // Muss ein Array sein!
  $permissions = new sly_Form_Select_Checkbox('myselect', 'Permissions', $selected, $values);

sly_Form_Select_Radio (Liste von Radioboxen)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. sourcecode:: php

  <? public function __construct($name, $label, $value, $values, $id = null)

Eine Gruppe von Radioboxen. In diesem Element kann von Natur aus maximal ein
Element ausgewählt werden, wobei nachdem ein Element ausgewählt wurde, die
Auswahl nicht mehr entfernt werden kann.

.. sourcecode:: php

  <?
  $values      = array('perm1' => 'Permission 1', 'perm2' => 'Permission 2');
  $selected    = array('perm1'); // Muss ein Array sein!
  $permissions = new sly_Form_Select_Radio('myselect', 'Permissions', $selected, $values);

Widgets
-------

.. note::

  *Muss noch geschrieben werden.*

Sonstiges
---------

sly_Form_ButtonBar (Buttonzeile)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. sourcecode:: php

  <? public function __construct($buttons = array(), $id = null)

Eine ButtonBar enthält eine Menge von Buttons. In 99,999% aller Fälle wird die
von ``sly_Form`` angelegte ButtonBar genügen, die am Ende eines Formulars steht
(und deren 4 standardmäßig vorhandene Buttons über die o.g. ``getXXButton()``
zur Verfügung stehen).

+------------------------+-----------------------------------------------+
| Methode                | Beschreibung                                  |
+========================+===============================================+
| ``getButtons``         | gibt die assoziative Liste von Buttons zurück |
+------------------------+-----------------------------------------------+
| ``addButton($button)`` | fügt einen neuen Button hinzu                 |
+------------------------+-----------------------------------------------+
| ``clearButtons()``     | entfernt alle Buttons                         |
+------------------------+-----------------------------------------------+

.. sourcecode:: php

  <?
  $bar = new sly_Form_ButtonBar();
  $bar->addButton(new sly_Form_Input_Button('submit', 'submit', 'Speichern'));

sly_Form_Container (generischer Container)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. sourcecode:: php

  <? public function __construct($id = null, $class = '', $style = '')

Container können verwendet werden, wenn die bestehenden Elemente nicht genügen
und im Formular eine Zeile eingefügt werden soll, deren Inhalt der Entwickler
frei bestimmen kann. Im Gegensatz zu ``sly_Form_Freeform`` wird hierbei kein
Label erzeugt, sondern der Container nimmt die volle Breite der Formularzeile
ein.

+--------------------------+--------------------------------------+
| Methode                  | Beschreibung                         |
+==========================+======================================+
| ``setContent($content)`` | setzt den HTML-Inhalt des Containers |
+--------------------------+--------------------------------------+

.. sourcecode:: php

  <?
  $container = new sly_Form_Container();
  $container->setContent('<p>Dies ist meine Zeile!</p>');

sly_Form_DateTime (Datepicker)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. sourcecode:: php

  <? public function __construct($name, $label, $value, $id = null, $allowedAttributes = null, $withTime = true)

Ein Datepicker dient dazu, dem Benutzer die einfache Eingabe von Daten (Plural
von Datum) zu ermöglichen.

Als Erweiterung können Datepicker in Sally auch einen Timepicker enthalten, der
die Eingabe von Zeiten erleichtern soll.

.. sourcecode:: php

  <?
  $datetime = new sly_Form_DateTime('mydate', 'Datum', time());
