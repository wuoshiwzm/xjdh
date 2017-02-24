<?php

/**
 * 
 * Construction pagination control for pages
 * @author peter
 *
 */
class MP_Paging extends CI_Model
{

    function __construct ()
    {
        parent::__construct();
    }

    function Show ($url, $totalRows, $pageSize, $uri_segment = 3, $query = FALSE)
    {
        $this->load->library('pagination');
        $config = array();
        $config['base_url'] = $url;
        $config['total_rows'] = $totalRows;
        $config['per_page'] = $pageSize;
        $config['uri_segment'] = $uri_segment;
        $totalPage = ceil($totalRows / $pageSize);
        $config['full_tag_open'] = '<div class="dataTables_paginate paging_bootstrap pagination"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="next">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '«';
        $config['next_link'] = '»';
        $config['page_query_string'] = $query;
        $config['first_link'] = "第一页";
        $config['last_link'] = "最后一页";
        $this->pagination->initialize($config);
        
        return $this->pagination->create_links();
    }

    function Show_Account ($url, $totalRows, $pageSize, $uri_segment = 3, $query = FALSE)
    {
        $this->load->library('pagination');
        $config = array();
        $config['base_url'] = $url;
        $config['total_rows'] = $totalRows;
        $config['per_page'] = $pageSize;
        $config['uri_segment'] = $uri_segment;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['next_link'] = '>>';
        $config['prev_link'] = '<<';
        $config['page_query_string'] = $query;
        $config['first_link'] = "第一页";
        $config['last_link'] = "最后一页";
        $this->pagination->initialize($config);
        
        return $this->pagination->create_links();
    }

    function Show_Admin ($url, $totalRows, $pageSize, $uri_segment = 3, $query = FALSE)
    {
        $this->load->library('pagination');
        $config = array();
        $config['base_url'] = $url;
        $config['total_rows'] = $totalRows;
        $config['per_page'] = $pageSize;
        $config['uri_segment'] = $uri_segment;
        $totalPage = ceil($totalRows / $pageSize);
        $config['full_tag_open'] = '<div><span style="display:block;margin:15px;float:left;font-size:17.5px;color:#22878e">共' . $totalRows . '条,分为' . $totalPage .
                 '页</span><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="next">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '«';
        $config['next_link'] = '»';
        $config['page_query_string'] = $query;
        $config['first_link'] = "第一页";
        $config['last_link'] = "最后一页";
        $this->pagination->initialize($config);
        
        return $this->pagination->create_links();
    }
}
