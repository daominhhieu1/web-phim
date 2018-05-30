<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 11:03 CH
 */

class FilmModel extends MyModel
{
    public $id;
    public $ten_film;
    public $ten_film_english;
    public $link_anh;
    public $thong_tin_film;
    public $danh_muc;
    public $dao_dien;
    public $thoi_luong;
    public $quoc_gia;
    public $nam_phat_hanh;
    public $ngay_them;
    public $ngay_cap_nhat;
    public $id_danh_muc;
    protected $tb_name = 'tb_film';
    protected $tb_name_dm = 'tb_danh_muc';
    protected $tb_name_dd = 'tb_dao_dien';
    protected $tb_name_nph = 'tb_nam_phat_hanh';
    protected $tb_name_qg = 'tb_quoc_gia';
    protected $tb_name_usr = 'tb_user';
    protected $tb_name_tf = 'tb_tap_film';
    public $id_tai_khoan = 1;//sau này sửa sau

    public function countList($params = null){
        $sql = "SELECT COUNT($this->tb_name.id) as tong FROM $this->tb_name 
                  inner join $this->tb_name_nph ON $this->tb_name.id_nam_phat_hanh=$this->tb_name_nph.id
                  inner join $this->tb_name_qg ON $this->tb_name.id_quoc_gia=$this->tb_name_qg.id 
                  ";

        // $sql = "SELECT count(*) FROM $this->tb_name as tb1
        // LEFT JOIN tb_nhom_tai_khoan as tb2 ON tb1.id_nhom_tai_khoan = tb2.id ";

        // lệnh sql chưa có where

        $strWhere = '';

        if (isset($params['search_ten_film']) && strlen($params['search_ten_film']) > 0) {
            if ($strWhere == '')
                $strWhere .= " WHERE $this->tb_name.ten_film LIKE '%{$params['search_ten_film']}%' ";
            else
                $strWhere .= " AND  $this->tb_name.ten_film LIKE '%{$params['search_ten_film']}%' ";
        }

        // if (isset($params['search_danh_muc']) && strlen($params['search_danh_muc']) > 0) {
        //     if ($strWhere == '')
        //         $strWhere .= " WHERE $this->tb_name_dm.id ='{$params['search_danh_muc']}' ";
        //     else
        //         $strWhere .= " AND  $this->tb_name_dm.id ='{$params['search_danh_muc']}' ";
        // }


        if (isset($params['search_nam_phat_hanh']) && strlen($params['search_nam_phat_hanh']) > 0) {
            if ($strWhere == '')
                $strWhere .= " WHERE $this->tb_name_nph.id ='{$params['search_nam_phat_hanh']}' ";
            else
                $strWhere .= " AND  $this->tb_name_nph.id ='{$params['search_nam_phat_hanh']}' ";
        }
        if (isset($params['search_quoc_gia']) && strlen($params['search_quoc_gia']) > 0) {
            if ($strWhere == '')
                $strWhere .= " WHERE $this->tb_name_qg.id ='{$params['search_quoc_gia']}' ";
            else
                $strWhere .= " AND  $this->tb_name_qg.id ='{$params['search_quoc_gia']}' ";
        }



        if(isset($params['order']) && isset($params['col'])){
            $strWhere .= " ORDER BY  {$params['col']} {$params['order']}";
        }

        // hết phần điều kiện
        $sql .= $strWhere;
        $res = mysqli_query($this->getConn(), $sql);

        if(mysqli_errno($this->getConn())){
            $dataRes['error'] = mysqli_error($this->getConn());
            return $dataRes;
            // nếu có lỗi thì không làm việc bên dưới
        }

        $row = mysqli_fetch_assoc($res);

        $data = $row['tong'];

        return $data;


    }

