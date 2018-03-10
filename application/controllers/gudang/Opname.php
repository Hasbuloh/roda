<?php
class Opname extends ZEN_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Opname_M','Opname');
        $this->load->library('gudang');
        $div = $this->session->userdata('div');
        $this->gudang->auth($div);
    }

    function index() {
		$this->_setNav('gudang');
		$this->data['items'] = '';
		$this->data['subview'] = 'gudang/opname/index';
		$this->load->view('_layoutMain',$this->data);
	}

	function table_opname() {
        $data = array();
        $no=1;
        $items = $this->db->query("SELECT 
                                        id,
                                        nomor,
                                        DATE_FORMAT(tanggal,'%d %M %Y') AS tanggal,
                                        tanggal AS tanggal_unformated,
                                        IFNULL(o.total,0) AS qty_fisik,
                                        IFNULL(o.item,0) AS item,
                                        status
                                    FROM tbl_headeropname
                                    LEFT JOIN (
                                        SELECT 
                                        nomor AS nomor_opname,
                                        SUM(QTY_FISIK) AS total,
                                        count(nomor_part) AS item
                                        FROM tbl_opname
                                        GROUP BY nomor
                                    ) AS o ON o.nomor_opname = tbl_headeropname.nomor ORDER BY id DESC
                                    ")->result();
        foreach ($items as $item):
            $row = array();
            $row[] = $this->tombol_edit_header();
            $row[] = $this->tombol_hapus_header(array('id'=>$item->id,'jumlah'=>$item->item));
            $row[] = $no;
            $row[] = $item->nomor;
            $row[] = $item->tanggal;
            $row[] = $item->item;
            $row[] = $item->qty_fisik;
            $row[] = $this->tombol_cetak(array('nomor_opname'=>$item->nomor,'tanggal'=>$item->tanggal_unformated));
            $row[] = $this->tombol_detail();
            $row[] = $this->tombol_update(array('status'=>$item->status,'nomor'=>$item->nomor));
            $no++;
            $data[] = $row;
        endforeach;

        echo json_encode(array('data'=>$data));
    }

	public function update_item_opname()   {
        $this->_setNav('gudang');
        $id = $this->input->get('id');
        $tanggal = $this->db->query("SELECT tanggal FROM  tbl_headeropname WHERE nomor = '{$id}'")->row();
        $this->data['header'] = $this->db->query("SELECT *,DATE_FORMAT(tanggal,'%d %M %Y') AS tanggal FROM tbl_headeropname WHERE nomor = '{$id}'")->row();
        $this->data['tanggal'] = $tanggal->tanggal;
        $this->data['subview'] = 'gudang/opname/index_detail';
        $this->load->view('_layoutMain',$this->data);

    }

	function table_detail() {

		$id = $this->input->get('id');
		$items = $this->Opname->table_detail($id)->result();
		// print_r($items);
		$data = array();
		$no=1;
		foreach ($items as $item) {
			$row = array();
			$row[] = $no;
			$row[] = "<strong class=\"text text-danger\">".$item->nomor_part."</strong>";
			$row[] = $item->nama_part;
			$row[] = "<strong class=\"text text-info\">".$item->qty_fisik."</strong>";
			$row[] = "<strong class=\"text text-warning\">".$item->nomor_rak."</strong>";
			$row[] = $this->cari_selisih(array('teori'=>$item->qty_teori,'fisik'=>$item->qty_fisik));
			$row[] = $this->tombol_hapus($item->id);
			$data[] = $row;
			$no++;
		}

		$output = array('data'=>$data);
		echo json_encode($output);
	}

	function generate_nomor() {
        $nomor = null;
        $data1 = $this->db->query("SELECT MAX(DATE_FORMAT(tanggal,'%y %m')) AS 'tanggal1' FROM tbl_headeropname")->row();
        $data2 = $this->db->query("SELECT DATE_FORMAT(NOW(),'%y %m') AS 'tanggal2'")->row();
        if (isset($data1->tanggal1) && isset($data2->tanggal2) && $data1->tanggal1 == $data2->tanggal2 ) {
            $data = $this->db->query("SELECT DATE_FORMAT(NOW(),'%Y') AS 'tahun',DATE_FORMAT(NOW(),'%m') AS 'bulan', MAX(nomor) AS 'nomor' FROM tbl_headeropname WHERE DATE_FORMAT(tanggal,'%y %m')=DATE_FORMAT(NOW(),'%y %m')")->row();
            $tmp = (int) substr($data->nomor,0,3);
            $tmp++;
            $nomor = sprintf('%03s',$tmp);
            $nomor .= '/OPNAME/'.toRome($data->bulan).'/10108/'.$data->tahun;
        }else{
            $date = $this->db->query("SELECT DATE_FORMAT(NOW(),'%Y') AS 'tahun', DATE_FORMAT(NOW(),'%m') AS 'bulan'")->row();
            $nomor = '001/OPNAME/'.toRome($date->bulan).'/10108/'.$date->tahun;
        }
        echo json_encode(array('nomor_opname'=>$nomor));
	}

	function insert_header() {
        $id = $this->input->post('nomor');
        $status = (boolean) false;
        $cek = $this->db->get_where('tbl_headeropname',array('nomor'=>$id))->num_rows();
        if ($cek < 1) {
            $data = array(
                'nomor' => $this->input->post('nomor'),
                'tanggal' => $this->input->post('tanggal')
            );

            $this->Opname->insert_header($data);
            $status = (boolean) true;
        }

        echo json_encode(array('status'=>$status));

	}

	function insert_detail() {
        $status = (boolean) false;
        $cek = $this->db->get_where('tbl_opname',array('nomor'=>$this->input->post('nomor'),'id_barang'=>$this->input->post('id_barang')))->num_rows();
        if ($cek < 1) {
            $data = array(
                'nomor' => $this->input->post('nomor'),
                'id_barang' => $this->input->post('id_barang'),
                'nomor_part' => $this->input->post('nomor_part'),
                'qty_teori' => $this->input->post('qty_teori'),
                'qty_fisik' => $this->input->post('qty_fisik'),
                'tanggal' => $this->input->post('tanggal'),
                'nomor_rak' => $this->input->post('nomor_rak')
            );

            $this->Opname->insert_detail($data);
            $status = (boolean) true;
        }

        echo json_encode(array('status'=>$status));
	}

	function hapus_detail() {
        $id = $this->input->post('id');
        $status = (bool) false;
        $query = $this->db->query("DELETE FROM tbl_opname WHERE id = '{$id}'");
        if ($query) {
            $status = (bool) true;
        }

        echo json_encode(array('status'=>$status));
    }

    function update_status() {
        $id = $this->input->post('id');
        $status = (bool) false;
        $query = $this->db->query("UPDATE tbl_headeropname SET status = TRUE WHERE nomor = '{$id}'");
        if ($query) {
            $status = (bool) true;
        }

        echo json_encode(array('status'=>$status));
    }

    public function hapus_header() {
        $id = $this->input->post('id');
        $status = (bool) false;
        $hapus = $this->db->delete('tbl_headeropname',array('id'=>$id));
        if ($hapus) {
            $status = (bool) true;
        }

        echo json_encode(array('status'=>$status));
    }

    function tombol_hapus($string) {
    	$tombol = null;
    	$tombol = '<a href="javascript:void(0)" onclick="HapusItem('.$string.')"><i class="fa fa-trash fa-fw"></i></a>';
    	return $tombol;
    }

    function tombol_update($string) {
        return (string) $string['status'] == 0 ? "<a href=".base_url('gudang/Opname/update_item_opname?id=').$string['nomor']."><i class=\"fa fa-edit fa-fw\"></i></a>":"<span><i class=\"fa fa-lock fa-fw\"></i></span>";
    }

    function tombol_hapus_header($string) {
        return (string) "<a href=\"javascript:void(0)\" class=\"text text-danger\" onclick=\"hapusData({$string['id']},{$string['jumlah']})\"><i  class=\"fa fa-trash fa-fw\"></i></a>";
    }

    function tombol_edit_header() {
        return (string) "<a href=\"#\" class=\"text text-success\"><i  class=\"fa fa-pencil fa-fw\"></i></a>";
    }

    function tombol_detail() {
        return (string) "<a href=\"#\" class=\"text text-primary\"><i  class=\"fa fa-search fa-fw\"></i></a>";
    }

    function cari_selisih($string) {
        $status = (string) null;
        if ($string['fisik'] != $string['teori']) {
            $status = "<span class=\"label label-danger\">Selisih</span>";
        }else{
            $status = "<span class=\"label label-success\">Balance</span>";
        }

        return (string) $status;
    }

    function tombol_cetak($string) {
        return (string) "<a href=".base_url('gudang/Laporan_Opname/cetak_laporan_opname?id=').$string['nomor_opname']."&date=".$string['tanggal']."><i class=\" fa fa-print fa-fw\"></i> Cetak </a>";
    }
}
