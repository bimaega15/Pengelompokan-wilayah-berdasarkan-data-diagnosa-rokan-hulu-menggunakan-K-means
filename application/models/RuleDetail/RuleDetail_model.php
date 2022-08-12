<?php
class RuleDetail_model extends CI_Model
{
    public function get($id = null, $rule_id = null, $gejala_id = [])
    {
        $this->db->select('*');
        $this->db->from('rule_detail rld');
        $this->db->join('gejala g', 'g.id_gejala = rld.gejala_id', 'left');
        $this->db->join('rule r', 'r.id_rule = rld.rule_id', 'left');
        $this->db->join('penyakit p', 'p.id_penyakit = r.penyakit_id', 'left');

        if ($id != null) {
            $this->db->where('rld.id_rule_detail', $id);
        }

        if ($rule_id != null) {
            $this->db->where('rld.rule_id', $rule_id);
        }
        if (!empty($gejala_id)) {
            $this->db->where_in('g.gejala_id', $gejala_id);
        }

        return $this->db->get();
    }
    public function update($data, $id_rule_detail)
    {
        $this->db->where('id_rule_detail', $id_rule_detail);
        $this->db->update('rule_detail', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('rule_detail', $data);
        return $this->db->insert_id();
    }

    public function insertMany($data)
    {
        $this->db->insert_batch('rule_detail', $data);
        return $this->db->affected_rows();
    }

    public function delete($rule_id)
    {
        $this->db->delete('rule_detail', ['rule_id' => $rule_id]);
        return $this->db->affected_rows();
    }

    public function deleteOne($id_rule_detail)
    {
        $this->db->delete('rule_detail', ['id_rule_detail' => $id_rule_detail]);
        return $this->db->affected_rows();
    }
}
