<?php


class sly_Controller_Frontend_Hello extends sly_Controller_Frontend_Base {
	// ...

	/**
	 * Callback für SLY_FRONTEND_ROUTER
	 *
	 * Fügt dem übergebenen Router die Routen für diesen Controller hinzu.
	 *
	 * @param  array $params    Eventparameter
	 * @return sly_Router_Base  der übergebene Router
	 */
	public static function addRoutes(array $params) {
		$router = $params['subject']; // sly_Router_Base

		// Die Reihenfolge der Routen ist von Relevanz! Die erste treffende Route
		// zählt, alle weiteren werden nicht ausgewertet.

		// Jede Route besteht aus zwei Teilen: Das URL-Muster und die zusätzlichen
		// Parameter. Das Muster ist ein regulärer Ausdruck, der zusätzlich
		// Platzhalter der Form ':placeholder' erlaubt. Diese Platzhalter matchen
		// auf [a-z_][a-z0-9-_]* und erlauben es, direkt auf die gematchen Werte
		// zuzugreifen.

		// Route zur greet Action
		// ':name' steht später ebenso wie 'controller' über ->get() zur Verfügung.
		// 'controller' gibt den Namen des Controllers an, der den Request handeln
		// soll. 'action' gibt den Namen der Action an (ohne das 'Action'-Suffix).
		// Beide Werte müssen vorhanden sein, wobei es OK ist, wenn sie in dem
		// URL-Muster als Platzhalter auftauchen. Treffer im Muster haben Vorrang
		// vor den zusätzlich gegebenen Werten (diese fungieren also als Default-
		// Werte).

		$router->addRoute('/hello/:name', array(
			'controller' => 'hello',
			'action'     => 'greet'
		));

		// Route zum allgemeinen Controller

		$router->addRoute('/hello', array(
			'controller' => 'hello'
			// keine 'action', also wird 'index' angenommen
		));

		// und den Router an den nächsten Listener weitergeben
		return $router;
	}
}
