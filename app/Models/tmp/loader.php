<?php

// Class Loading
function classAutoLoader($class) {
    $includePaths = array(
        ROOT_PATH. 'lib/',
        ROOT_PATH. 'lib/vendor/',
        ROOT_PATH. 'models/',
        ROOT_PATH. 'models/Words/',
        ROOT_PATH. 'models/Wikipedia/',
        ROOT_PATH. 'models/Wiktionary/',
        ROOT_PATH. 'models/Google/',
        ROOT_PATH. 'models/Yahoo/',
        ROOT_PATH. 'models/Others/'
    );
    set_include_path(implode(':',$includePaths));
    require $class . ".php";
}

spl_autoload_register('classAutoLoader');