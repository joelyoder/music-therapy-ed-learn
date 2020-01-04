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

                ?>

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
                                    ?>

                                    <a class="button <?php echo $color; ?>" href="<?php echo $url; ?>"><?php echo $text; ?></a>

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

            <?php endwhile; ?>

        <?php endif; ?>
    </div><!-- .section -->

    <div class="container">
        <div class="filters-group search">
            <i class="fas fa-search"></i>
            <input class="textfield filter__search js-shuffle-search" type="search" id="filters-search-input" aria-label="Search" />
        </div>
        <div class="btn-group filter-options">
            <button class="btn btn--primary" data-group="cognitive">Cognitive</button>
            <button class="btn btn--primary" data-group="communicative">Communicative</button>
            <button class="btn btn--primary" data-group="emotional">Emotional</button>
            <button class="btn btn--primary" data-group="musical">Musical</button>
            <button class="btn btn--primary" data-group="psychosocial">Psychosocial</button>
            <button class="btn btn--primary" data-group="sensorimotor">Sensorimotor</button>
            <button class="btn btn--primary" data-group="spiritual">Spiritual</button>
        </div>
    </div>

    <div class="section campfire my-shuffle-container row" id="grid">

        <!-- Card repeater -->
        <?php if( $posts ): ?>

                <?php foreach( $posts as $post ): 
                    
                    setup_postdata( $post );
                    $description = get_field('description');
                    $freebie = get_field('freebie');
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
                    $population_list = get_the_terms( $post->ID, 'population' );
                    $population_terms_string = join(', ', wp_list_pluck($population_list, 'name'));
                    $population_shuffle_string = strtolower('["' . str_replace(', ', '"],["', $population_terms_string) . '"]');

                    // List equipment and format for card and shuffle
                    $equipment_list = get_the_terms( $post->ID, 'equipment' );
                    $equipment_terms_string = join(', ', wp_list_pluck($equipment_list, 'name'));
                    $equipment_shuffle_string = strtolower('["' . str_replace(', ', '"],["', $equipment_terms_string) . '"]');
                    ?>
                    
                    <div class="card-module<?php if( !accessally_has_any_tag_id("104,2207,1879,$tag") && !$freebie ): ?> disabled<?php endif; ?>" <?php if( accessally_has_any_tag_id("$tag") || $freebie ): ?>style="order:-1;"<?php endif; ?> data-groups='<?php echo $equipment_shuffle_string . ',' . $population_shuffle_string . ',["' . $method . '"],["' . $domain . '"]' ?>' data-title="<?php the_title(); ?>">
                        <!-- Thumbnail-->
                        <div class="thumbnail">
                            <?php
                            if ( !empty($domain)) :
                                switch ($domain) :
                                    case "cognitive":
                                        echo '<img src="https://learn.musictherapyed.com/wp-content/uploads/2019/11/Cognitive-Intervention-Cover.png" alt="" />';
                                        break;
                                    case "communicative":
                                        echo '<img src="https://learn.musictherapyed.com/wp-content/uploads/2019/11/Communication-Intervention-Cover.png" alt="" />';
                                        break;
                                    case "emotional":
                                        echo '<img src="https://learn.musictherapyed.com/wp-content/uploads/2019/11/Emotional-Intervention-Cover.png" alt="" />';
                                        break;
                                    case "musical":
                                        echo '<img src="https://learn.musictherapyed.com/wp-content/uploads/2019/11/Musical-Intervention-Cover.png" alt="" />';
                                        break;
                                    case "psychosocial":
                                        echo '<img src="https://learn.musictherapyed.com/wp-content/uploads/2019/11/Pscyhosocial-Intervention-Cover.png" alt="" />';
                                        break;
                                    case "sensorimotor":
                                        echo '<img src="https://learn.musictherapyed.com/wp-content/uploads/2019/11/Sensorimotor-Intervention-Cover.png" alt="" />';
                                        break;
                                    case "spiritual":
                                        echo '<img src="https://learn.musictherapyed.com/wp-content/uploads/2019/11/Spiritual-Intervention-Cover.png" alt="" />';
                                        break;
                                endswitch;
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
                                <?php elseif( accessally_has_any_tag_id("104,2207,1879") ) : ?>
                                    <?php echo do_shortcode( '[accessally_custom_operation operation_id="'. $operation_id .'"]' ); ?>
                                <?php else : ?>
                                    <a class="button" href="">Coming Soon <i class="fas fa-lock"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                    <div class="my-sizer-element"></div>
                    
                <?php endforeach; ?>
            
            <?php wp_reset_postdata(); ?>

        <?php endif; ?>
    </div><!-- .section -->

    <script crossorigin="anonymous" src="https://polyfill.io/v3/polyfill.min.js?flags=gated&features=Set%2CArray.from%2CObject.assign%2CArray.prototype.find%2CArray.prototype.includes"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/Shuffle/5.2.3/shuffle.min.js"></script>

</div> <!-- #main-content -->

<?php

get_footer();