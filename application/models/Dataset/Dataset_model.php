<?php
class Dataset_model extends CI_Model
{
    public function get($id = null, $arr_id = [])
    {
        $this->db->select('*');
        $this->db->from('dataset');
        if ($id != null) {
            $this->db->where('id_dataset', $id);
        }
        if (!empty($arr_id)) {
            $this->db->where_in('id_dataset', $arr_id);
        }
        return $this->db->get();
    }

    public function update($data, $id_dataset)
    {
        $this->db->where('id_dataset', $id_dataset);
        $this->db->update('dataset', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('dataset', $data);
        return $this->db->insert_id();
    }

    public function delete($id_dataset)
    {
        $this->db->delete('dataset', ['id_dataset' => $id_dataset]);
        return $this->db->affected_rows();
    }
    public function maxKode()
    {
        $this->db->select('kode_dataset');
        $this->db->from('dataset');
        return $this->db->get();
    }
}
