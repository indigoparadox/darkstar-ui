<?php

namespace POLDB;

abstract class POLDBObject {

   public function fields() {
      // Prepare the field definitions.
      foreach( $this->field_defs as $field_key => $field_iter ) {
         // Fill in the name field if it's missing.
         if( !array_key_exists( 'name', $field_iter ) ) { 
            $this->field_defs[$field_key]['name'] = $field_key;
         }

         if( !array_key_exists( 'display', $field_iter ) ) {
            $this->field_defs[$field_key]['display'] = true;
         }

         if( !array_key_exists( 'edit', $field_iter ) ) {
            $this->field_defs[$field_key]['edit'] = true;
         }
      }

      return $this->field_defs;
   }

   public function populate( $f3, $db_name, $sort_key, $page=0 ) {
      $row = new \DB\SQL\Mapper( $f3->get( 'dsdb' ), $db_name );
      $row->load(
         array(),
         array(
            'order' => $sort_key,
            'offset' => $page * $f3->get( 'db_page_size' ),
            'limit' => $f3->get( 'db_page_size' ),
         )
      );
      $items_array = array();
      while( !$row->dry() ) {
         $item = array();
         foreach( $this->fields() as $field_key => $field_iter ) {
            $item[$field_key] = $row->$field_key;
         }
         $items_array[] = $item;
         $row->next();
      }

      $f3->set( 'rows', $items_array );
      $f3->set( 'fields', $this->fields() );
   }

   public function show( $f3, $params ) {
   }

}

