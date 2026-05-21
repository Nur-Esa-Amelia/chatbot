<?php
// Load WordPress
define('WP_USE_THEMES', false);
require('wp-load.php');

// Hapus page dengan title "Chatbot"
$posts = get_posts(array(
    'title' => 'Chatbot',
    'post_type' => 'page',
    'posts_per_page' => -1
));

foreach ($posts as $post) {
    wp_delete_post($post->ID, true);
    echo "Post ID " . $post->ID . " dihapus.\n";
}

// Hapus menu item dengan nama "chatbot"
$menu_items = wp_get_nav_menu_items(0);
if ($menu_items) {
    foreach ($menu_items as $item) {
        if (strtolower($item->title) === 'chatbot') {
            wp_delete_post($item->ID, true);
            echo "Menu item '" . $item->title . "' dihapus.\n";
        }
    }
}

echo "Selesai! Page dan menu chatbot telah dihapus.";
?>
