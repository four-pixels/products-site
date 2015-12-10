<?php
include 'commons/head.php';
?>
<div id="home">
  <section>
    <h2>SESSION</h2>
    <?php var_dump($session); ?>
    <h3>is Login?</h3>
    <?php var_dump($session->isLogin()); ?>
    <h3>GET USERNAME AND ID</h3>
    <?php var_dump($session->getUsername()); ?>
    <?php var_dump($session->getUserId()); ?>
  </section>
  <section>
    <h2>SELECT ALL USERS [getUserAll()]</h2>
    <?php
    $db = new FourPixels\Database\Database();
    $result = $db->getUserAll();
    if ($result['hasError'] !== '') :
      $error = $result['hasError'];
      var_dump($error);
// RENDER THE ERROR
    else: foreach ($result['result'] as $result):
        ?>
        <h2><?php echo $result['id'] . '->' . $result['firstname']; ?></h2>
        <div><?php echo $result['lastname']; ?></div>
        <div><?php echo $result['username']; ?></div>
        <div><?php echo $result['password']; ?></div>
        <div><?php echo $result['email']; ?></div>
        <?php
      endforeach;
    endif;
    ?>
  </section>

  <section>
    <h2>SELECT SPECIFIC USER erick [getUserByPasswordAndUsernameOrEmail($password, $usernameOrEmail)]</h2>

    <?php
    $userResult = $db->getUserByPasswordAndUsernameOrEmail('erick', 'ehz');
    if ($userResult['hasError'] !== '') :
      $error = $userResult['hasError'];
      var_dump($error);
// RENDER THE ERROR
    else:
      $user = $userResult['result'];
      ?>
      <h2><?php echo $user['id'] . '->' . $user['firstname']; ?></h2>
      <div><?php echo $user['lastname']; ?></div>
      <div><?php echo $user['username']; ?></div>
      <div><?php echo $user['password']; ?></div>
      <div><?php echo $user['email']; ?></div>
    <?php
    endif;
    ?>
  </section>

  <section>
    <h2>SELECT SPECIFIC USER WITH INVALID PASSWORD [getUserByPasswordAndUsernameOrEmail($password, $usernameOrEmail)]</h2>
    <?php
    $userResult = $db->getUserByPasswordAndUsernameOrEmail('erik', 'ehz');
    if ($userResult['hasError'] !== '') :
      $error = $userResult['hasError'];
      var_dump($error);
// RENDER THE ERROR
    endif;
    ?>
  </section>
  <section>
    <h2>SELECT SPECIFIC USER WITH INVALID USERNAME [getUserByPasswordAndUsernameOrEmail($password, $usernameOrEmail)]</h2>
    <?php
    $userResult = $db->getUserByPasswordAndUsernameOrEmail('erick', 'ez');
    if ($userResult['hasError'] !== '') :
      $error = $userResult['hasError'];
      var_dump($error);
// RENDER THE ERROR
    endif;
    ?>
  </section>



  <section>
    <h2>SELECT ALL PRODUCTS [getProductAll()]</h2>

    <?php
    $result = $db->getProductAll();
    if ($result['hasError'] !== '') :
      $error = $result['hasError'];
      var_dump($error);
