<?php
  require_once('./php/Auth.php');
  $Auth->CekSession();
?>
<!doctype html>
<html lang="en">
<?php include_once('./views/partisi/head.php'); ?>
<link rel="stylesheet" href="../../public/assets/css/log-in.css">
<body class="text-center">
  <div class="card">
    <div class="card-body">
      <form action="../../php/Auth.php?login" method="POST">
          <img class="mb-3" src="http://m.ayosurabaya.com/images-surabaya/post/articles/2020/09/25/3178/logo-dikbud.png" alt="" width="72" height="67">
          <h1 class="h3 mb-3 fw-normal">Silahkan Login</h1>
        
          <div class="input-group mb-3">
            <input type="text" class="form-control" required name="username" placeholder="Username">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
          </div>

          <div class="input-group mb-3">
            <input type="password" class="form-control" required name="password" placeholder="Password">
            <span class="input-group-text"><i class="fas fa-key"></i></span>
          </div>

          <div class="form-group mb-3">
            <div class="input-group flex-nowrap">
              <input type="text" class="form-control" readonly name="number_1" value="<?php echo rand(1, 9); ?>" style="background-color: whitesmoke; text-align:center;">
              <span class="input-group-text" id="addon-wrapping">+</span>
              <input type="text" class="form-control" readonly name="number_2"value="<?php echo rand(1, 9); ?>" style="background-color: whitesmoke; text-align:center;">
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="number" class="form-control" required name="captcha" placeholder="Masukkan Hasil Diatas">
            <span class="input-group-text"><i class="fas fa-robot"></i></span>
          </div>

          <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
      </form>
    </div>
  </div>
<?php if(isset($_GET['error'])): ?>
<script>swal('Username Atau Password Salah');</script>
<?php endif; ?>

<?php if(isset($_GET['captcha'])): ?>
<script>swal('Captcha Salah');</script>
<?php endif; ?>
</body>
</html>
