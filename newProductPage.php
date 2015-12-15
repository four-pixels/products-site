<?php require_once 'configFolder/databaseFunctions/databaseConnect.php'; ?>
<?php require_once 'configFolder/sessions.php'; ?>
<?php include 'commons/head.php'; ?>
<?php if (isLoggedIn() === false) : ?>
  <meta http-equiv="refresh" content="0;URL='http://<?php echo $_SERVER['HTTP_HOST'] ?>/login.php'" /> 
<?php endif; ?>


  

  <section id="singleProduct">
    <?php $product = select("product where id =".$_GET['id'])  ?>
        <?php $images = select("image WHERE product_id =" .$product[0]['id']. " and featured = false limit 3") ?>
        <ul>
        <?php foreach ($images as $key => $image):?>
          <li class="thumbnail__image thumbnail__image-1" style="background-image:url('images/<?php echo $image['path'] ?>')"></li>
        <?php endforeach; ?> 
        </ul>
        <?php echo $product[0]["description"]; ?>
    <?php echo $product[0]["price"] ?>
 <?php echo $product[0]["productname"] ?>
    <?php $image = select("image WHERE product_id =" .$product[0]['id']. " and featured = true") ?>
    <img id="product__image" src="images/<?php echo $image[0]['path'] ?>" alt="">


  </section>

 <?php include 'commons/footer.php'; ?>
