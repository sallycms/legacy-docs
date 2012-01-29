Mails mit Sally verschicken
===========================

Seit Sally 0.4 existiert mit ``sly_Mail`` eine rudimentäre Unterstützung zum
Versenden von einfachen Plaintext-eMails.

Grundlagen
----------

.. sourcecode:: php

  <?
  $mail = sly_Mail::factory();

  // Empfänger
  $mail->addTo('mail@host.com', 'Tom Tester');
  $mail->addTo('second@mail.com'); // Name ist optional

  // wirft eine sly_Mail_Exception
  // $mail->addTo('ungültige adresse');

  // Absender
  $mail->setFrom('mail@host.com', 'Super Website X');

  // Betreff
  $mail->setSubject('Meine Betreffszeile');

  // Inhalt
  $mail->setBody('Hallo Welt. Dies ist meine Mail.');

  // Sonstiges
  $mail->setContentType('text/plain'); // text/plain ist auch Standard
  $mail->setCharset('UTF-8');          // dito

  // Header setzen
  $mail->setHeader('X-User', 'Beispielwert');

  // Ein Header kann über false/null/'' entfernt werden.
  $mail->setHeader('X-User', null);

  // alle Empfänger entfernen
  // $mail->clearTo();

  // Mail versenden (wirft sly_Mail_Exception im Fehlerfall)
  try {
      $mail->send();
  }
  catch (Exception $e) {
      print 'eMail konnte nicht versendet werden.';
  }

Erweitere Implementierungen
---------------------------

``sly_Mail`` implementiert das Interface ``sly_Mail_Interface``, in dem die oben
gezeigten Methoden definiert sind. Die ``::factory()``-Methode liefert immer ein
neues Objekt zurück, wobei über das Eventsystem auf die jeweilige Klasse
Einfluss genommen werden kann.

Das Event ``SLY_MAIL_CLASS`` filtert den Klassennamen. Ein AddOn könnte so zum
Beispiel Swiftmailer oder PHPMailer bereitstellen:

.. sourcecode:: php

  <?
  // alternativen Klassennamen zurückgeben
  function getMailerClassName(array $params) {
      return 'MyMailWrapper';
  }

  // in das Event hängen
  sly_Core::dispatcher()->register('SLY_MAIL_CLASS', 'getMailerClassName');

  $mail = sly_Mail::factory(); // $mail instanceof MyMailWrapper

Dabei ist zu beachten, dass ``MyMailWrapper`` unbedingt das Interface
implementieren muss, da sonst eine Exception geworfen wird. Für die meisten
Bibliotheken dürfte es daher nötig sein, eine eigene Wrapper-Klasse zu
entwickeln, die zwischen Sally und der Bibliothek vermittelt.

.. sourcecode:: php

  <?
  class MyMailWrapper implements sly_Mail_Interface {
      protected $mailer;

      public function __construct() {
          $this->mailer = new PHPMailer();
      }

      public function addTo($mail, $name = null) {
          $this->mailer->To = $mail; // PSEUDOCODE!
      }

      public function send() {
          try {
              $this->mailer->Send(); // PSEUDOCODE
          }
          catch (MailSpecificExceptionClass $e) {
              // Es sollte sichergestellt werden, dass auch hier im Fehlerfall eine
              // sly_Mail_Exception geworfen wird.
              throw new sly_Mail_Exception($e->getMessage());
          }
      }
  }

Basisimplementierung erzwingen
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

In Sonderfällen kann es auch gewünscht sein, *immer* ``sly_Mail`` zu verwenden,
selbst wenn ein AddOn eine größere Bibliothek mitbringt. In diesem Fall kann man
den Konstruktur von ``sly_Mail`` auch direkt aufrufen und so das
``SLY_MAIL_CLASS``-Event umgehen:

.. sourcecode:: php

  <?
  $mail = new sly_Mail();

Im Allgemeinen sollte man aber eher die Factory verwenden.
