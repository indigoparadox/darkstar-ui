<?php

namespace POLDB;

class NPC extends POLDBObject {

   protected $fields = array(
      'npcid' => array(
         'name' => 'NPC ID',
         'edit' => false,
         'size' => 10,
      ),
      'name' => array(
         'name' => 'NPC Name',
      ),
      'polutils_name' => array(
         'display' => false,
      ),
      'pos_rot' => array(
         'name' => 'Rotation',
         'size' => 7,
      ),
      'pos_x' => array(
         'name' => 'Position X',
         'size' => 7,
      ),
      'pos_y' => array(
         'size' => 7,
      ),
      'pos_z' => array(
         'size' => 7,
      ),
      'flag' => array(
         'size' => 5,
      ),
      'speed' => array(
         'size' => 3,
      ),
      'speedsub' => array(
         'size' => 3,
      ),
      'animation' => array(
         'size' => 3,
      ),
      'animationsub' => array(
         'size' => 3,
      ),
      'namevis' => array(
         'size' => 3,
      ),
      'status' => array(
         'size' => 3,
      ),
      'flags' => array(
         'size' => 7,
      ),
      //'look' => array(
      //),
      'name_prefix' => array(
         'size' => 3,
      ),
      'required_expansion' => array(
         'size' => 3,
         'type' => 'select',
         'options' => array(
            'COP',
            'SOA',
         ),
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

