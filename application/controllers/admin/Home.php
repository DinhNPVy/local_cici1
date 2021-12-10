<?php
class Home extends MY_Controller
{
    function index()
    {
        // Tai cac file thanh phan
        $this->load->model('user_model');
        $this->load->model('transaction_model');
        $this->load->model('news_model');
        $this->load->model('product_model');
        $this->load->model('contact_model');

        //thong ke doanh thu ngay hom nay
        $today = get_date(now());
        $time = get_time_between($today);
        $where = array(
            'created <=' => $time['end'],
            'created >=' => $time['start'],
            'status'     => 2
        );
        $amount_to_day = $this->transaction_model->get_sum('amount', $where);
        $this->data['amount_to_day'] = $amount_to_day;

        // tong thu theo thang nay
        $thangnay = get_date(now());
        $time     = get_time_between($thangnay, '1');
        $where = array(
            'created <=' => $time['end'],
            'created >=' => $time['start'],
            'status'     => 2
        );
        $tongtien_thang = $this->transaction_model->get_sum('amount', $where);
        $this->data['tongtien_thang'] = $tongtien_thang;

        // lay tong doanh thu
        $where = array('status' => 2);
        $amount_total = $this->transaction_model->get_sum('amount', $where);
        $this->data[$amount_total] = $amount_total;

        // thong ke tong so doanh thu
        $this->data['total_transaction'] = $this->transaction_model->get_total();
        $this->data['total_product']     = $this->product_model->get_total();
        $this->data['total_news']        = $this->news_model->get_total();
        $this->data['total_user']        = $this->user_model->get_total();
        $this->data['total_contact']     = $this->contact_model->get_total();

        //kiem ra co thuc hien lọc kh 
        $input = array();
        $id = $this->input->get('id');
        $id = intval($id);
        $input['where'] = array();
        if ($id > 0) {
            $input['where']['id'] = $id;
        }

        // lay ra danh sách sản phẩm
        $list = $this->transaction_model->get_list($input);
        $this->data['list'] = $list;

        $this->lang->load('vi', 'vietnamese');
        $input = array();
        $input['limit'] = array(6, 0);
        $input['order'] = array('buyed', 'DESC');
        $product_buy = $this->product_model->get_list($input);
        $this->data['product_buy'] = $product_buy;





        $this->data['temp'] = 'admin/home/index';
        $this->load->view('admin/main', $this->data);
    }
    // thuc hien dang xuat
    function logout()
    {
        if ($this->session->userdata('login')) {
            $this->session->unset_userdata('login');
        }
        redirect(admin_url('login'));
    }
}
