$(document).ready(function() {
	//fetch data
	//console.log("Document ready, library has been loaded!");
	if (pagesType == "dashboard") {
		getData();
	} else if (pagesType == "history") {
		getDataHistory();
	} else if (pagesType == "settings") {
		getSettingsInfo();
	}
	//login
	$("#Login_Submit").click(function() {
		$.ajax({
			type: "POST",
			data: $("#login_form").serialize(),
			url: baseURL + "auth/tryLogin",
			success: function(response) {
				var obj = jQuery.parseJSON(response);
				if (obj.error) {
					alert("Gagal Login, ID atau Password tidak ditemukan!");
				} else {
					alert("Berhasil Login");
					window.location = baseURL + "dashboard";
				}
			},
			error: function(response) {
				alert("ERROR : Tidak dapat menerima data dari server!");
			}
		});
	});

	//signup
	$("#SignUp_Submit").click(function() {
		$.ajax({
			type: "POST",
			data: $("#signup_form").serialize(),
			url: baseURL + "auth/trySignup",
			dataType: "JSON",
			success: function(data) {
				if (data["error"]) {
					alert(data["msg"]);
				} else {
					alert(data["msg"]);
					window.location = "login";
				}
			},
			error: function(response) {
				alert("ERROR : Tidak dapat menerima data dari server!");
			}
		});
	});

	//DetailMDL
	$(".container").on("click", ".donasi_detail", function() {
		var id = $(this).attr("data");
		getDataDetail(id);
	});

	//DetailMDL::Hide
	$("#detail_modal").on("hidden.bs.modal", function() {
		if (pagesType == "dashboard") {
			getData();
		} else if (pagesType == "history") {
			getDataHistory();
		}
	});

	//EditMDL
	$(".container").on("click", ".modal_edit", function() {
		var id = $(this).attr("data");
		getDataEdit(id);
		$("#detail_modal").modal("hide");
		$("#update_foto").prop("selectedIndex", 0);
		$("#pilih_gambar").addClass("d-none");
		$("#no_update").removeClass("d-none");
		$("#input_foto").removeAttr("required");
		checkData("#edit_", null, "Modal");
	});
	//Edit::SetIMGOption
	$("#update_foto").change(function() {
		var set = $(this).val();
		if (set == "Y") {
			$("#pilih_gambar").removeClass("d-none");
			$("#no_update").addClass("d-none");
			$("#input_foto").attr("required");
		} else {
			$("#pilih_gambar").addClass("d-none");
			$("#no_update").removeClass("d-none");
			$("#input_foto").removeAttr("required");
		}
	});
	//Edit::Batal
	$(".container").on("click", "#edit_batal", function() {
		$("#edit_").modal("hide");
		var id = $(this).attr("data");
		getDataDetail(id);
		$("#detail_modal").modal("show");
	});
	//Edit::Submit
	$("#edit_").on("click", "#edit_submit", function() {
		var postData = new FormData($("#edit_form")[0]);
		checkData("editSubmit", postData, "function");
	});

	//EditMDL::Hide
	$("#edit_").on("hidden.bs.modal", function() {
		var id = $(".modal_edit").attr("data");
		getDataDetail(id);
		$("#detail_modal").modal("show");
	});

	//KonfirmasiMDL
	$(".container").on("click", ".modal_konfirmasi", function() {
		var id = $(this).data("id_donasi");
		$("#detail_modal").modal("hide");
		$("#konfirmasi_")
			.find(".modal-title")
			.text(title_konfirmasi + id);
		checkData("#konfirmasi_", null, "Modal");
	});
	//Konfirmasi::GetMitraInfo
	$("#username_mitra").blur(function() {
		if (
			$(this).val() === null ||
			$(this)
				.val()
				.match(/^ *$/) !== null
		) {
		} else {
			checkData("konfirmasiGetData", $(this).val(), "function");
		}
	});

	//Konfirmasi::RemovingWhiteSpace
	$("input#username_mitra").on({
		keydown: function(e) {
			if (e.which === 32) return false;
		},
		change: function() {
			this.value = this.value.replace(/\s/g, "");
		}
	});
	//KonfirmasiMDL::Hide
	$("#konfirmasi_").on("hidden.bs.modal", function() {
		var id = $(".modal_konfirmasi").data("id_donasi");
		getDataDetail(id);
		$("#detail_modal").modal("show");
	});
	//Konfirmasi::Submit
	$(".container").on("click", ".konfirmasi_submit", function() {
		var id_donasi = $(".modal_konfirmasi").data("id_donasi");
		var creator = $(".modal_konfirmasi").data("id_creator");
		checkData(
			"konfirmasiSubmit",
			[id_donasi, creator, $("#username_mitra").val(), $("#hp_mitra").val()],
			"function"
		);
	});

	//DeleteMDL
	$(".container").on("click", ".modal_delete", function() {
		var id_donasi = $(".modal_konfirmasi").data("id_donasi");
		var id_creator = $(".modal_konfirmasi").data("id_creator");
		$("#delete_")
			.find(".modal-title")
			.text(del_title + id_donasi);
		checkData("#delete_", null, "Modal");
		$("#detail_modal").modal("hide");
		getDelDetail(id_donasi, id_creator);
	});

	//DeleteMDL::Hide
	$("#delete_").on("hidden.bs.modal", function() {
		var id = $("#delData").data("id_donasi");
		$("#detail_modal").modal("show");
		getDataDetail(id);
	});

	//Delete::DeleteBTN
	$(".container").on("click", "#delData", function() {
		var id_donasi = $("#delData").data("id_donasi");
		var creator = $("#delData").data("id_creator");
		checkData("deleteDonasi", [id_donasi, creator], "function");
	});

	$("#updateSettings").submit(function(e) {
		e.preventDefault();
		updateProfile($("#updateSettings").serialize());
	});

	$(".container").on("click", ".donasi-sekarang", function() {
		checkData("#add_modal", null, "Modal");
	});

	//add data section check user activation
	$("#header_addDonasi").click(function() {
		checkData("#add_modal", null, "Modal");
	});

	$("#add_modal").on("click", "#add_submit", function() {
		var postData = new FormData($("#add_form")[0]);
		checkData("AddData", postData, "function");
	});
});

