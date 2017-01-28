<?php

namespace POLDB;

class Auction {
   public static function show( $f3, $params ) {
      $f3->set( 'title', 'Auction House' );

   /*
      db_fields_load(
         $f3,
         'auction_house',
         array(
            'id' => array(
               'name' => 'Auction ID',
            ),
            'itemid' => array(
               'Item ID',
            'stack' => 'Stack Size',
            'seller' => 'Seller',
            'seller_name' => 'Seller Name',
            'date' => array(
               'name' => 'Date',
            ),
            'price' =>,
            'buyer_name',
            'sale',
            'sell_date',
         ),
         'itemid ASC',
         $f3->get( 'PARAMS.page' )
      );
   */

      echo( \Template::instance()->render( 'templates/data.html' ) );
   }
}

