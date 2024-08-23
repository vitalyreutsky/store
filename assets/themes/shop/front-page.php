<?php if (!defined('ABSPATH')) exit('No direct script access allowed');
/**
 * The front page template.
 * Template Name: Front Page template
 */

get_header();
?>
<main class="main">
   <?php
   get_template_part('templates/blocks/products-list');
   ?>
</main>
<?php
get_footer(); ?>