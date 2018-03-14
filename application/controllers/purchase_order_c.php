<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_order_c extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('purchase_order_m','purchase');
		$data = $this->session->userdata('sign_in');
        $nama = $data['id'];

        if($nama == "" || $nama == null){
        	redirect('login_c','refresh');
        }
	}

	public function index()
	{
		$data = array(
				'title' 	      => 'Purchase Order',
				'page'  	      => 'purchase_order_v',
				'sub_menu' 	      => 'pembelian',
				'sub_menu1'	      => 'purchase order',
				'menu' 	   	      => 'penjualan',
				'menu2'		      => 'purchase_order',
				'lihat_data'      => $this->purchase->lihat_data_purchase(),
				'url_simpan' 	  => base_url().'purchase_order_c/simpan',
				'url_hapus'  	  => base_url().'purchase_order_c/hapus',
				'url_ubah'	 	  => base_url().'purchase_order_c/ubah_purchase',
			);
		
		$this->load->view('home_v',$data);
	}

	function simpan()
	{
		$id_purchase 	= $this->input->post('id_purchase');
		if ($id_purchase == '') {
			
			$no_po 			= $this->input->post('no_po');
			$tanggal 		= $this->input->post('tanggal');
			$supplier 		= $this->input->post('supplier');

			$this->purchase->simpan_data_purchase($no_po,$tanggal,$supplier);

			$id_purchase_baru   = $this->db->insert_id();
			$id_produk    		= $this->input->post('produk');
			$nama_produk 		= $this->input->post('nama_produk');
			$keterangan 		= $this->input->post('keterangan');
			$kuantitas  		= $this->input->post('kuantitas');
			$harga 				= $this->input->post('harga');
			$total 				= $this->input->post('total');
			$no_opb 			= $this->input->post('no_opb');

			foreach ($nama_produk as $key => $val) {
				$this->purchase->simpan_data_purchase_detail($id_purchase_baru,$id_produk,$val,$keterangan[$key],$kuantitas[$key],$harga[$key],$total[$key],$no_opb[$key]);
			}
			$this->session->set_flashdata('sukses','1');
			redirect('purchase_order_c');
		
		}else{

			$id 			= $this->input->post('id_purchase');
			$no_po 			= $this->input->post('no_po');
			$tanggal 		= $this->input->post('tanggal');
			$supplier 		= $this->input->post('supplier');

			$this->purchase->ubah_data_purchase($id,$no_po,$tanggal,$supplier);

			$nama_produk 		= $this->input->post('nama_produk');
			$keterangan 		= $this->input->post('keterangan');
			$kuantitas  		= $this->input->post('kuantitas');
			$harga 				= $this->input->post('harga');
			$total 				= $this->input->post('total');
			$no_opb 			= $this->input->post('no_opb');

			foreach ($nama_produk as $key => $val) {
				$this->purchase->ubah_data_purchase_detail($id, $val,$keterangan[$key],$kuantitas[$key],$harga[$key],$total[$key],$no_opb[$key]);
			}
			$this->session->set_flashdata('sukses','1');
			redirect('purchase_order_c');
		}
	}

	function hapus()
	{
		$id = $this->input->post('id_hapus');
		$this->purchase->hapus_purchase($id);
		$this->session->set_flashdata('hapus','1');
		redirect('purchase_order_c');
	}

	function data_purchase_id()
	{
		$id = $this->input->post('id');
		$data = $this->purchase->data_purchase_id($id);
		echo json_encode($data);
	}

	function data_purchase_detail_id()
	{
		$id = $this->input->post('id');
		$data = $this->purchase->data_purchase_detail_id($id);
		echo json_encode($data);
	}

	function get_supplier_popup()
	{
		$where = "1=1";

		$keyword = $this->input->post('keyword');
		if ($keyword != "" || $keyword != null) {
			$where = $where."AND (kode_supplier LIKE '%$keyword%' OR nama_supplier LIKE '%$keyword%')";
		}

		$sql = "SELECT * FROM master_supplier WHERE $where ORDER BY id_supplier DESC LIMIT 10 ";

		$dt = $this->db->query($sql)->result();
		echo json_encode($dt);
	}

	function get_supplier_detail()
	{
		$id_supplier = $this->input->get('id_supplier');
		$dt = $this->purchase->get_supplier_detail($id_supplier);

		echo json_encode($dt);
	}

	function get_produk_popup()
	{
		$where = "1=1";

		$keyword = $this->input->post('keyword');
		if ($keyword != "" || $keyword != null) {
			$where = $where."AND (kode_barang LIKE '%$keyword%' OR nama_barang LIKE '%$keyword%')";
		}

		$sql = "SELECT * FROM master_barang WHERE $where ORDER BY id_barang DESC LIMIT 10 ";

		$dt = $this->db->query($sql)->result();
		echo json_encode($dt);
	}

	function get_produk_detail()
	{
		$id_barang = $this->input->get('id_barang');
		$dt = $this->purchase->get_produk_detail($id_barang);

		echo json_encode($dt);
	}

	function get_opb_popup()
	{
		$where = "1=1";

		$keyword = $this->input->post('keyword');
		if ($keyword != "" || $keyword != null) {
			$where = $where."AND (no_spb LIKE '%$keyword%' OR uraian LIKE '%$keyword%')";
		}

		$sql = "SELECT *
				FROM tb_order_pembelian 
				WHERE $where ORDER BY id_order DESC LIMIT 10 ";

		$dt = $this->db->query($sql)->result();
		echo json_encode($dt);
	}

	function get_opb_detail()
	{
		$id = $this->input->post('id');

		$sql = "
		SELECT b.*, a.no_opb FROM tb_order_pembelian a
		JOIN tb_order_pembelian_detail b ON a.id_order = b.id_induk
		WHERE a.id_order = $id
		";

		$dt = $this->db->query($sql)->result();
        echo json_encode($dt);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */