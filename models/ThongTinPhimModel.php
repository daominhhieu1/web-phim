<?php
class ThongTinPhimModel extends MyModel
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
    public function loadOne($id)
    {

        $sql = "SELECT tb_film.id,tb_tap_film.id_film,ten_film,ten_film_english,link_anh,thong_tin_film,id_quoc_gia,thoi_luong,ten_dao_dien,ten_quoc_gia,nam_phat_hanh,ten_tap
                FROM tb_film,tb_dao_dien,tb_quoc_gia,tb_nam_phat_hanh,tb_tap_film
                WHERE tb_dao_dien.id = tb_film.id_dao_dien
                AND tb_nam_phat_hanh.id = tb_film.id_nam_phat_hanh
                AND tb_quoc_gia.id = tb_film.id_quoc_gia
                AND tb_tap_film.id_film = tb_film.id
                AND tb_film.id = $id
                GROUP BY ten_film
                ORDER BY ten_tap ASC
                LIMIT 1";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
    public function loadDienVienFilm($id){
        $sql = "SELECT ten_dien_vien FROM tb_dien_vien,tb_chi_tiet_film WHERE tb_dien_vien.id = tb_chi_tiet_film.id_dien_vien AND id_film = $id";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
    public function loadTheLoaiFilm($id){
        $sql = "SELECT ten_the_loai,id_the_loai FROM tb_the_loai,tb_chi_tiet_the_loai WHERE tb_the_loai.id = tb_chi_tiet_the_loai.id_the_loai AND id_film = $id";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
    public function loadRelated($id){
        $sql = "select * from tb_tap_film
INNER JOIN tb_film as tb3 ON tb_tap_film.id_film = tb3.id
WHERE tb_tap_film.id IN (select max(tb2.id) from tb_tap_film as tb2 GROUP BY tb2.id_film) 
AND tb_tap_film.id_film IN (select DISTINCT id_film from tb_chi_tiet_danh_muc as tb3  WHERE id_danh_muc = $id)  
ORDER BY tb_tap_film.id desc
limit 8";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }

}