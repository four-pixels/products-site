<?php require_once 'configFolder/databaseFunctions/databaseConnect.php'; ?>
<?php require_once 'configFolder/sessions.php'; ?>

<?php
$isAjax = true;
/* AJAX check  */
if (!(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
  /* special ajax here */

  include 'commons/head.php';
  echo '<section class="product on-seen">';
}
?>

<?php if (isLoggedIn() === false) : ?>
  <meta http-equiv="refresh" content="0;URL='http://<?php echo $_SERVER['HTTP_HOST'] ?>/login.php'" /> 
<?php endif; ?>

<?php $product = select("product where id =" . $_GET['id']) ?>

<div class="product__info">
  <div class="product__thumbnails__container">
    <ul>
      <?php $images = select("image WHERE product_id =" . $product[0]['id'] . " and featured = false limit 3") ?>
      <?php foreach ($images as $key => $image): ?>
        <li class="thumbnail__image thumbnail__image-1" style="background-image:url('images/<?php echo $image['path'] ?>')" data-image="images/<?php echo $image['path']; ?>"></li>
      <?php endforeach; ?> 
    </ul>
  </div>
  <div class="product__description">
    <div class="product__text">
      <?php echo $product[0]["description"]; ?>
    </div>
    <div class="product__price">Starting at <span><?php echo $product[0]["price"] ?></span></div>
    <div class="product__price">Quantity <span><?php echo $product[0]["quantity"] ?></span></div>
  </div>
</div>
<div class="product__img-container">
  <h1 id="product__title"><?php echo $product[0]["productname"] ?></h1>
  <?php $image = select("image WHERE product_id =" . $product[0]['id'] . " and featured = true") ?>
  <img id="product__image" src="images/<?php echo $image[0]['path'] ?>" alt="">
</div>

<?php
/* AJAX check  */
if (!(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')):
  ?>


  </section>

  <script type="text/javascript">
    $(function () {
      $('.thumbnail__image').on('mouseout', function () {
        $('#product__image').removeClass('fadeTheBike');
        $('.product').css('background', 'linear-gradient(rgba(51,51,51, 0.9), rgba(51,51,51, 0.5)), url("images/productPage_bg.jpg")');
        $('.product').css('backgroundSize', 'cover');
      });

      $('.thumbnail__image').on('mouseover', function () {
        var imgPath = $(this).attr('data-image');

        $('.product').css('background', 'linear-gradient(rgba(51,51,51, 0.9), rgba(51,51,51, 0.5)), url("' + imgPath + '")');
        $('.product').css('backgroundPosition', 'center');
        $('.product').css('backgroundSize', 'cover');
        $('.product').css('backgroundRepeat', 'no-repeat');
        $('#product__image').addClass('fadeTheBike');
      });
    });

  </script>

  <?php
  include 'commons/footer.php';
endif;
?>

