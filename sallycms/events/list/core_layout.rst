Layout-Events
=============

``sly_Layout`` erlaubt es, die gesetzten CSS/JS-Dateien noch einmal zu
verändern, bevor sie schlussendlich ausgegeben werden. Neben den Dateien können
auch Inline-Codes und andere Inhalte noch einmal gefiltert werden.

.. slyevent:: HEADER_CSS
  :type:    filter
  :in:      string
  :out:     string
  :subject: der Inline-CSS-Code

  Über dieses Event kann der CSS-Code auf der aktuellen Seite noch einmal
  verarbeitet werden. So könnte er minimiert oder optimiert werden.

.. =============================================================================

.. slyevent:: HEADER_CSS_FILES
  :type:    filter
  :in:      array
  :out:     array
  :subject: die verlinkten CSS-Dateien

  Über dieses Event können die verlinkten CSS-Dateien noch einmal verändert
  werden.

.. =============================================================================

.. slyevent:: HEADER_JAVASCRIPT
  :type:    filter
  :in:      string
  :out:     string
  :subject: der Inline-JavaScript-Code

  Über dieses Event kann der JavaScript-Code auf der aktuellen Seite noch einmal
  verarbeitet werden. So könnte er minimiert oder optimiert werden.

.. =============================================================================

.. slyevent:: HEADER_JAVASCRIPT_FILES
  :type:    filter
  :in:      array
  :out:     array
  :subject: die verlinkten JavaScript-Dateien

  Über dieses Event können die verlinkten JavaScript-Dateien noch einmal
  verändert werden.
