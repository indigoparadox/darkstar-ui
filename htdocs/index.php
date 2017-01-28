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

$f3->set( 'AUTOLOAD', 'classes/' );

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
         $item[$field_key] = $row->$field_key;
      }
      $items_array[] = $item;
      $row->next();
   }

   $f3->set( 'rows', $items_array );
   $f3->set( 'fields', $fields );
}

$f3->route( 'GET /', function( $f3, $params ) {
   
} );

$f3->route( 'GET /auction_house/@page', 'POLDB\Auction->show' );
$f3->route( 'POST /auction_house/@page', 'POLDB\Auction->post' );
$f3->route( 'GET /npc/@page', 'POLDB\NPC->show' );
$f3->route( 'POST /npc/@page', 'POLDB\NPC->post' );

$f3->run();

