<?php
class Rule_model extends CI_Model
{
    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('rule r');
        $this->db->join('penyakit p', 'p.id_penyakit = r.penyakit_id');
        if ($id != null) {
            $this->db->where('r.id_rule', $id);
        }
        return $this->db->get();
    }
    public function update($data, $id_rule)
    {
        $this->db->where('id_rule', $id_rule);
        $this->db->update('rule', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('rule', $data);
        return $this->db->insert_id();
    }

    public function delete($id_rule)
    {
        $this->db->delete('rule', ['id_rule' => $id_rule]);
        return $this->db->affected_rows();
    }
    public function maxKode()
    {
        $this->db->select('max(kode_rule) as max_kode_rule');
        $this->db->from('rule');
        return $this->db->get();
    }
}
