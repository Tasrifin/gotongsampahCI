<div id="detail_modal" class="modal fade" tabindex="-1" role="dialog">';
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
                      <img src="" style="height:40%;">
                    </div>
                    <h4 class="card-title" style="margin-left:3%;"></h4>
                    <div class="card-body">
                      <p class="card-text">Jenis : </p>
                      <p class="card-text">Jumlah : </p>
                      <p class="card-text">Informasi : </p>
                      <p class="card-text">Donatur : </p>
                      <p class="card-text">Kontak : </p>
                      <p class="card-text">Alamat : </p>
                    </div>
                  </div>
                </div>
                <div id="main_modal_footer" class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  <button type="button" class="btn btn-theme-yellow" data-toggle="modal" data-target="#edit_" data-dismiss="modal"><i class="ti-pencil-alt"></i></button>
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete" data-dismiss="modal"><i class="ti-trash"></i></button>
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#konfirmasi_" data-dismiss="modal">Konfirmasi</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  <button type="button" class="btn btn-theme-yellow" data-toggle="modal" data-target="" data-dismiss="modal" disabled><i class="ti-pencil-alt"></i></button>
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="" data-dismiss="modal" disabled><i class="ti-trash"></i></button>
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="" data-dismiss="modal" disabled>Telah Diambil</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  <a class="btn btn-success" data-dismiss="" href=""><i class="fas fa-phone"> Telepon</i></a>
                  <a class="btn btn-success" data-dismiss="" href=""><i class="fas fa-envelope-square"> Email</i></a>
                  <a class="btn btn-danger" style="color:white" data-dismiss="modal">Donasi telah diambil</a>
                </div>
              </div>
          </div>           
         </div>

         <!-- Modal Konfirmasi -->
         <div class="modal fade" id="konfirmasi_" tabindex="-1" role="dialog">
           <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
               <div class="modal-header">
                 <h5 class="modal-title" id="konfirmasi">Konfirmasi Pengambilan Donasi </h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
               </div>
               <div class="modal-body">
                 <form>
                   <div class="form-group">
                     <label for="username" class="col-form-label">Username Mitra Penerima</label>
                     <input placeholder="Username Mitra Penerima" type="text" id="" class="form-control" placeholder="Username Mitra Penerima" required>
                   </div>
                   <div class="form-group">
                     <label for="phone" class="col-form-label">Nomor Handphone Mitra Penerima</label>
                     <input type="number" id="" class="form-control" placeholder="Nomor Handphone Mitra Penerima" required>
                   </div>
                 </form>
               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                 <button type="button" class="btn btn-success" onclick="">Konfirmasi</button>
               </div>
             </div>
           </div>
         </div>

         <!-- Modal Hapus -->
         <div class="modal fade" id="delete_" tabindex="-1" role="dialog">
           <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">

               <div class="modal-header">
                 <h5 class="modal-title" id="hapus">Hapus Donasi</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
               </div>
               <div class="modal-body">
                 <p>Apakah Anda yakin akan menghapus data ini ?</p>
               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-success" data-dismiss="modal">BATAL</button>
                 <button type="button" id="delData" class="btn btn-danger" onclick="">HAPUS</button>
               </div>

               <div id="takenByMitra" class="d-none">
                 <div class="modal-body">
                   <p>Sampah telah diambil oleh Mitra, Data tidak dapat dihapus!</p>
                 </div>
                 <div class="modal-footer">
                   <button type="button" class="btn btn-success" data-dismiss="modal">BATAL</button>
                 </div>
               </div>


               <div id="notMine" class="d-none">
                 <div class="modal-header">
                   <h5 class="modal-title" id="hapus">Tidak dapat mengakses donasi milik orang lain!</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                   </button>
                 </div>
                 <div class="modal-body">
                   <p>Tidak dapat mengakses donasi milik orang lain!!</p>
                 </div>
                 <div class="modal-footer">
                   <button type="button" class="btn btn-success" data-dismiss="modal">KELUAR</button>
                 </div>
               </div>


             </div>
           </div>
         </div>


         <!-- Modal Edit -->
         <div class="modal fade  bd-example-modal-lg" id="edit_">
           <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
             <div class="modal-content">
               <div class="modal-header">
                 <h5 class="modal-title" id="edit">Edit Data Donasi #</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
               </div>
               <div class="modal-body">
                 <form>
                   <div>
                     <label for="judul_donasi">Judul Donasi</label>
                     <div class="input-group mb-3">
                       <input type="text" class="form-control" placeholder="Judul donasi" id="" name="judul_donasi" value="" required>
                     </div>
                   </div>

                   <div class="form-group">
                     <label for="jenis_sampah">Jenis Sampah</label>
                     <select name="jenis_sampah" id="" class="custom-select" required>

                     </select>
                   </div>

                   <div>
                     <label for="berat_sampah">Total Berat Sampah</label>
                     <div class="input-group mb-3">
                       <input type="number" class="form-control" placeholder="Berat Sampah" id="" name="berat_sampah" value="" required>
                       <div class="input-group-append">
                         <span class="input-group-text">Kg.</span>
                       </div>
                     </div>
                   </div>
                   <div class="form-group">
                     <label for="deskripsi">Deskripsi</label>
                     <textarea name="deskripsi" id="" class="form-control" rows="3" placeholder="Tuliskan deskripsi seperti : Kondisi sampah & informasi lainya " required></textarea>
                   </div>
                   <div class="form-group">
                     <label for="alamat">Alamat Penjemputan</label>
                     <textarea name="alamat" id="" rows="0" class="form-control" placeholder="Alamat Lengkap" required></textarea>
                   </div>
                   <div class="form-group">
                     <label for="tlp">Nomor Telephone</label>
                     <input type="tel" class="form-control d-inline" id="tlp" name="tlp" placeholder="Nomor Telephone Yang Masih Aktif" value="" required>
                   </div>

                 </form>
               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-danger" data-dismiss="modal">BATAL</button>
                 <button type="button" class="btn btn-success" onclick="">SIMPAN</button>
               </div>
             </div>
           </div>
         </div>