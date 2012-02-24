"Catch All"-Events
==================

Einige der API-Klassen von Sally enthalten eine magische ``__call``-Methode,
über die ihr Interface erweiterbar wird. Dies erlaubt es, eigene Methoden an
vom Core erzeugten Objeken nachzurüsten, um so beispielsweise Helper-Methoden
komfortabler verfügbar zu machen. So kann man die Methode ``->getImageTag()``
bei einem ``sly_Model_Medium``-Objekt nachrüsten, ohne die Klasse selbst ändern
zu müssen.

Zu diesem Zweck wird von ``__call`` ein entsprechendes Event ausgelöst. Der Name
des Events setzt sich aus einem Präfix (siehe die jeweilige Dokumentation weiter
unten) und dem Namen der aufgerufen Methode zusammen, sodass obiges Beispiel das
Event ``SLY_MODEL_MEDIUM_GETIMAGETAG`` auslösen würde.

Die folgenden Klassen enthalten ein "Catch All"-Event:

* alle Klassen, die sich von ``sly_Model_Base`` ableiten
* ``sly_Slice_Values``
* ``sly_Slice_Form``

Sollte kein Listener für das Event registriert sein, so wird eine entsprechende
Exception (``Call to undefined method ...``) geworfen. Andernfalls ist der
Rückgabewert des Events der Rückgabewert der ``__call``-Methode.

Models
------

Model-Events folgen immer dem Namensschema ``[KLASSENNAME]_[METHODE]``, also
beispielsweise ``SLY_MODEL_ARTICLE_GETAUTHOR`` für
``sly_Model_Article->getAuthor()`` oder ``SLY_MODEL_SLICE_DELETE`` für
``sly_Model_Slice->delete()``.

.. note::

  Bei Models besteht der Name des Events aus dem Klassennamen und dem
  Methodenname. Wenn eine abgeleitete Klasse nicht ``sly_Model_XY`` heißt,
  sondern ``MyModel``, so wird das Event entsprechend ``MYMODEL_GETIMAGETAG``
  heißen.

.. slyevent:: SLY_MODEL_*_*
  :type:    filter
  :in:      null
  :out:     mixed
  :subject: immer ``null``
  :params:
    method    (string)          Name der aufgerufenen Methode
    arguments (array)           die der Methode übergebenen Argumente
    object    (sly_Model_Base)  das aktuelle Objekt

  Listener können über dieses Event das Interface der Core-Models um
  Komfortmethoden erweitern.

sly_Slice_Values
----------------

Slice-Value-Events folgen immer dem Namensschema ``SLY_SLICEVALUES_[METHODE]``.

.. slyevent:: SLY_SLICEVALUES_*
  :type:    filter
  :in:      null
  :out:     mixed
  :subject: immer ``null``
  :since:   0.6.1
  :params:
    method    (string)            Name der aufgerufenen Methode
    arguments (array)             die der Methode übergebenen Argumente
    object    (sly_Slice_Values)  das aktuelle Objekt

  Listener können über dieses Event das Objekt erweitern, das in alle Module
  als ``$values`` reingegeben wird.

sly_Slice_Form
--------------

Slice-Form-Events folgen immer dem Namensschema ``SLY_SLICEFORM_[METHODE]``.

.. slyevent:: SLY_SLICEFORM_*
  :type:    filter
  :in:      null
  :out:     mixed
  :subject: immer ``null``
  :since:   0.6.1
  :params:
    method    (string)          Name der aufgerufenen Methode
    arguments (array)           die der Methode übergebenen Argumente
    object    (sly_Slice_Form)  das aktuelle Objekt

  Listener können über dieses Event das Objekt erweitern, das in alle Module
  als ``$form`` reingegeben wird.
