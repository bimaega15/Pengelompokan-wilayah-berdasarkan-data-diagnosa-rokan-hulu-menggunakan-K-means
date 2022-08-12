<?php
class DatasetDetail_model extends CI_Model
{
    public function get($id = null, $dataset_id = null, $nama_inisialisasi_detail = null)
    {
        $this->db->select('*');
        $this->db->from('dataset_detail dd');
        $this->db->join('inisialisasi i', 'i.id_inisialisasi = dd.inisialisasi_id', 'left');
        $this->db->join('inisialisasi_detail id', 'id.id_inisialisasi_detail = dd.inisialisasi_detail_id', 'left');
        if ($id != null) {
            $this->db->where('dd.id_dataset_detail', $id);
        }
        if ($dataset_id != null) {
            $this->db->where('dd.dataset_id', $dataset_id);
        }
        if ($nama_inisialisasi_detail != null) {
            $this->db->where('id.nama_inisialisasi_detail', $dataset_id);
        }

        return $this->db->get();
    }
    public function update($data, $id_dataset_detail)
    {
        $this->db->where('id_dataset_detail', $id_dataset_detail);
        $this->db->update('dataset_detail', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('dataset_detail', $data);
        return $this->db->insert_id();
    }

    public function insertMany($data)
    {
        $this->db->insert_batch('dataset_detail', $data);
        return $this->db->affected_rows();
    }

    public function delete($id_dataset_detail)
    {
        $this->db->delete('dataset_detail', ['id_dataset_detail' => $id_dataset_detail]);
        return $this->db->affected_rows();
    }
}
