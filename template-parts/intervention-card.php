<?php
/**
 * Intervention card template
 * 
 * @since 3.0.0
 * @package music-therapy-ed-learn
 */

// Get the ACF fields
$freebie = get_field('freebie');
$type = get_field('type');
$unlocks = get_field('unlocks');
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

<div class="intervention-card<?php
// Set card styling to disabled if you do not possess VIP, ProCamp subscriber tags
// or the tag for an individual intervention and ensure freebies are not disabled
if( !accessally_has_any_tag_id("104,2207,1879,2529,$tag") && !$freebie ):
    ?> disabled<?php
endif;
?>">
    <!-- Thumbnail-->
    <div class="intervention-card-image">
        <?php
        // Set the image to the domain unless it's a Jam Along
        // @todo: fix the manually set URLs to an ACF settings page
        if ( !empty($domain) && $type != 'jam-along' ) :
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
        elseif ( !empty($domain) && $type == 'jam-along' ) :
            echo '<img src="/wp-content/uploads/2020/11/Jam-Along-Intervention-Cover.jpg" alt="" />';
        endif; ?>
    </div>

    <!-- Card Content-->
    <div class="intervention-card-info">
        
        <div class="category <?php echo $domain; ?>">
            <?php echo $domain; ?>
        </div>

        <h2 class="title"><?php the_title(); ?></h2>

        <?php if ( $description ) : ?>
            <p class="description"><?php echo $description ?></p>
        <?php endif; ?>

        <ul class="intervention-card-taxonomies">
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
    </div>

    <div class="intervention-card-meta">
        <div class="unlocks">
            <?php if( $freebie ) : ?>
                <?php //Crickets ?>
            <?php elseif( $unlocks && $unlocks == 1 ) : //If it's worth 1 unlock, make sure it's singular ?>
                <p><span class="count"><i class="fas fa-key"></i> <?php echo $unlocks; ?></span> <span class="sr-only">unlock</span></p>
            <?php elseif( $unlocks && $unlocks != 1 ) : //Otherwise, use a plural ?>
                <p><span class="count"><i class="fas fa-key"></i><?php echo $unlocks; ?></span> <span class="sr-only">unlock</span></p>
            <?php else : //Set the default for no value to 1 for backwards compatibility ?>
                <p><span class="count"><i class="fas fa-key"></i> 1</span> <span class="sr-only">unlock</span></p>
            <?php endif; //@todo replace this whole mess with a sprintf ?>
        </div>
        <div class="buttons">
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