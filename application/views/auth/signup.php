<body class="bg-light" ng-app="myApp">
    <div class="container bg-white mx-auto mt-5 shadow" style="height:80%; border-radius: 25px;">
        <div class="row" >
            <div class="col-sm-4 p-5 text-left theme-main" style="height:100%; border-radius: 25px 0px 0px 25px">
                <h3 class="leads text-white">Sangat Mudah Untuk Mendaftar!</h3>
                <div class="display-4 text-white font-weight-light small">Dengan mendaftar kamu akan berkontribusi
                    untuk mengurangi permasalahan sampah di Indonesia</div>
                <h4 class="mt-5 lead text-white">Sudah punya akun? <a href="login" class="text-warning">Masuk</a></h4>
                <img src="../static/img/home-banner-main.svg" class="mx-auto" style="width: 300px; height: auto;">
            </div>
            <div class="col-sm-8 p-3">
                <form id="signup_form">
                    <div class="form-group">
                                        </div>
                    <div class="form-group">
                        <label for="username">Username* </label> <span style="color:red"><?= form_error('username')?></span>
                        <input class="form-control" type="text" id="username" name="username" placeholder="Masukan Username" required="">
                    </div>
                    <div class="form-group">
                        <label for="email">Email* </label> <span style="color:red"><?= form_error('email')?></span>
                        <input class="form-control" type="email" id="email" name="email" placeholder="Masukan Email" required="">
                    </div>
                    <div class="form-group">
                        <label for="password">Password* </label>
                        <input class="form-control" type="password" id="password" name="password" placeholder="Masukan Password" required>                    
                    </div>
                    <div class="form-group">
                        <label for="password">Retype Password* </label> <span style="color:red"><?= form_error('repassword')?></span>
                        <input class="form-control" type="password" id="repassword" name="repassword"  placeholder="Masukan Ulang Password" required>
                    </div>
                    <span id="span1" style="color : red; visibility: hidden;"></span>
                    <div class="form-group">
                        <label for="type_signup">Daftar Sebagai</label>
                        <select name="type_signup" id="type_signup" class="custom-select" name="type_signup" required>
                            <option value="mitra">MITRA</option>
                            <option value="user">Pengguna</option>
                        </select>
                    </div>
                    <p class="small">Dengan mendaftar, Anda setuju dengan <a href="#">syarat, ketentuan dan kebijakan privasi dari GOTONG SAMPAH</a></p>
                    <div class="text-center">
                    <button type="button" class="btn btn-light" style="border-radius:25px;" onclick="location.href='<?php echo base_url(); ?>'">Batal</button>
                    <button type="button" id="SignUp_Submit" name="submit" class="btn btn-theme-2nd" name="submit" value="submit_signup" style="border-radius:25px;">Daftar</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</body>
</html>

<script>

$("input#username").on({
  keydown: function(e) {
    if (e.which === 32)
      return false;
  },
  change: function() {
    this.value = this.value.replace(/\s/g, "");
  }
});

$("input#password").on({
  keydown: function(e) {
    if (e.which === 32)
      return false;
  },
  change: function() {
    this.value = this.value.replace(/\s/g, "");
  }
});

$("input#repassword").on({
  keydown: function(e) {
    if (e.which === 32)
      return false;
  },
  change: function() {
    this.value = this.value.replace(/\s/g, "");
  }
});

</script>