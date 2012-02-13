<?php

/**
 * Unser Hello-Controller
 *
 * Controller müssen mindestens das Interface sly_Controller_Interface implementieren.
 * In 99% der Fälle wird man sich aber eher von sly_Controller_Frontend_Base
 * ableiten. Dort wird bereits das view-Verzeichnis auf develop/views festgelegt
 * und der Zugriff für alle Besucher erlaubt.
 */
class sly_Controller_Frontend_Hello extends sly_Controller_Frontend_Base {
	/**
	 * Die Standard-Action
	 *
	 * Wenn keine Action in der URL gefunden wurde, wird diese Action verwendet.
	 *
	 * Actions sollten immer *entweder* ihre Ausgabe direkt printen *oder* ein
	 * sly_Response-Objekt zurückgeben (sehr empfohlen). Das Response-Objekt
	 * erlaubt es, Header zu sammeln und ggf. von Listenern auf SLY_SEND_RESPONSE
	 * noch einmal verarbeiten zu lassen.
	 */
	public function indexAction() {
		$response = new sly_Response('hallo');
		$response->setContentType('text/plain', 'UTF-8');

		return $response;
	}

	/**
	 * Eine weitere Action
	 *
	 * Diese Action nutzt einen Parameter aus der Route (Teil des virtuellen
	 * Request Filename, nicht aus dem Query-String), um jemanden persönlich
	 * zu begrüßen.
	 */
	public function greetAction() {
		// aktuelle App (Frontend-App)
		$app = sly_Core::getCurrentApp();

		// die Frontend-App (und nur sie!) gibt den Router preis
		$router = $app->getRouter();

		// die getroffene Route hat weitere Daten, auf die wir via ->get()
		// zugreifen können.
		$name = $router->get('name');

		// as usual
		$response = new sly_Response('hallo '.$name.'!');
		$response->setContentType('text/plain', 'UTF-8');

		return $response;
	}
}
