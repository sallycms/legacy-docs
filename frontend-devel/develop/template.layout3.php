<?php

class sly_Layout_Frontend extends sly_Layout_XHTML5 {
	public function __construct() {
		// Den aktuellen Artikel wird man hier vermutlich benötigen.
		$article = sly_Core::getCurrentArticle();

		// Titel
		$this->setTitle('Projekt X > '.$article->getName());

		// CSS
		$this->addCSSFile('assets/css/main.css');

		// JavaScript
		$this->addJavaScriptFile('http://code.jquery.com/jquery-1.7.1.min.js');
		$this->addJavaScriptFile('assets/js/main.js');

		// sonstige Tags
		$this->addMeta('robots', 'index, follow, noodp');
		$this->addHttpMeta('Content-Type', 'text/html; charset=UTF-8');
		$this->setFavIcon('data/mediapool/favicon.ico');
	}
}
