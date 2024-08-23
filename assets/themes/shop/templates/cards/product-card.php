<?php
$product_id = $args['product_id'];
$product = wc_get_product($product_id);
?>

<div class="product-card">
  <div class="product-card__image" style="background-image: url('<?php echo get_the_post_thumbnail_url($product_id, 'full'); ?>')"></div>

  <div class="product-card__inner">
    <h2 class="product-card__name"><?php echo $product->name; ?></h2>
    <p class="product-card__desc"><?php echo $product->description; ?></p>


    <div class="product-card__btns">
      <?php if (WC()->cart->find_product_in_cart(WC()->cart->generate_cart_id($product->get_id()))) { ?>
        <button
          data-quantity="1"
          class="product-card__btn in-cart btn btn-reset"
          data-product_id="<?php echo $product->get_id(); ?>"
          data-product_sku=""
          aria-label="“<?php echo get_the_title(); ?>” in your cart">
          Add to Cart
        </button>

        <button data-quantity="1"
          class="product-card__btn remove-from-cart show btn btn-reset"
          data-product_id="<?php echo $product->get_id(); ?>"
          aria-label="Add “<?php echo get_the_title(); ?>” to your cart">
          Remove from Cart
        </button>
      <?php
      } else { ?>
        <button data-quantity="1"
          class="product-card__btn add-to-cart btn btn-reset"
          data-product_id="<?php echo $product->get_id(); ?>"
          aria-label="Add “<?php echo get_the_title(); ?>” to your cart">
          Add to Cart
        </button>
      <?php
      } ?>

      <button data-quantity="1"
        class="product-card__btn remove-from-cart btn btn-reset"
        data-product_id="<?php echo $product->get_id(); ?>"
        aria-label="Add “<?php echo get_the_title(); ?>” to your cart"
        data-url_cart="/cart/">
        Remove from Cart
      </button>
    </div>
  </div>
</div>