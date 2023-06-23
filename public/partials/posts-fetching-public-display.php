<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://https://karaliunas.dev
 * @since      1.0.0
 *
 * @package    Posts_Fetching
 * @subpackage Posts_Fetching/public/partials
 */
?>

<ul class="grid gap-4">
    <?php foreach ($posts as $post): ?>
        <li class="border border-black p-4 rounded">
            <h3 class="text-lg font-bold normal-case "><?php echo esc_html($post['id']); ?> - <?php echo esc_html($post['title']); ?></h3>
            <p class="mt-2 normal-case "><?php echo esc_html($post['body']); ?></p>
        </li>
    <?php endforeach; ?>
</ul>