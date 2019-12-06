<body class="bg-light">
    <div class="container bg-white mx-auto mt-5 shadow" style="border-radius: 25px;">
        <div class="row" style="height: 550px;">
            <div class="col-sm-4 p-5 text-left theme-main" style="height:100%; border-radius: 25px 0px 0px 25px">
                <h3 class="leads text-white">Masuk ke GotongSampah.ID</h3>
                <div class="display-4 text-white font-weight-light small">GotongSampah.ID adalah platform peduli lingkungan yang menghubungkan mereka yang memiliki sampah non-organik dengan
                mitra GotongSampah.ID</div>
                <h4 class="mt-5 lead text-white">Belum punya akun? <a href="signup" class="text-warning">Daftar</a></h4>
                <img src="../static/img/home-banner-main.svg" class="mx-auto" style="width: 300px; height: auto;">
            </div>
            <div class="col-sm-8 p-3">
                <form id="login_form">
                    <div class="form-group">
                        <label for="type_login">Login Sebagai</label>
                        <select name="type_login" id="type_login" class="custom-select" required>
                            <option value="mitra">MITRA</option>
                            <option value="user">Pengguna</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="username">Username* </label>
                        <input class="form-control" type="text" id="username" placeholder="Masukan Username" name="username"  required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password* </label>
                        <input class="form-control" type="password" id="password" placeholder="Masukan Password" name="password"  required>
                    </div>
                    <p class="small">Dengan login, Anda setuju dengan <a href="#">syarat, ketentuan dan kebijakan
                            privasi dari Lumpang</a></p>
                    <div class="text-center">
                        <button type="button" class="btn btn-light" style="border-radius:25px;" onclick="location.href='<?php echo base_url(); ?>'">Batal</button>
                        <button type="button" class="btn btn-theme-2nd " style="border-radius:25px;" value="submit_login" id="Login_Submit" name="submit">Masuk</button>
                    </div>
                    </form>
                    <div class="form-inline mt-5">
                        <label class="mr-3 col-sm-12">Atau Daftar Dengan : </label>
                        <button type="button" class="btn btn-light mt-sm-3 col-sm-6" style="border-radius:25px;font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"><i
                                class="fab fa-facebook-f pr-2 text-center" style="font-size:20px;color: #5770A6;"> </i>
                            Facebook</button>
                        <button type="button" class="btn btn-light mt-sm-3 col-sm-6" style="border-radius:25px;font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"><i
                                class="fab fa-google pr-2 text-center" style="font-size:20px;color: #E06555;"> </i> Google</button>
                </div>
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

</script>




