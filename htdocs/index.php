<?php

$f3 = require( 'fatfree/base.php' );

$f3->config( '../conf/darkstar.ini' );

$f3->set(
   'dsdb',
   new DB\SQL(
      'mysql:host='.$f3->get( 'db_host' ).';port='.$f3->get( 'db_port' ).';dbname='.$f3->get( 'db_database' ),
      $f3->get( 'db_user' ),
      $f3->get( 'db_password' )
   )
);

$f3->route( 'GET /', function( $f3, $params ) {
   
} );

$f3->route( 'GET /auction_house', function( $f3, $params ) {

   $f3->set( 'title', 'Auction House' );

   $auction = new DB\SQL\Mapper( $f3->get( 'dsdb' ), 'auction_house' );

   $auction->load();

   $items_array = array();
   while( !$auction->dry() ) {
      $item = array(
         'id' => $auction->id,
         'itemid' => $auction->itemid,
         'stack' => $auction->stack,
         'seller' => $auction->seller,
         'seller_name' => $auction->seller_name,
         'date' => $auction->date,
         'price' => $auction->price,
         'buyer_name' => $auction->buyer_name,
         'sale' => $auction->sale,
         'sell_date' => $auction->sell_date,
      );
      $items_array[] = $item;
      $auction->next();
   }
   $f3->set( 'items', $items_array );

   $f3->set( 'fields', array(
      'itemid',
      'stack',
      'seller',
      'seller_name',
      'date',
      'price',
      'buyer_name',
      'sale',
      'sell_date',
   ) );

   echo( \Template::instance()->render( 'templates/data.html' ) );

} );

$f3->route( 'GET /npc', function( $f3, $params ) {

   $f3->set( 'title', 'NPCs' );

   $npc = new DB\SQL\Mapper( $f3->get( 'dsdb' ), 'npc_list' );

   $npc->load(
      array(),
      array(
         'order' => 'npcid ASC',
         'offset' => 0,
         'limit' => 5,
      )
   );

   $items_array = array();
   while( !$npc->dry() ) {
      $item = array(
         'npcid' => $npc->npcid,
         'name' => $npc->name,
         'polutils_name' => $npc->polutils_name,
         'pos_rot' => $npc->pos_rot,
         'pos_x' => $npc->pos_x,
      );
      $items_array[] = $item;
      $npc->next();
   }
   $f3->set( 'items', $items_array );

   $f3->set( 'fields', array(
      'npcid',
      'name',
      'polutils_name',
      'pos_rot',
      'pos_x',
   ) );

   echo( \Template::instance()->render( 'templates/data.html' ) );
} );

$f3->run();

