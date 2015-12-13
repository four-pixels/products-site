<?php include 'commons/head.php'; ?>
<?php include 'sidebar.php'; ?>
<section class="product">
</section>
<script>
  $(function() {
     getProduct('productPage.php?id=1');
   }); 


  $(document).on('click','.products-nav__link', function(e){
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