Model-Events
============

Alle Klassen, die sich von ``sly_Model_Base`` ableiten, erhalten automatisch
eine magische ``__call``-Methode, über die ihr Interface erweiterbar wird. So
kann man beispielsweise die Methode ``->getImageTag()`` bei einem
``sly_Model_Medium``-Objekt nachrüsten, ohne die Klasse selbst ändern zu müssen.

Zu diesem Zweck wird von ``__call`` ein entsprechendes Event ausgelöst. Der Name
des Events setzt sich aus dem Namen der jeweiligen Klasse und dem Namen der
aufgerufen Methode zusammen, sodass obiges Beispiel das Event
``SLY_MODEL_MEDIUM_GETIMAGETAG`` auslösen würde.

.. note::

  Wenn eine abgeleitete Klasse nicht ``sly_Model_XY`` heißt, sondern
  ``MyModel``, so wird das Event entsprechend ``MYMODEL_GETIMAGETAG`` heißen.

Sollte kein Listener für das Event registriert sein, so wird eine entsprechende
Exception (``Call to undefined method ...``) geworfen. Andernfalls ist der
Rückgabewert des Events der Rückgabewert der ``__call``-Methode.

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
