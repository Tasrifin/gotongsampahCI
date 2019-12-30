<script>
    var baseURL = "<?= base_url() ?>";
    var type = '<?php echo $type ?>';
    var my_id = '<?php echo $session_data[0]["id_" . $type] ?>';
    var pagesType = 'history';
</script>
<script type="text/javascript" src="<?php echo base_url() ?>static/js/gotongsampah.js"></script>
<main>
    <!-- Selamat Datang -->
    <section class="section" id="about">
        <div class="container">
            <div class="row justify-content-center">
                <div class="section-title text-center">
                    <h6 class="theme-color">SELAMAT DATANG  <?php echo (($session_data[0]['nama'] == null) ? $session_data[0]['username'] : $session_data[0]['nama']) ?>!</h6>
                    <h2 class="theme-after">Riwayat <?php echo ($type == "user") ? "Berdonasi" : "Bermitra" ?> Kamu</h2>
                </div>
            </div>
        </div>
    </section>
    <!-- Donasi -->
    <section class="section">
        <div class="row justify-content-center">
            <div id="donasiState" class="section-title text-center">
                
            </div>
        </div>
        <div class="container">
            <!-- Modal -->
            <div id="detail_modal" class="modal fade detail_modal" tabindex="-1" role="dialog">';
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Detail Donasi : #</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div style="display: flex; justify-content: center;">
                                    <img class="gambar_donasi" src="" style="height:95%;">
                                </div>
                                <div>
                                    <center>
                                        <h4 class="card-title" style="margin-left:3%;"></h4>
                                    </center>
                                    <div class="card-body">
                                        <p class="card-text jenis_donasi" style="text-align:justify">Jenis : </p>
                                        <p class="card-text jumlah_donasi" style="text-align:justify">Jumlah : </p>
                                        <p class="card-text informasi_donasi" style="text-align:justify">Informasi : </p>
                                        <p class="card-text donatur_donasi" style="text-align:justify">Donatur : </p>
                                        <p class="card-text kontak_donasi" style="text-align:justify">Kontak : </p>
                                        <p class="card-text alamat_donasi" style="text-align:justify">Alamat : </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="main_modal_footer" class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Konfirmasi -->
            <div class="modal fade" id="konfirmasi_" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="konfirmasi">Konfirmasi Pengambilan Donasi #</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <label class="col-form-label">Masukkan username saja, nomor handphone akan auto generate</label>
                                <br>
                                <span style="color:red" class="col-form-label mitra-unknown" hidden>Data username tidak ditemukan!</span>
                                <div class="form-group">
                                    <label for="username" class="col-form-label">Username Mitra Penerima</label>
                                    <input placeholder="Username Mitra Penerima" type="text" id="username_mitra" name="username_mitra" class="form-control username_mitra" placeholder="Username Mitra Penerima" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="col-form-label">Nomor Handphone Mitra Penerima</label>
                                    <input type="number" id="hp_mitra" name="hp_mitra" class="form-control hp_mitra" placeholder="Nomor Handphone Mitra Penerima" required readonly>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-success konfirmasi_submit" onclick="">Konfirmasi</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Hapus -->
            <div class="modal fade" id="delete_" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="hapus">Hapus Donasi #</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="del-word">here text</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">BATAL</button>
                            <button type="button" id="delData" class="btn btn-danger" onclick="">HAPUS</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal Edit -->
            <div class="modal fade" id="edit_" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="edit">Edit Data Donasi #</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="edit_form" enctype="multipart/form-data">
                                <div hidden>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" placeholder="id donasi" id="id_donasi" name="id_donasi" value="" required hidden>
                                        <input type="number" class="form-control" placeholder="id donasi" id="id_user" name="id_user" value="" required hidden>
                                        <input type="text" class="form-control" placeholder="id donasi" id="gbr" name="gbr" value="" required hidden>
                                    </div>
                                </div>
                                <div>
                                    <label id="" for="judul_donasi">Judul Donasi</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Judul donasi" id="judul_donasi" name="judul_donasi" value="" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="jenis_sampah">Jenis Sampah</label>
                                    <select name="jenis_donasi" id="jenis_donasi" class="custom-select" required>
                                        <option value="" selected disabled>Pilih</option>
                                        <option value="Plastik">Plastik</option>
                                        <option value="Kertas">Kertas</option>
                                        <option value="Botol">Botol</option>
                                        <option value="Kaca">Kaca</option>
                                        <option value="Besi">Besi</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="berat_sampah">Total Berat Sampah</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" placeholder="Berat Sampah" id="jumlah_donasi" name="jumlah_donasi" value="" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Kg.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi_donasi" id="deskripsi_donasi" class="form-control" rows="2" placeholder="Tuliskan deskripsi seperti : Kondisi sampah & informasi lainya " required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="update_foto">Update Foto Sampah?</label>
                                    <select name="update_foto" id="update_foto" class="custom-select" required>
                                        <option value="N">Tidak, tetap gunakan file lama.</option>
                                        <option value="Y">Iya, perbaharui foto</option>
                                    </select>
                                </div>
                                <div id="no_update" class=" form-group" style="margin-top:-20px; margin-bottom:-40px">

                                </div>
                                <div id="pilih_gambar" class="form-group d-none">
                                    <label for="up_foto" class="text-black">Upload Foto Sampahmu :</label>
                                    <div class="custom-file">
                                        <input type="file" name="input_foto" class="custom-file-input" id="input_foto" onchange="ShowImage(this,'imgUpdate')">
                                        <label class="custom-file-label" for="customFile">Pilih file</label>
                                    </div>
                                    <div id="imgUpdate"></div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="edit_batal">BATAL</button>
                            <button type="button" class="btn btn-success" id="edit_submit">SIMPAN</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal add -->
            <div class="modal fade" id="add_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add">Tambah Donasi Baru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <form id="add_form" enctype="multipart/form-data">
                                <div>
                                    <label id="" for="judul_donasi">Judul Donasi</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Judul donasi" id="judul_donasi" name="judul_donasi" value="" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="jenis_sampah">Jenis Sampah</label>
                                    <select name="jenis_donasi" id="jenis_donasi" class="custom-select" required>
                                        <option value="" selected disabled>Pilih</option>
                                        <option value="Plastik">Plastik</option>
                                        <option value="Kertas">Kertas</option>
                                        <option value="Botol">Botol</option>
                                        <option value="Kaca">Kaca</option>
                                        <option value="Besi">Besi</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="berat_sampah">Total Berat Sampah</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" placeholder="Berat Sampah" id="jumlah_donasi" name="jumlah_donasi" value="" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Kg.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi_donasi" id="deskripsi_donasi" class="form-control" rows="2" placeholder="Tuliskan deskripsi seperti : Kondisi sampah & informasi lainya " required></textarea>
                                </div>
                                <div id="pilih_gambar" class="form-group">
                                    <label for="up_foto" class="text-black">Upload Foto Sampahmu :</label>
                                    <div class="custom-file">
                                        <input type="file" name="input_foto" class="custom-file-input" id="input_foto" onchange="ShowImage(this,'imgAdd')" required>
                                        <label class="custom-file-label" for="customFile">Pilih file</label>
                                    </div>
                                    <div id="imgAdd"></div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="add_batal">BATAL</button>
                            <button type="button" class="btn btn-success" id="add_submit">SIMPAN</button>
                        </div>
                    </div>
                </div>
            </div>


            <div id="place_data_history" class="row">
                <!--
                DATA FROM AJAX WILL BE PRESENTED IN THIS DIV
            -->



            </div>
        </div>
    </section>
</main>