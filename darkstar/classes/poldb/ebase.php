<?php

namespace POLDB;

class EBase extends POLDBObject {

   protected $fields = array(
      'level' => array(
         'name' => 'Level',
      ),
      'exp' => array(
         'name' => 'Experience',
      ),
   );

   protected function reroute( $f3 ) {
      $f3->reroute( '/ebase/@page' );
   }

   protected function get_db_key() {
      return 'level';
   }

   protected function get_mapper() {
      return new \DB\SQL\Mapper( $this->get( 'dsdb' ), 'exp_base' );
   }

   public function show( $f3, $params ) {
      $this->populate( 'level ASC' );
      $this->_show( $params, 'Experience Base' );
   }

}

