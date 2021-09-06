<?php
/**
* Template Name: Project Campfire Dashboard
*
* @package WordPress
* @subpackage Music Therapy Ed Learn
*/

get_header();

?>



<div id="main-content" class="campfire">

    <div class="section campfire">
        
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
                                    <p><span style="display: inline-block;"><span class="count"><?php echo do_shortcode( '[accessally_field_value operation_id="'. $unlock_id .'"]' ); ?></span> <strong>UNLOCKS AVAILABLE</strong></span></p>
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
    </div><!-- .section -->
    
    <div class="searchbox">
        <?php echo facetwp_display( 'facet', 'procamp_search' ); ?>
    </div>

    <div class="filters">

        <h3>Type</h3>
        <?php echo facetwp_display( 'facet', 'procamp_type' ); ?>
        <h3>Domains</h3>
        <?php echo facetwp_display( 'facet', 'procamp_domains' ); ?>
        <h3>Populations</h3>
        <?php echo facetwp_display( 'facet', 'procamp_populations' ); ?>

    </div>

    <div class="section campfire grid">

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
                
                // Get the ACF fields
                $freebie = get_field('freebie');
                $jam_along = get_field('jam_along');
                $operation_id = get_field('operation_id');
                $tag = get_field('tag');
                $description = get_field('description');

                // Pull the last slug of the Domain attributes (there should only be one, but some have multiple)
                if ( $domain_attrs = get_the_terms( $post->ID, 'domain' ) ) {
                    foreach($domain_attrs as $attr){
                    $domain = $attr->slug;
                    }
                }
                
                // List populations and format for card and shuffle
                if ( $population_terms = get_the_terms( $post->ID, 'population' ) ) {
                    $population_terms_string = join(', ', wp_list_pluck($population_terms, 'name'));
                }

                // List equipment and format for card and shuffle
                if ( $equipment_list = get_the_terms( $post->ID, 'equipment' ) ) {
                    $equipment_terms_string = join(', ', wp_list_pluck($equipment_list, 'name'));
                }

                ?>
                
                <div class="card-module grid-item<?php
                // Set card styling to disabled if you do not possess VIP, ProCamp subscriber tags
                // or the tag for an individual intervention and ensure freebies are not disabled
                if( !accessally_has_any_tag_id("104,2207,1879,2529,$tag") && !$freebie ):
                    ?> disabled<?php
                endif;
                ?>">
                    <!-- Thumbnail-->
                    <div class="thumbnail">
                        <?php
                        // Set the image to the domain unless it's a Jam Along
                        // @todo: fix the manually set URLs to an ACF settings page
                        if ( !empty($domain) && !$jam_along ) :
                            switch ($domain) :
                                case "cognitive":
                                    echo '<img src="/wp-content/uploads/2019/11/Cognitive-Intervention-Cover.png" alt="" />';
                                    break;
                                case "communicative":
                                    echo '<img src="/wp-content/uploads/2019/11/Communication-Intervention-Cover.png" alt="" />';
                                    break;
                                case "emotional":
                                    echo '<img src="/wp-content/uploads/2019/11/Emotional-Intervention-Cover.png" alt="" />';
                                    break;
                                case "musical":
                                    echo '<img src="/wp-content/uploads/2019/11/Musical-Intervention-Cover.png" alt="" />';
                                    break;
                                case "psychosocial":
                                    echo '<img src="/wp-content/uploads/2019/11/Pscyhosocial-Intervention-Cover.png" alt="" />';
                                    break;
                                case "sensorimotor":
                                    echo '<img src="/wp-content/uploads/2019/11/Sensorimotor-Intervention-Cover.png" alt="" />';
                                    break;
                                case "spiritual":
                                    echo '<img src="/wp-content/uploads/2019/11/Spiritual-Intervention-Cover.png" alt="" />';
                                    break;
                            endswitch;
                        // Set the image to Jam Along
                        elseif ( !empty($domain) && $jam_along) :
                            echo '<img src="/wp-content/uploads/2020/11/Jam-Along-Intervention-Cover.jpg" alt="" />';
                        endif; ?>
                    </div>

                    <!-- Card Content-->
                    <div class="card-content">

                        
                        <div class="category <?php echo $domain; ?>">
                            <?php echo $domain; ?>
                        </div>

                        <h1 class="title"><?php the_title(); ?></h1>

                        <?php if ( $description ) : ?>
                            <p class="description"><?php echo $description ?></p>
                        <?php endif; ?>

                        <ul class="card-meta">
                            <?php if ( $population_terms_string ) : ?>
                                <li>For
                                    <?php
                                    echo $population_terms_string;
                                    ?>
                                </li>
                            <?php endif; ?>
                            <?php if ( $equipment_terms_string ) : ?>
                                <li>Requires
                                    <?php
                                    echo $equipment_terms_string;
                                    ?>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <div class="card-access">
                            <?php if( accessally_has_any_tag_id( $tag ) ): ?>
                                <a class="button orange" href="<?php the_permalink(); ?>">Access <i class="fas fa-fire-alt"></i></a>
                            <?php elseif( $freebie ): ?>
                                <a class="button orange" href="<?php the_permalink(); ?>">FREE <i class="fas fa-fire-alt"></i></a>
                            <?php elseif( accessally_has_any_tag_id("104,2207,1879,2529") ) : ?>
                                <?php echo do_shortcode( '[accessally_custom_operation operation_id="'. $operation_id .'"]' ); ?>
                            <?php else : ?>
                                <a class="button" href="https://musictherapyed.com/campfire/">Upgrade <i class="fas fa-lock"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

            <?php endwhile; 
            wp_reset_postdata();
        endif;
        ?>
    </div><!-- .section -->

</div> <!-- #main-content -->

<?php

get_footer();
