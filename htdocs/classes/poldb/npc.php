<?php

namespace POLDB;

class NPC {
   public static function show( $f3, $params ) {

      $f3->set( 'title', 'NPCs' );

      db_fields_load(
         $f3,
         'npc_list',
         array(
            'npcid' => array(
               'name' => 'NPC ID',
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
         ),
         'npcid ASC',
         $f3->get( 'PARAMS.page' )
      );

      echo( \Template::instance()->render( 'templates/data.html' ) );
   }
}

