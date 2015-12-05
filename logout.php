<?php

//SESSION HAS TO BE DESTROYYED BEFORE RENDERING THE HEADER
require_once 'session/SessionManager.php';
$session = new FourPixels\Session\SessionManager();
$session->destroy();


include 'commons/head.php';
?>


<?php include 'commons/footer.php'; ?>