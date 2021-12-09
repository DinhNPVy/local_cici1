<?php
class Wishlist extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    // phuong thuc them san pham vao yeu thich
    function add()
    {
        // lay ra san pham muon them vao yeu thich
        // lay ra san pham muon them vao yeu thich
        $this->load->model('product_model');
        $id = $this->uri->rsegment(3);
        $product = $this->product_model->get_info($id);
        if (!$product) {
            redirect();
        }

        // tong so san pham
        $qty = 1;
        $price = $product->price;
        if ($product->discount > 0) {
            $price = $product->price - $product->discount;
        }
        // thong tin them vao yeu thich
        $data = array();
        $data['id'] = $product->id;
        $data['qty'] = $qty;
        $data['name'] = url_title($product->name);
        $data['image_link'] = $product->image_link;
        $data['price'] = $price;
        $this->cart->insert($data);

        // chuyen ra danh sach san pham trong yeu thich
        redirect(base_url('wishlist'));
    }

    // hien thi danh sach san pham trong gio hàng

    function index()
    { // thong tin yeu thich
        $carts = $this->cart->contents();

        $total_items_wishlist = $this->cart->total_items();
        if ($total_items_wishlist <= 0) {
            redirect();
        }
        $this->data['carts'] = $carts;


        // tong so tien can thanh toan
        $total_amount_wishlist = 0;
        foreach ($carts as $row) {
            $total_amount_wishlist = $total_amount_wishlist + $row['subtotal'];
        }
        foreach ($carts as $row) {

            $product_name = $row['name'];
            $product_id = $row['id'];
            $image_link = $row['image_link'];
            $price = $row['price'];
        }
        $this->data['total_amount_wishlist'] = $total_amount_wishlist;

        $user_id = 0;
        $user = "";
        // neu thanh vien da dang nhap thi lay thong tin thanh vien
        if ($this->session->userdata('user_id_login')) {
            // lay thong tin cua thanh vien
            $user_id = $this->session->userdata('user_id_login');
            $user = $this->user_model->get_info($user_id);
        }
        $this->data['user'] = $user;


        // them vao bang wishlist
        $this->load->model('wishlist_model');
        $data = array(
            'user_id'        => $user_id,
            'product_id'     => $product_id,
            'product_name'   => $product_name,
            'image_link'     => $image_link,
            'price'          => $price,
            'created'        => now(),

        );
        // them du lieu voa bang wishlist 
        $this->load->model('wishlist_model');
        $this->wishlist_model->create($data);

        $this->data['temp'] = 'site/wishlist/index';
        $this->load->view('site/layout', $this->data);
    }
    function del()
    {
        $id = $this->uri->rsegment(3);
        $id = intval($id);
        // xoa 1 sản phẩm nào đó trong giỏ hàng
        if ($id > 0) {
            // thong tin yeu thich
            $carts = $this->cart->contents();
            foreach ($carts as $key => $row) {

                if ($row['id'] == $id) {


                    $data = array();
                    $data['rowid'] = $key;
                    $data['qty'] = 0;
                    $this->cart->update($data);
                }
            }
        } else {
            // xoa toan bo
            $this->cart->destroy();
        }
        // chuyen ra danh sach san pham trong yeu thich
        redirect(base_url('wishlist'));
    }
}
