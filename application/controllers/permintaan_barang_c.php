<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permintaan_barang_c extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('permintaan_barang_m','permintaan');
		$data = $this->session->userdata('sign_in');
        $nama = $data['id'];

        if($nama == "" || $nama == null){
        	redirect('login_c','refresh');
        }
	}

	public function index()
	{
		$data = array(
				'title' 	      => 'Permintaan Barang',
				'page'  	      => 'permintaan_barang_v',
				'sub_menu' 	      => 'pembelian',
				'sub_menu1'	      => 'permintaan barang',
				'menu' 	   	      => 'penjualan',
				'menu2'		      => 'permintaan',
				'lihat_data'      => $this->permintaan->lihat_data_permintaan(),
				'lihat_barang'    => $this->permintaan->lihat_data_barang(),
				'url_simpan' 	  => base_url().'permintaan_barang_c/simpan',
				'url_hapus'  	  => base_url().'permintaan_barang_c/hapus',
			);
		
		$this->load->view('home_v',$data);
	}

	function simpan()
	{
		$id_permintaan     = $this->input->post('id_permintaan');
		if ($id_permintaan == '') {

			$no_spb 	  = $this->input->post('no_spb');
			$tanggal 	  = $this->input->post('tanggal');
			$uraian 	  = $this->input->post('uraian');

			$this->permintaan->simpan_data_barang($no_spb,$tanggal,$uraian);

			$id_permintaan_baru = $this->db->insert_id();
			$id_produk 	    	= $this->input->post('produk');
			$nama_produk    	= $this->input->post('nama_produk');
			$keterangan     	= $this->input->post('keterangan');
			$kuantitas      	= $this->input->post('kuantitas');
			$satuan 	    	= $this->input->post('satuan');
			$harga 		    	= $this->input->post('harga');
			$jumlah 	    	= $this->input->post('jumlah');

			foreach ($nama_produk as $key => $val) {
					 $this->permintaan->simpan_data_barang_detail($id_permintaan_baru,$id_produk,$val,$keterangan[$key],$kuantitas[$key],$satuan[$key],$harga[$key],$jumlah[$key]);
			}
			$this->session->set_flashdata('sukses','1');
			redirect('permintaan_barang_c');
		
		}else{

			$id 		  = $this->input->post('id_permintaan');
			$no_spb 	  = $this->input->post('no_spb');
			$tanggal 	  = $this->input->post('tanggal');
			$uraian 	  = $this->input->post('uraian');

			$this->permintaan->ubah_data_permintaan($id,$no_spb,$tanggal,$uraian);

			$nama_produk  		 = $this->input->post('nama_produk');
			$keterangan   		 = $this->input->post('keterangan');
			$kuantitas    		 = $this->input->post('kuantitas');
			$satuan 	  		 = $this->input->post('satuan');
			$harga 		  		 = $this->input->post('harga');
			$jumlah 	  		 = $this->input->post('jumlah');

			foreach ($nama_produk as $key => $val) {
				$this->permintaan->ubah_data_permintaan_detail($id,$val,$keterangan[$key],$kuantitas[$key],$satuan[$key],$harga[$key],$jumlah[$key]);
			}
			$this->session->set_flashdata('sukses','1');
			redirect('permintaan_barang_c');
		}
	}

	function hapus()
	{
		$id = $this->input->post('id_hapus');
		$this->permintaan->hapus_permintaan($id);
		$this->session->set_flashdata('hapus','1');
		redirect('permintaan_barang_c');
	}

	function data_permintaan_id()
	{
		$id = $this->input->post('id');
		$data = $this->permintaan->data_permintaan_id($id);
		echo json_encode($data);
	}

	function data_permintaan_detail_id()
	{
		$id = $this->input->post('id');
		$data = $this->permintaan->data_permintaan_detail_id($id);
		echo json_encode($data);	
	}

	function get_produk_popup()
	{
		$where = "1=1";

		$keyword = $this->input->post('keyword');
		if($keyword != "" || $keyword != null){
			$where = $where." AND (kode_barang LIKE '%$keyword%' OR nama_barang LIKE '%$keyword%')";
		}

		$sql = "
		SELECT * FROM master_barang WHERE $where 
		ORDER BY id_barang DESC
		LIMIT 10
		";

		$dt = $this->db->query($sql)->result();

		echo json_encode($dt);
	}

	function get_produk_detail(){
		$id_barang = $this->input->get('id_barang');
		$dt = $this->permintaan->get_produk_detail($id_barang);

		echo json_encode($dt);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */