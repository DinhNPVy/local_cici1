<?php
class Order extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }
    // lay thong tin cua khach hang
    function checkout()
    {
        // thong tin gio hang
        $carts = $this->cart->contents();

        $total_items = $this->cart->total_items();
        if ($total_items <= 0) {
            redirect();
        }
        $this->data['carts'] = $carts;


        // tong so tien can thanh toan
        $total_amount = 0;
        foreach ($carts as $row) {
            $total_amount = $total_amount + $row['subtotal'];
        }
        foreach ($carts as $row) {

            $product_name = $row['name'];
            $image_link = $row['image_link'];
        }
        $this->data['total_amount'] = $total_amount;

        $user_id = 0;
        $user = "";
        // neu thanh vien da dang nhap thi lay thong tin thanh vien
        if ($this->session->userdata('user_id_login')) {
            // lay thong tin cua thanh vien
            $user_id = $this->session->userdata('user_id_login');
            $user = $this->user_model->get_info($user_id);
        }
        $this->data['user'] = $user;

        $this->load->library('form_validation');
        $this->load->helper('form');

        //neu ma co du lieu post len thi kiem tra
        if ($this->input->post()) {



            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('name', 'Name', 'required|min_length[8]');
            $this->form_validation->set_rules('phone', 'Phone', 'required');
            $this->form_validation->set_rules('message', 'Order Note', 'required');
            $this->form_validation->set_rules('payment', 'Select a payment method', 'required');



            //nhập liệu chính xác
            if ($this->form_validation->run()) {
                //them vao csdl

                $payment = $this->input->post('payment');
                $data = array(
                    'status'         => 0, // trang thai chua thanh toan
                    'product_name'   => $product_name,
                    'image_link'     => $image_link,
                    'user_id'        => $user_id,
                    'user_email'     => $this->input->post('email'),
                    'user_name'      => $this->input->post('name'),
                    'user_phone'     => $this->input->post('phone'),
                    'message'        => $this->input->post('message'), // ghi chu mua hang 
                    'amount'         =>  $total_amount, // tong so tien thanh toan
                    'payment'        =>  $payment,
                    'created'        => now(),

                );
                // them du lieu voa bang order
                $this->load->model('order_model');
                $this->order_model->create($data);

                $order_id = $this->db->insert_id(); // lấy ra id giao dịch vừa thêm vào

                // them vao bang order
                $this->load->model('order_model');
                foreach ($carts as $row) {
                    $data = array(
                        'order_id' => $order_id,
                        'product_id'     => $row['id'],
                        'product_name'     => $row['name'],
                        'image_link'     => $row['image_link'],
                        'qty'            => $row['qty'],
                        'amount'         => $row['subtotal'],
                        'status'         => '0',
                        'created'        => now(),
                    );
                    $this->order_model->create($data);
                }
                // xoa toan bo
                $this->cart->destroy();
                if ($payment == 'cash') {
                    $this->session->set_flashdata('message', ' A Successful order - We will inspect the goods and send them to you as soon as feasible. ');

                    redirect(site_url());
                } elseif (in_array($payment, array('card', 'baokim'))) {
                    // load thu vien thanh toan
                    $this->load->library('payment/' . $payment . '_payment');

                    // chuyen sang cong thanh toan
                    $this->{$payment . '_payment'}->payment($order_id, $total_amount);
                }
            }
        }

        $this->data['temp'] = 'site/order/checkout';
        $this->load->view('site/layout', $this->data);
    }

    // nhan ket qua tra ve tu cong thanh toan
    function result()
    {

        $this->load->model('order_model');
        // id cu agiao dich
        $order_id = $this->input->post('order_id');

        $order = $this->order_model->get_info($order_id);
        if (!$order) {
            redirect();
        }

        // goi toi ham kiem tra giam gia thanh toan tren bao kim
        $status = $this->result($order_id, $order->amount);
        if ($status == true) {
            // cap nhat lai trang thai don hang ma da thanh toan
            $data = array();
            $data['status'] = 1;
            $this->order_model->update($order_id, $data);
        } elseif ($status == false) {
            // cap nhat lai trang thai don hang ma khong thanh toan
            $data = array();
            $data['status'] = 2;
            $this->order_model->update($order_id, $data);
        }
    }
    function index()
    {
        // lay danh sach san pham 
        $this->load->model('order_model');
        $input = array();
        $ordered = $this->order_model->get_list($input);
        $this->data['ordered'] = $ordered;



        $this->data['temp'] = 'site/order/index';
        $this->load->view('site/layout', $this->data);
    }
    // order
    function ShiftedConfirmid($id_order, $time_order, $price_order)
    {
        $this->load->model('order_model');
    
        $id = $this->input->post('transaction_id');
        $id_order = $this->order_model->get_info($id);
       
        $time = $this->input->post('created');
        $time_order = $this->order_model->get_info($time);
        $price = $this->input->post('amount');
        $price_order = $this->order_model->get_info($price);
        $query = "UPDATE order SET
            status = '2'

          WHERE transaction_id = '$id_order' AND created = '$time_order' AND amount = '$price_order' ";

        $result = $this->db->update($query);
    }

  

    // ham xoa
    function delete()
    {
        $id = $this->uri->rsegment('3');
        $this->_del($id);

        $this->session->set_flashdata('message', 'Delete success');
        redirect(site_url('order'));
    }
    // xoa nhieu san pham
    function delete_all()
    {
        $ids = $this->input->post('ids');
        foreach ($ids as $id) {
        }
    }
    // xoa san pham
    private function _del($id)
    {
        $this->load->model('order_model');
        $id = intval($id);

        $order = $this->order_model->get_info($id);

        if (!$order) {
            $this->session->set_flashdata('message', 'Order does not exist');
            redirect(site_url('order'));
        }
        // thuc hien xoa 

        $this->order_model->delete($id);
    }
}