    public function getList($params = null,$start, $limit)
    {
        $dataRes = array();
        $sql = "SELECT $this->tb_name.id,ten_film,ten_film_english,link_anh,thong_tin_film,ten_dao_dien,thoi_luong,nam_phat_hanh,ten_quoc_gia,$this->tb_name_usr.ho_ten,$this->tb_name.ngay_them,$this->tb_name.ngay_cap_nhat,view FROM $this->tb_name
                  
                  inner join $this->tb_name_dd ON $this->tb_name.id_dao_dien=$this->tb_name_dd.id
                  inner join $this->tb_name_nph ON $this->tb_name.id_nam_phat_hanh=$this->tb_name_nph.id
                  inner join $this->tb_name_qg ON $this->tb_name.id_quoc_gia=$this->tb_name_qg.id 
                  inner join $this->tb_name_usr ON $this->tb_name.id_tai_khoan=$this->tb_name_usr.id";
        //    $sql = "SELECT $this->tb_name.id,ten_film,ten_film_english,link_anh,thong_tin_film,ten_danh_muc,ten_dao_dien,thoi_luong,nam_phat_hanh,ten_quoc_gia,$this->tb_name_usr.ho_ten,$this->tb_name.ngay_them,$this->tb_name.ngay_cap_nhat,view
        // FROM $this->tb_name,$this->tb_name_dm,$this->tb_name_dd,$this->tb_name_nph,$this->tb_name_qg,$this->tb_name_usr
        // WHERE $this->tb_name_dm.id = $this->tb_name.id_danh_muc and $this->tb_name_dd.id = $this->tb_name.id_dao_dien and $this->tb_name_nph.id = $this->tb_name.id_nam_phat_hanh and $this->tb_name_qg.id = $this->tb_name.id_quoc_gia and $this->tb_name_usr.id = $this->tb_name.id_tai_khoan
        // ORDER BY $this->tb_name.id DESC";

        // lệnh sql chưa có where
        $strWhere = '';

        if (isset($params['search_ten_film']) && strlen($params['search_ten_film']) > 0) {
            if ($strWhere == '')
                $strWhere .= " WHERE $this->tb_name.ten_film LIKE '%{$params['search_ten_film']}%' ";
            else
                $strWhere .= " AND  $this->tb_name.ten_film LIKE '%{$params['search_ten_film']}%' ";
        }

        if (isset($params['search_danh_muc']) && strlen($params['search_danh_muc']) > 0) {
            if ($strWhere == '')
                $strWhere .= " WHERE $this->tb_name_dm.id ='{$params['search_danh_muc']}' ";
            else
                $strWhere .= " AND  $this->tb_name_dm.id ='{$params['search_danh_muc']}' ";
        }


        if (isset($params['search_nam_phat_hanh']) && strlen($params['search_nam_phat_hanh']) > 0) {
            if ($strWhere == '')
                $strWhere .= " WHERE $this->tb_name_nph.id ='1' ";
            else
                $strWhere .= " AND  $this->tb_name_nph.id ='{$params['search_nam_phat_hanh']}' ";
        }
        if (isset($params['search_quoc_gia']) && strlen($params['search_quoc_gia']) > 0) {
            if ($strWhere == '')
                $strWhere .= " WHERE $this->tb_name_qg.id ='{$params['search_quoc_gia']}' ";
            else
                $strWhere .= " AND  $this->tb_name_qg.id ='{$params['search_quoc_gia']}' ";
        }


        // hết phần điều kiện
        $strLimit = " LIMIT $start, $limit";
        $sql .= $strWhere;
        $sql .= $strLimit;
        $res = mysqli_query($this->getConn(), $sql);

        if (mysqli_errno($this->getConn())) {
            $dataRes['error'] = mysqli_error($this->getConn());
            return $dataRes;
            // nếu có lỗi thì không làm việc bên dưới
        }

        if (mysqli_num_rows($res) <= 0) {
            $dataRes['error'] = "Không có dữ liệu!";
            return $dataRes;
        }

        // có dữ liệu ==> tạo mảng để lưu trữ
        $dataRes['list'] = array();
        while ($row = mysqli_fetch_assoc($res)) {
            // chuyển dòng về dối tượng để sử dụng ở view cho tiện

            $objTmp = new stdClass();
            foreach ($row as $field_name => $value)
                $objTmp->$field_name = $value;

            $dataRes['list'][] = $objTmp;
        }

        return $dataRes;

    }

    public function getNamPhatHanh()
    {
        $sql = "SELECT * FROM $this->tb_name_nph";
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }

