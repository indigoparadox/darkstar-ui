<?php

namespace POLDB;

abstract class POLDBObject {

   private $f3;

   protected $params;
   protected $fields = array();
   
   public function beforeroute( $f3 ) {
      $this->f3 = $f3;
      $this->params = $params;
      $this->_setup_field_defs();
      $this->f3->set( 'fields', $this->fields );
   }

   private function _ensure_field_opt( $field_key, $opt, $default ) {
      if( !array_key_exists( $opt, $this->fields[$field_key] ) ) { 
         $this->fields[$field_key][$opt] = $default;
      }
   }

   private function _setup_field_defs() {
      // Prepare the field definitions.
      foreach( $this->fields as $field_key => $field_iter ) {
         // Fill in the name field if it's missing.
         $this->_ensure_field_opt( $field_key, 'name', $field_key );
         $this->_ensure_field_opt( $field_key, 'type', 'text' );
         $this->_ensure_field_opt( $field_key, 'display', true );
         $this->_ensure_field_opt( $field_key, 'edit', true );
         $this->_ensure_field_opt( $field_key, 'size', 20 );
      }
   }

   protected function _show( $params, $title ) {
      $this->f3->set( 'title', $title );
      $templar = \Template::instance();

      $templar->extend( 'field', 'POLUtil\TemplarField::render' );

      echo( $templar->render( 'templates/data.html' ) );
   }

   public function post( $f3, $params ) {
      $row = $this->get_mapper(); 
      $row->load( array(
         // Can we not use params as the field name?
         $this->get_db_key().' = ?',
         $this->get_post( $this->get_db_key() )
      ) );

/*
      echo( '<pre>' );
      var_dump( $this->get_db_key() );
      var_dump( $row->name );
      var_dump( $row->value );
      var_dump( $this->get( 'POST.action' ) );
      echo( '</pre>' );
      die();
*/

      if( 'Submit' == $f3->get( 'POST.action' ) ) {
         foreach( $this->fields as $field_key => $field_iter ) {
            $row->$field_key = $f3->get( 'POST.'.$field_key );
         }

         $row->save();
      } elseif( 'Delete' == $f3->get( 'POST.action' ) ) {
         $row->erase();
      }

      $this->reroute( $f3 );
   }

   protected abstract function reroute( $f3 );

   protected abstract function get_db_key();
   protected abstract function get_mapper();

   protected function get( $key ) {
      return $this->f3->get( $key );
   }

   protected function get_param( $key ) {
      return $this->get( 'PARAMS.'.$key );
   }

   protected function get_post( $key ) {
      return $this->get( 'POST.'.$key );
   }

   protected function populate( $sort_key ) {
      $row = $this->get_mapper();
      $row->load(
         array(),
         array(
            'order' => $sort_key,
            'offset' => $this->get_param( 'page' ) * $this->get( 'db_page_size' ),
            'limit' => $this->get( 'db_page_size' ),
         )
      );
      $items_array = array();
      while( !$row->dry() ) {
         $item = array();
         foreach( $this->fields as $field_key => $field_iter ) {
            $item[$field_key] = $row->$field_key;
         }
         $items_array[] = $item;
         $row->next();
      }

      $this->f3->set( 'rows', $items_array );
   }

}

