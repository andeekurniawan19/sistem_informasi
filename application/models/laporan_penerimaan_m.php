<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_penerimaan_m extends CI_Model
{
	function __construct() {
		  parent::__construct();
		  $this->load->database();
	}

	function simpan_data_laporan($no_lpb,$tanggal,$no_po,$diterima)
	{
		$sql = "
			INSERT INTO tb_laporan_penerimaan (
				no_lpb,
				tanggal,
				no_po,
				diterima
			) VALUES (
				'$no_lpb',
				'$tanggal',
				'$no_po',
				'$diterima'
			)";
		$this->db->query($sql);
	}

	function simpan_data_laporan_detail($id_laporan_baru,$id_produk,$nama_produk,$keterangan,$kuantitas,$harga,$total,$no_opb)
	{
		$kuantitas 	= str_replace(',', '', $kuantitas);
		$harga 		= str_replace(',', '', $harga);
		$total 		= str_replace(',', '', $total);

		$sql = "
			INSERT INTO tb_laporan_penerimaan_detail (
				id_induk,
				id_produk,
				nama_produk,
				keterangan,
				kuantitas,
				harga,
				total,
				no_opb
			)	VALUES (
				'$id_laporan_baru',
				'$id_produk',
				'$nama_produk',
				'$keterangan',
				'$kuantitas',
				'$harga',
				'$total',
				'$no_opb'
		)";
		$this->db->query($sql);
	}

	function lihat_data_laporan()
	{
		$sql = "
			SELECT * FROM tb_laporan_penerimaan ";

		return $this->db->query($sql)->result();
	}

	function hapus_laporan($id)
	{
		$sql = "DELETE FROM  tb_laporan_penerimaan WHERE id_laporan = '$id' " ;
		$this->db->query($sql);
	}

	function data_laporan_id($id)
	{
		$sql = "SELECT * FROM tb_laporan_penerimaan WHERE id_laporan = '$id' ";
		$query = $this->db->query($sql);
		return $query->row();
	}

	function ubah_data_laporan($id,$no_lpb,$tanggal,$no_po,$diterima)
	{
		$sql = "
			UPDATE tb_laporan_penerimaan SET
				no_lpb  	  = '$no_lpb',
				tanggal 	  = '$tanggal',
				no_po  		  = '$no_po',
				diterima  	  = '$diterima'
			WHERE id_laporan  = '$id'
		";
		$this->db->query($sql);
	}

	function ubah_data_laporan_detail($id,$id_produk,$nama_produk,$keterangan,$kuantitas,$harga,$total,$no_opb)
	{
		$kuantitas 	= str_replace(',', '', $kuantitas);
		$harga 		= str_replace(',', '', $harga);
		$total 		= str_replace(',', '', $total);
		
		$sql = "
			UPDATE tb_laporan_penerimaan_detail SET
				id_produk 	  = '$id_produk',
				nama_produk   = '$nama_produk',
				keterangan    = '$keterangan',
				kuantitas  	  = '$kuantitas',
				harga  	  	  = '$harga',
				total  	  	  = '$total',
				no_opb  	  = '$no_opb'
			WHERE id_laporan  = '$id'
		";
		$this->db->query($sql);
	}

	function get_po_detail($id_purchase)
	{
		$sql = "SELECT * FROM tb_purchase_order WHERE id_purchase = $id_purchase";

		return $this->db->query($sql)->row();
	}

	function get_produk_detail($id_barang){
		
        $sql = " SELECT * FROM master_barang WHERE id_barang = $id_barang  ";

        return $this->db->query($sql)->row();
    }
}
