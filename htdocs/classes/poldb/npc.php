<?php

namespace POLDB;

class NPC extends POLDBObject {

   protected $fields = array(
      'npcid' => array(
         'name' => 'NPC ID',
         'edit' => false,
         'size' => 10,
      ),
      'name' => array(
         'name' => 'NPC Name',
      ),
      'polutils_name' => array(
         'display' => false,
      ),
      'pos_rot' => array(
         'name' => 'Rotation',
         'size' => 7,
      ),
      'pos_x' => array(
         'name' => 'Position X',
         'size' => 7,
      ),
      'pos_y' => array(
         'name' => 'Position Y',
         'size' => 7,
      ),
      'pos_z' => array(
         'name' => 'Position Z',
         'size' => 7,
      ),
      'flag' => array(
         'name' => 'Flag',
         'size' => 5,
         'display' => false,
      ),
      'speed' => array(
         'name' => 'Speed',
         'size' => 3,
      ),
      'speedsub' => array(
         'name' => 'Speed Sub',
         'size' => 3,
      ),
      'animation' => array(
         'name' => 'Animation',
         'type' => 'select',
         'size' => 10,
         'options' => array(
            '0' => 'NONE',
            '1,' => 'ATTACK',
            '3,' => 'DEATH',
            '5,' => 'CHOCOBO',
            '6,' => 'FISHING',
            '8,' => 'OPEN_DOOR',
            '9,' => 'CLOSE_DOOR',
            '10' => 'ELEVATOR_UP',     
            '11' => 'ELEVATOR_DOWN',
            '33' => 'HEALING',
            '38' => 'FISHING_FISH',
            '39' => 'FISHING_CAUGHT',
            '40' => 'FISHING_ROD_BREAK',
            '41' => 'FISHING_LINE_BREAK',
            '42' => 'FISHING_MONSTER',
            '43' => 'FISHING_STOP',
            '44' => 'SYNTH',
            '47' => 'SIT',
            '48' => 'RANGED',
            '50' => 'FISHING_START',
         ),
      ),
      'animationsub' => array(
         'name' => 'Ani Sub',
         'size' => 3,
      ),
      'namevis' => array(
         'name' => 'Name Visible',
         'type' => 'select',
         'size' => 10,
         'options' => array(
            '0' => 'None',
            //'1' => 'UNKNOWN1',
            //'2' => 'UNKNOWN2',
            //'4' => 'UNKNOWN4',
            '8' => 'Hide Name',
            //'12' => 'UNK4/Hide',
            //'16' => 'UNKNOWN16',
            //'24' => 'Hide/UNK16',
            '32' => 'Call for Help',
            //'36' => 'UNK4/Help',
            //'40' => 'Hide/Help',
            //'64' => 'UNKNOWN64',
            //'68' => 'Hide/UNK64',
            //'96' => 'Help/UNK64',
            //'100' => 'UNK4/Help/U64',
            //'104' => 'UNK96/Hide Name',
            //'112' => 'UNK96/UNK16',
            //'127' => 'U2/U4/Hide/U16/Help/U64',
            '128' => 'Hide Model',
            '256' => 'Hide HP',
            '2048' => 'Untargetable',
         ),
      ),
      'status' => array(
         'name' => 'Status',
         'type' => 'select',
         'size' => 10,
         'options' => array(
            '0' => 'NORMAL',
            '1' => 'UPDATE',
            '2' => 'DISAPPEAR',
            '6' => 'CUTSCENE_ONLY',
         ),
      ),
      'flags' => array(
         'name' => 'Flags',
         'size' => 7,
         'display' => false,
      ),
      //'look' => array(
      //),
      'name_prefix' => array(
         'name' => 'Name Prefix',
         'type' => 'select',
         //'size' => 3,
         'options' => array(
            '0' => 'None',
            '32' => 'The',
         ),
      ),
      'required_expansion' => array(
         'name' => 'Required EP',
         'size' => 3,
         'type' => 'select',
         'options' => array(
            'COP' => 'COP',
            'SOA' => 'SOA',
         ),
      ),
   );

   protected function reroute( $f3 ) {
      $f3->reroute( '/npc/@page' );
   }

   protected function get_db_key() {
      return 'npcid';
   }

   protected function get_mapper() {
      return new \DB\SQL\Mapper( $this->get( 'dsdb' ), 'npc_list' );
   }

   public function show( $f3, $params ) {
      $this->populate( 'npcid ASC' );
      $this->_show( $params, 'NPCs' );
   }
}

