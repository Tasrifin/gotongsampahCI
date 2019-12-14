<script>
    $('.btn_Donasi').addClass('d-none');
    var pagesType = 'settings';
</script>


<main>

    <!-- Profil -->

    <section id="editprofile" class="section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="side-title">
                        <h6 class="theme-color">Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun</h6>
                        <h2><u>Pengaturan Akun</u></h2>
                        <form id='updateSettings'>
                            <div class="form-group row">
                                <label for="inputUsername" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="username" name="username" readonly="readonly">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Nama User</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputAlamat" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea name="Alamat" id="Alamat" rows="0" class="form-control" placeholder="Alamat Lengkap" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputTanggalLahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="tanggallahir" name="tanggallahir" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputHandphone" class="col-sm-2 col-form-label">Handphone</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="handphone" name="handphone" placeholder="Phone Number" required>
                                </div>
                            </div>
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Jenis Kelamin</legend>
                                <div class="form-check">
                                    <select name="jenisKelamin" id="jenisKelamin">
                                        <option value="0" selected disabled>Jenis kelamin</option>
                                        <option value="Laki-Laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Password Lama</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password Lama"  required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Password Baru</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="inputnewPassword" name="inputnewPassword" placeholder="Password Baru"    required>
                                    <span id="span2">**Jika password tetap, isi dengan password yang saat ini digunakan <br></span>
                                    <span id="span1" style="color : red; visibility: hidden;"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <input type="submit" class="form-control" id="submit_updateSettings" name="submit_updateSettings" value="SIMPAN">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="side-title ">
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</main>
<script type="text/javascript" src="<?php echo base_url() ?>static/js/ajax.js"></script>