<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */

if ( is_shop() ) {
    $sections = get_field('page_content', wc_get_page_id('shop'));
    if ($sections) {
        foreach ($sections as $key => $section) {
            switch ($section['acf_fc_layout']) {
                case 'hero':
                    get_template_part('views/hero_catalog', null, $section);
                    break;
                case 'categories_list':
                    get_template_part('views/categories_list', null, $section);
                    break;
                case 'image_text_variable':
                    get_template_part('views/image-text-variable', null, $section);
                    break;
            }
        }
    }
}
else {
    if (is_product_category()) {
        $term = get_term_by( 'id', get_queried_object_id(), 'product_cat' );
        $sections = get_field('content_taxes_page', $term);
        if ($sections) {
            foreach ($sections as $key => $section) {
                switch ($section['acf_fc_layout']) {
                    case 'hero':
                        get_template_part('views/hero_tax', null, $section);
                        break;
                    case 'hero_onmed':
                        get_template_part('views/hero_onmed', null, $section);
                        break;
                    case 'product_list':
                        get_template_part('views/product_list', null, $section);
                        break;
                    case 'image_text_variable':
                        get_template_part('views/image-text-variable', null, $section);
                        break;
                    case 'image_text_variable_with_leaf':
                        get_template_part('views/image-text-variable-leaf', null, $section);
                        break;
                    case 'aida_text_image_block':
                        get_template_part('views/aida_text_image_block', null, $section);
                        break;
                }
            }
        }
    }
}

get_footer( 'shop' );
