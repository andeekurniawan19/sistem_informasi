<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_order_m extends CI_Model
{
	function __construct() {
		  parent::__construct();
		  $this->load->database();
	}

	function simpan_data_purchase($no_po,$tanggal,$supplier)
	{
		$sql = "
			INSERT INTO tb_purchase_order (
				no_po,
				tanggal,
				supplier
			) VALUES (
				'$no_po',
				'$tanggal',
				'$supplier'
			)";
		$this->db->query($sql);
	}

	function simpan_data_purchase_detail($id_purchase_baru,$id_produk,$nama_produk,$keterangan,$kuantitas,$harga,$total,$no_opb)
	{

		$kuantitas 	= str_replace(',', '', $kuantitas);
		$harga 		= str_replace(',', '', $harga);
		$total 		= str_replace(',', '', $total);

		$sql = "
			INSERT INTO tb_purchase_order_detail (
				id_induk,
				id_produk,
				nama_produk,
				keterangan,
				kuantitas,
				harga,
				total,
				no_opb
			) VALUES (
				'$id_purchase_baru',
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

	function lihat_data_purchase()
	{
		$sql = "
			SELECT * FROM tb_purchase_order ";

		return $this->db->query($sql)->result();
	}

	function hapus_purchase($id)
	{
		$sql = "DELETE FROM  tb_purchase_order WHERE id_purchase = '$id' " ;
		$this->db->query($sql);

		$sql = "DELETE FROM  tb_purchase_order_detail WHERE id_induk = '$id' " ;
		$this->db->query($sql);
	}

	function data_purchase_id($id)
	{
		$sql = "SELECT * FROM tb_purchase_order WHERE id_purchase = '$id' ";
		$query = $this->db->query($sql);
		return $query->row();
	}

	function data_purchase_detail_id($id)
	{
		$sql = "SELECT * FROM tb_purchase_order_detail WHERE id_induk = '$id' ";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function ubah_data_purchase($id,$no_po,$tanggal,$supplier)
	{
		$sql = "
			UPDATE tb_purchase_order SET
				no_po 	 = '$no_po',
				tanggal  = '$tanggal',
				supplier = '$supplier'
			WHERE id_purchase = '$id'
		";
		$this->db->query($sql);
	}

	function ubah_data_purchase_detail($id,$nama_produk,$keterangan,$kuantitas,$harga,$total,$no_opb)
	{
		$kuantitas 	= str_replace(',', '', $kuantitas);
		$harga 		= str_replace(',', '', $harga);
		$total 		= str_replace(',', '', $total);
		
		$sql = "
			UPDATE tb_purchase_order_detail SET
				nama_produk  	= '$nama_produk',
				keterangan  	= '$keterangan',
				kuantitas  		= '$kuantitas',
				harga  			= '$harga',
				total  			= '$total',
				no_opb  		= '$no_opb'
			WHERE id_induk  = '$id '
		";
		$this->db->query($sql);
	}

	function get_supplier_detail($id_supplier)
	{
		$sql = "SELECT * FROM master_supplier WHERE id_supplier = $id_supplier";

		return $this->db->query($sql)->row();
	}

	function get_produk_detail($id_barang)
	{
		$sql = "SELECT * FROM master_barang WHERE id_barang = $id_barang";

		return $this->db->query($sql)->row();
	}

	function get_opb_detail($id_permintaan)
	{
		$sql = "SELECT * FROM tb_permintaan_barang WHERE id_permintaan = $id_permintaan";

		return $this->db->query($sql)->row();
	}
}
