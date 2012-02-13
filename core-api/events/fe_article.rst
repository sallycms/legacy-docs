Artikel-Controller
==================

Die folgenden Events werden vom Artikel-Controller im **Frontend** ausgeführt.

.. slyevent:: SLY_RESOLVE_ARTICLE
  :type:    filter
  :in:      sly_Model_Article
  :out:     sly_Model_Article
  :since:   0.6
  :subject: am Anfang ``null``

  Dieses Event dient dazu, den anzuzeigenden Artikel zu ermitteln. Listener
  können dazu die URL auswerten, den Wasserstand messen oder im Kaffeesatz
  lesen. Listener sollten entweder einen Treffer in Form eines
  ``sly_Model_Article``-Objekts oder ``null`` zurückgeben. In den meisten Fällen
  sollten Listener das Subject ungeändert zurückgeben, wenn es sich bereits um
  einen Artikel handelt (sprich ein Listener vorher bereits einen Treffer
  gelandet hat). Es ist zwar möglich, die Entscheidung eines früheren Listeners
  noch einmal zu überschreiben, aber nett ist es nicht.

.. =============================================================================

.. slyevent:: SLY_CURRENT_ARTICLE
  :type:    notify
  :in:      sly_Model_Article
  :since:   0.6
  :subject: der anzuzeigende Artikel

  Dieses Event wird ausgelöst bevor der ermittelte Artikel im Frontend gerendert
  wird. Erst ab diesem Punkt steht eindeutig fest, welcher Artikel zur Anzeige
  kommt. Listener, die im Frontend einen Artikelkontext
  (``sly_Core::getCurrentArticle()``) benötigen, sollten daher unbedingt bis zu
  diesem Event warten.

.. =============================================================================

.. slyevent:: SLY_ARTICLE_OUTPUT
  :type:    filter
  :in:      string
  :out:     string
  :since:   0.6
  :subject: die generierte Ausgabe (die gesamte HTML-Seite)
  :params:
    article  (sly_Model_Article)  der angezeigte Artikel

  Dieses Event entspricht in etwa ``OUTPUT_FILTER``, mit dem Unterschied, dass
  es nur für Artikel ausgelöst wird. Listener, die nur die Ausgabe von
  *Artikeln* verarbeiten wollen, sollten sich besser auf dieses Event anstatt
  auf das allgemeinere ``OUTPUT_FILTER`` registrieren.