// RENDER THE ERROR
    else:
      foreach ($result['result'] as $result):
        ?>
        <h2><?php echo $result['id'] . '->' . $result['productname']; ?></h2>
        <div><?php echo $result['description']; ?></div>
        <div><?php echo $result['price']; ?></div>
        <div><?php echo $result['quantity']; ?></div>
        <section>
          <h3>Images for <?php echo $result['productname']; ?></h3>
          <?php
          $imagesResult = $db->getProductImages($result['id']);
          if ($imagesResult['hasError'] !== '') :
            var_dump($imagesResult['hasError']); // HANDLE AND RENDER ERROR
          else:
            foreach ($imagesResult['result'] as $imageResult):
              ?>
              <div class="thumbnail displa_inline"> 
                <img class="image_responsive"  alt="<?php echo $imageResult['title']; ?>" src="/images/<?php echo $imageResult['path']; ?>" > 
                <div class="caption"> 
                  <h3><?php echo $imageResult['title']; ?></h3> 
                  <p>ID:<?php echo $imageResult['id']; ?></p> 
                  <p>Path: <?php echo $imageResult['path']; ?></p>
                  <p>Featured: <?php echo $imageResult['featured'] ? "True" : "False"; ?></p>
                  <p>Belongs to product_id: <?php echo $imageResult['product_id']; ?></p>
                </div> 
              </div>
              <?php
            endforeach;
          endif;
          ?>
        </section>
        <?php
      endforeach;
    endif;
    ?>
  </section>

  <section>
    <h2>SELECT SINGLE PRODUCT WITH IMAGES TRUE  [getProductById($idProduct, $withImages = false)]</h2>
    <?php
    $result = $db->getProductById(1, true);
    if ($result['hasError'] !== '') :
      $error = $result['hasError'];
      var_dump($error);
// RENDER THE ERROR
    else:
      $product = $result['result'];
      ?>
      <h2><?php echo $product['id'] . '->' . $product['productname']; ?></h2>
      <div><?php echo $product['description']; ?></div>
      <div><?php echo $product['price']; ?></div>
      <div><?php echo $product['quantity']; ?></div>
      <section>
        <h3>Images for <?php echo $product['productname']; ?></h3>
        <?php foreach ($product['images'] as $image) : ?>
          <div>
            <?php echo $image['id']; ?>
            <?php echo $image['title']; ?>
            <?php echo $image['path']; ?>
            <?php echo $image['featured']; ?>
            <?php echo $image['product_id']; ?>
          </div>
        <?php endforeach; ?>
      </section>
    <?php endif;
    ?>
  </section>
  <section>
    <h2>SELECT SINGLE PRODUCT WITH IMAGES FALSE  [getProductById($idProduct, $withImages = false)]</h2>
    <?php
    $result = $db->getProductById(1);
    if ($result['hasError'] !== '') :
      $error = $result['hasError'];
      var_dump($error);
// RENDER THE ERROR
    else:
      $product = $result['result'];
      ?>
      <h2><?php echo $product['id'] . '->' . $product['productname']; ?></h2>
      <div><?php echo $product['description']; ?></div>
      <div><?php echo $product['price']; ?></div>
      <div><?php echo $product['quantity']; ?></div>
      <section>
        <h3>Images for <?php echo $product['productname']; ?></h3>
        <?php if (isset($product['images'])) : ?>
          <?php foreach ($product['images'] as $image) : ?>
            <div>
              <?php echo $image['id']; ?>
              <?php echo $image['title']; ?>
              <?php echo $image['path']; ?>
              <?php echo $image['featured']; ?>
              <?php echo $image['product_id']; ?>
            </div>
          <?php endforeach; ?>
          <?php endif;
        ?>
      </section>
    <?php endif;
    ?>
  </section>
  <section>
    <h2>SELECT SINGLE PRODUCT INVALID ID [getProductById($idProduct, $withImages = false)]</h2>
    <?php
    $result = $db->getProductById(100);
    if ($result['hasError'] !== '') :
      $error = $result['hasError'];
      var_dump($error);
// RENDER THE ERROR
    else:
      $product = $result['result'];
      ?>
      <h2><?php echo $product['id'] . '->' . $product['productname']; ?></h2>
      <div><?php echo $product['description']; ?></div>
      <div><?php echo $product['price']; ?></div>
      <div><?php echo $product['quantity']; ?></div>
      <section>
        <h3>Images for <?php echo $product['productname']; ?></h3>
        <?php foreach ($product['images'] as $image) : ?>
          <div>
            <?php echo $image['id']; ?>
            <?php echo $image['title']; ?>
            <?php echo $image['path']; ?>
            <?php echo $image['featured']; ?>
            <?php echo $image['product_id']; ?>
          </div>
        <?php endforeach; ?>
      </section>
    <?php endif;
    ?>
  </section>

</div>

<?php include_once 'commons/footer.php'; ?>