//Check data about user info
function checkData(data, params, TypeOf) {
	$.ajax({
		type: "POST",
		data: {
			id: my_id,
			type: type
		},
		url: baseURL + "dashboard/getData_UserInfo",
		dataType: "JSON",
		async: false,
		success: function(response) {
			var rsp = response[0];
			if (rsp.activationCode == null) {
				if (
					rsp.nama != null &&
					rsp.alamat != null &&
					rsp.handphone != null &&
					rsp.email != null &&
					rsp.tanggallahir != null &&
					rsp.jeniskelamin != null
				) {
					if (TypeOf == "function") {
						window[data](params);
					} else {
						$("" + data).modal("show");
					}
				} else {
					alert("Harap penuhi data pada profile anda terlebih dahulu!");
					TypeOf != "function" ? $("" + data).modal("hide") : console.log();
				}
			} else {
				alert("Harap aktivasi email anda terlebih dahulu!");
				TypeOf != "function" ? $("" + data).modal("hide") : console.log();
			}
		},
		error: function(response) {
			alert("ERROR : Tidak dapat menerima data dari server!");
		}
	});
}

//Get data for dashboard
function getData() {
	$.ajax({
		type: "GET",
		url: baseURL + "dashboard/getData",
		async: false,
		dataType: "JSON",
		success: function(data) {
			var html = "";
			var judul = "";
			var desc = "";
			if (data.length >= 1) {
				for (var i = 0; i < data.length; i++) {
					var dt = data[i];
					var stat = UrlExists(baseURL + "cdn/img/" + dt.gambar);
					if (stat === false) {
						dt.gambar = "404.jpeg";
					}
					judul = text_truncate(dt.Judul_Donasi, 23, "...");
					desc = text_truncate(dt.informasi_donasi, 100, "...");
					html +=
						'<div class="col-md-4">' +
						'<div class="card " style="margin-bottom: 10%; ">' +
						'<div class="wrapper">' +
						'<img class="card-img-top img-fluid" src="' +
						baseURL +
						"cdn/img/" +
						dt.gambar +
						'" alt="Card image cap">' +
						"</div>" +
						'<div title="' +
						dt.Judul_Donasi +
						'"><h4 class="card-title" style="text-align:center; margin-top:15px; margin-bottom:-10px;">' +
						judul +
						"</h4></div>" +
						'<div class="card-body">' +
						'<div title="click detail for more info"><p class="card-text" style="text-align:justify; margin-bottom:10px;">' +
						desc +
						"</p></div>" +
						'<button class="btn btn-theme-yellow btn-block donasi_detail" data="' +
						dt.id_donasi +
						'">Detail</button>' +
						"</div>" +
						"</div>" +
						"</div>";
				}
				$("#place_data").html(html);
			} else {
				html = "<h4>Tidak ada riwayat donasi.</h4>";
				$("#donasiState").html(html);
			}
		},
		error: function(data) {
			alert("ERROR : Tidak dapat menerima data dari server!");
		}
	});
}

