<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 11:03 CH
 */

class AdminDanhMucController extends Controller
{
    public function indexAction(){
// action này in ra danh sách nhà sản xuất
        $this->layout->tieu_de = "Danh sách danh mục";
        $this->layout->meta_des ="Trang quản trị| Danh sách Danh Mục ";
        $this->view->title = "DANH MỤC";
        // admin-banner-qc
        // LOAD MODEL

        $objDMModel = new DanhMucModel();
        $this->view->list = $objDMModel->getList();

    }

    public function addAction(){
        
        $this->layout->meta_des ="Trang quản trị| Danh sách Danh Mục ";
        
        // thêm mới

//        echo '<pre>'.__FILE__.'::'.__METHOD__.'('.__LINE__.')<br>';
//            print_r($_POST);
//        echo '</pre>';
        //1. Kiểm tra hợp lệ của dữ liệu
        if(isset($_POST['ten_danh_muc'])) {

            //2. Tạo model xử lý ghi vào CSDL
            $obModelDM = new DanhMucModel();

            $obModelDM->ten_danh_muc = $_POST['ten_danh_muc'];


            

            $res =  $obModelDM->SaveNew();
            if (is_numeric($res)) {
                $this->view->msg = "Thêm mới thành công!";
            } else
                $this->view->msg = $res;
        }

    }
    public function editAction(){
        
        $this->layout->meta_des ="Trang quản trị| Danh sách Danh Mục ";
       
        //,,.,....
        if(!isset($_GET['id'])) die("Khong xac dinh ID");

        $id = intval($_GET['id']);


        //1. Tạo model, load thông tin lên form
        $obModelDM = new DanhMucModel();

        $this->view->objDM =  $obModelDM->loadOne($id);

        //2. Xử lý ghi vào DB

        if(isset($_POST['ten_danh_muc'])) {
            //1. Kiểm tra hợp lệ của dữ liệu
            // tự làm



            //2.Nếu không có lỗi  Tạo model xử lý ghi vào CSDL
            $obModelDMEdit = new DanhMucModel();
            $obModelDMEdit->id = $id;
            $obModelDMEdit->ten_danh_muc = $_POST['ten_danh_muc'];

            $res = $obModelDMEdit->SaveUpdate();
            if (is_numeric($res)) {
                $this->view->objDM  = $obModelDMEdit;
                $this->view->msg = "Cập nhật thành công!";
            } else
                $this->view->msg = $res;
        }





    }
}