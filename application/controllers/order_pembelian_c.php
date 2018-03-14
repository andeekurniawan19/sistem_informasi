<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_pembelian_c extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('order_pembelian_m','order');
		$data = $this->session->userdata('sign_in');
        $nama = $data['id'];

        if($nama == "" || $nama == null){
        	redirect('login_c','refresh');
        }
	}

	public function index()
	{
		$data = array(
				'title' 	      => 'Order Pembelian Barang',
				'page'  	      => 'order_pembelian_v',
				'sub_menu' 	      => 'pembelian',
				'sub_menu1'	      => 'order Pembelian',
				'menu' 	   	      => 'penjualan',
				'menu2'		      => 'order_pembelian',
				'lihat_data'      => $this->order->lihat_data_order(),
				'lihat_barang'    => $this->order->lihat_data_barang(),
				'url_simpan' 	  => base_url().'order_pembelian_c/simpan',
				'url_hapus'  	  => base_url().'order_pembelian_c/hapus',
			);
		
		$this->load->view('home_v',$data);
	}

	function simpan()
	{	
		$id_order 		= $this->input->post('id_order');
		if ($id_order == '') {
			
			$no_opb 		= $this->input->post('no_opb');
			$tanggal 		= $this->input->post('tanggal');
			$uraian 		= $this->input->post('uraian');

			$this->order->simpan_data_order($no_opb,$tanggal,$uraian);

			$id_order_baru  = $this->db->insert_id();
			$id_produk  	= $this->input->post('produk');
			$nama_produk 	= $this->input->post('nama_produk');
			$keterangan 	= $this->input->post('keterangan');
			$kuantitas  	= $this->input->post('kuantitas');
			$satuan 		= $this->input->post('satuan');
			$harga	 		= $this->input->post('harga');
			$total	 		= $this->input->post('total');
			$no_spb 		= $this->input->post('no_spb');

			foreach ($nama_produk as $key => $val) {
				$this->order->simpan_data_order_detail($id_order_baru,$id_produk,$val,$keterangan[$key],$kuantitas[$key],
													   $satuan[$key],$harga[$key],$total[$key],$no_spb[$key]);
			}
			$this->session->set_flashdata('sukses','1');
			redirect('order_pembelian_c');
		
		} else {

			$id 			= $this->input->post('id_order');
			$no_opb 		= $this->input->post('no_opb');
			$tanggal 		= $this->input->post('tanggal');
			$uraian 		= $this->input->post('uraian');

			$this->order->ubah_data_order($id,$no_opb,$tanggal,$uraian);

			$nama_produk 	= $this->input->post('nama_produk');
			$keterangan 	= $this->input->post('keterangan');
			$kuantitas  	= $this->input->post('kuantitas');
			$satuan 		= $this->input->post('satuan');
			$harga	 		= $this->input->post('harga');
			$total	 		= $this->input->post('total');
			$no_spb 		= $this->input->post('no_spb');

			foreach ($nama_produk as $key => $val) {
				$this->order->ubah_data_order_detail($val,$keterangan[$key],$kuantitas[$key],$satuan[$key],
													$harga[$key],$total[$key],$no_spb[$key]);
			}
			$this->session->set_flashdata('sukses','1');
			redirect('order_pembelian_c');
		}
		
	}

	function hapus()
	{
		$id = $this->input->post('id_hapus');
		$this->order->hapus_order($id);
		$this->session->set_flashdata('hapus','1');
		redirect('order_pembelian_c');
	}

	function data_order_id()
	{
		$id = $this->input->post('id');
		$data = $this->order->data_order_id($id);
		echo json_encode($data);
	}

	function data_order_detail_id()
	{
		$id = $this->input->post('id');
		$data = $this->order->data_order_detail_id($id);
		echo json_encode($data);
	}

	function get_produk_popup()
	{
		$where = "1=1";

		$keyword = $this->input->post('keyword');
		if($keyword != "" || $keyword != null){
			$where = $where." AND (nama_produk LIKE '%$keyword%' OR id_produk LIKE '%$keyword%')";
		}

		$sql = "
		SELECT * FROM tb_permintaan_barang_detail WHERE $where 
		ORDER BY id DESC
		LIMIT 10
		";

		$dt = $this->db->query($sql)->result();

		echo json_encode($dt);
	}

	function get_produk_detail(){
		$id_induk = $this->input->get('id_induk');
		$dt = $this->order->get_produk_detail($id_induk);

		echo json_encode($dt);
	}

	function get_spb_popup()
	{
		$where = "1=1";

		$keyword = $this->input->post('keyword');
		if($keyword != "" || $keyword != null){
			$where = $where." AND (no_spb LIKE '%$keyword%' OR nama_produk LIKE '%$keyword%')";
		}

		$sql = "
		SELECT * FROM tb_permintaan_barang WHERE $where 
		ORDER BY id_permintaan DESC
		LIMIT 10
		";

		$dt = $this->db->query($sql)->result();

		echo json_encode($dt);
	}

	function get_spb_detail()
	{
		$id = $this->input->post('id');

		$sql = "
		SELECT b.*, a.no_spb FROM tb_permintaan_barang a
		JOIN tb_permintaan_barang_detail b ON a.id_permintaan = b.id_induk
		WHERE a.id_permintaan = $id
		";

		$dt = $this->db->query($sql)->result();
        echo json_encode($dt);
	}

	function get_order_detail(){
		$id_induk = $this->input->get('id_induk');
		$dt = $this->order->get_order_detail($id_induk);

		echo json_encode($dt);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */