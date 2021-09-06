<?php
/**
* Template Name: Project Campfire Dashboard
*
* @package WordPress
* @subpackage Music Therapy Ed Learn
*/

get_header();

?>



<div id="main-content" class="library-procamp">

    <div class="filter-sidebar">
        <div class="sticky-wrapper">
            <?php echo facetwp_display( 'facet', 'procamp_search' ); ?>
            <h3>Type</h3>
            <?php echo facetwp_display( 'facet', 'procamp_type' ); ?>
            <h3>Domains</h3>
            <?php echo facetwp_display( 'facet', 'procamp_domains' ); ?>
            <h3>Populations</h3>
            <?php echo facetwp_display( 'facet', 'procamp_populations' ); ?>
        </div>

        <div class="mobile-filters">
            <?php echo facetwp_display( 'facet', 'procamp_search' ); ?>
            <?php echo facetwp_display( 'facet', 'procamp_type_mobile' ); ?>
            <?php echo facetwp_display( 'facet', 'procamp_domains_mobile' ); ?>
            <?php echo facetwp_display( 'facet', 'procamp_populations_mobile' ); ?>
        </div>
    </div>

    <div class="header-cards">
        <!--header card repeater-->
        <?php if( have_rows('header_cards') ): ?>

            <?php while( have_rows('header_cards') ): the_row(); 

                // vars
                $message = get_sub_field('message');
                $video = get_sub_field('video');
                $unlock_id = get_sub_field('unlock_id');
                $tags = get_sub_field('tags');
                $without_tags = get_sub_field('without_tags');
                ?>

                <?php if( !accessally_has_any_tag_id("$without_tags") || empty($without_tags) ): ?>

                    <?php if( accessally_has_any_tag_id("$tags") || empty($tags) ): ?>

                        <div class="header-card">

                            <div class="message">
                                <h1><strong>Project</strong> Campfire <i class="fad fa-fire-alt" style="--fa-primary-color: #FFCA51; --fa-secondary-color: #fc7405; --fa-secondary-opacity: 1; font-size: 30px;" aria-hidden="true"></i></h1>
                                <?php echo $message; ?>

                                <!--button repeater-->
                                <?php if( have_rows('buttons') ): ?>

                                    <p class="button-bar">

                                        <?php while( have_rows('buttons') ): the_row();

                                        //vars
                                        $text = get_sub_field('text');
                                        $url = get_sub_field('url');
                                        $color = get_sub_field('color');
                                        $external_link = get_sub_field('external_link');
                                        $icon = get_sub_field('icon');
                                        ?>

                                        <a class="button <?php echo $color; ?>" href="<?php echo $url; ?>"<?php if( $external_link ): ?>target="_blank"<?php endif; ?>><?php echo $text; ?><i class="fas fa-<?php echo $icon; ?>"></i></a>

                                        <?php endwhile; ?>

                                    </p>

                                <?php endif; ?>

                                <!--unlocks counter-->
                                <?php if( !empty($unlock_id) ): ?>
                                    <p><span style="display: inline-block;"><span class="count"><i class="fas fa-key"></i>  <?php echo do_shortcode( '[accessally_field_value operation_id="'. $unlock_id .'"]' ); ?></span> <strong>UNLOCKS AVAILABLE</strong></span></p>
                                <?php endif; ?>
                            </div>

                            <div class="video">
                                <div class="embed-container">
                                    <?php echo $video ?>
                                </div><!-- .embed-container -->
                            </div>

                        </div>

                    <?php endif; ?>
                    
                <?php endif; ?>

            <?php endwhile; ?>

        <?php endif; ?>
    </div>

    <div class="intervention-card-container">
        <?php
        $ids_args = [
            'post_type'      => 'intervention',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
        ];

        $all_interventions = get_posts( $ids_args );

        if ( $all_interventions ) {
            $intervention_list = array();
            $owned_list = array();

            // Loop through all of the interventions to build ID lists
            foreach ( $all_interventions as $intervention ) {
                $tag = get_field( 'tag', $intervention );
                $freebie = get_field('freebie', $intervention );

                // Add all IDs to an array we can merge into
                array_push( $intervention_list, $intervention->ID );
                
                // If they own the intervention, add it to an array
                if ( accessally_has_any_tag_id( $tag ) || $freebie ) {
                    array_push( $owned_list, $intervention->ID );
                }
            }

            wp_reset_postdata();
        }

        // Make sure we have interventions before continuing
        if ( $intervention_list ) :

            // Add the array of owned interventions to the front of our $interventions array
            $post_ids_merged = array_merge( $owned_list, $intervention_list );

            // Make sure that we remove the ID's from their original positions
            $reordered_ids   = array_unique( $post_ids_merged );

            // Now we can run our normal query to display all of the interventions with Facet enabled
            $args = [
                'post_type'      => 'intervention',
                'posts_per_page' => -1,
                'post__in'       => $reordered_ids,
                'orderby'        => 'post__in',
                'order'          => 'ASC',
                'facetwp'        => true,
            ];

            $the_loop = new WP_Query( $args );

            while( $the_loop->have_posts() ) :
                // Setup the post loop
                $the_loop->the_post();

                get_template_part( 'template-parts/intervention-card', 'intervention-card' );
                
            endwhile;
            wp_reset_postdata();
        else : ?>
            <div class="search-error">
                <h2>No courses found &#129300;</h2>
                <p>We couldn't find what you're looking for - try using a different search term.</p>
            </div>
        <?php endif;
        /* Restore original Post Data */
        wp_reset_postdata();
        ?>
    </div>
</div> <!-- #main-content -->

<?php

get_footer();
