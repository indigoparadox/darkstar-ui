<?php

namespace POLDB;

class Auction extends POLDBObject {

   protected $fields = array(
      'id' => array(
         'name' => 'Auction ID',
         'size' => 10,
      ),
      'itemid' => array(
         'name' => 'Item ID',
         'size' => 10,
      ),
      'stack' => array(
         'name' => 'Stack Size',
         'size' => 4,
      ),
      'seller' => array(
         'name' => 'Seller',
      ),
      'seller_name' => array(
         'name' => 'Seller Name',
      ),
      'date' => array(
         'name' => 'Date',
         'size' => 10,
      ),
      'price' => array(
         'name' => 'Price',
         'size' => 5,
      ),
      'buyer_name' => array(
         'name' => 'Buyer Name',
      ),
      'sale' => array(
         'name' => 'Sale',
         'size' => 10,
      ),
      'sell_date' => array(
         'name' => 'Sell Date',
         'size' => 10,
      ),
   );

   protected function reroute( $f3 ) {
      $f3->reroute( '/auction/@page' );
   }

   protected function get_db_key() {
      return 'id';
   }

   protected function get_mapper() {
      return new \DB\SQL\Mapper( $this->get( 'dsdb' ), 'auction_house' );
   }

   public function show( $f3, $params ) {
      $this->populate( '' );
      $this->_show( $params, 'Auctions' );
   }
}