//CheckURLExist?
function UrlExists(url) {
	var http = new XMLHttpRequest();
	http.open("HEAD", url, false);
	http.send();
	return http.status != 404;
}

//Edit::GetDataEdit
function getDataEdit(id) {
	$("#edit_")
		.find(".modal-title")
		.text(title + id);
	$.ajax({
		type: "AJAX",
		method: "POST",
		data: {
			id: id
		},
		url: baseURL + "dashboard/getData",
		async: false,
		dataType: "JSON",
		success: function(data) {
			if (data.length) {
				dt = data[0];

				$("#edit_")
					.find("#judul_donasi")
					.val(dt.Judul_Donasi);
				$("#edit_")
					.find("#jenis_donasi")
					.val(dt.jenis_donasi);
				$("#edit_")
					.find("#jumlah_donasi")
					.val(dt.jumlah_donasi);
				$("#edit_")
					.find("#deskripsi_donasi")
					.val(dt.informasi_donasi);
				$("#edit_")
					.find("#edit_batal")
					.attr("data", id);
				var gbr = baseURL + "cdn/img/" + dt.gambar;
				ShowImage_default(gbr);
				$("#edit_")
					.find("#id_donasi")
					.val(id);
				$("#edit_")
					.find("#id_user")
					.val(dt.fkid_user);
				$("#edit_")
					.find("#gbr")
					.val(dt.gambar);
			} else {
				alert("ERROR : Data tidak ditemukan!");
			}
		},
		error: function(data) {
			alert("ERROR : Tidak dapat menerima data dari server!");
		}
	});
}
//Edit::ShowCurrentIMG
function ShowImage_default(input) {
	var html =
		'<img src="' +
		input +
		'" width="200" height="100" class="img-thumbnail m-3">';
	$("#no_update").html(html);
}
//edit::editSubmitAJAX
function editSubmit(postData) {
	$.ajax({
		type: "POST",
		data: postData,
		url: baseURL + "dashboard/edit",
		dataType: "json",
		processData: false,
		contentType: false,
		success: function(response) {
			if (response["error"]) {
				alert(response["msg"]);
			} else {
				alert(response["msg"]);
				$("#edit_").modal("hide");
				$("#detail_modal").modal("show");
				getDataDetail(response["id"]);
			}
		},
		error: function(response) {
			alert("ERROR : Tidak dapat menerima data dari server!");
		}
	});
}

var data_detail = {
	title: "Detail Donasi #",
	jenis_donasi: "Jenis : ",
	jumlah_donasi: "Jumlah : ",
	informasi_donasi: "Deskripsi : ",
	donatur_donasi: "Donatur : ",
	kontak_donasi: "Kontak Donatur : ",
	alamat_donasi: "Alamat Donatur : "
};
var title_konfirmasi = "Konfirmasi Pengambilan Donasi #";
var title = "Edit Donasi #";
var del_title = "Hapus Donasi #";

//Edit::ShowIMG
function ShowImage(input, ids) {
	var element = document.getElementById("" + ids);
	var stage = true;
	if (element.children.length === 5) {
		stage = false;
	}
	if (input.files && input.files[0] && stage === true) {
		var reader = new FileReader();
		reader.onload = function(e) {
			html =
				"<img src='" +
				e.target.result +
				"' width='100' height='50' class='img-thumbnail m-3'>";
			$("#" + ids).html(html);
		};
		reader.readAsDataURL(input.files[0]);
	} else {
		alert("Maksimum input 1 Gambar!");
	}
}

//Detail::ShortText
text_truncate = function(str, length, ending) {
	if (length == null) {
		length = 100;
	}
	if (ending == null) {
		ending = "...";
	}
	if (str.length > length) {
		return str.substring(0, length - ending.length) + ending;
	} else {
		return str;
	}
};

