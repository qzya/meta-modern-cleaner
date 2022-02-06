<?php
?>
<h1>Meta modern cleaner for WordPress</h1>
<div class="meta-modern-cleaner-container-row">
    <div class="meta-modern-cleaner-container-column post_types">
        <?php 
        $post_types = get_post_types(array(
            'public' => true,
        ));
        ?>

        <?php if ( $post_types ): ?>
        <label for="post_types">Choose a post type(s): </label>
        <select multiple name="post_types" id="post_types" >
            <?php foreach ($post_types as $post_type) : ?>
                <option value='<?php echo $post_type ?>'><?php echo $post_type ?></option>
            <?php endforeach; ?>
        </select>
        <input type="button" value="Get meta fields" id="get_metas">
        <?php endif; ?>

    </div>

    <div class="meta-modern-cleaner-container-column metas">
        <label for="u_metas">Choose metas: </label>
        <select multiple name="u_metas" id="u_metas" >
            <option disabled >Choose a post type(s) first</option>
        </select>
        <input type="button" value="Next -->" id="metas_chosen" style='visibility:hidden'>
    </div>
    <div id="confirmation_area" ></div>
</div>
