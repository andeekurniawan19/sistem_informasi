<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Divisi_m extends CI_Model
{
	function __construct() {
		  parent::__construct();
		  $this->load->database();
	}

	function simpan_data_divisi($id_depart,$kode_divisi,$nama_divisi)
	{
		$sql = "
			INSERT INTO master_divisi (
				id_depart,
				kode_divisi,
				nama_divisi
			) VALUES (
				'$id_depart',
				'$kode_divisi',
				'$nama_divisi'
			)";
		$this->db->query($sql);
	}

	function lihat_data_divisi()
	{
		$sql = "
			SELECT id_divisi,nama_depart,kode_divisi,nama_divisi FROM master_divisi INNER JOIN master_departemen ON 'id_depart' = 'id_depart' ";

		return $this->db->query($sql)->result();
	}

	function lihat_data_depart()
	{
		$sql = "
			SELECT * FROM master_departemen ";

		return $this->db->query($sql)->result();
	}

	function hapus_divisi($id)
	{
		$sql = "DELETE FROM  master_divisi WHERE id_divisi = '$id' " ;
		$this->db->query($sql);
	}

	function data_divisi_id($id)
	{
		$sql = "SELECT * FROM master_divisi WHERE id_divisi = '$id' ";
		$query = $this->db->query($sql);
		return $query->row();
	}

	function ubah_data_divisi($id,$kode_divisi_modal,$nama_divisi_modal)
	{
		$sql = "
			UPDATE master_divisi SET
				kode_divisi  = '$kode_divisi_modal',
				nama_divisi  = '$nama_divisi_modal'
			WHERE id_divisi = '$id'
		";
		$this->db->query($sql);
	}
}
