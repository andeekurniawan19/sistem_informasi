<script src="<?php echo base_url(); ?>js/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/js-form.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function(){

	$("#no_po").focus();

	$('#hapus').click(function(){
		$('#popup_hapus').css('display','block');
		$('#popup_hapus').show();
	});

	$('#close_hapus').click(function(){
		$('#popup_hapus').css('display','none');
		$('#popup_hapus').hide();
	});

	$('#batal_hapus').click(function(){
		$('#popup_hapus').css('display','none');
		$('#popup_hapus').hide();
	});

	$("#batal").click(function(){
		$('#kode_barang').val("");
		$('#nama_barang').val("");
		$("#kode_barang").focus();
		$('body,html').animate({
                scrollTop : 0 // Scroll to top of body
        }, 500);
	});

	$('#batal_ubah').click(function(){
		$('#popup_ubah').css('display','none');
		$('#popup_ubah').hide();
	});

	$("#tambah_purchase").click(function(){
		$("#tambah_purchase").fadeOut('slow');
		$("#table_purchase").fadeOut('slow');
		$("#form_purchase").fadeIn('slow');
		$("#tabel_total").fadeIn('slow');
	});

	$("#batal").click(function(){
		$("#tambah_purchase").fadeIn('slow');
		$("#table_purchase").fadeIn('slow');
		$("#form_purchase").fadeOut('slow');
		$("#tabel_total").fadeOut('slow');
	});	
});

function loading(){
	$('#popup_load').css('display','block');
	$('#popup_load').show();
}

