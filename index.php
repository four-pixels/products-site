<?php
include 'database/objects/User.php';
include 'database/Database.php';
include 'commons/head.php';
?>

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

<h2>SELECT SPECIFIC USER erick [getUserByPasswordAndUsernameOrEmail($password, $usernameOrEmail)]</h2>


<?php
$userResult = $db->getUserByPasswordAndUsernameOrEmail('erick', 'ehz');
if ($userResult['hasError'] !== '') :
  $error = $userResult['hasError'];
  var_dump($error);
// RENDER THE ERROR
else:
  $user = $userResult['result'][0];
  ?>
  <h2><?php echo $user['id'] . '->' . $user['firstname']; ?></h2>
  <div><?php echo $user['lastname']; ?></div>
  <div><?php echo $user['username']; ?></div>
  <div><?php echo $user['password']; ?></div>
  <div><?php echo $user['email']; ?></div>
<?php
endif;
?>



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
    <h3>Images for <?php echo $result['productname']; ?></h3>
    <?php
    $imagesResult = $db->getProductImages($result['id']);
    if ($imagesResult['hasError'] !== '') :
      var_dump($imagesResult['hasError']); // HANDLE AND RENDER ERROR
    else:
      foreach ($imagesResult['result'] as $imageResult):
        ?>
        <div>
          <?php echo $imageResult['id']; ?>
          <?php echo $imageResult['title']; ?>
          <?php echo $imageResult['path']; ?>
          <?php echo $imageResult['featured']; ?>
          <?php echo $imageResult['product_id']; ?>
        </div>
        <?php
      endforeach;
    endif;
  endforeach;
endif;
?>





<?php include_once 'commons/footer.php'; ?>
