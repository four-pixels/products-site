<?php include 'commons/head.php'; ?>
<?php include 'heroImage.php' ?>
<?php if (isLoggedIn() === false) : ?>
  <meta http-equiv="refresh" content="0;URL='http://<?php echo $_SERVER['HTTP_HOST'] ?>/login.php'" /> 
  <?php else: ?>
<?php include 'sidebar.php'; ?>
<section class="product">
</section>
<?php endif; ?>
<script>
  $(function() {
     getProduct('productPage.php?id=1');
   }); 


  $(document).on('click','.products-nav__link', function(e){
   
$('.products-nav__item.active').removeClass('active');
$(this).closest('.products-nav__item').addClass('active');

    if($(document).width()>1130)
     e.preventDefault();
    getProduct($(this).attr('href'));
   
  })

  function getProduct(url){
    $.ajax({
      url: url    
    })
    .done(function(data) {
      $('.product').html(data);
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  }
</script>
<?php include 'commons/footer.php'; ?>