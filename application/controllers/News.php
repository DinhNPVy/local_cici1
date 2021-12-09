<?php
class News extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        // load model san pham
        $this->load->model('news_model');
    }

    function blog()
    {

        $input = array();
        $input['limit'] = array(6, 0);
        $news_list = $this->news_model->get_list($input);
        $this->data['news_list'] = $news_list;

        $total_rows = $this->news_model->get_total($input);
        $this->data['total_rows'] = $total_rows;
        //load thu vien phan trang
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $total_rows; // tong tat ca san pham tren website
        $config['base_url'] = base_url('news/index'); // link hiển thị ra danh sách sản phẩm
        $config['per_page'] = 3; // số lượng hiển thị trên 1 trang
        $config['uri_segment'] = 4; // lấy ra phân đoạn hiện trên link url
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';

        $this->pagination->initialize($config);




        // lay dữ liệu phân trang
        $segment = $this->uri->segment(4);
        $segment = intval($segment);


        $input['limit'] = array($config['per_page'], $segment);

        //hiển thị ra view
        $this->data['temp'] = 'site/news/index';
        $this->load->view('site/layout', $this->data);
    }
    function count_view()
    {
        // lay id san pham muon xem
        $id = $this->uri->rsegment(3);
        $news = $this->news_model->get_info($id);
        if (!$news) redirect();


        // cap nhat lai luot xem cua san pham
        $data = array();
        $data['count_view'] = $news->count_view + 1;
        $this->news_model->update($news->id, $data);


        // hien thi ra count_view
        $this->data['temp'] = 'site/news/blog';
        $this->load->view('site/layout', $this->data);
    }
}
