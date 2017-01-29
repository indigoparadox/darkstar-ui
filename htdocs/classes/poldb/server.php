<?php

namespace POLDB;

class Server extends POLDBObject {

   protected $fields = array(
      'name' => array(
         'name' => 'Name',
      ),
      'value' => array(
         'value' => 'Value',
      ),
   );

   protected function reroute( $f3 ) {
      $f3->reroute( '/server/@page' );
   }

   protected function get_db_key() {
      return 'name';
   }

   protected function get_mapper() {
      return new \DB\SQL\Mapper( $this->get( 'dsdb' ), 'server_variables' );
   }

   public function show( $f3, $params ) {
      $this->populate( 'name ASC' );
      $this->_show( $params, 'Server Variables' );
   }

}

