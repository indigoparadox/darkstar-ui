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

   private function _setup_field_defs() {
      // Prepare the field definitions.
      foreach( $this->fields as $field_key => $field_iter ) {
         // Fill in the name field if it's missing.
         if( !array_key_exists( 'name', $field_iter ) ) { 
            $this->fields[$field_key]['name'] = $field_key;
         }

         if( !array_key_exists( 'display', $field_iter ) ) {
            $this->fields[$field_key]['display'] = true;
         }

         if( !array_key_exists( 'edit', $field_iter ) ) {
            $this->fields[$field_key]['edit'] = true;
         }
      }
   }

   protected function _show( $params, $title ) {
      $this->f3->set( 'title', $title );
      echo( \Template::instance()->render( 'templates/data.html' ) );
   }

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

