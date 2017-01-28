<?php

namespace POLDB;

define( 'NPC_TABLE', 'npc_list' );

class NPC extends POLDBObject {

   protected $field_defs = array(
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

   protected $db_table = 'npc_list';
   protected $db_key = 'npcid';

   public function show( $f3, $params ) {

      $f3->set( 'title', 'NPCs' );

      $this->populate(
         $f3,
         $this->db_table,
         'npcid ASC',
         $f3->get( 'PARAMS.page' )
      );

      echo( \Template::instance()->render( 'templates/data.html' ) );
   }

   public function post( $f3, $params ) {
   
      $npc = new \DB\SQL\Mapper( $f3->get( 'dsdb' ), $this->db_table );
      $npc->load( array( 'npcid = ?', $f3->get( 'POST.npcid' ) ) );

      foreach( $this->fields() as $field_key => $field_iter ) {
         if( $this->db_key == $field_iter ) {
            continue;
         }

         $npc->$field_key = $f3->get( 'POST.'.$field_key );
      }

      $npc->save();

      $f3->reroute( '/npc/@page' );
   }
}

