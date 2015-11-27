<?php
include 'database/Database.php';

include_once 'commons/head.php';
?>
<h1>This is the Bike website</h1>
<?php
$db = new database\Database();
$results = $db->select('select * from user');
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

<?php include_once 'commons/footer.php'; ?>