//Detail::GetDataDetail
function getDataDetail(id) {
	$("#detail_modal")
		.find(".modal-title")
		.text(data_detail.title + id);
	$.ajax({
		type: "AJAX",
		method: "POST",
		data: {
			id: id
		},
		url: baseURL + "dashboard/getData",
		async: false,
		dataType: "JSON",
		success: function(data) {
			if (data.length === 0) {
				alert("Data donasi tidak ditemukan!");
			} else {
				var dt = data[0];
				var stat = UrlExists(baseURL + "cdn/img/" + dt.gambar);
				if (stat === false) {
					dt.gambar = "404.jpeg";
				}
				console.log(data_detail.title);
				$("#detail_modal")
					.find(".card-title")
					.text(dt.Judul_Donasi);
				$("#detail_modal")
					.find(".gambar_donasi")
					.attr("src", baseURL + "cdn/img/" + dt.gambar);
				$("#detail_modal")
					.find(".jenis_donasi")
					.text(data_detail.jenis_donasi + dt.jenis_donasi);
				$("#detail_modal")
					.find(".jumlah_donasi")
					.text(data_detail.jumlah_donasi + dt.jumlah_donasi + " KG");
				$("#detail_modal")
					.find(".informasi_donasi")
					.text(data_detail.informasi_donasi + dt.informasi_donasi);
				getData_UserInfo(dt.fkid_user, "user", my_id, dt);
				$("#detail_modal").modal("show");
			}
		},
		error: function(data) {
			alert("ERROR : Tidak dapat menerima data dari server!");
		}
	});
}

//Detail::GetDataUserInfo
function getData_UserInfo(id_donatur, type_, my_id, dt) {
	$.ajax({
		type: "AJAX",
		method: "POST",
		data: {
			id: id_donatur,
			type: type_
		},
		url: baseURL + "dashboard/getData_UserInfo",
		async: false,
		dataType: "JSON",
		success: function(data) {
			var dtinf = data[0];
			$("#detail_modal")
				.find(".donatur_donasi")
				.text(data_detail.donatur_donasi + dtinf.nama);
			$("#detail_modal")
				.find(".kontak_donasi")
				.text(data_detail.kontak_donasi + dtinf.handphone);
			$("#detail_modal")
				.find(".alamat_donasi")
				.text(data_detail.alamat_donasi + dtinf.alamat);

			var html = "";
			//footer
			if (my_id == dt.fkid_user && dt.fkid_mitra === null && type == "user") {
				html =
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>' +
					'<button type="button" class="btn btn-theme-yellow modal_edit" data=' +
					dt.id_donasi +
					' ><i class="ti-pencil-alt"></i></button>' +
					'<button type="button" class="btn btn-danger modal_delete" data-id_donasi=' +
					dt.id_donasi +
					" data-id_creator=" +
					dt.fkid_user +
					' d><i class="ti-trash"></i></button>' +
					'<button type="button" class="btn btn-success modal_konfirmasi" data-id_donasi=' +
					dt.id_donasi +
					" data-id_creator=" +
					dt.fkid_user +
					">Konfirmasi</button>";
			} else if (
				my_id == dt.fkid_user &&
				dt.fkid_mitra !== null &&
				type == "user"
			) {
				html =
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>' +
					'<button type="button" class="btn btn-theme-yellow" data-toggle="modal" data-target="" data-dismiss="modal" disabled><i class="ti-pencil-alt"></i></button>' +
					'<button type="button" class="btn btn-danger" data-toggle="modal" data-target="" data-dismiss="modal" disabled><i class="ti-trash"></i></button>' +
					'<button type="button" class="btn btn-success" data-toggle="modal" data-target="" data-dismiss="modal" disabled>Telah Diambil</button>';
			} else if (dt.fkid_mitra === null && type == "mitra") {
				html =
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>' +
					'<a class="btn btn-success" href="tel:' +
					dtinf.handphone +
					'"><i class="fas fa-phone"> Telepon</i></a>' +
					'<a class="btn btn-success" href="mailto:' +
					dtinf.email +
					'"><i class="fas fa-envelope-square"> Email</i></a>';
			} else if (dt.fkid_mitra !== null && type == "mitra") {
				html =
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>' +
					'<a class="btn btn-danger" style="color:white" data-dismiss="modal">Donasi telah diambil</a>';
			} else if (my_id !== dt.fkid_user) {
				html =
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
			} else {
				html =
					'<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>';
			}
			$("#main_modal_footer").html(html);
		},
		error: function(data) {
			alert("ERROR : Tidak dapat menerima data dari server!");
		}
	});
}

