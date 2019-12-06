

$(document).ready(function () {
    console.log("ready");
    getData();
    var data_detail = {
        title: $("#detail_modal").find('.modal-title').text(),
        jenis_donasi: $("#detail_modal").find('.jenis_donasi').text(),
        jumlah_donasi: $("#detail_modal").find('.jumlah_donasi').text(),
        informasi_donasi: $("#detail_modal").find('.informasi_donasi').text(),
        donatur_donasi: $("#detail_modal").find('.donatur_donasi').text(),
        kontak_donasi: $("#detail_modal").find('.kontak_donasi').text(),
        alamat_donasi: $("#detail_modal").find('.alamat_donasi').text(),
    };

    //login
    $('#Login_Submit').click(function () {
        $.ajax({
            type: 'POST',
            data: $('#login_form').serialize(),
            url: baseURL + "auth/tryLogin",
            success: function (response) {
                var obj = jQuery.parseJSON(response);
                if (obj.error) {
                    alert("Gagal Login");

                } else {
                    alert("Berhasil Login");
                    window.location = baseURL + "dashboard";

                }
            },
            error: function (response) {
                alert("Tidak dapat memuat data, Error :" + response);
            }
        });
    });

    //signup

    $('#SignUp_Submit').click(function () {
        $.ajax({
            type: 'POST',
            data: $('#signup_form').serialize(),
            url: baseURL + "auth/trySignup",
            success: function (data) {
                if (data == "true") {
                    alert("Berhasil daftar!");
                    window.location = "login";
                } else {
                    alert('Gagal mendaftar!\n' + data);
                }
            },
            error: function (response) {
                alert("Tidak dapat memuat data, Error :" + response);
            }
        });
    });

    $('.container').on('click', '.donasi_detail', function () {
        var id = $(this).attr('data');
        getDataDetail(id);
        $("#detail_modal").modal('show');
    });

    function getDataDetail(id) {

        console.log(id);
        console.log(my_id);
        console.log(data_detail.title);
        $("#detail_modal").find('.modal-title').text(data_detail.title + id);
        $.ajax({
            type: 'AJAX',
            method: 'POST',
            data: {
                id: id,
            },
            url: baseURL + 'dashboard/getData',
            async: false,
            dataType: 'JSON',
            success: function (data) {
                var dt = data[0];
                var stat = UrlExists(baseURL + 'cdn/img/' + dt.gambar);
                if (stat === false) {
                    dt.gambar = '404.jpeg';
                }
                $("#detail_modal").find('.card-title').text(dt.Judul_Donasi);
                $("#detail_modal").find('.gambar_donasi').attr('src', baseURL + 'cdn/img/' + dt.gambar);
                console.log($("#detail_modal").find('.gambar_donasi').attr('src'));
                $("#detail_modal").find('.jenis_donasi').text(data_detail.jenis_donasi + dt.jenis_donasi);
                $("#detail_modal").find('.jumlah_donasi').text(data_detail.jumlah_donasi + dt.jumlah_donasi + " KG");
                $("#detail_modal").find('.informasi_donasi').text(data_detail.informasi_donasi + dt.informasi_donasi);
                getData_UserInfo(dt.fkid_user, "user");

                var html = '';
                //footer
                if (my_id == dt.fkid_user && dt.fkid_mitra === null && type == "user") {
                    html = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>' +
                        '<button type="button" class="btn btn-theme-yellow modal_edit" data=' + id + ' ><i class="ti-pencil-alt"></i></button>' +
                        '<button type="button" class="btn btn-danger modal_delete" data-id_donasi='+id+' data-id_creator='+dt.fkid_user+' d><i class="ti-trash"></i></button>' +
                        '<button type="button" class="btn btn-success modal_konfirmasi" data-id_donasi='+id+' data-id_creator='+dt.fkid_user+'>Konfirmasi</button>';
                } else if (my_id == dt.fkid_user && dt.fkid_mitra !== null && type == "user") {
                    html = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>' +
                        '<button type="button" class="btn btn-theme-yellow" data-toggle="modal" data-target="" data-dismiss="modal" disabled><i class="ti-pencil-alt"></i></button>' +
                        '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="" data-dismiss="modal" disabled><i class="ti-trash"></i></button>' +
                        '<button type="button" class="btn btn-success" data-toggle="modal" data-target="" data-dismiss="modal" disabled>Telah Diambil</button>';
                } else if (dt.fkid_mitra === null && type == "mitra") {
                    html = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>' +
                        '<a class="btn btn-success" data-dismiss="" href=""><i class="fas fa-phone"> Telepon</i></a>' +
                        '<a class="btn btn-success" data-dismiss="" href=""><i class="fas fa-envelope-square"> Email</i></a>';
                } else if (dt.fkid_mitra !== null && type == "mitra") {
                    html = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>' +
                        '<a class="btn btn-danger" style="color:white" data-dismiss="modal">Donasi telah diambil</a>';
                } else if (my_id !== dt.fkid_user) {
                    html = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
                }
                $('#main_modal_footer').html(html);

            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    function getData_UserInfo(id, type_) {
        $.ajax({
            type: 'AJAX',
            method: 'POST',
            data: {
                id: id,
                type: type_,
            },
            url: baseURL + 'dashboard/getData_UserInfo',
            async: false,
            dataType: 'JSON',
            success: function (data) {
                var dt = data[0];
                $("#detail_modal").find('.donatur_donasi').text(data_detail.donatur_donasi + dt.nama);
                $("#detail_modal").find('.kontak_donasi').text(data_detail.kontak_donasi + dt.handphone);
                $("#detail_modal").find('.alamat_donasi').text(data_detail.alamat_donasi + dt.alamat);
            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    $('.container').on('click', '.modal_edit', function () {
        var id = $(this).attr('data');
        getDataEdit(id);
        $("#detail_modal").modal('hide');
        $("#edit_").modal('show');
    });

    var title_konfirmasi = $("#konfirmasi_").find('.modal-title').text();
    $('.container').on('click', '.modal_konfirmasi', function () {
        var id = $(this).data('id_donasi');
        $("#detail_modal").modal('hide');
        $("#konfirmasi_").modal('show');
        
        $("#konfirmasi_").find('.modal-title').text(title_konfirmasi + id);

    });

    //ajax get info mitra when try to get donasi

    $('#username_mitra').blur(function(){
        if($(this).val()=== null || $(this).val().match(/^ *$/) !== null){

        }else{
            $.ajax({
                type: "POST",
                data: {
                    getType: 'username',
                    uname: $(this).val(),
                },
                url: baseURL + 'dashboard/mitra',
                dataType: "JSON",
                success: function (rsp) {        
                    if (rsp['status']) {
                        $("#konfirmasi_").find('.mitra-unknown').attr('hidden',true);
                        $("#konfirmasi_").find('.hp_mitra').val(rsp['response'][0].handphone);
        
                    } else {
                        $("#konfirmasi_").find('.mitra-unknown').removeAttr('hidden');
                        $("#konfirmasi_").find('.hp_mitra').val('');        
                        $("#konfirmasi_").find('#username_mitra').val('');     
                        
                    }
                },
                error: function (rsp) {
                    alert(rsp);
                }
            })
        }   
    });

    

    var title = $("#edit_").find('.modal-title').text();

    function getDataEdit(id) {
        $("#edit_").find('.modal-title').text(title + id);
        $.ajax({
            type: 'AJAX',
            method: 'POST',
            data: {
                id: id,
            },
            url: baseURL + 'dashboard/getData',
            async: false,
            dataType: 'JSON',
            success: function (data) {
                dt = data[0];

                $("#edit_").find('#judul_donasi').val(dt.Judul_Donasi);
                $("#edit_").find('#jenis_donasi').val(dt.jenis_donasi);
                $("#edit_").find('#jumlah_donasi').val(dt.jumlah_donasi);
                $("#edit_").find('#deskripsi_donasi').val(dt.informasi_donasi);
                $("#edit_").find('#edit_batal').attr('data', id);
                var gbr = baseURL + 'cdn/img/' + dt.gambar;
                ShowImage_default(gbr);
                $("#edit_").find('#id_donasi').val(id);
                $("#edit_").find('#id_user').val(dt.fkid_user);

            },
            error: function (data) {
                console.log(data);
            }
        });


    }

    function ShowImage_default(input) {
        var html = '<img src="' + input + '" width="200" height="100" class="img-thumbnail m-3">';
        $('#no_update').html(html);
        console.log(html);

    }

    $('#update_foto').change(function () {
        var set = $(this).val();
        if (set == "Y") {
            $('#pilih_gambar').removeClass('d-none');
            $('#no_update').addClass('d-none');
            $('#input_foto').attr('required');
        } else {
            $('#pilih_gambar').addClass('d-none');
            $('#no_update').removeClass('d-none');
            $('#input_foto').removeAttr('required');
        }
    });

    $('.container').on('click', '#edit_batal', function () {
        $("#edit_").modal('hide');
        $("#detail_modal").modal('show');
        var id = $(this).attr('data');
        getDataDetail(id);

    });

    $('.container').on('click', '#edit_submit', function () {
        var postData = new FormData($('#edit_form')[0]);
        $.ajax({
            type: 'POST',
            data: postData,
            url: baseURL + "dashboard/edit",
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                if (response['error']) {
                    alert(response['msg']);
                } else {
                    alert(response['msg']);
                    $("#edit_").modal('hide');
                    $("#detail_modal").modal('show');
                    getDataDetail(response['id']);
                }
            },
            error: function (response) {
                alert("Tidak dapat memuat data, Error :" + response);
            }
        });

    });

    $('#detail_modal').on('hidden.bs.modal', function () {
        getData();
    })

    $('#edit_').on('hidden.bs.modal', function () {
        var id = $('.modal_edit').attr('data');
        getDataEdit(id);
        $("#detail_modal").modal('show');
    })

    $("input#username_mitra").on({
        keydown: function(e) {
          if (e.which === 32)
            return false;
        },
        change: function() {
          this.value = this.value.replace(/\s/g, "");
        }
      });

    $('#konfirmasi_').on('hidden.bs.modal', function () {
        var id = $('.modal_konfirmasi').attr('data');
        getDataEdit(id);
        $("#detail_modal").modal('show');
    })

    $('.container').on('click', '.konfirmasi_submit', function () {
        var id_donasi = $('.modal_konfirmasi').data('id_donasi');
        var creator = $('.modal_konfirmasi').data('id_creator');
        $.ajax({
            type: 'POST',
            data: {
                'id_donasi' : id_donasi,
                'creator'   : creator,
                'username_mitra' : $('#username_mitra').val(),
            },
            url: baseURL + "dashboard/konfirmasi",
            dataType : "json",
            success: function (response) {
                console.log(response);
                if(response['error']){
                    alert(response['msg']);
                }else{
                    alert(response['msg']);
                    $("#konfirmasi_").modal('hide');
                    $("#detail_modal").modal('show');
                    getDataDetail(id_donasi);
                }

            },
            error: function (response) {
                alert("Tidak dapat memuat data, Error :" + response);
            }
        });

    });
    var del_title = $("#delete_").find('.modal-title').text();

    $('.container').on('click', '.modal_delete', function () {
        var id_donasi = $('.modal_konfirmasi').data('id_donasi');
        var id_creator = $('.modal_konfirmasi').data('id_creator');
        $("#delete_").find('.modal-title').text(del_title+id_donasi);
        $("#detail_modal").modal('hide');
        $("#delete_").modal('show');
        $.ajax({
            type: 'GET',
            data : {
                'id_donasi' : id_donasi,
                'id_creator' : id_creator,
            },
            url: baseURL+'dashboard/getDel',
            success:function(response){
                if(response == 0)
                {
                    $("#delete_").find('.del-word').text("Tidak dapat mengakses donasi milik orang lain!");
                }else if(response == 1){
                    $("#delete_").find('.del-word').text("Apakah Anda yakin akan menghapus data ini ?");
                }else if(response == 2){
                    $("#delete_").find('.del-word').text("Sampah telah diambil oleh Mitra, Data tidak dapat dihapus!");
                }
            },
            error:function(response){
                alert(response);
            }
        });








    });
    




});

function ShowImage(input) {
    var element = document.getElementById('img');
    var stage = true;
    if (element.children.length === 5) {
        stage = false;
    }
    if (input.files && input.files[0] && stage === true) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('img').innerHTML = "<img src='" + e.target.result + "' width='100' height='50' class='img-thumbnail m-3'>";


        };
        reader.readAsDataURL(input.files[0]);
    } else {
        alert("Maksimum input 1 Gambar!");
    }
}



text_truncate = function (str, length, ending) {
    if (length == null) {
        length = 100;
    }
    if (ending == null) {
        ending = '...';
    }
    if (str.length > length) {
        return str.substring(0, length - ending.length) + ending;
    } else {
        return str;
    }
};

function UrlExists(url) {
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status != 404;
}

function getData() {
    $.ajax({
        type: 'AJAX',
        url: baseURL + 'dashboard/getData',
        async: false,
        dataType: 'JSON',
        success: function (data) {
            var html = '';
            var judul = '';
            var desc = '';
            for (var i = 0; i < data.length; i++) {
                var dt = data[i];
                var stat = UrlExists(baseURL + 'cdn/img/' + dt.gambar);
                if (stat === false) {
                    dt.gambar = '404.jpeg';
                }
                console.log(dt.gambar);
                judul = text_truncate(dt.Judul_Donasi, 23, '...');
                desc = text_truncate(dt.informasi_donasi, 100, '...');
                html += '<div class="col-md-4">' +
                    '<div class="card " style="margin-bottom: 10%; ">' +
                    '<div class="wrapper">' +
                    '<img class="card-img-top img-fluid" src="' + baseURL + 'cdn/img/' + dt.gambar + '" alt="Card image cap">' +
                    '</div>' +
                    '<div title="' + dt.Judul_Donasi + '"><h4 class="card-title" style="text-align:center; margin-top:15px; margin-bottom:-10px;">' + judul + '</h4></div>' +
                    '<div class="card-body">' +
                    '<div title="click detail for more info"><p class="card-text" style="text-align:justify; margin-bottom:10px;">' + desc + '</p></div>' +
                    '<button class="btn btn-theme-yellow btn-block donasi_detail" data="' + dt.id_donasi + '">Detail</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            }
            $('#place_data').html(html);
        }
    });

}





