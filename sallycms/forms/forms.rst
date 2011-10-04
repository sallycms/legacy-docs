Formular-API
============

Im Folgenden soll auf die API der einzelnen Formularelemente eingegangen werden.
Dabei werden nicht zwangsweise *alle* Methoden aufgezählt, sondern nur die
Wichtigsten.

sly_Form
========

``sly_Form`` ist die Basisklasse für alle Formulare und die Klasse, die man
benutzen sollte, wenn man seine eigenen Formulare bauen möchte. Sie dient als
Container für die Fieldsets und versteckten Werte.

.. sourcecode:: php

  <?
  public function __construct($action, $method = 'POST', $title, $name = '', $id = '')

Das Formularobjekt bietet einige nette Methoden an.

+------------------------------------------+----------------------------------------------------------------------------+
| Methode                                  | Beschreibung                                                               |
+==========================================+============================================================================+
| ``setEncType($enctype)``                 | setzt den Encoding-Type, für Formulare mit Uploads                         |
+------------------------------------------+----------------------------------------------------------------------------+
| ``add``                                  | fügt eine neue Zeile mit einem einzelnen Element ins Formular ein          |
+------------------------------------------+----------------------------------------------------------------------------+
| ``addRow``                               | fügt eine neue Zeile mit mehreren Elementen (mehrspaltig) ins Formular ein |
+------------------------------------------+----------------------------------------------------------------------------+
| ``beginFieldset($title, $id, $columns)`` | startet ein neues Fieldset                                                 |
+------------------------------------------+----------------------------------------------------------------------------+
| ``addFieldset($fieldset)``               | fügt ein neues, bestehendes Fieldset ein                                   |
+------------------------------------------+----------------------------------------------------------------------------+
| ``addHiddenValue($name, $value)``        | fügt einen versteckten Wert ins Formular ein                               |
+------------------------------------------+----------------------------------------------------------------------------+
| ``setSubmitButton($button)``             | setzt den Submit-Button (null entfernt ihn)                                |
+------------------------------------------+----------------------------------------------------------------------------+
| ``setResetButton($button)``              | setzt den Reset-Button (null entfernt ihn)                                 |
+------------------------------------------+----------------------------------------------------------------------------+
| ``setApplyButton($button)``              | setzt den Apply-Button (null entfernt ihn)                                 |
+------------------------------------------+----------------------------------------------------------------------------+
| ``setDeleteButton($button)``             | setzt den Delete-Button (null entfernt ihn)                                |
+------------------------------------------+----------------------------------------------------------------------------+
| ``getSubmitButton()``                    | liefert den Submit-Button                                                  |
+------------------------------------------+----------------------------------------------------------------------------+
| ``getResetButton()``                     | liefert den Reset-Button                                                   |
+------------------------------------------+----------------------------------------------------------------------------+
| ``getApplyButton()``                     | liefert den Apply-Button                                                   |
+------------------------------------------+----------------------------------------------------------------------------+
| ``getDeleteButton()``                    | liefert den Delete-Button                                                  |
+------------------------------------------+----------------------------------------------------------------------------+
| ``render($print)``                       | rendert das Formular, wird standardmäßig direkt ausgegeben                 |
+------------------------------------------+----------------------------------------------------------------------------+
| ``clearElements()``                      | entfernt alle Elemente und Fieldsets vom Formular                          |
+------------------------------------------+----------------------------------------------------------------------------+
| ``setFocus($elementID)``                 | setzt den Fokus auf ein bestimmtes Element                                 |
+------------------------------------------+----------------------------------------------------------------------------+
| ``addClass($class)``                     | fügt eine oder mehrere Klassen zum ``<form>``-Tag hinzu                    |
+------------------------------------------+----------------------------------------------------------------------------+
| ``clearClasses()``                       | entfernt alle CSS-Klassen vom ``<form>``-Tag                               |
+------------------------------------------+----------------------------------------------------------------------------+
| ``getClasses()``                         | liefert alle gesetzten Klassen                                             |
+------------------------------------------+----------------------------------------------------------------------------+
| ``getCurrentFieldset()``                 | liefert das aktuelle (meist letzte) Fieldset-Objekt zurück                 |
+------------------------------------------+----------------------------------------------------------------------------+

