<?php
/**
* Template Name: Project Campfire Dashboard
*
* @package WordPress
* @subpackage Music Therapy Ed Learn
*/

get_header();

?>

<script type="text/javascript">
    (function($) {
    $(window).load(function() {
        $('.card-module').hover(function() {
        $(this).find('.description').stop().animate({
            height: "toggle",
            opacity: "toggle"
        }, 300);
        });
        });
    })(jQuery);
</script>

<div id="main-content" class="campfire">

<?php 
$posts = get_posts(array(
	'posts_per_page'    => -1,
    'post_type'         => 'intervention',
    'order'             => 'ASC',
    'orderby'           => 'title'
));
?>
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
        <i class="fal fa-search"></i><input type="text" class="quicksearch" placeholder="Search for ideas" />
    </div>

    <div class="filters">

        <div class="button-group" data-filter-group="type">
            <p class="filter-label">Type</p>
            <button class="filter-button" data-filter=".idea">Idea</button>
            <button class="filter-button" data-filter=".jam-along">Jam Along</button>
        </div>

        <div class="button-group domain" data-filter-group="domain">
            <p class="filter-label">Domains</p>
            <button class="filter-button" data-filter=".cognitive">Cognitive</button>
            <button class="filter-button" data-filter=".emotional">Emotional</button>
            <button class="filter-button" data-filter=".communicative">Communicative</button>
            <button class="filter-button" data-filter=".musical">Musical</button>
            <button class="filter-button" data-filter=".psychosocial">Psychosocial</button>
            <button class="filter-button" data-filter=".sensorimotor">Sensorimotor</button>
            <button class="filter-button" data-filter=".spiritual">Spiritual</button>
        </div>

        <div class="button-group" data-filter-group="population">
            <p class="filter-label">Populations</p>
            <button class="filter-button" data-filter=".addictive-disorders">Addictive Disorders</button>
            <button class="filter-button" data-filter=".educational-settings">Educational Settings</button>
            <button class="filter-button" data-filter=".intellectual-and-developmental-disabilities">Intellectual and Developmental Disabilities</button>
            <button class="filter-button" data-filter=".medical-settings">Medical Settings</button>
            <button class="filter-button" data-filter=".mental-health">Mental Health</button>
            <button class="filter-button" data-filter=".older-adults">Older Adults</button>
            <button class="filter-button" data-filter=".physical-disabilities">Physical Disabilities</button>
            <button class="filter-button" data-filter=".wellness">Wellness</button>
        </div>
    </div>
    
    <div class="select-filters">

        <select class="filters-select" value-group="type">
            <option value="*">Both Types</option>
            <option value=".idea">Idea</option>
            <option value=".jam-along">Jam Along</option>
        </select>

        <select class="filters-select" value-group="domain">
            <option value="*">All Domains</option>
            <option value=".cognitive">Cognitive</option>
            <option value=".emotional">Emotional</option>
            <option value=".communicative">Communicative</option>
            <option value=".musical">Musical</option>
            <option value=".psychosocial">Psychosocial</option>
            <option value=".sensorimotor">Sensorimotor</option>
            <option value=".spiritual">Spiritual</option>
        </select>

        <select class="filters-select" value-group="population">
            <option value="*">All Populations</option>
            <option value=".addictive-disorders">Addictive Disorders</option>
            <option value=".educational-settings">Educational Settings</option>
            <option value=".intellectual-and-developmental-disabilities">Intellectual and Developmental Disabilities</option>
            <option value=".medical-settings">Medical Settings</option>
            <option value=".mental-health">Mental Health</option>
            <option value=".older-adults">Older Adults</option>
            <option value=".physical-disabilities">Physical Disabilities</option>
            <option value=".wellness">Wellness</option>
        </select>

    </div>

    <div class="section campfire grid">

        <!-- Card repeater -->
        <?php if( $posts ): ?>

                <?php foreach( $posts as $post ): 
                    
                    setup_postdata( $post );
                    $description = get_field('description');
                    $freebie = get_field('freebie');
					$jam_along = get_field('jam_along');
                    $operation_id = get_field('operation_id');
                    $tag = get_field('tag');

                    $domain_attrs = get_the_terms( $post->ID, 'domain' );
                    if (!empty($domain_attrs)){
                        foreach($domain_attrs as $attr){
                        $domain = $attr->slug;
                        }
                    }

                    $method_attrs = get_the_terms( $post->ID, 'method' );
                    if (!empty($method_attrs)){
                        foreach($method_attrs as $attr){
                        $method = $attr->slug;
                        }
                    }
                    
                    // List populations and format for card and shuffle
                    $population_terms = get_the_terms( $post->ID, 'population' );
                    $population_terms_string = join(', ', wp_list_pluck($population_terms, 'name'));
                    $population_terms_classes = join(' ', wp_list_pluck($population_terms, 'slug'));

                    // List equipment and format for card and shuffle
                    $equipment_list = get_the_terms( $post->ID, 'equipment' );
                    $equipment_terms_string = join(', ', wp_list_pluck($equipment_list, 'name'));
                    $equipment_terms_classes = join(' ', wp_list_pluck($equipment_list, 'slug'));

                    ?>
                    
                <div class="card-module grid-item<?php
                    // Set card styling to disabled if you do not possess VIP, ProCamp subscriber tags
                    // or the tag for an individual idea and ensure freebies are not disabled
                    if( !accessally_has_any_tag_id("104,2207,1879,2529,$tag") && !$freebie ):
                        ?> disabled<?php
                    endif;

                    // Dump all of the taxonomies to classes for isotope to filter
                    echo ' ' . $equipment_terms_classes . ' ' . $population_terms_classes . ' ' . $method . ' ' . $domain;

                    // Add the jam-along and idea classes for filtering
                    if( $jam_along ):
                        echo ' jam-along';
                    else:
                        echo ' idea';
                    endif;
                    ?>" data-owned="<?php
                    // Reorder the cards in the dashboard to ensure owned and freebie ideas show up first
                    if( accessally_has_any_tag_id("$tag") || $freebie ):
                        ?>1<?php
                    else:
                        ?>2<?php
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

                            <p class="description"><?php echo $description ?></p>

                            <ul class="card-meta">
                                <li>For
                                    <?php
                                    echo $population_terms_string;
                                    ?>
                                </li>
                                <li>Requires
                                    <?php
                                    echo $equipment_terms_string;
                                    ?>
                                </li>
                            </ul>
                            <div class="card-access">
                                <?php if( accessally_has_any_tag_id("$tag") ): ?>
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
                    <div class="my-sizer-element"></div>
                    
                <?php endforeach; ?>
            
            <?php wp_reset_postdata(); ?>

        <?php endif; ?>
    </div><!-- .section -->

    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>

</div> <!-- #main-content -->

<?php

get_footer();
