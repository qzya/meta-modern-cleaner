<?php
/**
 * Plugin Name:     Meta modern cleaner
 * Description:     Simple plugin for clean meta data in posts (and CPTs)
 * Author:          qzya
 * Author URI:      https://github.com/qzya
 * Text Domain:     meta-modern-cleaner
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 */

add_action('admin_enqueue_scripts', function() {
    wp_enqueue_script('meta-modern-cleaner', plugins_url('assets/meta-modern-cleaner.js', __FILE__), array('jquery'));
    wp_enqueue_style('meta-modern-cleaner', plugins_url('assets/meta-modern-cleaner.css', __FILE__));
} );

add_action('admin_menu', function() {
    add_menu_page(
        __('Meta modern cleaner', 'meta-modern-cleaner'),
        __('Meta modern cleaner', 'meta-modern-cleaner'), 
        'manage_options', 
        'meta-modern-cleaner', 
        function() {
            include('meta-modern-cleaner-admin-menu-page.php');
        },
        'dashicons-warning',
        1,
    );
});

//ajax action returns HTML with list of meta fields for selected post types
add_action( 'wp_ajax_get_metas', 'get_metas_callback' );
function get_metas_callback() {
    
    $selected_post_types = $_POST['selected_post_types'];

    $all_metas = array();
    $allposts_ids = get_posts( array(
        'numberposts' => -1,
        'post_type'   => $selected_post_types,
        'post_status' => 'any',
        'fields'      => 'ids',
    ));

    foreach ($allposts_ids as $post_id) {
        foreach (get_post_meta($post_id) as $meta_key => $meta_value ) {
            array_push($all_metas, $meta_key );
        }
        
    }
    $unique_metas = array_count_values($all_metas);
    ksort($unique_metas);
    
    echo '<option disabled value="">' . count($unique_metas) . ' metas for post type(s): '. preg_replace( '/(\w+)/', '"$1"',  implode(', ',$selected_post_types) ). '</option>'; 
    foreach ($unique_metas as $unique_meta => $num) {
        echo "<option value='{$unique_meta}'>{$unique_meta} ({$num})</option>";
    }

	wp_die();
}

//ajax action generates HTML of confirmation area
add_action( 'wp_ajax_before_cleaning', 'before_cleaning_callback' );
function before_cleaning_callback() {
    $selected_post_types = $_POST['selected_post_types'];
    if (!empty($_POST['selected_metas'])) : 
        $selected_metas = $_POST['selected_metas'];
        ?>
        <p>You are going to remove the following elements from the <strong><?php echo implode(', ', $selected_post_types); ?></strong> post type(s):</p>
        <ol>
        <?php foreach ($selected_metas as $selected_meta ): ?>
            <li><?php echo  "{$selected_meta} (<a href='https://github.com/search?q={$selected_meta}&type=code' target='_blank'>search on github</a>)" ?></li>
        <?php endforeach; ?>
        </ol>
        <p>After clicking the "YES" button, the items will be <strong>permanently deleted</strong>. Click "NO" to cancel.</p>
        <div class="conf_buttons">
            <input type="button" value="YES" id="yes_confirm">
            <input type="button" value="NO" id="no_return">
        </div>
    <?php else: 
        echo 'Please, select metas'; 
    endif;

    wp_die();
}

//ajax action deletes meta items and generates final output
add_action('wp_ajax_meta_delete_confirmed', 'meta_delete_confirmed_callback');
function meta_delete_confirmed_callback() {

    $selected_post_types = $_POST['selected_post_types'];
    $selected_metas = $_POST['selected_metas'];

    $time_start = microtime(true);

    $query_args = array(
        'posts_per_page' => -1,
        'post_type'      => $selected_post_types,
        'post_status'    => array('publish', 'private' ),
    );
    
    $query = new WP_Query( $query_args );
    
    $i = 0;
    $i_pass = 0;
    $work_output = [];
    foreach ( $query->posts as $post) {
        foreach ($selected_metas as $selected_meta) {
            if ( metadata_exists('post', $post->ID, $selected_meta) ) {
                $i++;
                delete_post_meta( $post->ID, $selected_meta ); //comment this line for "dry run"
                array_push($work_output, "{$i}. DELETED '{$selected_meta}' from {$post->post_type} '{$post->post_title}'");
            } else {
                $i_pass++;
                // array_push($work_output, "SKIPPED '{$selected_meta}' from {$post->post_type} '{$post->post_title}'");
            }
        }
    }

    $time_end = microtime(true);
    $time = $time_end - $time_start;
    
    echo '<p>The operation took <strong>' . round($time, 4) . '</strong> sec.</p>';

    echo "<p><strong>{$i}</strong> meta fields are successfully deleted and <strong>{$i_pass}</strong> skipped.<br> <small> It`s normal that items are skipped, since it`s much faster to go through all the posts with a meta existence check, than to create a meta query and to filter posts by meta fields :) </small> </p>";
    ?>
    <div class="results">
        <a href="#hidden_content" class="show_link">Show all &#129047; </a>
        <div id="hidden_content">
        <ul>
        <?php
        foreach ($work_output as $output_string) {
            echo '<li>' . $output_string . '</li>';
        }

    echo'<a href="#">Hide &#129045;</a></ul></div></div>';
    
    wp_die();
}