function hapus_toas(){
	toastr.options = {
      "closeButton": true,
      "debug": false,
      "positionClass": "toast-bottom-right",
      "onclick": null,
      "showDuration": "5000",
      "hideDuration": "5000",
      "timeOut": "5000",
      "extendedTimeOut": "5000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
    toastr.success("Data Berhasil Dihapus!", "Terhapus");
}

function hapus_purchase(id)
{
	$('#popup_hapus').css('display','block');
	$('#popup_hapus').show();

		$.ajax({
		url : '<?php echo base_url(); ?>purchase_order_c/data_purchase_id',
		data : {id:id},
		type : "POST",
		dataType : "json",
		async : false,
		success : function(row){
			$('#id_hapus').val(id);
			$('#msg').html('Apakah <b>'+row['no_po']+'</b> ini ingin dihapus ?');
		}
	});
}

function ubah_data_purchase(id)
{
		$("#tambah_purchase").fadeOut('slow');
		$("#table_purchase").fadeOut('slow');
		$("#form_purchase").fadeIn('slow');
		$("#tabel_total").fadeIn('slow');
	
		$.ajax({
			url : '<?php echo base_url(); ?>purchase_order_c/data_purchase_id',
			data : {id:id},
			type : "POST",
			dataType : "json",
			async : false,
			success : function(row){
				$('#id_purchase').val(id);
				$('#no_po').val(row['no_po']);
				$('#tanggal').val(row['tanggal']);
				$('#supplier').val(row['supplier']);
				
				detail_purchase(id);
			}
		});
}

function detail_purchase(id)
{
	$.ajax({
		url : '<?php echo base_url(); ?>purchase_order_c/data_purchase_detail_id',
		data : {id:id},
		type : "POST",
		dataType : "json",
		async : false,
		success : function(result){
			var isi = '';
			var no = 0;
			$('#jml_tr').val(result.length);
			$.each(result,function(i,res){
                no++;

                isi+= '<tr id="tr_'+no+'">'+
						'<td align="center" style="vertical-align:middle;">'+
							'<div class="span12">'+
								'<div class="control-group">'+
									'<div class="controls">'+
										'<div class="input-append" style="width: 100%;">'+
											'<input readonly value="'+res.nama_produk+'" type="text" id="nama_produk_'+no+'" class="form-control"  name="nama_produk[]" required style="background:#FFF; width: 60%; font-size: 13px; float: left;">'+
											'<button onclick="show_pop_produk('+no+');" type="button" class="btn" style="width: 30%;">Cari</button>'+
											'<input type="hidden" id="id_produk_'+no+'" name="produk[]" readonly  style="background:#FFF;" value="'+res.id_produk+'">'+
										'</div>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<div class="controls">'+
								'<input style="font-size: 10px; text-align:left;" type="text" class="form-control" value="'+res.keterangan+'" name="keterangan[]" id="keterangan_'+no+'">'+
							'</div>'+
						'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<div class="controls">'+
								'<input onkeyup="hitung_total('+no+');" style="font-size: 10px; text-align:left;" type="text" class="form-control" value="'+res.kuantitas+'" name="kuantitas[]" id="kuantitas_'+no+'">'+
							'</div>'+
						'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<div class="controls">'+
								'<input style="font-size: 10px; text-align:left;" type="text" class="form-control" value="'+res.harga+'" name="harga[]" id="harga_'+no+'">'+
							'</div>'+
						'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<div class="controls">'+
								'<input style="font-size: 10px; text-align:left;" type="text" class="form-control" value="'+res.total+'" name="total[]" id="total_'+no+'">'+
							'</div>'+
						'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<div class="controls">'+
								'<button style="width: 100%;" onclick="Spesifikasi();" type="button" class="btn btn-warning"> Spesifikasi </button>'+
							'</div>'+
						'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<div class="controls">'+
								'<input style="font-size: 10px; text-align:left;" type="text" class="form-control" value="'+res.no_opb+'" name="no_opb[]" id="no_opb_'+no+'">'+
							'</div>'+
						'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<div class="controls">'+
								'<button style="width: 100%;" onclick="hapus_row_pertama('+no+');" type="button" class="btn btn-danger"> Hapus </button>'+
							'</div>'+
						'</td>'+
					'</tr>';
	            });
			$('#data_item').html(isi);
		}
	});

	hitung_total_semua();
}

function simpan_add_produk(){
	var nama_produk = $('#nama_produk').val();
	var keterangan 	= $('#keterangan').val();
	var kuantitas   = $('#kuantitas').val();
	var harga       = $('#harga').val();
	var total       = $('#total').val();
	var no_spb      = $('#no_opb').val();

	if(nama_produk == ""){
		alert("Nama Produk Harus di isi.");
	} else if(keterangan == ""){
		alert("Nama Produk Harus di isi.");
	} else if(kuantitas == ""){
		alert("Satuan Produk Harus di isi.");
	} else if(harga == ""){
		alert("Harga Produk Harus di isi.");
	} else if(total == ""){
		alert("total Produk Harus di isi.");
	}else if(no_opb == ""){
	} else {
		$.ajax({
			url : '<?php echo base_url(); ?>purchase_order_c/simpan',
			data : {
				nama_produk:nama_produk,
				keterangan:keterangan,
				kuantitas:kuantitas,
				harga:harga,
				total:total,
				no_spb:no_opb,
			},
			type : "POST",
			dataType : "json",
		});
	}

}

function berhasil(){
	toastr.options = {
      "closeButton": true,
      "debug": false,
      "positionClass": "toast-bottom-right",
      "onclick": null,
      "showDuration": "5000",
      "hideDuration": "5000",
      "timeOut": "5000",
      "extendedTimeOut": "5000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
    toastr.success("Data Berhasil Disimpan!", "Berhasil");
}

function tambah_data()
{
	var jml_tr = $('#jml_tr').val();
	var i = parseFloat(jml_tr)+1;

	var isi = '<tr id="tr_'+i+'">'+
				'<td align="center" style="vertical-align:middle;">'+
					'<div class="span12">'+
						'<div class="control-group">'+
							'<div class="controls">'+
								'<div class="input-append" style="width: 100%;">'+
									'<input readonly type="text" id="nama_produk_'+i+'" class="form-control"  name="nama_produk[]" required style="background:#FFF; width: 60%; font-size: 13px; float: left;">'+
									'<button onclick="show_pop_produk('+i+');" type="button" class="btn" style="width: 30%;">Cari</button>'+
									'<input type="hidden" id="id_produk_'+i+'" name="produk[]" readonly style="background:#FFF;" value="0">'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</td>'+
				'<td align="center" style="vertical-align:middle;">'+
					'<div class="controls">'+
						'<input style="font-size: 10px; text-align:left;" type="text" class="form-control" value="" name="keterangan[]" id="keterangan_'+i+'">'+
					'</div>'+
				'</td>'+
				'<td align="center" style="vertical-align:middle;">'+
					'<div class="controls">'+
						'<input onkeyup="hitung_total('+i+');" style="font-size: 10px; text-align:left;" type="text" class="form-control" value="" name="kuantitas[]" id="kuantitas_'+i+'">'+
					'</div>'+
				'</td>'+
				'<td align="center" style="vertical-align:middle;">'+
					'<div class="controls">'+
						'<input style="font-size: 10px; text-align:left;" type="text" class="form-control" value="" name="harga[]" id="harga_'+i+'">'+
					'</div>'+
				'</td>'+
				'<td align="center" style="vertical-align:middle;">'+
					'<div class="controls">'+
						'<input style="font-size: 10px; text-align:left;" type="text" class="form-control" value="" name="total[]" id="total_'+i+'">'+
					'</div>'+
				'</td>'+
				'<td align="center" style="vertical-align:middle;">'+
					'<div class="controls">'+
						'<button style="width: 100%;" onclick="Spesifikasi();" type="button" class="btn btn-warning"> Spesifikasi </button>'+
					'</div>'+
				'</td>'+
				'<td align="center" style="vertical-align:middle;">'+
					'<div class="controls">'+
						'<input style="font-size: 10px; text-align:left;" type="text" class="form-control" value="" name="no_opb[]" id="no_opb_'+i+'">'+
					'</div>'+
				'</td>'+
				'<td align="center" style="vertical-align:middle;">'+
					'<div class="controls">'+
						'<button style="width: 100%;" onclick="hapus_row_pertama('+i+');" type="button" class="btn btn-danger"> Hapus </button>'+
					'</div>'+
				'</td>'+
			'</tr>';

	$('#data_item').append(isi);
	$('#jml_tr').val(i);
}

function hapus_row_pertama(i){
	$('#tr_'+i).remove();
}

function show_pop_supplier(no){
	$('#popup_koang').remove();
	get_popup_supplier();
    ajax_supplier(no);
}

function get_popup_supplier(){
    var base_url = '<?php echo base_url(); ?>';
    var $isi = '<div id="popup_koang">'+
                '<div class="window_koang">'+
                '    <a href="javascript:void(0);"><img src="'+base_url+'ico/cancel.gif" id="pojok_koang"></a>'+
                '    <div class="panel-body">'+
                '    <input style="width: 95%;" type="text" name="search_koang_pro" id="search_koang_pro" class="form-control" value="" placeholder="Cari Supplier...">'+
                '    <div class="table-responsive">'+
                '            <table class="table table-hover2" id="tes5">'+
                '                <thead>'+
                '                    <tr>'+
                '                        <th>NO</th>'+
                '                        <th style="white-space:nowrap;"> Nama Supplier </th>'+
                '                        <th style="white-space:nowrap;"> Alamat </th>'+
                '                    </tr>'+
                '                </thead>'+
                '                <tbody>'+
            
                '                </tbody>'+
                '            </table>'+
                '        </div>'+
                '    </div>'+
                '</div>'+
            '</div>';
    $('body').append($isi);

    $('#pojok_koang').click(function(){
        $('#popup_koang').css('display','none');
        $('#popup_koang').hide();
    });

    $('#popup_koang').css('display','block');
    $('#popup_koang').show();
}

function ajax_supplier(id_form){
    var keyword = $('#search_koang_pro').val();
    $.ajax({
        url : '<?php echo base_url(); ?>purchase_order_c/get_supplier_popup',
        type : "POST",
        dataType : "json",
        data : {keyword : keyword},
        success : function(result){
            var isine = '';
            var no = 0;
            var tipe_data = "";
            $.each(result,function(i,res){
                no++;

                isine += '<tr onclick="get_supplier_detail(\'' +res.id_supplier+ '\',\'' +id_form+ '\');" style="cursor:pointer;">'+
                            '<td text-align="center">'+no+'</td>'+
                            '<td text-align="center">'+res.nama_supplier+'</td>'+
                            '<td text-align="left">'+res.alamat_supplier+'</td>'+
                        '</tr>';
            });

            if(result.length == 0){
            	isine = "<tr><td colspan='3' style='text-align:center'><b style='font-size: 15px;'> Data tidak tersedia </b></td></tr>";
            }

            $('#tes5 tbody').html(isine); 
            $('#search_koang_pro').off('keyup').keyup(function(){
                ajax_supplier(id_form);
            });
        }
    });
}

function get_supplier_detail(id, no_form)
{
	var id_supplier = id ; 

	$.ajax({
		url 	 : '<?php echo base_url(); ?>purchase_order_c/get_supplier_detail',
		data 	 : {id_supplier:id},
		type 	 : "GET",
		dataType : "json",

		success  : function(result){
			$('#id_supplier').val(result.id_supplier);
			$('#supplier').val(result.nama_supplier);

			$('#search_koang_pro').val("");
		    $('#popup_koang').css('display','none');
		    $('#popup_koang').hide()
		} 
	});
}

function show_pop_produk(no){
	$('#popup_koang').remove();
	get_popup_produk();
    ajax_produk(no);
}

function get_popup_produk(){
    var base_url = '<?php echo base_url(); ?>';
    var $isi = '<div id="popup_koang">'+
                '<div class="window_koang">'+
                '    <a href="javascript:void(0);"><img src="'+base_url+'ico/cancel.gif" id="pojok_koang"></a>'+
                '    <div class="panel-body">'+
                '    <input style="width: 95%;" type="text" name="search_koang_pro" id="search_koang_pro" class="form-control" value="" placeholder="Cari Produk...">'+
                '    <div class="table-responsive">'+
                '            <table class="table table-hover2" id="tes5">'+
                '                <thead>'+
                '                    <tr>'+
                '                        <th>NO</th>'+
                '						 <th style="white-space:nowrap;"> Kode Produk </th>'+
                '                        <th style="white-space:nowrap;"> Nama Produk </th>'+
                '                        <th style="white-space:nowrap;"> Harga </th>'+
                '                    </tr>'+
                '                </thead>'+
                '                <tbody>'+
            
                '                </tbody>'+
                '            </table>'+
                '        </div>'+
                '    </div>'+
                '</div>'+
            '</div>';
    $('body').append($isi);

    $('#pojok_koang').click(function(){
        $('#popup_koang').css('display','none');
        $('#popup_koang').hide();
    });

    $('#popup_koang').css('display','block');
    $('#popup_koang').show();
}

function ajax_produk(id_form){
    var keyword = $('#search_koang_pro').val();
    $.ajax({
        url : '<?php echo base_url(); ?>purchase_order_c/get_produk_popup',
        type : "POST",
        dataType : "json",
        data : {keyword : keyword},
        success : function(result){
            var isine = '';
            var no = 0;
            var tipe_data = "";
            $.each(result,function(i,res){
                no++;

                isine += '<tr onclick="get_produk_detail(\'' +res.id_barang+ '\',\'' +id_form+ '\');" style="cursor:pointer;">'+
                            '<td text-align="center">'+no+'</td>'+
                            '<td text-align="center">'+res.kode_barang+'</td>'+
                            '<td text-align="center">'+res.nama_barang+'</td>'+
                            '<td text-align="left">Rp '+NumberToMoney(res.harga_beli).split('.00').join('')+'</td>'+
                        '</tr>';
            });

            if(result.length == 0){
            	isine = "<tr><td colspan='4' style='text-align:center'><b style='font-size: 15px;'> Data tidak tersedia </b></td></tr>";
            }

            $('#tes5 tbody').html(isine); 
            $('#search_koang_pro').off('keyup').keyup(function(){
                ajax_produk(id_form);
            });
        }
    });
}

function get_produk_detail(id, no_form)
{
	var id_barang = id ; 

	$.ajax({
		url 	 : '<?php echo base_url(); ?>purchase_order_c/get_produk_detail',
		data 	 : {id_barang:id},
		type 	 : "GET",
		dataType : "json",

		success  : function(result){
			$('#kuantitas_'+no_form).val('');
			$('#id_produk_'+no_form).val(result.id_barang);
			$('#nama_produk_'+no_form).val(result.nama_barang);
			$('#kuantitas_'+no_form).focus();
			$('#harga_'+no_form).val(NumberToMoney(result.harga_beli).split('.00').join(''));
			$('#jumlah_'+no_form).val(NumberToMoney(result.harga_beli*1).split('.00').join(''));

			$('#search_koang_pro').val("");
		    $('#popup_koang').css('display','none');
		    $('#popup_koang').hide()
		} 
	});
}

function show_pop_opb(no){
	$('#popup_koang').remove();
	get_popup_opb();
    ajax_opb(no);
}

function get_popup_opb(){
    var base_url = '<?php echo base_url(); ?>';
    var $isi = '<div id="popup_koang">'+
                '<div class="window_koang">'+
                '    <a href="javascript:void(0);"><img src="'+base_url+'ico/cancel.gif" id="pojok_koang"></a>'+
                '    <div class="panel-body">'+
                '    <input style="width: 95%;" type="text" name="search_koang_pro" id="search_koang_pro" class="form-control" value="" placeholder="Cari No. SPB...">'+
                '    <div class="table-responsive">'+
                '    <input type="hidden" name="id_permintaan" id="id_permintaan">'+
                '            <table class="table table-hover2" id="tes5">'+
                '                <thead>'+
                '                    <tr>'+
                '                        <th>Tanggal</th>'+
                '                        <th style="white-space:nowrap;"> No SPB </th>'+
                '                        <th style="white-space:nowrap;"> Uraian </th>'+
                '                    </tr>'+
                '                </thead>'+
                '                <tbody>'+
            
                '                </tbody>'+
                '            </table>'+
                '        </div>'+
                '    </div>'+
                '</div>'+
            '</div>';
    $('body').append($isi);

    $('#pojok_koang').click(function(){
        $('#popup_koang').css('display','none');
        $('#popup_koang').hide();
    });

    $('#popup_koang').css('display','block');
    $('#popup_koang').show();
}

function ajax_opb(id_form){
    var keyword = $('#search_koang_pro').val();
    $.ajax({
        url : '<?php echo base_url(); ?>purchase_order_c/get_opb_popup',
        type : "POST",
        dataType : "json",
        data : {keyword : keyword},
        success : function(result){
            var isine = '';
            var no = 0;
            var tipe_data = "";
            $.each(result,function(i,res){
                no++;

                isine += '<tr onclick="get_opb_detail(\'' +res.id_order+ '\',\'' +id_form+ '\');" style="cursor:pointer;">'+
                            '<td text-align="center">'+res.tanggal+'</td>'+
                            '<td text-align="center">'+res.no_opb+'</td>'+
                            '<td text-align="left">'+res.uraian+'</td>'+
                        '</tr>';
            });

            if(result.length == 0){
            	isine = "<tr><td colspan='3' style='text-align:center'><b style='font-size: 15px;'> Data tidak tersedia </b></td></tr>";
            }

            $('#tes5 tbody').html(isine); 
            $('#search_koang_pro').off('keyup').keyup(function(){
                ajax_opb(id_form);
            });
        }
    });
}

function get_opb_detail(id)
{
	$.ajax({
		url : '<?php echo base_url(); ?>purchase_order_c/get_opb_detail',
		data : {id:id},
		type : "POST",
		dataType : "json",
		async : false,
		success : function(result){
			var isi = '';
			var i = 0;
			$.each(result,function(ii,res){
				i++;

				isi += 
			'<tr id="tr_'+i+'">'+
				'<td align="center" style="vertical-align:middle;">'+
					'<div class="span12">'+
						'<div class="control-group">'+
							'<div class="controls">'+
								'<div class="input-append" style="width: 100%;">'+
									'<input readonly type="text" id="nama_produk_'+i+'" value="'+res.nama_produk+'" class="form-control"  name="nama_produk[]" required style="background:#FFF; width: 60%; font-size: 13px; float: left;">'+
									'<button onclick="show_pop_produk('+i+');" type="button" class="btn" style="width: 30%;">Cari</button>'+
									'<input type="hidden" id="id_produk_'+i+'" name="produk[]" readonly style="background:#FFF;" value="'+res.id_produk+'">'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</td>'+
				'<td align="center" style="vertical-align:middle;">'+
					'<div class="controls">'+
						'<input style="font-size: 10px; text-align:left;" type="text" class="form-control" value="'+res.keterangan+'" name="keterangan[]" id="keterangan_'+i+'">'+
					'</div>'+
				'</td>'+
				'<td align="center" style="vertical-align:middle;">'+
					'<div class="controls">'+
						'<input onkeyup="hitung_total('+i+');" style="font-size: 10px; text-align:left;" type="text" class="form-control" value="'+res.kuantitas+'" name="kuantitas[]" id="kuantitas_'+i+'">'+
					'</div>'+
				'</td>'+
				'<td align="center" style="vertical-align:middle;">'+
					'<div class="controls">'+
						'<input style="font-size: 10px; text-align:left;" type="text" class="form-control" value="'+res.harga+'" name="harga[]" id="harga_'+i+'">'+
					'</div>'+
				'</td>'+
				'<td align="center" style="vertical-align:middle;">'+
					'<div class="controls">'+
						'<input style="font-size: 10px; text-align:left;" type="text" class="form-control" value="'+res.total+'" name="total[]" id="total_'+i+'">'+
					'</div>'+
				'</td>'+
				'<td align="center" style="vertical-align:middle;">'+
					'<div class="controls">'+
						'<button style="width: 100%;" onclick="Spesifikasi();" type="button" class="btn btn-warning"> Spesifikasi </button>'+
					'</div>'+
				'</td>'+
				'<td align="center" style="vertical-align:middle;">'+
					'<div class="controls">'+
						'<input style="font-size: 10px; text-align:left;" type="text" class="form-control" value="'+res.no_opb+'" name="no_opb[]" id="no_opb_'+i+'">'+
					'</div>'+
				'</td>'+
				'<td align="center" style="vertical-align:middle;">'+
					'<div class="controls">'+
						'<button style="width: 100%;" onclick="hapus_row_pertama('+i+');" type="button" class="btn btn-danger"> Hapus </button>'+
					'</div>'+
				'</td>'+
			'</tr>';
			});
			$('#data_item').html(isi);
			$('#jml_tr').val(i);

			$('#search_koang_pro').val("");
		    $('#popup_koang').css('display','none');
		    $('#popup_koang').hide()

		}
	});
	hitung_total_semua();
}

function hitung_total(id){

	var kuantitas = $('#kuantitas_'+id).val();
	kuantitas = kuantitas.split(',').join('');

	if(kuantitas == ""){
		kuantitas = 0;
	}

	var harga = $('#harga_'+id).val();
	harga = harga.split(',').join('');

	if(harga == "" || harga== null){
		harga = 0;
	}

	var total = parseFloat(kuantitas) * parseFloat(harga);

	var pajak = 0;

	total = total + pajak;

	$('#total_'+id).val(acc_format(total, "").split('.00').join('') );

	hitung_total_semua();
}

function hitung_total_semua(){
	var sum = 0;
	var pajak_prosen = 0
	$("input[name='total[]']").each(function(idx, elm) {
		var tot = elm.value.split(',').join('');
		if(tot > 0){
    		sum += parseFloat(tot);
		}
    });

    $('#subtotal_txt').html('Rp. '+acc_format(sum, ""));
}

function acc_format(n, currency) {
	return currency + " " + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}

</script>

<style type="text/css">

#data_item tr td input{
	font-size: 15px !important;
}

</style>

<form role="form" action="<?php echo $url_simpan; ?>" method="post">
<input type="hidden" id="jml_tr" value="1">
<input type="hidden" id="id_purchase" name="id_purchase">

<div class="row" id="form_purchase" style="display:none; ">
	<div class="col-md-12 col-sm-6">
		<!-- BEGIN PORTLET-->
		<div class="portlet light ">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-bar-chart font-green-sharp hide"></i>
					<span class="caption-subject font-green-sharp bold uppercase">Form Purchase Order</span>
				</div>
				<div class="actions">
					<div class="btn-group btn-group-devided" data-toggle="buttons">
					</div>
				</div>
			</div>

			<div class="portlet-body">	
				<div class="row" style="padding-top: 15px; padding-bottom: 15px;">
					<div class="col-md-12">
						<div class="col-md-3">
							<label class="control-label"><b style="font-size:14px;">No PO</b></label>
							<div class="input-group" style="width: 100%;">
								<input type="text" class="form-control" id="no_po" name="no_po">
							</div>
						</div>

						<div class="col-md-3">
							<label class="control-label"><b style="font-size:14px;">Tanggal</b></label>
							<div class="input-group" style="width: 100%;">
								<input type="text" class="form-control" name="tanggal" id="tanggal" value="<?=date('d-m-Y');?>" readonly required>
								<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>
							</div>
						</div>

						<div class="col-md-3">
							<label class="control-label"><b style="font-size:14px;">Supplier</b></label>
							<div class="input-group" style="width: 100%;">
								<input type="text"  rows="1" id="supplier" name="supplier" class="form-control">
								<span class="input-group-btn"><button onclick="show_pop_supplier();" class="btn green" type="button"><i class="fa fa-search"> Cari </i></button></span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row" style="padding-top: 15px; padding-bottom: 15px;">
				<div class="portlet-body flip-scroll">
					<table class="table table-bordered table-striped table-condensed flip-content">
						<thead class="flip-content">
							<tr>
								<th style="text-align: center; width: 20%;">Produk / Item</th>
								<th style="text-align: center; widows: 30%;">Keterangan</th>
								<th style="text-align: center;">Kuantitas</th>
								<th style="text-align: center;">Harga</th>
								<th style="text-align: center;">Total</th>
								<th style="text-align: center;">Spesifikasi</th>
								<th style="text-align: center;">No. OPB</th>
								<th style="text-align: center;">Aksi</th>
							</tr>
						</thead>
						<tbody id="data_item" style="background: #26a69a;">
							<tr id="tr_1">
								<td align="center" style="vertical-align:middle;">
									<div class="span12">
										<div class="control-group">
											<div class="controls">
												<div class="input-append" style="width: 100%;">
													<input readonly type="text" id="nama_produk_1" class="form-control"  name="nama_produk[]" required style="background:#FFF; width: 60%; font-size: 13px; float: left;">
													<button onclick="show_pop_produk(1);" type="button" class="btn" style="width: 30%;">Cari</button>
													<input type="hidden" id="id_produk_1" name="produk[]" readonly style="background:#FFF;" value="0">
												</div>
											</div>
										</div>
									</div>
								</td>
								<td align="center" style="vertical-align:middle;">
									<div class="controls">
										<input style="font-size: 10px; text-align:left;" type="text" class="form-control" value="" name="keterangan[]" id="keterangan_1">
									</div>
								</td>
								<td align="center" style="vertical-align:middle;">
									<div class="controls">
										<input onkeyup="hitung_total(1);" style="font-size: 10px; text-align:left;" type="text" class="form-control" value="" name="kuantitas[]" id="kuantitas_1">
									</div>
								</td>
								<td align="center" style="vertical-align:middle;">
									<div class="controls">
										<input style="font-size: 10px; text-align:left;" type="text" class="form-control" value="" name="harga[]" id="harga_1">
									</div>
								</td>
								<td align="center" style="vertical-align:middle;">
									<div class="controls">
										<input style="font-size: 10px; text-align:left;" type="text" class="form-control" value="" name="total[]" id="total_1">
									</div>
								</td>
								<td align="center" style="vertical-align:middle;">
									<div class="controls">
										<button style="width: 100%;" onclick="spesifikasi();" type="button" class="btn btn-warning"> Spesifikasi </button>
									</div>
								</td>
								<td align="center" style="vertical-align:middle;">
									<div class="controls">
										<input style="font-size: 10px; text-align:left;" type="text" class="form-control" value="" name="no_opb[]" id="no_opb_1">
									</div>
								</td>
								<td align="center" style="vertical-align:middle;">
									<div class="controls">
										<button style="width: 100%;" onclick="hapus_row_pertama();" type="button" class="btn btn-danger"> Hapus </button>
									</div>
								</td>
							</tr>
						</tbody>
					</table>

					<button style="margin-bottom: 15px; background: #26a69a;" onclick="tambah_data();" type="button" class="btn btn-info"><i class="icon-plus"></i> Tambah Baris Data </button>
					<button style="margin-bottom: 15px; background: #f47a42;" onclick="show_pop_opb(1);" type="button" class="btn btn-info"><i class="icon-plus"></i> Include OPB </button>

				</div>
			</div>

		</div>
	</div>
</div>

<div class="row" id="tabel_total" style="display:none; ">
	<div class="col-md-12 col-sm-6">
		<!-- BEGIN PORTLET-->
		<div class="portlet light ">
			<div class="portlet-body">
				<div class="row" style="padding-top: 15px;">
					<div class="col-md-12">
						<div class="col-md-3">
							<div style="margin-bottom: 15px;" class="span3">
								<h4 class="control-label"> Sub Total :</h4> 
							</div>
						</div>

						<div class="col-md-3">
							<div style="margin-bottom: 15px;" class="span4">
								<h4 id="subtotal_txt" class="control-label"> Rp. 0.00 </h4> 
							</div>
						</div>
					</div>
				</div>

				<div class="row" style="padding-top: 35px; padding-bottom: 15px;">
					<div class="col-md-12">
						<div class="col-md-offset-2 col-md-10">
							<button type="submit" class="btn blue">Simpan</button>
							<button type="button" id="batal" class="btn red">Batal Dan Kembali</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END PORTLET-->
	</div>
</div>
</form>


<button id="tambah_purchase" class="btn green">
Tambah Purchase Order <i class="fa fa-plus"></i>
</button>
</br>
</br>

<div class="row" id="table_purchase" style="display:block; ">
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet box green">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i>Table Purchase Order
				</div>
				<div class="tools">
					<a href="javascript:;" class="collapse">
					</a>
					<a href="#portlet-config" data-toggle="modal" class="config">
					</a>
					<a href="javascript:;" class="reload">
					</a>
					<a href="javascript:;" class="remove">
					</a>
				</div>		
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
				<thead>
				<tr>
					<th style="text-align:center;"> No</th>
					<th style="text-align:center;"> No PO</th>
					<th style="text-align:center;"> Supplier</th>
					<th style="text-align:center;"> Aksi </th>
				</tr>
				</thead>
				<tbody>
					<?php 
					$no = 0 ;
					foreach ($lihat_data as $value) {
						$no++;
					?>
				<tr>
					<td style="text-align:center; vertical-align:"><?php echo $no; ?></td>
					<td style="text-align:center; vertical-align:"><?php echo $value->no_po; ?></td>
					<td style="text-align:center; vertical-align:"><?php echo $value->supplier; ?></td>
					<td style="text-align:center; vertical-align: middle;">
						<a class="btn default btn-xs purple" id="ubah" onclick="ubah_data_purchase(<?php echo $value->id_purchase?>);"><i class="fa fa-edit"></i> Ubah </a>
						<a class="btn default btn-xs red" id="hapus" onclick="hapus_purchase(<?php echo $value->id_purchase?>);"><i class="fa fa-trash-o"></i> Hapus </a>
					</td>
				</tr>
					<?php 
						}
					?>
				</tbody>
				</table>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>

<div id="popup_ubah">
	<div class="window_ubah">
		<div class="tab-content">
			<div id="tab_0" class="tab-pane active">
				<div class="portlet box green">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-pencil"></i>Ubah Purchase Order
						</div>
					</div>

					<div class="portlet-body form">
						<!-- BEGIN FORM-->
						<div class="portlet-body form">
					<form role="form" class="form-horizontal" method="post" action="<?php echo $url_ubah;?>" enctype="multipart/form-data">
						<div class="form-body">
							<input type="hidden" name="id_purchase_modal" id="id_purchase_modal">

							<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label" for="form_control_1">No PO</label>
							<div class="col-md-4">
								<input type="text" class="form-control" id="no_po_modal" name="no_po_modal" >
								<div class="form-control-focus">
								</div>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label" for="form_control_1">Tanggal</label>
							<div class="col-md-3">
								<div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy">
									<input type="text" class="form-control" name="tanggal_modal" id="tanggal_modal" >
									<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label" for="form_control_1">Supplier</label>
							<div class="col-md-4">
								<input type="text" class="form-control" id="supplier_modal" name="supplier_modal" >
								<div class="form-control-focus">
								</div>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label" for="form_control_1">Keterangan</label>
							<div class="col-md-4">
								<input type="text" class="form-control" id="keterangan_modal" name="keterangan_modal" >
								<div class="form-control-focus">
								</div>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label" for="form_control_1">QTY</label>
							<div class="col-md-4">
								<input type="text" class="form-control" id="qty_modal" name="qty_modal" >
								<div class="form-control-focus">
								</div>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label" for="form_control_1">Harga</label>
								<div class="col-md-4 input-group left-addon">
									<span class="input-group-addon">Rp.</span>
									<input type="text" onkeyup="FormatCurrency(this);" class="form-control" id="harga_modal" name="harga_modal" >
									<div class="form-control-focus">
								</div>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label" for="form_control_1">Total</label>
								<div class="col-md-4 input-group left-addon">
									<span class="input-group-addon">Rp.</span>
									<input type="text" onkeyup="FormatCurrency(this);" class="form-control" id="total_modal" name="total_modal" >
									<div class="form-control-focus">
								</div>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label" for="form_control_1">No OPB</label>
							<div class="col-md-4">
								<input type="text" class="form-control" id="no_opb_modal" name="no_opb_modal" >
								<div class="form-control-focus">
								</div>
							</div>
						</div>

						<div class="form-actions">
							<div class="row">
								<div class="col-md-offset-3 col-md-10">
									<button type="submit" class="btn blue">Simpan</button>
									<button type="button" id="batal_ubah" class="btn default">Batal</button>
								</div>
							</div>
						</div>
				</div>
			</form>
		</div>
										<!-- END FORM-->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="popup_hapus">
	<div class="window_hapus">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<button class="bootbox-close-button close" type="button" id="close_hapus">×</button>
					<div class="bootbox-body" id="msg"></div>
				</div>
				<div class="modal-footer">
					<form action="<?php echo $url_hapus; ?>" method="post">
						<input type="hidden" name="id_hapus" id="id_hapus" value="">
						<input type="button" class="btn btn-default" data-bb-handler="cancel" value="Batal" id="batal_hapus">
						<input type="submit" class="btn btn-primary" data-bb-handler="confirm" value="Hapus" id="hapus" onclick="loading();">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	<?php
		if($this->session->flashdata('sukses')){
	?>
		berhasil();
	<?php 
		}elseif($this->session->flashdata('hapus')){
	?>
		hapus_toas();
	<?php
		}
	?>
});
</script>