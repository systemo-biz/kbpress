<?php
/*

Example [term-list term_id=1 taxonomy='category']

*/


class term_list_shortcode
{

  function __construct()
  {

    add_shortcode('term-list', function($atts){

      extract( shortcode_atts( array(
    		  'term_id' => 0,
          'taxonomy' => 'category',
    	 ), $atts ) );

       $term = get_term( $term_id, $taxonomy );

      ob_start();
      ?>
        <div class='term-item-wrapper'>


          <div class="term-item-title">
            <span class="glyphicon glyphicon-folder-open"></span>
            <span>   </span>
            <a href="<?php echo get_term_link($term->term_id, $taxonomy); ?>">
              <strong><?php echo $term->name; ?></strong>
              <span> (<?php echo $term->count; ?>)</span>
            </a>
          </div>


          <div class="term-item-list-subterm">
            <?php
              $terms_sublevel = get_categories( $args = array(
                //'child_of'                 => 0,
                'parent'                   => $term_id,
                'hide_empty'               => 1,
                'hierarchical'             => 1,
                'taxonomy'                 => $taxonomy,
                'pad_counts'               => false
              ));

              if($terms_sublevel):
                echo '<ul>';
                foreach( $terms_sublevel as $subterm ):
                  ?>
                  <li>
                    <span class="glyphicon glyphicon-folder-open"></span>
                    <span>   </span>

                    <a href="<?php echo get_term_link($subterm->term_id, $taxonomy); ?>">
                      <strong><?php echo $subterm->name; ?></strong>
                      <span> (<?php echo $subterm->count; ?>)</span>
                    </a>

                    <?php //var_dump($subterm) ?>
                  </li>
                  <?php
                endforeach;
                echo '</ul>';
              endif;
              //$subterm = get_term( $term_id, $taxonomy );

            ?>
          </div>


          <div class="term-item-list-posts">
            <?php
              $data = get_posts($arg=array(
                'tax_query' => array(
                		array(
                			'taxonomy' => $taxonomy,
                			'terms'    => $term_id
                		)
                	)
              ));
              if($data) {
                echo '<ul>';
                foreach ($data as $item) {
                  ?>
                  <li>
                    <span class='glyphicon glyphicon-info-sign'></span>
                    <a href="<?php echo get_permalink($item->ID); ?>">
                      <?php echo $item->post_title; ?>
                    </a>
                  </li>
                  <?php
                }
                echo '</ul>';

              }
            ?>
          </div>
        </div>
      <?php

      $html = ob_get_contents();
      ob_get_clean();

      return $html;
    });


    add_action( 'wp_enqueue_scripts', array($this, 'wptuts_styles_with_the_lot' ));

  }




  function wptuts_styles_with_the_lot()	{
  	    wp_register_style( 'sc-term-list-style', get_stylesheet_directory_uri() . '/inc/shortcode-term-list/style.css', array(), '20160208', 'all' );

  	    wp_enqueue_style( 'sc-term-list-style' );
  	}
}

$the_term_list_shortcode = new term_list_shortcode;
