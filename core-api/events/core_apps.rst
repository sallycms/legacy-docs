Apps & Controller
=================

.. slyevent:: SLY_CONTROLLER_FOUND
  :type:    notify
  :in:      sly_Controller_Interface
  :since:   0.6
  :subject: der auszuführende Controller
  :params:
    app     (sly_App_Interface)  die aktuelle App
    name    (string)             der Name des Controllers (z.B. ``structure``)
    action  (string)             die auszuführende Action (z.B. ``edit``)

  Dieses Event wird immer ausgeführt, nachdem der Controller erkannt wurde, der
  ausgeführt werden soll. Im Gegensatz zum veralteten ``PAGE_CHECKED`` wird
  dieses Event auch im Frontend ausgeführt.
