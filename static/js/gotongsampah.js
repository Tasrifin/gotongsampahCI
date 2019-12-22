$.holdReady(true);
$.getScript(baseURL + "static/js/function.js", function() {
	console.log("Load library...");
	$.holdReady(false);
});

$(document).ready(function() {
	//fetch data
	console.log("Document ready, library has been loaded!");

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
		checkData('AddData',postData,'function');		
	});
	
});
