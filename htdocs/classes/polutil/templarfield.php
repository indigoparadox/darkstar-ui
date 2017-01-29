<?php

namespace POLUtil;

class TemplarField extends \Prefab {

   public static function render( $node ) {
      $key = \Template::instance()->token( $node['@attrib']['key'] );
      $row = \Template::instance()->token( $node['@attrib']['row'] );
      if( $row ) {
         return '<?php $field_final = POLUtil\TemplarField::instance()->build( '.
            $key.', '.$row.' ); echo( $field_final ); ?>';
      } else {
         return '<?php $field_final = POLUtil\TemplarField::instance()->build( '.
            $key.' ); echo( $field_final ); ?>';
      }
   }

   public function build( $key, $row=null ) {
      $f3 = \Base::instance();

      $field_def = $f3->get( 'fields' )[$key];

      switch( $field_def['type'] ) {
         case 'select':
            $options = '';
            foreach( $field_def['options'] as $opt_key => $opt_iter ) {
               // Mark option as checked if it matches current value.
               if( $row && $opt_iter == $row[$key] ) {
                  $options .= '<option selected="selected">';
               } else {
                  $options .= '<option>';
               }
               
               $options .= $opt_iter.'</option>';
            }
            return '<select name="'.$key.'">'.$options.'</select>';

         case 'text':
            if( $row ) {
               $value = 'value="'.$row[$key].'" ';
            } else {
               $value = '';
            }
            $input = '<input type="text" name="'.$key.'" '.$value.'size="'.
               $field_def['size'].'" />';
            return $input;
      }
   }

}

