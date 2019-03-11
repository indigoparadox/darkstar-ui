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

$f3->route( 'GET /', function( $f3, $params ) {
   
} );

$f3->route( 'GET /auction/@page', 'POLDB\Auction->show' );
$f3->route( 'POST /auction/@page', 'POLDB\Auction->post' );
$f3->route( 'GET /npc/@page', 'POLDB\NPC->show' );
$f3->route( 'POST /npc/@page', 'POLDB\NPC->post' );
$f3->route( 'GET /server/@page', 'POLDB\Server->show' );
$f3->route( 'POST /server/@page', 'POLDB\Server->post' );
$f3->route( 'GET /ebase/@page', 'POLDB\EBase->show' );
$f3->route( 'POST /ebase/@page', 'POLDB\EBase->post' );
$f3->route( 'GET /mobspawns/@page', 'POLDB\MobSpawns->show' );
$f3->route( 'POST /mobspawns/@page', 'POLDB\MobSpawns->post' );

$f3->run();

