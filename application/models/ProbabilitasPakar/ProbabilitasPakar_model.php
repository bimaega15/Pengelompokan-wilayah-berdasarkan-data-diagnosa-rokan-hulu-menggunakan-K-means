<?php
class ProbabilitasPakar_model extends CI_Model
{
    public function get($id = null, $gejala_id = [])
    {
        $this->db->select('*');
        $this->db->from('probabilitas_pakar pp');
        $this->db->join('gejala g', 'g.id_gejala = pp.gejala_id');
        $this->db->join('penyakit p', 'p.id_penyakit = pp.penyakit_id');
        if ($id != null) {
            $this->db->where('id_probabilitas_pakar', $id);
        }
        if (!(empty($gejala_id))) {
            $this->db->where_in('pp.gejala_id', $gejala_id);
        }

        return $this->db->get();
    }
    public function update($data, $id_probabilitas_pakar)
    {
        $this->db->where('id_probabilitas_pakar', $id_probabilitas_pakar);
        $this->db->update('probabilitas_pakar', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('probabilitas_pakar', $data);
        return $this->db->insert_id();
    }

    public function delete($id_probabilitas_pakar)
    {
        $this->db->delete('probabilitas_pakar', ['id_probabilitas_pakar' => $id_probabilitas_pakar]);
        return $this->db->affected_rows();
    }
}
