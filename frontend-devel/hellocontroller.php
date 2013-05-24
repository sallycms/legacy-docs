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
	 * Diese Action nutzt einen Parameter aus dem Request, um jemanden persönlich
	 * zu begrüßen.
	 */
	public function greetAction() {
		// aktueller Request
		$request = $this->getRequest();

		// 'name' wird im Query-String (als GET-Parameter) erwartet.
		// Alternativ kann 'name' auch in einer Route als Platzhalter vorkommen,
		// da ein Treffer dann den entsprechenden Wert im Request-Objekt setzt.
		$name = $request->get('name', 'string');

		// as usual
		$response = new sly_Response('hallo '.$name.'!');
		$response->setContentType('text/plain', 'UTF-8');

		return $response;
	}
}
