<?php
/*
 * Copyright (c) 2010, webvariants GbR, http://www.webvariants.de
 *
 * This file is released under the terms of the MIT license. You can find the
 * complete text in the attached LICENSE file or online at:
 *
 * http://www.opensource.org/licenses/mit-license.php
 */

/* align the equal signs with SPACES only */

$myVar           = 'myvalue';
$anotherVariable = 5;
$anObjectToGo    = new stdClass();

switch ($anotherVariable) {
    case 1:
        doSomething();
        break;

    case 2:
        doSomethingOther();
        break;
}

/* It's okay to omit the brackets if your line doesn't get ridiculously long. */

if ($shortCond) shortAction();
else another();

/* But never do this: */

if ($short) action();
else {
   /* grr(); */
}

if ($reallyLongAndStupid) {
   /* muh() */
}
else foo();

/* Either use both or use none, but don't mix it! */
/* And now play attention to the whitespaces... */

function mySuperAwesomeFunction($does, $stuff, $with = true, $things = array()) {
    // I'm a comment and indented with a single [TAB].
    /* Me too! */

    if ($does && $stuff) {
        // Ha, I've got two [TAB]s!
        /* My [TAB]s can beat your [TAB]s! */

        foreach ($things as $key => $value) {
             print $value;
        }
    }
    else {
        callingAnotherFunction();
    }

    for ($i = 0; $i < count($things); ++$i) {
        /* Shame on me, did not store count() in a variable! */
    }
}

/* BTW: It doesn't matter which comment style you use. */

$foo = array(1, 2, 3);
$bar = array(
    'indented' => 'with a tab',
    'me'       => 'too' // There should be ONLY spaces between 'me' and the arrow!
);

$anotherVar = $inlineConditions ? $are : $okayIfNotTooLong;

class MyClass {
    public $foo;
    protected $bar;
    private $muh;

    /* normal methods should look like this: */

    public function __construct($a, $b) {
        $this->foo = (int) $a;
        $this->bar = (int) $b;
        $this->muh = 4;
    }

    /* It's okay to put many similar functions like this */

    public function getFoo() { return $this->foo; }
    public function getBar() { return $this->bar; }
    public function getMuh() { return $this->muh; }

    /* Be reasonable when deciding how far to go with alignments! */

    public function getXYZ()       { return $this->xyz;       }
    public function getSomething() { return $this->something; }

    public function getADamnLongVariableSoItDoesNotMakeSenseToAlignTheOthers() {
        return 7;
    }
}

/* Inside of templates, you should use the alternative control structure. */

if (true):
else:
endif;

/* end each file with one empy line*/
_