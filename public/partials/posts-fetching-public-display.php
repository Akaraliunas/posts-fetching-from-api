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
        <li class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <h3 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?php echo esc_html($post['title']); ?></h3>
            <p class="font-normal text-gray-700 dark:text-gray-400"><?php echo esc_html($post['body']); ?></p>
        </li>
    <?php endforeach; ?>
</ul>