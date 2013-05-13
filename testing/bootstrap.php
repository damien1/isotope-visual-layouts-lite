<?php
// Load the test environment
// https://github.com/nb/wordpress-tests

$path = '/Volumes/Proust/Damien/Sites/wordpress-tests/bootstrap.php';

if (file_exists($path)) {
        $GLOBALS['wp_tests_options'] = array(
                'active_plugins' => array('visual-layouts-filtrify/visual-layouts-filtrify.php')
        );
        require_once $path;
} else {
        exit("Couldn't find wordpress-tests/bootstrap.php\n");
}