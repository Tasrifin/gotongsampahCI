 <main>

   <!-- Selamat Datang -->
   <section class="section" id="about">
     <div class="container">
       <div class="row justify-content-center">
         <div class="col-md-10">
           <div class="section-title text-center">
             <?php
              //if for user or mitra
              if ($type == 'user') {
                ?>
               <h6 class="theme-color">SELAMAT DATANG !</h6>
               <h2 class="theme-after">Siap Mendonasikan Sampahmu ?</h2>
               <p>Hay #EnvirontmentHeroes !</p>
             <?php
              } else {
                ?>
               <h6 class="theme-color">SELAMAT DATANG !</h6>
               <h2 class="theme-after">Mitra GotongSampah.ID</h2>
               <p>Proses Donasi Yang Tersedia, dan Hubungi Para Giver!</p>
             <?php
              }
              ?>
           </div>
         </div>
       </div>
     </div>
   </section>
   <section id="urai" class="section gray-bg">
     <div class="container">
       <div class="row align-items-center">
         <div class="col-md-6">
           <div class="side-title">
             <h6 class="theme-color">GotongSampah.ID</h6>
             <h2>Website Donasi Sampah #1 di Indonesia</h2>
             <p></p>
             <div class="m-30px-t">
               <?php
                //if for user or mitra
                if ($type == 'user') {
                  ?>
                 <a class="btn btn-theme" href="input_donasi.php">DONASI SEKARANG</a>
               <?php
                } else {
                  //nothing to show
                }
                ?>
             </div>
           </div>
         </div>
       </div>
     </div>
   </section>
   <!-- Donasi -->
   <section class="section">
     <div class="container">
       <div id="place_data" class="row">
         <!--

                DATA FROM AJAX WILL BE PRESENTED IN THIS DIV

         -->

         <!-- Modal -->
         <div class="modal fade" id="myModal" role="dialog">
           <div class="modal-dialog">

             <!-- Modal content-->
             <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 id="cn" class="modal-title">Modal Header</h4>
               </div>
               <div class="modal-body">
                 <p>Some text in the modal.</p>
               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
             </div>

           </div>
         </div>
       </div>
     </div>
   </section>
 </main>


 <script>
   $('.container').on('click', '.btn_dtl', function() {
     $('#myModal').modal('show');
     var txt = document.getElementsByClassName('container').innerHTML;
     console.log(txt);
   })
 </script>