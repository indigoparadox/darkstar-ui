<?php

namespace POLDB;

class NPC extends POLDBObject {

   protected $fields = array(
      'npcid' => array(
         'name' => 'NPC ID',
         'edit' => false,
      ),
      'name' => array(
         'name' => 'NPC Name',
      ),
      'polutils_name' => array(
         'display' => false,
      ),
      'pos_rot' => array(
         'name' => 'Rotation',
      ),
      'pos_x' => array(
         'name' => 'Position X',
      ),
   );

   protected function get_mapper() {
      return new \DB\SQL\Mapper( $this->get( 'dsdb' ), 'npc_list' );
   }

   public function show( $f3, $params ) {
      $this->populate( 'npcid ASC' );
      $this->_show( $params, 'NPCs' );
   }

   public function post( $f3, $params ) {
      $npc = $this->get_mapper(); 
      $npc->load( array( 'npcid = ?', $this->get_post( 'npcid' ) ) );

      foreach( $this->fields as $field_key => $field_iter ) {
         $npc->$field_key = $f3->get( 'POST.'.$field_key );
      }

      $npc->save();

      $f3->reroute( '/npc/@page' );
   }
}

