<?php
class HasilDetail_model extends CI_Model
{
    public function get($id = null, $hasil_id = null)
    {
        $this->db->select('*');
        $this->db->from('hasil_detail hd');
        $this->db->join('dataset d', 'd.id_dataset = hd.dataset_id', 'left');
        if ($id != null) {
            $this->db->where('hd.id_hasil_detail', $id);
        }
        if ($hasil_id != null) {
            $this->db->where('hd.hasil_id', $hasil_id);
        }
        return $this->db->get();
    }
    public function allData($id = null, $hasil_id = null)
    {
        $this->db->select('*');
        $this->db->from('hasil_detail hd');
        $this->db->join('dataset d', 'd.id_dataset = hd.dataset_id', 'left');
        $this->db->join('dataset_detail dd', 'dd.dataset_id = d.id_dataset', 'left');
        $this->db->join('inisialisasi in', 'dd.inisialisasi_id = in.id_inisialisasi', 'left');
        $this->db->join('inisialisasi_detail ind', 'dd.inisialisasi_detail_id = ind.id_inisialisasi_detail', 'left');
        $this->db->join('coordinate cr', 'ind.id_inisialisasi_detail = cr.inisialisasi_detail_id', 'left');
        if ($id != null) {
            $this->db->where('hd.id_hasil_detail', $id);
        }
        if ($hasil_id != null) {
            $this->db->where('hd.hasil_id', $hasil_id);
        }
        return $this->db->get();
    }

    public function update($data, $id_hasil_detail)
    {
        $this->db->where('id_hasil_detail', $id_hasil_detail);
        $this->db->update('hasil_detail', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('hasil_detail', $data);
        return $this->db->insert_id();
    }

    public function insertMany($data)
    {
        $this->db->insert_batch('hasil_detail', $data);
        return $this->db->affected_rows();
    }

    public function delete($id_hasil_detail)
    {
        $this->db->delete('hasil_detail', ['id_hasil_detail' => $id_hasil_detail]);
        return $this->db->affected_rows();
    }
}
