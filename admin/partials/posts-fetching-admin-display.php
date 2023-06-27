<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://https://karaliunas.dev
 * @since      1.0.0
 *
 * @package    Posts_Fetching
 * @subpackage Posts_Fetching/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h1><?php echo __('Posts fetching settings'); ?></h1><br>

    <form method="post" action="">
        <label for="api_url"><?php echo __('API url:'); ?></label>
        <input type="text" id="api_url" name="api_url" value="<?php echo esc_attr($api_url) ?>" /><br>

    <form method="post" action="">
        <label for="posts_count"><?php echo __('Posts count:'); ?></label>
        <input type="text" id="posts_count" name="posts_count" value="<?php echo esc_attr($posts_count) ?>" /><br>

        <label for="default_order"><?php echo __('Default order:'); ?></label>
        <input type="text" id="default_order" name="default_order" value="<?php echo esc_attr($default_order) ?>" /><br>

        <br><input type="submit" name="posts_fetching_settings_submit" class="button button-primary" value="<?php echo __('Save Settings'); ?>" />
    </form>

</div>