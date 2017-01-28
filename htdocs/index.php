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

function db_fields_names( $fields, $hidden=false ) {
   foreach( $fields as $field_key => $field_iter ) {
      if( 
         !array_key_exists( 'display', $field_iter ) ||
         $field_iter['display'] ||
         $hidden
      ) {
         if( array_key_exists( 'name', $field_iter ) ) {
            yield $field_iter['name'];
         } else {
            yield $field_key;
         }
      }
   }
}

function db_fields_load( $f3, $db_name, $fields, $sort_key, $page=0, $hidden=false ) {
   $row = new DB\SQL\Mapper( $f3->get( 'dsdb' ), $db_name );
   $row->load(
      array(),
      array(
         'order' => $sort_key,
         'offset' => $page * $f3->get( 'db_page_size' ),
         'limit' => $f3->get( 'db_page_size' ),
      )
   );
   $items_array = array();
   while( !$row->dry() ) {
      $item = array();
      foreach( $fields as $field_key => $field_iter ) {
         if(
            !array_key_exists( 'display', $field_iter ) ||
            $field_iter['display'] ||
            $hidden
         ) {
            $item[$field_key] = $row->$field_key;
         }
      }
      $items_array[] = $item;
      $row->next();
   }
   $f3->set( 'items', $items_array );
   $f3->set( 'fields', db_fields_names( $fields, $hidden ) );
}

$f3->route( 'GET /', function( $f3, $params ) {
   
} );

$f3->route( 'GET /auction_house/@page', function( $f3, $params ) {

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

} );

$f3->route( 'GET /npc/@page', function( $f3, $params ) {

   $f3->set( 'title', 'NPCs' );

   db_fields_load(
      $f3,
      'npc_list',
      array(
         'npcid' => array(
            'name' => 'NPC ID',
         ),
         'name' => array(
            'name' => 'NPC Name',
         ),
         'polutils_name' => array(
            'display' => false,
         ),
         'pos_rot' => array(
            'name' => 'Rotation',
         ),
         'pos_x' => array(
            'name' => 'Position X',
         ),
      ),
      'npcid ASC',
      $f3->get( 'PARAMS.page' )
   );

   echo( \Template::instance()->render( 'templates/data.html' ) );
} );

$f3->run();

