<?php
class Konfigurasi_model extends CI_Model
{
    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('konfigurasi');
        if ($id != null) {
            $this->db->where('id_konfigurasi', $id);
        }
        return $this->db->get();
    }
    public function update($data, $id_konfigurasi)
    {
        $this->db->where('id_konfigurasi', $id_konfigurasi);
        $this->db->update('konfigurasi', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('konfigurasi', $data);
        return $this->db->affected_rows();
    }

    public function delete($id_konfigurasi)
    {
        $this->db->delete('konfigurasi', ['id_konfigurasi' => $id_konfigurasi]);
        return $this->db->affected_rows();
    }
}
