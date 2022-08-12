<?php
class Penyakit_model extends CI_Model
{
    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('penyakit');
        if ($id != null) {
            $this->db->where('id_penyakit', $id);
        }
        return $this->db->get();
    }
    public function update($data, $id_penyakit)
    {
        $this->db->where('id_penyakit', $id_penyakit);
        $this->db->update('penyakit', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('penyakit', $data);
        return $this->db->insert_id();
    }

    public function delete($id_penyakit)
    {
        $this->db->delete('penyakit', ['id_penyakit' => $id_penyakit]);
        return $this->db->affected_rows();
    }
    public function maxKode()
    {
        $this->db->select('max(kode_penyakit) as max_kode_penyakit');
        $this->db->from('penyakit');
        return $this->db->get();
    }
}
