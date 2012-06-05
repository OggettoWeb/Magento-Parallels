Run heavy pieces of your Magento code in a background process to increase page load speed.


Installation
------------

Just copy files to your magento directory. Make file /var/log/parallels.txt writeable and .parallels/run.sh executable.

Usage
-----

For example you have a model class `mymodule/model` with a method:

``````php
<?php

function bigCalculations($a, $b)
{
    $c = $a * $b;
    sleep(30); // Just relax
}
``````

And in some request you wanna run it in a backround. In your module add the following to config.xml

``````xml
<global>
    <parallels>
        <process>
            <do_my_calculations>
                <model>mymodule/model</model>
                <method>bigCalculations</method>
            </do_my_calculations>
        </process>
    </parallels>
</global>
``````

Then go to your module's class where you want to run these calculations and write:

``````php
<?php
Mage::getModel('parallels/runner')->run('do_my_calculations', array(2, 3));
``````

`run` method has 2 arguments:

1.  Process identifier which we mentioned in config.xml
2.  Array with arguments which will be passed to the callback method

So after this `bigCalculations` execution will be forwarded to the separate process with
specified arguments (in our case it will just do 2*3 and sleep). Please note, that in callback method
you are free to use any Magento-related stuff like `Mage::getModel(...)`, etc.

Also, `var/log/parallels.log` file will contain output from the last parallel process call. This may help with debugging.