    public function getQuocGia()
    {
        $sql = "SELECT * FROM $this->tb_name_qg";
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
    public function getDaoDien()
    {
        $sql = "SELECT * FROM $this->tb_name_dd";
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }

    public function getDanhMuc()
    {
        $sql = "SELECT * FROM $this->tb_name_dm";
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
    public function getTheLoai(){
        $sql = "SELECT * FROM tb_the_loai";
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }

    public function SaveNew()
    {

//        public $ten_film = $_POST['ten_film'];
//        public $link_anh = $_POST['link_anh'];
//        public $thong_tin_phim = $_POST['thong_tin_phim'];
//        public $danh_muc = $_POST['danh_muc'];
//        public $dao_dien = $_POST['dao_dien'];
//        public $thoi_luong = $_POST['thoi_luong'];
//        public $quoc_gia = $_POST['quoc_gia'];
        $sqlInsert = "INSERT INTO $this->tb_name(ten_film,ten_film_english,link_anh,thong_tin_film,id_dao_dien,thoi_luong,id_nam_phat_hanh,id_quoc_gia,id_tai_khoan,ngay_them)
          VALUES ('$this->ten_film','$this->ten_film_english','$this->link_anh','$this->thong_tin_film','$this->dao_dien','$this->thoi_luong','$this->nam_phat_hanh','$this->quoc_gia','$this->id_tai_khoan','$this->ngay_them')";

        $res = mysqli_query($this->getConn(), $sqlInsert);

        if (mysqli_errno($this->getConn()))
            return mysqli_error($this->getConn());

        if ($res)
            return mysqli_insert_id($this->getConn()); // trả về ID mới
        else
            return "Không insert được";
    }

    public function loadOne($id)
    {
        $sql = "SELECT * FROM $this->tb_name WHERE id= $id";
        $objRes = new stdClass();
        $res = mysqli_query($this->getConn(), $sql);
        if (mysqli_errno($this->getConn())) {
            $objRes->error = mysqli_error($this->getConn());
            return $objRes;
        }

        if (mysqli_num_rows($res) != 1) {
            $objRes->error = "Lỗi không xác định bản ghi cần chỉnh sửa";
            return $objRes;
        }

        $row = mysqli_fetch_assoc($res); // lấy dòng dữ liệu
        foreach ($row as $field_name => $value)
            $objRes->$field_name = $value;

        return $objRes;

    }

    public function SaveUpdate()
    {
        // public $ten_film;
        // public $link_anh;
        // public $thong_tin_film;
        // public $danh_muc;
        // public $dao_dien;
        // public $thoi_luong;
        // public $quoc_gia;
        // public $nam_phat_hanh;
        // public $ngay_them;
        // public $ngay_cap_nhat;
        $sqlUpdate = "UPDATE $this->tb_name SET ten_film='$this->ten_film',ten_film_english='$this->ten_film_english',link_anh='$this->link_anh',thong_tin_film='$this->thong_tin_film',id_dao_dien='$this->dao_dien',thoi_luong='$this->thoi_luong',id_quoc_gia='$this->quoc_gia',id_nam_phat_hanh='$this->nam_phat_hanh',ngay_cap_nhat='$this->ngay_cap_nhat' WHERE id=$this->id";
        $res = mysqli_query($this->getConn(), $sqlUpdate);

        if (mysqli_errno($this->getConn()))
            return mysqli_error($this->getConn());

        if ($res)
            return mysqli_insert_id($this->getConn()); // trả về ID mới
        else
            return "Không cập nhật  được";

    }

    public function Delete($id)
    {
        $sqlDelete = "DELETE FROM $this->tb_name WHERE id = $id";


        $res = mysqli_query($this->getConn(), $sqlDelete);

        if (mysqli_errno($this->getConn()))
            return mysqli_error($this->getConn());

        if ($res)
            return mysqli_insert_id($this->getConn()); // trả về ID mới
        else
            return "Không Xóa được";


    }

    public function listDanhMucPhimBo()
    {
        $sql = "select * from tb_tap_film
INNER JOIN tb_film as tb3 ON tb_tap_film.id_film = tb3.id
WHERE tb_tap_film.id IN (select max(tb2.id) from tb_tap_film as tb2 GROUP BY tb2.id_film)
AND tb_tap_film.id_film IN (select DISTINCT id_film from tb_chi_tiet_danh_muc as tb3  WHERE id_danh_muc = 1)
ORDER BY tb_tap_film.id desc
limit 8";
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }

    public function listDanhMucPhimLe()
    {
        $sql = "select * from tb_tap_film
INNER JOIN tb_film as tb3 ON tb_tap_film.id_film = tb3.id
WHERE tb_tap_film.id IN (select max(tb2.id) from tb_tap_film as tb2 GROUP BY tb2.id_film) 
AND tb_tap_film.id_film IN (select DISTINCT id_film from tb_chi_tiet_danh_muc as tb3  WHERE id_danh_muc = 2)  
ORDER BY tb_tap_film.id desc
limit 8";
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }

    public function listDanhMucPhimChieuRap()
    {
        $sql = "select * from tb_tap_film
INNER JOIN tb_film as tb3 ON tb_tap_film.id_film = tb3.id
WHERE tb_tap_film.id IN (select max(tb2.id) from tb_tap_film as tb2 GROUP BY tb2.id_film) 
AND tb_tap_film.id_film IN (select DISTINCT id_film from tb_chi_tiet_danh_muc as tb3  WHERE id_danh_muc = 3)  
ORDER BY tb_tap_film.id desc
limit 8";
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }

    public function listDanhMucPhimAnime()
    {
        $sql = "select * from tb_tap_film
INNER JOIN tb_film as tb3 ON tb_tap_film.id_film = tb3.id
WHERE tb_tap_film.id IN (select max(tb2.id) from tb_tap_film as tb2 GROUP BY tb2.id_film) 
AND tb_tap_film.id_film IN (select DISTINCT id_film from tb_chi_tiet_danh_muc as tb3  WHERE id_danh_muc = 4)  
ORDER BY tb_tap_film.id desc
limit 8";
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;

    }
    public function getSlide(){
        $sql = "SELECT * FROM tb_slide,tb_film WHERE tb_film.id = tb_slide.id_film ORDER BY tb_slide.id DESC LIMIT 8";
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
}