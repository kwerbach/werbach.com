<?php 

if ( ! function_exists( 'bfa_content_nav' ) ) :

function bfa_content_nav( $args = '' ) {

   global $wp_query;
   if ( $wp_query->max_num_pages < 2 )  // Display only if more than 1 page:
       return;

    $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
    $pagenum_link = html_entity_decode( get_pagenum_link() );
    $query_args   = array();
    $url_parts    = explode( '?', $pagenum_link );

    if ( isset( $url_parts[1] ) ) {
        wp_parse_str( $url_parts[1], $query_args );
    }

    $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
    $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

    $defaults = array(
        'base'     => $pagenum_link,
        'format' => '?paged=%#%',
        'total'    => $wp_query->max_num_pages,
        'current'  => $paged,
        'mid_size' => 5
   );

   $id = '';
   if( strpos( $args, '=' ) !== FALSE ) { // A URL query stlye parameter was used: this=that&this=that
       $params = wp_parse_args( $args, $defaults );
       if( isset( $params['id'] ) ) {
           $id = $params['id'];
           unset( $params['id'] ); // 'id' does not belong to paginate_links parameters
       }
   } else {
       if( ! empty( $args ) ) {
           $id = $args; // old version, only $id could be passed as parameter
       }
       $params = $defaults;
   }

   if( $id != '' )
       $id = ' id="' . $id . '"'; // a CSS ID can be added
   ?>


   <nav class="multinav"<?php echo $id; ?>>
       <?php echo paginate_links( $params ); ?>
   </nav>

   <?php

}
endif;
