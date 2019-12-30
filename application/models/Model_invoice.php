<?php 

	class Model_invoice extends CI_Model{
		public function index(){
			date_default_timezone_set('Asia/Jakarta');
			$nama = $this->input->post('full_name');
			$alamat = $this->input->post('address');
			$no_telp = $this->input->post('no_telp');
			$email = $this->input->post('email');

			$invoice = array(
				'nama' => $nama,
				'alamat' => $alamat,
				'no_telp' => $no_telp,
				'email' => $email,
				'tgl_pesan' => date('Y-m-d H:i:s'),
				'batas_bayar' => date('Y-m-d H:i:s', mktime(date('H'),date('i'),date('s'), date('m'), date('d') + 1, date('Y'))),
			);

			$this->db->insert('tb_invoice', $invoice);
			$id_invoice = $this->db->insert_id();

			foreach($this->cart->contents() as $i){
				$data = array(
					'id_invoice' => $id_invoice,
					'id_brg' => $i['id'],
					'nama_brg' => $i['name'],
					'jumlah' => $i['qty'],
					'harga' => $i['price'],
				);
				$this->db->insert('tb_pesanan', $data);
			}
			return TRUE;
		}

		public function tampil_data(){
			$result = $this->db->get('tb_invoice');
			if($result->num_rows() > 0){
				return $result->result();
			}else{
				return false;
			}
		}

}