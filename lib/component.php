<?php

/**
 * This file contains functions that let us include a partial file
 * and send arguments, this enable us to use modular components
 * in wordpress from the server side, very similar to an angular directive
 *
 * Usage:
 *
 * get_component("filename.php", array(
 *     "argument1" => "value 1",
 *     "argument2" => "value 2"
 * ));
 *
 */



/* @param string $file The file path, relative to theme root
 * @param array $args The arguments to pass to this file. Optional.
 * Default empty array.
 *
 * @return object Use render() method to display the content.
 */

if ( ! class_exists("Component") ) {
  class Component{
    private $args;
    private $file;

    public function __get($name) {
      return $this->args[$name];
    }

    public function __construct($file, $args = array()) {
      $this->file = $file;
      $this->args = $args;
    }

    public function __isset($name){
      return isset( $this->args[$name] );
    }

    public function render() {
      $compRoot = "/components/";
      include( get_template_directory() . $compRoot . $this->file . ".php");
    }
  }
}

/**
 * get_component
 *
 * shorthand to render a component.
 *
 * @see PHP class Component above
 * @param string $file The file path, relative to theme components dir
 * @param array $args The arguments to pass to this file. Optional.
 * Default empty array.
 *
 * @return string The HTML from $file
 */
if( ! function_exists("render_component") ){
  function render_component($file, $args = array()){
    $component = new Component($file, $args);
    $component->render();
  }
}

if( ! function_exists("get_component") ){
  function get_component($file, $args = array()){
    ob_start();
    $component = new Component($file, $args);
    $component->render();
    return ob_get_clean();
  }
}