//konfirmasi getData
function konfirmasiGetData(uname) {
	$.ajax({
		type: "POST",
		data: {
			getType: "username",
			uname: uname
		},
		url: baseURL + "dashboard/mitra",
		dataType: "JSON",
		success: function(rsp) {
			if (rsp["status"]) {
				$("#konfirmasi_")
					.find(".mitra-unknown")
					.attr("hidden", true);
				if (rsp["response"][0].activationCode != null) {
					$("#konfirmasi_")
						.find(".mitra-unknown")
						.removeAttr("hidden");
					$("#konfirmasi_")
						.find(".mitra-unknown")
						.text("Mitra belum melakukan aktivasi email!");
					$("#konfirmasi_")
						.find(".hp_mitra")
						.val("");
				} else {
					if (
						rsp["response"][0].nama != null &&
						rsp["response"][0].alamat != null &&
						rsp["response"][0].handphone != null &&
						rsp["response"][0].tanggallahir != null &&
						rsp["response"][0].jeniskelamin != null
					) {
						$("#konfirmasi_")
							.find(".mitra-unknown")
							.attr("hidden", true);
						$("#konfirmasi_")
							.find(".hp_mitra")
							.val(rsp["response"][0].handphone);
					} else {
						$("#konfirmasi_")
							.find(".mitra-unknown")
							.removeAttr("hidden");
						$("#konfirmasi_")
							.find(".mitra-unknown")
							.text("Data mitra belum lengkap, tidak dapat mengambil donasi!");
						$("#konfirmasi_")
							.find(".hp_mitra")
							.val(rsp["response"][0].handphone);
					}
				}
			} else {
				$("#konfirmasi_")
					.find(".mitra-unknown")
					.text("Data username tidak ditemukan!");
				$("#konfirmasi_")
					.find(".mitra-unknown")
					.removeAttr("hidden");
				$("#konfirmasi_")
					.find(".hp_mitra")
					.val("");
				$("#konfirmasi_")
					.find("#username_mitra")
					.val("");
			}
		},
		error: function(rsp) {
			alert("ERROR : Tidak dapat menerima data dari server!");
		}
	});
}

//Konfirmasi::KonfirmasiSubmit()
function konfirmasiSubmit(param) {
	$.ajax({
		type: "POST",
		data: {
			id_donasi: param[0],
			creator: param[1],
			username_mitra: param[2],
			hp_mitra: param[3]
		},
		url: baseURL + "dashboard/konfirmasi",
		dataType: "json",
		success: function(response) {
			if (response["error"]) {
				alert(response["msg"]);
			} else {
				alert(response["msg"]);
				$("#konfirmasi_").modal("hide");
			}
		},
		error: function(response) {
			alert("ERROR : Tidak dapat menerima data dari server!");
		}
	});
}

//Delete::GetDelInfo?
function getDelDetail(id_donasi, id_creator) {
	$.ajax({
		type: "GET",
		data: {
			id_donasi: id_donasi,
			id_creator: id_creator
		},
		url: baseURL + "dashboard/getDel",
		success: function(response) {
			if (response == 0) {
				$("#delete_")
					.find(".del-word")
					.text("Tidak dapat mengakses donasi milik orang lain!");
				$("#delete_")
					.find("#delData")
					.attr("hidden", true);
			} else if (response == 1) {
				$("#delete_")
					.find(".del-word")
					.text("Apakah Anda yakin akan menghapus data ini ?");
				$("#delete_")
					.find("#delData")
					.removeAttr("hidden");
				$("#delete_")
					.find("#delData")
					.attr("data-id_donasi", id_donasi);
				$("#delete_")
					.find("#delData")
					.attr("data-id_creator", id_creator);
			} else if (response == 2) {
				$("#delete_")
					.find(".del-word")
					.text("Sampah telah diambil oleh Mitra, Data tidak dapat dihapus!");
				$("#delete_")
					.find("#delData")
					.attr("hidden", true);
			}
		},
		error: function(response) {
			alert("ERROR : Tidak dapat menerima data dari server!");
		}
	});
}

//Delete::DeleteDonasi
function deleteDonasi(params) {
	$.ajax({
		type: "GET",
		data: {
			id_donasi: params[0],
			id_creator: params[1]
		},
		url: baseURL + "dashboard/deleteData",
		dataType: "json",
		success: function(response) {
			if (response["stat"] == 0) {
				alert("Tidak dapat menghapus milik orang lain!");
				$("#delete_").modal("hide");
			} else if (response["stat"] == 1) {
				alert(response["msg"]);
				$("#delete_").off("hidden.bs.modal");
				$("#delete_").modal("hide");
				setTimeout(function() {
					$("#delete_").on("hidden.bs.modal", function() {
						var id = $("#delData").data("id_donasi");
						$("#detail_modal").modal("show");
						getDataDetail(id);
					});
				}, 1000);
				if (pagesType == "dashboard") {
					getData();
				} else if (pagesType == "history") {
					getDataHistory();
				}
			} else if (response["stat"] == 2) {
				alert("Gagal menghapus donasi karena donasi telah diambil mitra!");
				$("#delete_").modal("hide");
			}
		},
		error: function(response) {
			alert("ERROR : Tidak dapat menerima data dari server!");
		}
	});
}

