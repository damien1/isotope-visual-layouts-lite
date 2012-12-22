<?php
/**
 * MyPlugin Tests
 */
class Visual_Layouts_Filtrify_Tests extends WP_UnitTestCase {  
    private $plugin;  
    function setUp() {  
        parent::setUp();  
        $this->plugin = $GLOBALS['visual-layouts-filtrify'];  
    } // end setup  
    function testPluginInitialization() {  
        $this->assertFalse( null == $this->plugin );  
    } // end testPluginInitialization  
} // end class  