sly_Form_Fieldset
-----------------

.. sourcecode:: php

  <?
  public function __construct($legend, $id = '', $columns = 1, $num = -1)

Ein Fieldset ist der Container, der die eigentliche Elemente enthält. Ein
Formular enthält immer mindestens ein Fieldset. Einige Methoden wie ``add()``
aus ``sly_Form`` leiten im Endeffekt nur auf das letzte Fieldset im Formular
weiter. Fieldsets werden fortlaufend durchnummeriert.

Ein Fieldset kann **entweder** mehrspaltig **oder** mehrsprachig sein. Dies
liegt daran, dass das HTML für ein mehrspaltiges, mehrsprachiges Fieldset
unmöglich komplex und unbedienbar wäre.

+------------------------+----------------------------------------------------------------------------+
| Methode                | Beschreibung                                                               |
+========================+============================================================================+
| ``add``                | fügt eine neue Zeile mit einem einzelnen Element ins Fieldset ein          |
+------------------------+----------------------------------------------------------------------------+
| ``addRow``             | fügt eine neue Zeile mit mehreren Elementen (mehrspaltig) ins Fieldset ein |
+------------------------+----------------------------------------------------------------------------+
| ``clearElements()``    | entfernt alle Elemente und Fieldsets vom Formular                          |
+------------------------+----------------------------------------------------------------------------+
| ``getRows()``          | gibt die Zeilen zurück (Arrays, die jeweils die Elemente enthalten)        |
+------------------------+----------------------------------------------------------------------------+
| ``getNum()``           | gibt die Nummer dieses Fieldsets zurück                                    |
+------------------------+----------------------------------------------------------------------------+
| ``setColumns($num)``   | setzt die Anzahl der Spalten                                               |
+------------------------+----------------------------------------------------------------------------+
| ``setLegend($legend)`` | setzt den Fieldset-Titel                                                   |
+------------------------+----------------------------------------------------------------------------+

sly_Form_Slice
--------------

.. sourcecode:: php

  <?
  public function __construct()

Ein Slice ist im Prinzip ein "Mini-Formular", das Formularelemente und
versteckte Werte enthalten kann. Es existiert, damit Event-Listener keinen
Zugriff auf das Ziel-Formular erhalten müssen, aber trotzdem eine
``sly_Form``-ähnliche API verwenden können.

Slices können nicht eigenständig gerendert werden, sondern müssen in "echte"
Formulare integriert werden, wobei dann die Elemente und versteckten Werte in
das Formular übertragen werden.

+----------------------+----------------------------------------------------------------------------+
| Methode              | Beschreibung                                                               |
+======================+============================================================================+
| ``add``              | fügt eine neue Zeile mit einem einzelnen Element ins Fieldset ein          |
+----------------------+----------------------------------------------------------------------------+
| ``addRow``           | fügt eine neue Zeile mit mehreren Elementen (mehrspaltig) ins Fieldset ein |
+----------------------+----------------------------------------------------------------------------+
| ``clear()``          | entfernt alle Elemente vom Slice                                           |
+----------------------+----------------------------------------------------------------------------+
| ``integrate($form)`` | integriert das Slice in ein Formular                                       |
+----------------------+----------------------------------------------------------------------------+

Für gewöhnlich ist es nicht nötig, Slices zu verwenden. Und selbst wenn ein
Event die Verwendung von Slices erfordert, kümmert sich derjenige, der die
Slices anfordert, um das Integrieren. Von daher soll an dieser Stelle nicht auf
``->integrate()`` eingegangen werden.
