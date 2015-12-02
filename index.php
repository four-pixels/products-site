<?php
include 'database/Database.php';
include_once 'commons/head.php';
?>

<h2>SELECT ALL USERS</h2>
<code>select * from user;</code>
<?php
$db = new database\Database();
$results = $db->executeSQL('select * from user');
?>
<?php if ($results === false) : ?>
  <?php
  $error = $db->error();
  var_dump($error);
// RENDER THE ERROR 
  ?>
<?php else: ?>
  <?php foreach ($results as $result): ?>
    <h2><?php echo $result['firstname']; ?></h2>
    <div><?php echo $result['lastname']; ?></div>
    <div><?php echo $result['username']; ?></div>
    <div><?php echo $result['password']; ?></div>
    <div><?php echo $result['email']; ?></div>
  <?php endforeach; ?>
<?php endif; ?>


<h2>SELECT ALL PRODUCTS</h2>
<code>select * from products;</code>

<?php
$results = $db->executeSQL('select * from product');
?>
<?php if ($results === false) : ?>
  <?php
  $error = $db->error();
  var_dump($error);
// RENDER THE ERROR 
  ?>
<?php else: ?>
  <?php foreach ($results as $result): ?>
    <h2><?php echo $result['productname']; ?></h2>
    <div><?php echo $result['description']; ?></div>
    <div><?php echo $result['price']; ?></div>
    <div><?php echo $result['quatity']; ?></div>
  <?php endforeach; ?>
<?php endif; ?>






<?php include_once 'commons/footer.php'; ?>
