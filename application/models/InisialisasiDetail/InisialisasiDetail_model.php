<?php
class InisialisasiDetail_model extends CI_Model
{
    public function get($id = null, $inisialisasi_id = null, $nama_inisialisasi_detail = null)
    {
        $this->db->select('*');
        $this->db->from('inisialisasi_detail id');
        $this->db->join('inisialisasi i', 'i.id_inisialisasi = id.inisialisasi_id', 'left');
        if ($id != null) {
            $this->db->where('id.id_inisialisasi_detail', $id);
        }
        if ($inisialisasi_id != null) {
            $this->db->where('id.inisialisasi_id', $inisialisasi_id);
        }
        if ($nama_inisialisasi_detail != null) {
            $this->db->where('LOWER(id.nama_inisialisasi_detail)', $nama_inisialisasi_detail);
        }
        return $this->db->get();
    }
    public function update($data, $id_inisialisasi_detail)
    {
        $this->db->where('id_inisialisasi_detail', $id_inisialisasi_detail);
        $this->db->update('inisialisasi_detail', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('inisialisasi_detail', $data);
        return $this->db->insert_id();
    }

    public function insertMany($data)
    {
        $this->db->insert_batch('inisialisasi_detail', $data);
        return $this->db->affected_rows();
    }

    public function delete($id_inisialisasi_detail)
    {
        $this->db->delete('inisialisasi_detail', ['id_inisialisasi_detail' => $id_inisialisasi_detail]);
        return $this->db->affected_rows();
    }
}
