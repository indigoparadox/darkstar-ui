<?php

namespace POLDB;

class Auction extends POLDBObject {

   protected $fields = array(
      'id' => array(
         'name' => 'Auction ID',
      ),
      'itemid' => array(
         'name' => 'Item ID',
      ),
      'stack' => array(
         'name' => 'Stack Size',
      ),
      'seller' => array(
         'name' => 'Seller',
      ),
      'seller_name' => array(
         'name' => 'Seller Name',
      ),
      'date' => array(
         'name' => 'Date',
      ),
      'price' => array(
         'name' => 'Price',
      ),
      'buyer_name' => array(
         'name' => 'Buyer Name',
      ),
      'sale' => array(
         'name' => 'Sale',
      ),
      'sell_date' => array(
         'name' => 'Sell Date'
      ),
   );

   protected function get_mapper() {
      return new \DB\SQL\Mapper( $this->get( 'dsdb' ), 'auction_house' );
   }

   public function show( $f3, $params ) {
      $this->populate( '' );
      $this->_show( $params, 'Auctions' );
   }
}

