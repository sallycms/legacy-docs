Formular-Framework
==================

SallyCMS bringt seit Version 0.3 ein umfangreiches Framework zum Erstellen von
Backend-Formularen mit, das auch von Sally an allen Stellen genutzt wird. Die
Highlights sind:

* mehrspaltige Formulare
* mehrsprachige Formularelemente
* Datenbank-unabhängig

Die Verwendung des Frameworks ist für alle AddOns **dringend** empfohlen, um zu
vermeiden, dass bei Updates des Stylings Anpassungen an den eigenen Formularen
notwendig sind.

Der größte Unterschied zu ``rex_form`` aus REDAXO besteht darin, dass
``sly_Form`` nicht auf einem bestimmten Datensatz operiert und das Formular
selber erstellt. Wer in einem Formular Datensätze bearbeiten möchte, muss sich
um das Abrufen der Daten, Erstellen des Formulars und Speichern der Daten
selber kümmern. Dafür kann man ``sly_Form`` auch für Formulare verwenden, die
nichts mit der Datenbank zu tun haben (oder bei denen keine 1:1-Relation
zwischen Datenbankfeldern und Formularfeldern existiert).

Unterseiten
-----------

* :doc:`Formulare <forms>` (``sly_Form``, ``sly_Fieldset``, ...)
* :doc:`Formularelemente <elements>`

Beispiele
---------

Der Einstiegspunkt in die Welt der Formulare ist die Klasse ``sly_Form``. Sie
enthält eine Menge von Fieldsets, die dann die eigentlichen Elemente enthalten.
Außerdem kann jedes Formular eine beliebige Menge an verstecken Werten
enthalten.

Einfaches Formular
^^^^^^^^^^^^^^^^^^

Die API ist denkbar einfach:

.. sourcecode:: php

  <?
  // Formular anlegen
  $form = new sly_Form('index.php', 'POST', 'Mein Formulartitel');

  // Elemente hinzufügen
  $form->add(new sly_Form_Input_Text('name', 'Titel', 'Hallo Welt!'));

  // Elemente können auch weiter konfiguriert werden
  $description = new sly_Form_Textarea('description', 'Beschreibung', "Mehrzeilige\nTexte!");
  $description->addStyle('height:70px');
  $form->add($description);

  // ggf. versteckte Daten setzen
  $form->addHiddenValue('page', 'myaddon');
  $form->addHiddenValue('subpage', 'sub');

  // Und raus damit!
  print $form->render();

Obiger Code ergibt ein Formular wie es der folgende Screenshot zeigt:

.. image:: /_static/slyform-example.png

Komplexes Formular
^^^^^^^^^^^^^^^^^^

``sly_Form`` bietet jedoch weit mehr, als das obige Beispiel zeigt. Mit etwas
mehr Code kann man weit komplexere Formulare umsetzen.

.. sourcecode:: php

  <?
  // Formular anlegen
  $form = new sly_Form('index.php', 'POST', 'Mein Formulartitel');

  // Elemente hinzufügen
  $form->add(new sly_Form_Input_Text('name', 'Titel', 'Hallo Welt!'));
  $form->add(new sly_Form_Input_Checkbox('checkbox', 'Admin?', 1, 'Dieser Benutzer ist Administrator.'));

  // ggf. versteckte Daten setzen
  $form->addHiddenValue('page', 'myaddon');
  $form->addHiddenValue('subpage', 'sub');

  // ein zweites Fieldset starten
  $form->beginFieldset('Zweispaltiges Fieldset', null, 2);

  // zwei Elemente nebeneinander
  $username = new sly_Form_Input_Text('username', 'Benutzername', 'admin');
  $password = new sly_Form_Input_Password('password', 'Passwort', '');

  // ins Fieldset hängen
  $form->addRow(array($username, $password));

  // Checkbox Gruppe & einfacher Text
  $permissions = new sly_Form_Select_Checkbox('permissions', 'Rechte', array(1), array('Permission 1', 'Permission 2', 'Permission 3'));
  $text = new sly_Form_Text('Einfacher Text', 'ist auch möglich');

  // ins Fieldset hängen
  $form->addRow(array($permissions, $text));

  // ein drittes Fieldset starten
  $form->beginFieldset('Mehrsprachige Elemente');

  // zwei Elemente nebeneinander
  $description = new sly_Form_Textarea('description', 'Beschreibung', array(1 => 'Meine Beschreibung in dt.', 2 => 'My description'));
  $description->addStyle('height:50px');
  $description->setMultilingual(true);

  // ins Fieldset hängen
  $form->add($description);

  // Buttons verändern
  $form->setApplyButton(new sly_Form_Input_Button('submit', 'apply', 'Übernehmen'));
  $form->setResetButton(null);
  $form->getSubmitButton()->setAttribute('value', 'Ab dafür!');

  // Und raus damit!
  print $form->render();

Obiger Code ergibt ein Formular wie es der folgende Screenshot zeigt:

.. image:: /_static/slyform-example-complex.png

Man kann an diesem Beispiel gut sehen, dass Fieldsets mehrere Spalten haben
können (wobei nur 1 oder 2 Spalten per CSS korrekt gestyled sind, die API
unterstützt jedoch bis zu 26 Spalten), die Buttons beliebig angepasst werden
können und einzelne Elemente auch automatisch mehrsprachig gerendert werden
können.

HTML-Struktur
^^^^^^^^^^^^^

Durch die Verwendung der API ist es eigentlich nicht nötig, den Aufbau der
Formulare auf HTML-Ebene zu kennen, aber schaden kann es auch nicht. Die
Struktur entspricht in großen Teilen der, die auch REDAXO verwendet.

.. sourcecode:: html

  <div class="sly-form">
    <form>
      <div>                                    <!-- für die versteckten Formularfelder -->
        <fieldset>
          <legend>Fieldset-Titel</legend>

          <div class="rex-form-wrapper">

            <div class="rex-form-row">         <!-- eine Zeile im Formular -->
              <p class="rex-form-col-a">       <!-- Spalte 1 -->
                <!-- Das eigentliche Element, z.B. <select> -->
              </p>
              <p class="rex-form-col-b">       <!-- Spalte 2 -->
                <!-- Das eigentliche Element, z.B. <select> -->
              </p>
            </div>

            <!-- weitere Zeilen -->

          </div>
        </fieldset>

        <!-- weitere Fieldsets -->
      </div>
    </form>
  </div>
