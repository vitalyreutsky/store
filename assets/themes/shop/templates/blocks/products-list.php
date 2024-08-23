<?php
$term = get_term_by('id', get_queried_object_id(), 'product_cat');
$product_args = array(
   'post_status' => 'publish',
   'limit' => -1,
   'category' => $term->slug,
   //more options according to wc_get_products() docs
);
$products = wc_get_products($product_args);
?>

<div class="products">
   <div class="container">
      <h1 class="products__title">Products</h1>

      <div class="products__list">
         <?php foreach ($products as $product) :
            get_template_part('templates/cards/product-card', null, array('product_id' => $product->get_id()));
         endforeach; ?>
      </div>
   </div>
</div>