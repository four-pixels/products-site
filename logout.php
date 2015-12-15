<?php

//SESSION HAS TO BE DESTROYYED BEFORE RENDERING THE HEADER
// require_once 'session/SessionManager.php';
require_once 'configFolder/sessions.php';

destroySession();


include 'commons/head.php';
?>


<?php include 'commons/footer.php'; ?>