<div class="row">
  <div class="main-block-kb col-md-12">
    <section class="category-list-column">

    <?php

      $categories_one_level = get_categories( $args = array(
        //'type'                     => 'post',
        //'child_of'                 => 0,
        'parent'                   => '0',
        'hide_empty'               => 1,
        'hierarchical'             => 1,
        'taxonomy'                 => 'category',
        'pad_counts'               => false
      ));

      if( $categories_one_level ): ?>
        <header>
          <h1>Обзор рубрик</h1>
        </header>
        <div class="row">
          <?php foreach( $categories_one_level as $cat_1 ): ?>

          	<div class="category-item-1l col-md-6 clearfix">
              <?php echo do_shortcode( '[term-list term_id="' . $cat_1->term_id . '" taxonomy="category"]' ) ?>

            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

    </section>

    <section class="tags-list">
        <?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
    </section>
  </div>

</div>
