<?php
class Solusi_model extends CI_Model
{
    public function get($id = null, $penyakit_id = null)
    {
        $this->db->select('*');
        $this->db->from('solusi s');
        $this->db->join('penyakit p', 'p.id_penyakit = s.penyakit_id', 'left');
        if ($id != null) {
            $this->db->where('s.id_solusi', $id);
        }
        if ($penyakit_id != null) {
            $this->db->where('s.penyakit_id', $penyakit_id);
        }
        return $this->db->get();
    }
    public function update($data, $id_solusi)
    {
        $this->db->where('id_solusi', $id_solusi);
        $this->db->update('solusi', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('solusi', $data);
        return $this->db->insert_id();
    }

    public function delete($id_solusi)
    {
        $this->db->delete('solusi', ['id_solusi' => $id_solusi]);
        return $this->db->affected_rows();
    }
    public function maxKode()
    {
        $this->db->select('max(kode_solusi) as max_kode_solusi');
        $this->db->from('solusi');
        return $this->db->get();
    }
}
