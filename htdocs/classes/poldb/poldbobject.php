<?php

namespace POLDB;

define( 'NPC_TABLE', 'npc_list' );

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

}

