<?php 
// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
  die( 'Nice try, But not here!!!' );
}

if ( ! function_exists( 'on_page_seo' ) ) {

  function on_page_seo()
  {
  // Site Map Function

   $postsForSitemap = get_posts( array(
          'numberposts' => -1,
          'orderby'     => 'modified',
          'post_type'   => array( 'post', 'page' ),
          'order'       => 'DESC'
      ) );
    $info = '<h1>XML Sitemap</h1>
       <p class="sitemap">
          Generated by <a href="http://xolodevelopers.com/" target="_blank" rel="noopener noreferrer">On Page SEO</a>, this is an XML Sitemap, meant for consumption by search engines.<br><br>
          You can find more information about XML sitemaps on <a href="http://sitemaps.org" target="_blank" rel="noopener noreferrer">sitemaps.org</a>.
        </p>';
      $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
      $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

      //$sitemap .= "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";    
      foreach( $postsForSitemap as $post ) {
          setup_postdata( $post );   
          $postdate = explode( " ", $post->post_modified );   
          $sitemap .= "\t" . '<url>' . "\n" .
              "\t\t" . '<loc>' . get_permalink( $post->ID ) . '</loc>' .
              "\n\t\t" . '<lastmod>' . $postdate[0] . '</lastmod>' .
              "\n\t\t" . '<changefreq>monthly</changefreq>' .
              "\n\t" . '</url>' . "\n";
      }     
      $sitemap .= '</urlset>';     
      $fp = fopen( ABSPATH . sanitize_file_name("sitemap.xml"), 'w' );
      fwrite( $fp, $sitemap );
      fclose( $fp );
  }
}
?>