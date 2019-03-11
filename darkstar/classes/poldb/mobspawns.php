<?php

namespace POLDB;

class MobSpawns extends POLDBObject {
   protected $fields = array(
      'mobid' => array(
         'name' => 'Spawn ID',
         'size' => 10,
      ),
      'mobname' => array(
         'name' => 'Mob Name',
      ),
      'polutils_name' => array(
         'display' => false,
      ),
      'groupid' => array(
         'name' => 'Group ID',
         'size' => 5,
      ),
      'pos_x' => array(
         'name' => 'Pos X',
         'size' => 5,
      ),
      'pos_y' => array(
         'name' => 'Pos Y',
         'size' => 5,
      ),
      'pos_z' => array(
         'name' => 'Pos Z',
         'size' => 5,
      ),
      'pos_rot' => array(
         'name' => 'Pos R',
         'size' => 5,
      ),
   );

   protected function reroute( $f3 ) {
      $f3->reroute( '/mobspawns/@page' );
   }

   protected function get_db_key() {
      return 'mobid';
   }

   protected function get_mapper() {
      return new \DB\SQL\Mapper( $this->get( 'dsdb' ), 'mob_spawn_points' );
   }

   public function show( $f3, $params ) {
      $this->populate( 'mobid ASC' );
      $this->_show( $params, 'Mob Spawn Points' );
   }

}

