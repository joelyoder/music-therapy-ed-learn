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

// Pull in the population attributes used to style the page
if ( $population_attrs = get_the_terms( $post->ID, 'population' ) ) {

	// Grab the last name & ID and format the ID for ACF
	foreach( $population_attrs as $attr ){
        $population = $attr->name;
		$population_id = $attr->term_id;
		$population_tax_id = 'population_' . $population_id;
	}

	// Pull in the population-specific design elements
	if ( !empty( $population_tax_id ) ) {
		$population_image = get_field( 'image', $population_tax_id );
		$population_color = get_field( 'color', $population_tax_id );
	}
}

// List populations and format for card and shuffle
if ( $domain_terms = get_the_terms( $post->ID, 'domain' ) ) {
    $domain_terms_string = join(', ', wp_list_pluck($domain_terms, 'name'));
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
    <div
    class="intervention-card-image"
    <?php if( $population_color && $type != 'jam-along' ) {
        // Leave the BG color white if Jam Along, otherwise match the set population color
        echo 'style="background-color:' . $population_color . ';"';
    }?>>
        <?php
        // Set the image to the population unless it's a Jam Along
        if ( $population_image && $type != 'jam-along' ) :
            echo wp_get_attachment_image( $population_image, 'medium' );
        // Set the image to Jam Along
        elseif ( $type == 'jam-along' ) :
            $jam_along_image = get_field( 'jam_along_image', 'option' );
            echo wp_get_attachment_image( $jam_along_image, 'medium' );
        // Otherwise just use the default image from the theme settings
        else :
            $default_procamp_image = get_field( 'default_procamp_image', 'option' );
            echo wp_get_attachment_image( $default_procamp_image, 'medium' );
        endif;
        ?>
    </div>

    <!-- Card Content-->
    <div class="intervention-card-info">
        
        <?php if( $population ) : ?>
            <div class="category" <?php echo ( $population_color ) ? 'style="background-color:' . $population_color . ';"' : '' ; ?>><?php echo $population; ?></div>
        <?php endif; ?>

        <h2 class="title"><?php the_title(); ?></h2>

        <?php if ( $description ) : ?><p class="description"><?php echo $description ?></p><?php endif; ?>

        <ul class="intervention-card-taxonomies">
            <?php if ( $domain_terms_string ) : ?>
                <li>Domains:
                    <?php
                    echo $domain_terms_string;
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