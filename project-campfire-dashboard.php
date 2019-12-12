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
        $('.post-module').hover(function() {
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
        <?php if( $posts ): ?>

                <?php foreach( $posts as $post ): 
                    
                    setup_postdata( $post );
                    $description = get_field( 'description' );

                    $domain_attrs = get_the_terms( $post->ID, 'domain' );
                    if (!empty($domain_attrs)){
                        foreach($domain_attrs as $attr){
                        $domain = $attr->slug;
                        }
                    }
                    ?>

                    <div class="post-module">

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

                        <!-- Post Content-->
                        <div class="post-content">

                            <div class="category <?php echo $domain; ?>">
                                <?php echo $domain; ?>
                            </div>

                            <h1 class="title"><?php the_title(); ?></h1>

                            <p class="description"><?php echo $description ?></p>

                            <ul class="card-meta">
                                <li>For
                                    <?php
                                    $population_list = get_the_terms( $post->ID, 'population' );
                                    $population_terms_string = join(', ', wp_list_pluck($population_list, 'name'));
                                    echo $population_terms_string;
                                    ?>
                                </li>
                                <li>Requires
                                    <?php
                                    $equipment_list = get_the_terms( $post->ID, 'equipment' );
                                    $equipment_terms_string = join(', ', wp_list_pluck($equipment_list, 'name'));
                                    echo $equipment_terms_string;
                                    ?>
                                </li>
                            </ul>
                            <div class="post-meta"><a class="button" href="<?php the_permalink(); ?>">Access<i class="fas fa-fire-alt"></i></a></div>
                        </div>

                    </div>
                    
                <?php endforeach; ?>
            
            <?php wp_reset_postdata(); ?>

        <?php endif; ?>
    </div><!-- .section -->
</div> <!-- #main-content -->

<?php

get_footer();