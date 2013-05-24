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
		// auf [a-z_][a-z0-9-_]* und erzeugen bei einem Treffer den gefundenen
		// Wert im Request.

		// Route zur greet Action
		// ':name' steht später im Request zur Verfügung.
		// 'slycontroller' gibt den Namen des Controllers an, der den Request
		// handeln soll. 'slyaction' gibt den Namen der Action an (ohne das
		// 'Action'-Suffix).
		// Beide Werte müssen vorhanden sein, wobei es OK ist, wenn sie in dem
		// URL-Muster als Platzhalter auftauchen. Treffer im Muster haben Vorrang
		// vor den zusätzlich gegebenen Werten (diese fungieren also als Default-
		// Werte).

		$router->addRoute('/hello/:name', array(
			'slycontroller' => 'hello',
			'slyaction'     => 'greet'
		));

		// Route zum allgemeinen Controller

		$router->addRoute('/hello', array(
			'slycontroller' => 'hello'
			// keine 'slyaction', also wird 'index' angenommen
		));

		// und den Router an den nächsten Listener weitergeben
		return $router;
	}
}
