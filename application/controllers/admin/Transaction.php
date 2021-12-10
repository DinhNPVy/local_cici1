<?php

class Transaction extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

        //load ra file model
        $this->load->model('transaction_model');
        $this->load->library('session');
    }

    // hien thi danh sach giao dich trong website
    function index()
    {
        // lay tong so luong tat ca san pham trong website
        $total_rows = $this->transaction_model->get_total();
        $this->data['total_rows'] = $total_rows;
        //load thu vien phan trang
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $total_rows; // tong tat ca san pham tren website
        $config['base_url'] = admin_url('transaction/index'); // link hiển thị ra danh sách sản phẩm
        $config['per_page'] = 11; // số lượng hiển thị trên 1 trang
        $config['uri_segment'] = 4; // lấy ra phân đoạn hiện trên link url
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';

        $this->pagination->initialize($config);

        // lay dữ liệu phân trang
        $segment = $this->uri->segment(4);
        $segment = intval($segment);

        $input = array();
        $input['limit'] = array($config['per_page'], $segment);

        //kiem ra co thuc hien lọc kh 
        $id = $this->input->get('id');
        $id = intval($id);
        $input['where'] = array();
        if ($id > 0) {
            $input['where']['id'] = $id;
        }

        // lay ra danh sách sản phẩm
        $list = $this->transaction_model->get_list($input);
        $this->data['list'] = $list;


        //lay noi dung cua bien message
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;

        //load view
        $this->data['temp'] = 'admin/transaction/index';
        $this->load->view('admin/main', $this->data);
    }
      // transaction 
      function shifted($id_order, $time_order, $price_order)
      {
        
          $this->load->model('transaction_model');
          $this->load->model('order_model');
    
          $id = $this->input->post('id');
          $id_order = $this->transaction_model->get_info($id);
         
          $time = $this->input->post('created');
          $time_order = $this->transaction_model->get_info($time);
          $price = $this->input->post('amount');
          $price_order = $this->transaction_model->get_info($price);
  
          $query = "UPDATE (transaction and order) SET
                 status = '1'
  
          WHERE id = '$id_order' AND created = '$time_order' AND amount = '$price_order'";
         $this->order_model->update($query);
         $this->transaction_model->update($query);
  
        //   if ($result) {
  
        //       $mes = "<span class='Success'>Update Order Successfully</span>";
        //       return $mes;
        //   } else {
  
        //       $mes = "<span class='error'>Update Order Not Successfully</span>";
        //       return $mes;
        //   }
      }
  
      // xoa cua xac nhan
      public function delShifted($id, $time, $price)
      {
          $id = mysqli_real_escape_string($this->db->link, $id);
          $time = mysqli_real_escape_string($this->db->link, $time);
          $price = mysqli_real_escape_string($this->db->link, $price);
          $query = "DELETE FROM transaction
            WHERE id = '$id' AND created = '$time' AND amount = '$price' ";
  
          $result = $this->db->update($query);
          if ($result) {
              $msg = "<span class='success'> DELETE Order Succesfully</span> ";
              return $msg;
          } else {
              $msg = "<span class='erorr'> DELETE Order NOT Succesfully</span> ";
              return $msg;
          }
      }
  
  
  
  
    // ham xoa
    function delete()
    {
        $id = $this->uri->rsegment('3');
        $this->_del($id);

        $this->session->set_flashdata('message', 'Delete success');
        redirect(admin_url('transaction'));
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
        $id = intval($id);

        $transaction = $this->transaction_model->get_info($id);

        if (!$transaction) {
            $this->session->set_flashdata('message', 'Transaction does not exist');
            redirect(admin_url('transaction'));
        }
        // thuc hien xoa 

        $this->transaction_model->delete($id);
    }
}
