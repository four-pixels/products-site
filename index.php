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
  $(function () {
    getProduct('productPage.php?id=1');
  });


  $(document).on('click', '.products-nav__link', function (e) {

    $('.products-nav__item.active').removeClass('active');
    $(this).closest('.products-nav__item').addClass('active');

    if ($(document).width() > 1130)
      e.preventDefault();
    getProduct($(this).attr('href'));

  })

  function getProduct(url) {
    $.ajax({
      url: url
    })
            .done(function (data) {
              $('.product').html(data);
              document.title = 'Bikes | ' + $('#product__title').html();
            })
            .fail(function () {
              console.log("error");
            })
            .always(function () {
              console.log("complete");
            });
  }
  $(function () {
    $(document).on('mouseout', '.thumbnail__image', function () {
      $('#product__image').removeClass('fadeTheBike');
      $('.product').css('background', 'linear-gradient(rgba(51,51,51, 0.9), rgba(51,51,51, 0.5)), url("images/productPage_bg.jpg")');
      $('.product').css('backgroundSize', 'cover');
    });

    $(document).on('mouseover', '.thumbnail__image', function () {
      var imgPath = $(this).attr('data-image');

      $('.product').css('background', 'linear-gradient(rgba(51,51,51, 0.9), rgba(51,51,51, 0.5)), url("' + imgPath + '")');
      $('.product').css('backgroundPosition', 'center');
      $('.product').css('backgroundSize', 'cover');
      $('.product').css('backgroundRepeat', 'no-repeat');
      $('#product__image').addClass('fadeTheBike');
    });
  });

</script>
<?php include 'commons/footer.php'; ?>