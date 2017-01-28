<?php

namespace POLDB;

class Auction extends POLDBObject {

   protected $field_defs = array(
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

   protected $db_table = 'auction_house';

   public function show( $f3, $params ) {
      $f3->set( 'title', 'Auction House' );

      db_fields_load(
         $f3,
         $this->db_table,
         $this->fields(),
         'itemid ASC',
         $f3->get( 'PARAMS.page' )
      );

      echo( \Template::instance()->render( 'templates/data.html' ) );
   }
}

