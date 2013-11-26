<?php
class Depress extends CI_Controller
{
    public $owner_id;
    public $user_id;
    public $provider_id;

    public function __construct()
    {
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');
        $this->user_id = $this->session->userdata('user_id');

        if(empty($this->user_id)){
            redirect(site_url('users/login'));
        }

        $this->load->model('Depress_model', 'dep');

        $this->dep->owner_id = $this->owner_id;
        $this->dep->user_id = $this->user_id;
    }

    public function save()
    {
        $data = $this->input->post('data');

        if(!empty($data))
        {
            $exist = $this->dep->check_exist($data['hn'], $data['vn']);

            $rs = $exist ? $this->dep->update($data) : $this->dep->save($data);
            $json = $rs ? '{"success": true}' : '{"success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้"}';
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลที่ต้องการบันทึก"}';
        }

        render_json($json);
    }

    public function detail()
    {
        $hn = $this->input->post('hn');
        $vn = $this->input->post('vn');

        $rs = $this->dep->detail($hn, $vn);

        if($rs)
        {
            $rows = json_encode($rs);
            $json = '{"success": true, "rows": '.$rows.'}';
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูล"}';
        }

        render_json($json);
    }

    public function remove()
    {
        $hn = $this->input->post('hn');
        $vn = $this->input->post('vn');

        if(!empty($hn) && !empty($vn))
        {
            $rs = $this->dep->remove($hn, $vn);

            $json = $rs ? '{"success": true}' : '{"success": false, "msg": "ไม่สามารถลบรายการได้"}';
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลที่ต้องการลบ (เงื่อนไขไม่ครบถ้วน)"}';
        }

        render_json($json);
    }
}