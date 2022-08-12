<?php
class Inisialisasi_model extends CI_Model
{
    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('inisialisasi');
        if ($id != null) {
            $this->db->where('id_inisialisasi', $id);
        }
        return $this->db->get();
    }
    public function joinData($id = null)
    {
        $this->db->select('*');
        $this->db->from('inisialisasi i');
        $this->db->join('inisialisasi_detail id', 'id.inisialisasi_id = i.id_inisialisasi');
        if ($id != null) {
            $this->db->where('id_inisialisasi', $id);
        }
        return $this->db->get();
    }
    public function update($data, $id_inisialisasi)
    {
        $this->db->where('id_inisialisasi', $id_inisialisasi);
        $this->db->update('inisialisasi', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('inisialisasi', $data);
        return $this->db->insert_id();
    }

    public function insertMany($data)
    {
        $this->db->insert_batch('inisialisasi', $data);
        return $this->db->affected_rows();
    }

    public function delete($id_inisialisasi)
    {
        $this->db->delete('inisialisasi', ['id_inisialisasi' => $id_inisialisasi]);
        return $this->db->affected_rows();
    }
}
