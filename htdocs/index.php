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
         $item[$field_key] = $row->$field_key;
      }
      $items_array[] = $item;
      $row->next();
   }


   // Prepare the field definitions.
   foreach( $fields as $field_key => $field_iter ) {
      // Fill in the name field if it's missing.
      if( !array_key_exists( 'name', $field_iter ) ) { 
         $fields[$field_key]['name'] = $field_key;
      }

      if( !array_key_exists( 'display', $field_iter ) ) {
         $fields[$field_key]['display'] = true;
      }

      if( !array_key_exists( 'edit', $field_iter ) ) {
         $fields[$field_key]['edit'] = true;
      }
   }

   $f3->set( 'rows', $items_array );
   $f3->set( 'fields', $fields );
}

$f3->route( 'GET /', function( $f3, $params ) {
   
} );

$f3->route( 'GET /auction_house/@page', 'POLDB\Auction::show' );
$f3->route( 'GET /npc/@page', 'POLDB\NPC::show' );

$f3->run();