//get user profile info
function getSettingsInfo() {
	$.ajax({
		type: "GET",
		url: baseURL + "profile/getSettingsInfo",
		dataType: "json",
		success: function(data) {
			if (data.length) {
				$("#username").val(data[0].username);
				$("#name").val(data[0].nama);
				$("#email").val(data[0].email);
				$("#Alamat").val(data[0].alamat);
				$("#tanggallahir").val(data[0].tanggallahir);
				$("#handphone").val(data[0].handphone);
				$("#jenisKelamin").val(data[0].jeniskelamin);
			} else {
				alert("Data user tidak ditemukan!");
			}
		},
		error: function(data) {
			alert("ERROR : Tidak dapat menerima data dari server!");
		}
	});
}

//Get user history info
function getDataHistory() {
	$.ajax({
		type: "GET",
		url: baseURL + "profile/getDataHistory",
		async: false,
		dataType: "JSON",
		success: function(data) {
			var html = "";
			var judul = "";
			var desc = "";
			if (data.length >= 1) {
				for (var i = 0; i < data.length; i++) {
					var dt = data[i];
					var stat = UrlExists(baseURL + "cdn/img/" + dt.gambar);
					if (stat === false) {
						dt.gambar = "404.jpeg";
					}
					judul = text_truncate(dt.Judul_Donasi, 23, "...");
					desc = text_truncate(dt.informasi_donasi, 100, "...");
					html +=
						'<div class="col-md-4">' +
						'<div class="card " style="margin-bottom: 10%; ">' +
						'<div class="wrapper">' +
						'<img class="card-img-top img-fluid" src="' +
						baseURL +
						"cdn/img/" +
						dt.gambar +
						'" alt="Card image cap">' +
						"</div>" +
						'<div title="' +
						dt.Judul_Donasi +
						'"><h4 class="card-title" style="text-align:center; margin-top:15px; margin-bottom:-10px;">' +
						judul +
						"</h4></div>" +
						'<div class="card-body">' +
						'<div title="click detail for more info"><p class="card-text" style="text-align:justify; margin-bottom:10px;">' +
						desc +
						"</p></div>" +
						'<button class="btn btn-theme-yellow btn-block donasi_detail" data="' +
						dt.id_donasi +
						'">Detail</button>' +
						"</div>" +
						"</div>" +
						"</div>";
				}
				$("#place_data_history").html(html);
			} else {
				if (type == "user") {
					type__ = "donasi";
				}
				html = "<h4>Tidak ada riwayat ber" + type__ + " milik kamu.</h4>";
				$("#donasiState").html(html);
			}
		},
		error: function(data) {
			alert("ERROR : Tidak dapat menerima data dari server!");
		}
	});
}

//ProfileSubmit
function updateProfile(data) {
	$.ajax({
		type: "POST",
		data: data,
		url: baseURL + "Profile/tryUpdateUser",
		dataType: "JSON",
		success: function(response) {
			if (response["error"]) {
				alert(response["msg"]);
			} else {
				alert(response["msg"]);
				getSettingsInfo();
			}
		},
		error: function(response) {
			alert("ERROR : Tidak dapat menerima data dari server!");
		}
	});
}

//AddDonasi
function AddData(postData) {
	$.ajax({
		type: "POST",
		data: postData,
		url: baseURL + "dashboard/addDonasi",
		dataType: "json",
		processData: false,
		contentType: false,
		success: function(response) {
			if (response["error"]) {
				alert(response["msg"]);
			} else {
				alert(response["msg"]);
				$("#add_form")
					.find("#judul_donasi")
					.val(null);
				$("#add_form")
					.find("#jenis_donasi")
					.prop("selectedIndex", 0);
				$("#add_form")
					.find("#jumlah_donasi")
					.val(null);
				$("#add_form")
					.find("#deskripsi_donasi")
					.val(null);
				$("#add_form")
					.find("#input_foto")
					.val("");
				$("#imgAdd").html("");
				$("#add_modal").modal("hide");
				getData();
			}
		},
		error: function(response) {
			alert("ERROR : Tidak dapat menerima data dari server!");
		}
	});
}
