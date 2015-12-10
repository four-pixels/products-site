<?php

function notFound() {
  header('HTTP/1.0 404 Not Found');
  echo "<head><title>404 Not Found</title></head>";
  echo "<h1>Not Found</h1>";
  $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
  echo "<p>The requested URL " . $uri . " was not found on this server.</p>";
  exit();
}

require_once 'database/Database.php';
require_once 'session/SessionManager.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  $db = new FourPixels\Database\Database();
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $productResult = $db->getProductById($id, true);
    if ($productResult['hasError'] === '') {
      $product = $productResult['result'];
      ?>




      <h2><?php echo $product['id'] . '->' . $product['productname']; ?></h2>
      <div><?php echo $product['description']; ?></div>
      <div><?php echo $product['price']; ?></div>
      <div><?php echo $product['quantity']; ?></div>
      <section>
        <h3>Images for <?php echo $product['productname']; ?></h3>
        <?php
        foreach ($product['images'] as $image):
          ?>
          <div class="thumbnail displa_inline"> 
            <img class="image_responsive"  alt="<?php echo $image['title']; ?>" src="/images/<?php echo $image['path']; ?>" > 
            <div class="caption"> 
              <h3><?php echo $image['title']; ?></h3> 
              <p>ID:<?php echo $image['id']; ?></p> 
              <p>Path: <?php echo $image['path']; ?></p>
              <p>Featured: <?php echo $image['featured'] ? "True" : "False"; ?></p>
              <p>Belongs to product_id: <?php echo $image['product_id']; ?></p>
            </div> 
          </div>
          <?php
        endforeach;
        ?>







        <?php
      } else {
        notFound();
      }
    } else {
      notFound();
    }
  } else {
    notFound();
  }
  ?>