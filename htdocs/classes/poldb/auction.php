<?php

namespace POLDB;

class Auction {
   public static function show( $f3, $params ) {
      $f3->set( 'title', 'Auction House' );

      db_fields_load(
         $f3,
         'auction_house',
         array(
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
         ),
         'itemid ASC',
         $f3->get( 'PARAMS.page' )
      );

      echo( \Template::instance()->render( 'templates/data.html' ) );
   }
}

