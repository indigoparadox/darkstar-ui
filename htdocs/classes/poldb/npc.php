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

   public function show( $f3, $params ) {

      $f3->set( 'title', 'NPCs' );

      db_fields_load(
         $f3,
         $this->db_table,
         $this->fields(),
         'npcid ASC',
         $f3->get( 'PARAMS.page' )
      );

      echo( \Template::instance()->render( 'templates/data.html' ) );
   }

   public function post( $f3, $params ) {
   
      $npc = new \DB\SQL\Mapper( $f3->get( 'dsdb' ), $this->db_table );
      $npc->load( array( 'npcid = ?', $f3->get( 'POST.npcid' ) ) );

      print_r( $this->fields() );

      die();

   }
}

