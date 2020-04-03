<?php


class projecttheme_user_query extends WP_User_Query {


  protected function parse_orderby( $orderby ) {
              global $wpdb;

              $meta_query_clauses = $this->meta_query->get_clauses();

              $_orderby = '';
              if ( in_array( $orderby, array( 'login', 'nicename', 'email', 'url', 'registered' ) ) ) {
                  $_orderby = 'user_' . $orderby;
              } elseif ( in_array( $orderby, array( 'user_login', 'user_nicename', 'user_email', 'user_url', 'user_registered' ) ) ) {
                  $_orderby = $orderby;
              } elseif ( 'name' == $orderby || 'display_name' == $orderby ) {
                  $_orderby = 'display_name';
              } elseif ( 'post_count' == $orderby ) {
                  // todo: avoid the JOIN
                  $where             = get_posts_by_author_sql( 'post' );
                  $this->query_from .= " LEFT OUTER JOIN (
                      SELECT post_author, COUNT(*) as post_count
                      FROM $wpdb->posts
                      $where
                      GROUP BY post_author
                  ) p ON ({$wpdb->users}.ID = p.post_author)
                  ";
                  $_orderby          = 'post_count';
              } elseif ( 'ID' == $orderby || 'id' == $orderby ) {
                  $_orderby = 'ID';
              } elseif ( 'meta_value' == $orderby || $this->get( 'meta_key' ) == $orderby ) {
                  $_orderby = "$wpdb->usermeta.meta_value";
              } elseif ( 'meta_value_num' == $orderby ) {
                  $_orderby = "$wpdb->usermeta.meta_value+0";
              } elseif ( 'include' === $orderby && ! empty( $this->query_vars['include'] ) ) {
                  $include     = wp_parse_id_list( $this->query_vars['include'] );
                  $include_sql = implode( ',', $include );
                  $_orderby    = "FIELD( $wpdb->users.ID, $include_sql )";
              } elseif ( 'nicename__in' === $orderby ) {
                  $sanitized_nicename__in = array_map( 'esc_sql', $this->query_vars['nicename__in'] );
                  $nicename__in           = implode( "','", $sanitized_nicename__in );
                  $_orderby               = "FIELD( user_nicename, '$nicename__in' )";
              } elseif ( 'login__in' === $orderby ) {
                  $sanitized_login__in = array_map( 'esc_sql', $this->query_vars['login__in'] );
                  $login__in           = implode( "','", $sanitized_login__in );
                  $_orderby            = "FIELD( user_login, '$login__in' )";
              } elseif ( isset( $meta_query_clauses[ $orderby ] ) ) {
                  $meta_clause = $meta_query_clauses[ $orderby ];
                  $_orderby    = sprintf( 'CAST(%s.meta_value AS %s)', esc_sql( $meta_clause['alias'] ), esc_sql( $meta_clause['cast'] ) );
              }

              return " rand() ";
            }
}


 ?>
