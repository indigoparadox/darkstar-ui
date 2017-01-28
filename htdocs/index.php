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

function load_db_fields( $f3, $db_name, $fields, $sort_key ) {
   $row = new DB\SQL\Mapper( $f3->get( 'dsdb' ), $db_name );
   $row->load(
      array(),
      array(
         'order' => $sort_key,
         'offset' => 0,
         'limit' => 5,
      )
   );
   $items_array = array();
   while( !$row->dry() ) {
      $item = array();
      foreach( $fields as $field_iter ) {
         $item[$field_iter] = $row->$field_iter;
      }
      $items_array[] = $item;
      $row->next();
   }
   $f3->set( 'items', $items_array );
   $f3->set( 'fields', $fields );
}

$f3->route( 'GET /', function( $f3, $params ) {
   
} );

$f3->route( 'GET /auction_house', function( $f3, $params ) {

   $f3->set( 'title', 'Auction House' );

   load_db_fields(
      $f3,
      'auction_house',
      array(
         'id',
         'itemid',
         'stack',   
         'seller',  
         'seller_name',
         'date',
         'price',
         'buyer_name',
         'sale',
         'sell_date',
      ),
      'itemid ASC'
   );

   echo( \Template::instance()->render( 'templates/data.html' ) );

} );

$f3->route( 'GET /npc', function( $f3, $params ) {

   $f3->set( 'title', 'NPCs' );

   load_db_fields(
      $f3,
      'npc_list',
      array(
         'npcid',
         'name',
         'polutils_name',
         'pos_rot',
         'pos_x',
      ),
      'npcid ASC'
   );

   echo( \Template::instance()->render( 'templates/data.html' ) );
} );

$f3->run();

