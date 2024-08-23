<header class="header">
   <div class="container header__container">
      <a href="/" class="header__logo">Header Logo</a>

      <a href="/registration-page/" class="header__auth"></a>

      <a href="/cart/" class="header__cart">
         <?php $count_cart = \App\WooCommerce\Cart::getTopCartCount();

         if ($count_cart) : ?>
            <span><?php echo $count_cart; ?></span>
         <?php endif; ?>
      </a>
   </div>
</header>