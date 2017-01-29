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
         'name' => 'Position Y',
         'size' => 7,
      ),
      'pos_z' => array(
         'name' => 'Position Z',
         'size' => 7,
      ),
      'flag' => array(
         'name' => 'Flag',
         'size' => 5,
      ),
      'speed' => array(
         'name' => 'Speed',
         'size' => 3,
      ),
      'speedsub' => array(
         'name' => 'Speed Sub',
         'size' => 3,
      ),
      'animation' => array(
         'name' => 'Ani',
         'size' => 3,
      ),
      'animationsub' => array(
         'name' => 'Ani Sub',
         'size' => 3,
      ),
      'namevis' => array(
         'name' => 'Name Visible',
         'size' => 3,
      ),
      'status' => array(
         'name' => 'Status',
         'size' => 3,
      ),
      'flags' => array(
         'name' => 'Flags',
         'size' => 7,
      ),
      //'look' => array(
      //),
      'name_prefix' => array(
         'name' => 'Name Prefix',
         'size' => 3,
      ),
      'required_expansion' => array(
         'name' => 'Required EP',
         'size' => 3,
         'type' => 'select',
         'options' => array(
            'COP' => 'COP',
            'SOA' => 'SOA',
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

      if( 'Submit' == $f3->get( 'POST.action' ) ) {
         foreach( $this->fields as $field_key => $field_iter ) {
            $npc->$field_key = $f3->get( 'POST.'.$field_key );
         }

         $npc->save();
      } elseif( 'Delete' == $f3->get( 'POST.action' ) ) {
         $npc->erase();
      }

      $f3->reroute( '/npc/@page' );
   }
}

