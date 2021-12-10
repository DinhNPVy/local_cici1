<?php
class transaction extends MY_Controller
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
            $qty = $row['qty'];
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
            $this->form_validation->set_rules('message', 'transaction Note', 'required');
            $this->form_validation->set_rules('payment', 'Select a payment method', 'required');



            //nhập liệu chính xác
            if ($this->form_validation->run()) {
                //them vao csdl

                $payment = $this->input->post('payment');
                $data = array(
                    'status'         => 0, // trang thai chua thanh toan
                    'product_name'   => $product_name,
                    'image_link'     => $image_link,
                    'qty'            => $qty,
                    'user_id'        => $user_id,
                    'user_email'     => $this->input->post('email'),
                    'user_name'      => $this->input->post('name'),
                    'user_phone'     => $this->input->post('phone'),
                    'message'        => $this->input->post('message'), // ghi chu mua hang 
                    'amount'         =>  $total_amount, // tong so tien thanh toan
                    'payment'        =>  $payment,
                    'created'        => now(),

                );
                // them du lieu voa bang transaction
                $this->load->model('transaction_model');
                $this->transaction_model->create($data);



                // xoa toan bo
                $this->cart->destroy();
                if ($payment == 'cash') {
                    $this->session->set_flashdata('message', ' A Successful transaction - We will inspect the goods and send them to you as soon as feasible. ');

                    redirect(site_url());
                }
            }
        }

        $this->data['temp'] = 'site/transaction/checkout';
        $this->load->view('site/layout', $this->data);
    }
    function confirmshifted()
    {
        // lay danh sach san pham 
        $this->load->model('transaction_model');
        $id = $this->uri->rsegment(3);
        $transaction = $this->transaction_model->get_info($id);
        if (!$transaction) redirect();
        $data = array();
        $data['status'] = $transaction->status + 1;
        $this->transaction_model->update($transaction->id, $data);
        redirect('transaction');
    }

    function index()
    {
        // lay danh sach san pham 
        $this->load->model('transaction_model');
        $input = array();
        $transactioned = $this->transaction_model->get_list($input);
        $this->data['transactioned'] = $transactioned;



        $this->data['temp'] = 'site/transaction/index';
        $this->load->view('site/layout', $this->data);
    }



    // ham xoa
    function delete()
    {
        $id = $this->uri->rsegment('3');
        $this->_del($id);

        $this->session->set_flashdata('message', 'Delete success');
        redirect(site_url('transaction'));
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
        $this->load->model('transaction_model');
        $id = intval($id);

        $transaction = $this->transaction_model->get_info($id);

        if (!$transaction) {
            $this->session->set_flashdata('message', 'transaction does not exist');
            redirect(site_url('transaction'));
        }
        // thuc hien xoa 

        $this->transaction_model->delete($id);
    }
}
