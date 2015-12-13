<?php $products = select("product"); ?>
  <!-- sidebar navigation -->
  <nav id="nav">
    <ul class="products-nav">

    <?php foreach ($products as $key => $product):?>
       <li class="products-nav__item">
        <a class="products-nav__link" href="productPage.php?id=<?php echo $product['id'] ?>">
        <?php $images = select("image WHERE product_id =" .$product['id']. " and featured = true") ?>
          <img src="images/<?php echo $images[0]["path"] ?>" alt="">

          <p class="product-title--sidebar"><?php echo $product["productname"] ?></p>
        </a>
      </li>
    <?php endforeach; ?>   
    </ul>    
  </nav>
  <!-- sidebar navigation -->


