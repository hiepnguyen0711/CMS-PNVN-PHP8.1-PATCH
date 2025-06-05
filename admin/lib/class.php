<?php
class func_index
{
    // global $rf;
    var $db = "";
    var $result = "";
    var $insert_id = "";
    var $sql = "";
    var $table = "";
    var $where = "";
    var $order = "";
    var $limit = "";

    var $servername = "";
    var $username = "";
    var $password = "";
    var $database = "";
    var $refix = "";

    function __construct($config = array())
    {
        if (!empty($config)) {
            $this->init($config);
            $this->connect();
        }
    }

    function init($config = array())
    {
        foreach ($config as $k => $v)
            $this->$k = $v;
    }

    function connect()
    {
        try {
            $this->db = new PDO("mysql:host=$this->servername;dbname=$this->database;charset=utf8", $this->username, $this->password);
            // set the PDO error mode to exception
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->exec("set names utf8");
            // echo "Connected successfully"; 

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    function disconnect()
    {
        $this->db = null;
    }

    function select($str = "*")
    {
        $this->sql = "select " . $str;
        $this->sql .= " from " . $this->refix . $this->table;
        $this->sql .=  $this->where;
        $this->sql .=  $this->order;
        $this->sql .=  $this->limit;
        $this->sql = str_replace('#_', $this->refix, $this->sql);
        return $this->query();
    }

    function query($sql)
    {
        $this->sql = str_replace('#_', $this->refix, $sql);
        $stmt = $this->db->prepare($this->sql);
        return $stmt->execute();
    }

    function fetch_array($sql)
    {

        $arr = array();
        $this->sql = str_replace('#_', $this->refix, $sql);
        $stmt = $this->db->prepare($this->sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function fetch()
    {
        $arr = array();
        $this->sql = str_replace('#_', $this->refix, $this->sql);
        $stmt = $this->db->prepare($this->sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function o_fet($sql)
    {
        $this->sql = $sql;
        return $this->fetch();
    }
    public function o_fet_class($sql)
    {
        $this->sql = $sql;
        return $this->fetch_class();
    }
    public function fetch_class()
    {
        $arr = array();
        $this->sql = str_replace('#_', $this->refix, $this->sql);
        $stmt = $this->db->prepare($this->sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function o_sel($sel, $table, $where = "", $order = "", $limit = "")
    {
        if ($where <> '')  $where = " where " . $where;
        else $where = "";
        if ($order <> '')  $order = " order by " . $order;
        else $order = "";
        if ($limit <> '')  $limit = " limit " . $limit;
        else $limit = "";
        $sql = "select " . $sel . " from " . $table . " " . $where . $order . $limit;
        $this->sql = $sql;
        return $this->fetch();
    }
    public function o_que($sql)
    {
        $this->sql = $sql;
        return $this->que();
    }
    function assoc_array($sql)
    {
        $this->sql = str_replace('#_', $this->refix, $sql);
        $stmt = $this->db->prepare($this->sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function num_rows($sql)
    {
        $this->sql = str_replace('#_', $this->refix, $sql);
        $stmt = $this->db->prepare($this->sql);
        $stmt->execute();
        return $stmt->rowCount();
    }

    function num()
    {
        $this->sql = str_replace('#_', $this->refix, $this->sql);
        $stmt = $this->db->prepare($this->sql);
        $stmt->execute();
        return $stmt->rowCount();
    }

    function que()
    {
        $this->sql = str_replace('#_', $this->refix, $this->sql);
        $stmt = $this->db->prepare($this->sql);
        return $stmt->execute();
    }

    function setTable($str)
    {
        $this->table = $str;
    }

    function setWhere($col, $dk)
    {
        if ($this->where == "") {
            $this->where = " where " . $col . " = '" . $dk . "'";
        } else {
            $this->where .= " and " . $col . " = '" . $dk . "'";
        }
    }

    function setWhereOrther($col, $dk)
    {
        if ($this->where == "") {
            $this->where = " where " . $col . " <> '" . $dk . "'";
        } else {
            $this->where .= " and " . $col . " <> '" . $dk . "'";
        }
    }

    function setWhereOr($col, $dk)
    {
        if ($this->where == "") {
            $this->where = " where " . $col . " = '" . $dk . "'";
        } else {
            $this->where .= " or " . $col . " = '" . $dk . "'";
        }
    }

    function setOrder($str)
    {
        $this->order = " order by " . $str;
    }

    function setLimit($str)
    {
        $this->limit = " limit " . $str;
    }

    function reset()
    {
        $this->sql = "";
        $this->result = "";
        $this->where = "";
        $this->order = "";
        $this->limit = "";
        $this->table = "";
    }

    function insert($data = array())
    {
        $into = "";
        $values = "";
        foreach ($data as $int => $val) {
            $into .= "," . $int;
            $values .= ",'" . $val . "'";
        }
        if ($into{
            0} == ",") $into{
            0} = "(";
        $into .= ")";
        if ($values{
            0} == 0) $values{
            0} = "(";
        $values .= ")";

        $this->sql = "insert into " . $this->table . $into . " values " . $values;
        $this->sql = str_replace('#_', $this->refix, $this->sql);

        $stmt = $this->db->prepare($this->sql);
        $stmt->execute();
        return $this->db->lastInsertId();
    }
    // function insert($data = array())
    // {
    //     $fields = array_keys($data);
    //     $placeholders = array_fill(0, count($fields), '?');

    //     $this->sql = "INSERT INTO " . $this->table . " (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
    //     $this->sql = str_replace('#_', $this->refix, $this->sql);

    //     $stmt = $this->db->prepare($this->sql);

    //     // Bind parameters
    //     $index = 1;
    //     foreach ($data as $value) {
    //         $stmt->bindValue($index++, $value);
    //     }

    //     $stmt->execute();
    //     return $this->db->lastInsertId();
    // }

    function update($data = array())
    {
        $values = "";
        foreach ($data as $col => $val) {
            $values .= "," . $col . " = '" . $val . "' ";
        }
        if ($values{
            0} == ",") $values{
            0} = " ";
        $this->sql = "update " . $this->table . " set " . $values . $this->where;

        $this->sql = str_replace('#_', $this->refix, $this->sql);
        $this->result = $this->query($this->sql);
        return $this->result;
    }

    function delete()
    {
        $this->sql = "delete from " . $this->table . $this->where;
        $this->sql = str_replace('#_', $this->refix, $this->sql);
        return $this->query($this->sql);
    }
    // other-----------------------------
    function alert($str)
    {
        echo '<script language="javascript"> alert("' . $str . '") </script>';
    }

    function location($url)
    {
        echo '<script language="javascript">window.location = "' . $url . '" </script>';
    }
    function checkLink($alias, $id = '')
    {
        if ($id != '') {
            $where = " and id <> " . $id;
        } else {
            $where = "";
        }
        $row_cate = $this->num_rows("select * from #_category where alias = '$alias' $where ");
        $row_sanpham = $this->num_rows("select * from #_sanpham where alias = '$alias' $where ");
        $row_tintuc = $this->num_rows("select * from #_tintuc where alias = '$alias' $where ");
        if ($row_cate == 0 and $row_sanpham == 0 and $row_tintuc == 0) {
            return 1;
        } else {
            return 0;
        }
    }
    function fullAddress()
    {
        $adr = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
        $adr .= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
        $adr .= isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
        $adr2 = explode('&page=', $adr);
        return $adr2[0];
    }

    function fullAddress1()
    {
        $adr = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
        $adr .= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
        $adr .= isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
        $adr2 = explode('&page=', $adr);
        $adr3 = explode('&sort=', $adr2[0]);
        return $adr3[0];
    }
    function fullAddress2()
    {
        $adr = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
        $adr .= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
        $adr .= isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
        $adr2 = explode('&page=', $adr);
        $adr3 = explode('&limit=', $adr2[0]);
        return $adr3[0];
    }

    function fns_Rand_digit($min, $max, $num)
    {
        $result = '';
        for ($i = 0; $i < $num; $i++) {
            $result .= rand($min, $max);
        }
        return $result;
    }
    function simple_fetch($sql)
    {
        $arr = array();
        $this->sql = str_replace('#_', $this->refix, $sql);
        $stmt = $this->db->prepare($this->sql);
        $stmt->execute();
        // $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        $result = $stmt->fetchAll();
        if (!empty($result)) {
            return $result[0];
        }
        return array();
    }
    function findIdSub($id, $level = 0)
    {
        $str = "";
        $query = $this->o_fet("select * from #_category where id_loai=$id and hien_thi=1 order by so_thu_tu asc, id desc");
        if (count($query > 0)) {
            foreach ($query as $item) {
                $str .= "," . $item['id'];
                $check = $this->o_fet("select * from #_category where id_loai={$item['id']} and hien_thi=1 order by so_thu_tu asc, id desc");
                if (count($check) > 0 && $level == 0) {
                    $str .= $this->findIdSub($item['id']);
                }
            }
        }
        return $str;
    }

    function breadcrumbid($id)
    {
        $str = "";
        $query = $this->simple_fetch("select * from cf_code where id=$id and hien_thi=1");
        $str .= $query['id'] . ",";
        if ($query['id_loai'] > 0) {
            $i++;
            $str = $this->breadcrumbid($query['id_loai']) . $str;
        }
        return $str;
    }
    function breadcrumblist($id)
    {
        $BreadcrumbList =  trim($this->breadcrumbid($id, $path), ',');
        $arrBrceList = explode(',', $BreadcrumbList);
        $dem = count($arrBrceList);
        $j = 2;
        $itemBrcelist = "";
        for ($i = 0; $i < count($arrBrceList); $i++) {
            if ($i + 1 == $dem) {
                $act = 'active';
            } else {
                $act = "";
            }
            $row = $this->simple_fetch("select * from #_category where id_code = '" . $arrBrceList[$i] . "' and lang ='" . _lang . "'");
            $itemBrcelist .= '
                <li property="itemListElement" typeof="ListItem" class="breadcrumb-item ' . $act . '">
                    <a property="item" typeof="WebPage" href="' . URLLANG . $row['alias'] . '.html">
                    <span property="name">' . $row['ten'] . '</span></a>
                    <meta property="position" content="' . $j . '">
                </li>';
            $j++;
        }
        $Brcelist = '
        <ol vocab="https://schema.org/" typeof="BreadcrumbList" class="breadcrumb"> 
            <li property="itemListElement" typeof="ListItem" class="breadcrumb-item">
                <a property="item" typeof="WebPage" href="' . URLLANG . '">
                <span property="name">' . $this->getTxt(11) . '</span></a>
                 <meta property="position" content="1">
            </li>
            ' . $itemBrcelist . '
        </ol>';
        return $Brcelist;
    }
    function clear($html)
    {
        $str = "";
        $str = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);
        return $str;
    }

    function generateUniqueToken($username)
    {
        $token = time() . rand(10, 5000) . sha1(rand(10, 5000)) . md5(__FILE__);
        $token = str_shuffle($token);
        $token = sha1($token) . md5(microtime()) . md5($username);
        return $token;
    }
    function getPassHash($token, $password)
    {
        $password_hash = md5(md5($token) . md5($password));
        return $password_hash;
    }

    function clean($str)
    {
        $str = @trim($str);
        
        return strip_tags($str);
    }

    function subText($text, $num)
    {
        $str_len = strlen($text);
        if ($str_len < $num) {
            $str = $text;
        } else {
            $str = mb_substr($text, 0, $num, 'UTF-8') . "...";
        }
        return $str;
    }
    function redirect($url = '')
    {
        echo '<script language="javascript">window.location = "' . $url . '" </script>';
        exit();
    }
    function link_redirect($alias = '')
    {
        $link_web = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $link_goc = URLPATH . $alias;

        if ($link_web != $link_goc) {
            $this->redirect($link_goc);
        }
    }

    function array_category($id_loai = 0, $plit = "=", $select_ = "", $module = 0, $notshow = 0, $level = 0)
    {

        $str = "";
        $and = ($notshow > 0) ? " and id!=$notshow" : '';

        if ($id_loai == 0) {
            $query = $this->o_fet("select * from cf_code where id_loai=0 $and order by so_thu_tu asc, id desc");
            echo $d->sql;
            $plit = "";
        } else {
            $query = $this->o_fet("select * from cf_code where id_loai=$id_loai $and order by so_thu_tu asc, id desc");
            echo $d->sql;
            // Chèn thêm $level vào trước $plit
            $plit .= "= ";
        }

        foreach ($query as $item) {

            $disable = '';
            $bold = '';



            if ($item['id'] == $select_) {
                $selected = "selected='selected'";
            } else {
                $selected = "";
            }
            if ($module > 0) {


                if ($item['module'] == $module) {
                    $str .= "<option value='" . $item['id'] . "' . $disable . " . $selected . " >" . $plit . " " . "<span style='{$bold}' >" . $item['ten'] . "</span>" . "</option>";
                }
            } else {
                $str .= "<option value='" . $item['id'] . "' " . $selected . ">" . $plit . " " . $item['ten'] . "</option>";
            }

            $check_sub = $this->num_rows("select * from cf_code where id_loai='{$item['id']}'");

            if ($check_sub > 0) {
                // Đoạn lặp đệ quy gọi lại hàm
                $str .= $this->array_category($item['id'], $plit, $select_, $module, $notshow, $level + 1);
            }
        }
        return $str;
    }

    function many_extra($post)
    {
        $str = "";
        $post = $this->clear($post);
        foreach ($post as $item) {
            $str .= "," . $item;
        }
        return $str;
    }
    function getIdsub($id_code)
    {
        //$lis_id .= $id_code;
        $query = $this->o_fet("select * from cf_code where id_loai= $id_code");
        foreach ($query as $key => $value) {
            $lis_id .= ',' . $value['id'];
            $query2 = $this->o_fet("select * from cf_code where id_loai= " . $value['id']);
            if (count($query2) > 0) {
                $lis_id .= $this->getIdsub($value['id']);
            }
        }
        return  $lis_id;
    }
    public function checkPermission($id_user, $id_page)
    {
        if ($_SESSION['is_admin'] == 1) {
            return 1;
        } else {
            $query = $this->o_fet("select * from #_user_permission_group where id_user = $id_user and id_permission in ($id_page)");
            if (count($query) > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }
    public function checkPermission_view($id_page)
    {
        if ($_SESSION['is_admin'] == 1) {
            return 1;
        } else {
            $query = $this->o_fet("select * from #_user_permission_group where id_user = " . $_SESSION['id_user'] . " and id_permission = $id_page and (action like '%1%' or action like '%2%' or action like '%3%') ");
            if (count($query) > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function checkPermission_edit($id_page)
    {
        if ($_SESSION['is_admin'] == 1) {
            return 1;
        } else {
            $query = $this->o_fet("select * from #_user_permission_group where id_user = " . $_SESSION['id_user'] . " and id_permission = $id_page and (action like '%3%' or action like '%2%')");
            if (count($query) > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function checkPermission_dele($id_page)
    {
        if ($_SESSION['is_admin'] == 1) {
            return 1;
        } else {
            $query = $this->o_fet("select * from #_user_permission_group where id_user = " . $_SESSION['id_user'] . " and id_permission = $id_page and (action like '%3%')");
            if (count($query) > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }
    function get_nav_act($id)
    {
        $BreadcrumbList =  trim($this->breadcrumbid($id, $path), ',');
        $arrBrceList = explode(',', $BreadcrumbList);
        return $arrBrceList[0];
    }
    function getnews($id_code, $col = '*')
    {
        $row = $this->simple_fetch("select $col from #_tintuc where id_code = $id_code and hien_thi = 1 " . _where_lang . "");
        return $row;
    }
    function getNewss($id_code, $col = '*', $home = '', $limit = '', $where2 = '')
    {
        if ($home != '') {
            $where = " and noi_bat = 1";
        } else {
            $where = "";
        }
        if ($limit != '') {
            $limit_txt = "limit " . $limit;
        } else {
            $limit_txt = '';
        }
        $list_id = $id_code . $this->getIdsub($id_code);
        $row = $this->o_fet("select $col from #_tintuc where id_loai in ($list_id) $where2 and hien_thi =1 " . _where_lang . " order by so_thu_tu ASC, id DESC $limit_txt");
        return $row;
    }
    function getProduct($id_code, $col = '*')
    {
        $row = $this->simple_fetch("select $col from #_sanpham where id_code = $id_code and hien_thi = 1 " . _where_lang . "");
        return $row;
    }
    function getProducts($id_code, $home = '', $limit = '')
    {
        if ($home != '') {
            $where = " and tieu_bieu = 1";
        } else {
            $where = "";
        }
        if ($limit != '') {
            $limit_txt = "limit " . $limit;
        } else {
            $limit_txt = '';
        }
        $list_id = $id_code . $this->getIdsub($id_code);
        $row = $this->o_fet("select * from #_sanpham where id_loai in ($list_id) $where and hien_thi =1 " . _where_lang . " order by so_thu_tu ASC, id DESC $limit_txt");
        return $row;
    }
    function getCate($id_code, $col = '*')
    {
        $row = $this->simple_fetch("select $col from #_category where id_code = $id_code and hien_thi = 1 " . _where_lang . "");
        if ($col == '*') {
            return $row;
        } else {
            return $row[$col];
        }
    }
    function getCates($id_code, $home = '')
    { //1:check home - 2:check menu
        if ($home == '1') {
            $where = " and tieu_bieu = 1";
        } elseif ($home == '2') {
            $where = " and menu = 1";
        } else {
            $where = "";
        }
        $row = $this->o_fet("select * from #_category where id_loai = $id_code $where and hien_thi =1 " . _where_lang . " order by so_thu_tu ASC, id DESC");
        return $row;
    }
    function getContent($id_code, $col = '')
    {
        if ($col == '') {
            $row = $this->simple_fetch("select * from #_category_noidung where hien_thi = 1  and id_code = $id_code " . _where_lang . "");
            return $row;
        } else {
            $row = $this->simple_fetch("select $col from #_category_noidung where hien_thi = 1  and id_code = $id_code " . _where_lang . "");
            return $row[$col];
        }
    }
    function getContents($id_code, $limit = '')
    {
        if ($limit != '') {
            $where = " limit 0," . $limit;
        } else {
            $where = "";
        }
        $row = $this->o_fet("select * from #_content where hien_thi = 1 and id_loai = $id_code " . _where_lang . " order by so_thu_tu ASC, id DESC $where");
        return $row;
    }
    function getContent_id($id_code, $limit = '')
    {
        if ($limit != '') {
            $where = " limit 0," . $limit;
        } else {
            $where = "";
        }
        $row = $this->simple_fetch("select * from #_content where hien_thi = 1 and id_code = $id_code " . _where_lang . " order by so_thu_tu ASC, id DESC $where");
        return $row;
    }
    function getData($tale, $col = '', $where = '', $limit = '')
    {
        if ($limit != '') {
            $limited = 'limit 0,' . $limit;
        } else {
            $limited = "";
        }
        if ($col != '') {
            $col_txt = $col;
        } else {
            $col_txt = '*';
        }
        if ($where != "") {
            $where_txt = " and $where";
        } else {
            $where_txt = '';
        }
        $row = $this->o_fet("select $col_txt from #_" . $tale . " where hien_thi = 1 $where_txt order by so_thu_tu ASC, id DESC $limited");
        return $row;
    }
    function getTinh($col = '*', $id = '')
    {
        if ($id == '') {
            $row = $this->o_fet("select $col from #_thanhpho order by ten ASC ");
        } else {
            $row = $this->simple_fetch("select $col from #_thanhpho where code= '" . $id . "' order by ten ASC ");
        }
        return $row;
    }
    function getHuyen($code_tinh, $col = '*', $code = '')
    {
        if ($code == '') {
            $row = $this->o_fet("select $col from #_huyen where code_tinh ='" . $code_tinh . "' order by ten ASC ");
        } else {
            $row = $this->simple_fetch("select $col from #_huyen where code_tinh ='" . $code_tinh . "' and code= '" . $code . "' order by ten ASC ");
        }
        return $row;
    }
    function getXa($code_huyen, $col = '*', $code = '')
    {
        if ($code == '') {
            $row = $this->o_fet("select $col from #_xa where code_huyen ='" . $code_huyen . "' order by ten ASC ");
        } else {
            $row = $this->simple_fetch("select $col from #_xa where code_huyen ='" . $code_huyen . "' and code='" . $code . "' order by ten ASC ");
        }
        return $row;
    }

    function getDataId($tale, $id_code, $col = '*')
    {
        $row = $this->simple_fetch("select $col from #_" . $tale . " where id_code = $id_code  limit 0,1");
        return $row;
    }
    function getTxt($id)
    {
        $row = $this->simple_fetch("select text from #_text where id = $id ");
        $str = $row['text'];
        $arr_txt = json_decode($str, true);
        return $arr_txt[_lang];
    }
    function getReview($id_sp)
    {
        //echo "select * from db_binhluan where id_sanpham =".(int)$id_sp." and trang_thai = 1 and parent=0 and danh_gia > 0 ";
        $row = $this->simple_fetch("select * from #_sanpham where id_code = " . $id_sp . " ");
        $count_bl = $this->num_rows("select * from #_binhluan where id_sanpham =" . (int)$id_sp . " and trang_thai = 1 and parent=0 and danh_gia > 0 ");
        $tongsao = $this->simple_fetch("select sum(danh_gia) as tong from #_binhluan where id_sanpham =" . (int)$id_sp . " and trang_thai = 1 and parent=0 and danh_gia > 0 order by id DESC ");
        if ($count_bl > 0) {
            $sao_trung_binh = $tongsao['tong'] / $count_bl;
        } else {
            $sao_trung_binh = 0;
        }

        if ($sao_trung_binh > 0) {
            $sao = '';
            for ($i = 0; $i < $sao_trung_binh; $i++) {
                $sao .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
</svg>';
            }
            for ($i = 0; $i < 5 - $sao_trung_binh; $i++) {
                $sao .=  '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
</svg>';
            }
        } else {
            $sao = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
</svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
</svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
</svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
</svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
</svg>';
        }
        //$tong_ban = $this->simple_fetch("SELECT id_sp, SUM(so_luong) as tong FROM `db_dathang_chitiet` WHERE id_sp= ".(int)$id_sp." GROUP BY id_sp");
        $review = '<span>' . $sao_trung_binh . '</span><ul class="rating-d"> ' . $sao . ' </ul> <span>Đã bán <b>' . $row['da_ban'] . '</b></span>';
        return $review;
    }
    function getReview2($id_sp)
    {
        //echo "select * from db_binhluan where id_sanpham =".(int)$id_sp." and trang_thai = 1 and parent=0 and danh_gia > 0 ";
        $row = $this->simple_fetch("select * from #_sanpham where id_code = " . $id_sp . " ");
        $count_bl = $this->num_rows("select * from #_binhluan where id_sanpham =" . (int)$id_sp . " and trang_thai = 1 and parent=0 and danh_gia > 0 ");
        $tongsao = $this->simple_fetch("select sum(danh_gia) as tong from #_binhluan where id_sanpham =" . (int)$id_sp . " and trang_thai = 1 and parent=0 and danh_gia > 0 order by id DESC ");
        if ($count_bl > 0) {
            $sao_trung_binh = $tongsao['tong'] / $count_bl;
        } else {
            $sao_trung_binh = 0;
        }

        if ($sao_trung_binh > 0) {
            $sao = '';
            for ($i = 0; $i < $sao_trung_binh; $i++) {
                $sao .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
</svg>';
            }
            for ($i = 0; $i < 5 - $sao_trung_binh; $i++) {
                $sao .=  '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
</svg>';
            }
        } else {
            $sao = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
</svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
</svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
</svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
</svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
</svg>';
        }
        $tong_ban = $this->simple_fetch("SELECT id_sp, SUM(so_luong) as tong FROM `db_dathang_chitiet` WHERE id_sp= " . (int)$id_sp . " GROUP BY id_sp");
        $review = '<span style="position: relative;top: 3px;">' . $sao_trung_binh . '</span><ul class="rating-d"> ' . $sao . ' </ul> |<span class="px-2">( <b>' . $count_bl . '</b> đánh giá )</span> | <span class="px-2">Đã bán <b>' . $row['da_ban'] . '</b></span>';
        return $review;
    }
    function showthongtin($data = '')
    {
        $url = URLPATH;
        $mxh        =   $this->simple_fetch("select * from #_thongtin where lang = '" . $_SESSION['lang'] . "'");
        if ($data == '') {
            return $mxh;
        } else {
            if ($data == 'logo') {
                $text = $url . 'img_data/images/' . $mxh['icon_share'];
            } elseif ($data == 'favicon') {
                $text = $url . 'img_data/images/' . $mxh['favicon'];
            } elseif ($data == 'backlink') {
                $text = '<a href="http://phuongnamvina.vn/" target="_blank" title="Design Web: PhuongNamVina">Design Web: PhuongNamVina</a>';
            } else {
                $text = $mxh[$data];
            }
            return $text;
        }
    }

    public function get_link_lang($com, $lang)
    {
        if ($com != '') {
            $arrtable = ['category', 'sanpham', 'tintuc'];
            foreach ($arrtable as $value) {
                $sql = "select id_code from #_{$value} where alias='{$com}'";
                $result = $this->simple_fetch($sql);
                // var_dump($sql);
                if ($result) {
                    $link = $this->simple_fetch("select alias from #_{$value} where id_code = {$result['id_code']} and lang = '{$lang}' ");
                    return $lang . "/" . $link['alias'] . ".html";
                }
            }
            return $com . ".html";
        } else {
            return $lang . "/";
        }
    }

    // Cart

    function product_exists($code = '', $q = 1)
    {
        $flag = 0;
        if (isset($_SESSION['cart']) && $code != '') {

            $q = ($q > 1) ? $q : 1;

            $max = count($_SESSION['cart']);

            for ($i = 0; $i < $max; $i++) {

                if ($code == $_SESSION['cart'][$i]['code']) {


                    $_SESSION['cart'][$i]['soluong'] += $q;

                    $flag = 1;
                }
            }
        }


        return $flag;
    }

    function addtocart($q = 1, $pid = 0, $mau = 0, $size = 0)
    {
        $code = md5($pid . $mau . $size);

        if ($pid < 1 or $q < 1) return;
        if (isset($_SESSION['cart'])) {

            if (!$this->product_exists($code, $q)) {

                $max = count($_SESSION['cart']);

                $_SESSION['cart'][$max]['productid'] = $pid;

                $_SESSION['cart'][$max]['soluong'] = $q;

                $_SESSION['cart'][$max]['mau'] = $mau;

                $_SESSION['cart'][$max]['size'] = $size;

                $_SESSION['cart'][$max]['code'] = $code;
            }
        } else {

            $_SESSION['cart'] = array();

            $_SESSION['cart'][0]['productid'] = $pid;

            $_SESSION['cart'][0]['soluong'] = $q;

            $_SESSION['cart'][0]['mau'] = $mau;

            $_SESSION['cart'][0]['size'] = $size;

            $_SESSION['cart'][0]['code'] = $code;
        }
    }

    public function get_order_total()
    {
        $sum = 0;
        if (isset($_SESSION['cart'])) {
            $max = count($_SESSION['cart']);
            for ($i = 0; $i < $max; $i++) {
                $pid = $_SESSION['cart'][$i]['productid'];
                $q = $_SESSION['cart'][$i]['soluong'];

                $proinfo = $this->simple_fetch("select * from #_sanpham where id_code={$pid} ");

                if ($proinfo['khuyen_mai']) $price = $proinfo['khuyen_mai'];

                else $price = $proinfo['gia'];

                $sum += ($price * $q);
            }
        }
        return $sum;
    }

    // Chuyển tiền tệ start

    function chuyentiente($key = 'fc01aba01229377741b9e9fa')
    {

        $api_key = $key;
        $req_url = 'https://v6.exchangerate-api.com/v6/fc01aba01229377741b9e9fa/latest/USD';
        $response_json = file_get_contents($req_url);
        // Continuing if we got a result
        if (false !== $response_json) {
            // Try/catch for json_decode operation
            try {

                // Decoding
                $response = json_decode($response_json);

                // Check for success
                if ('success' === $response->result) {
                    // YOUR APPLICATION CODE HERE, e.g.
                    // $base_price = $amount; // Your price in VND
                    // return $USD_price = round(($base_price * $response->conversion_rates->USD), 2);
                    return $response->conversion_rates->VND;
                }
            } catch (Exception $e) {
            }
        }
        return 1;
    }
    // Chuyển tiền tệ end

    // Check level danh mục start
    function checkLevelCategory($id)
    {
        $category = $this->getCate($id); // Lấy thông tin danh mục
        // Nếu không có danh mục cha là cấp 0    
        if ($category['id_loai'] == 0) {
            return 0;
        }
        // Lấy danh mục cha
        $parent = $this->getCate($category['id_loai']);

        // Gọi đệ quy để tìm cấp độ
        $parent_level = $this->checkLevelCategory($parent['id_code']);

        // Trả về cấp độ
        return $parent_level + 1;
    }
    // Check level danh mục end

    // lấy các danh mục theo module
    function get_cate_module($module, $lang = 'vi')
    {
        // danh sách tuyển dụng hot
        $category_module = $this->o_fet("select id_code from #_category where module = {$module} and lang = '{$lang}'");
        $category_module_array = "";
        foreach ($category_module as $key => $v) {
            $category_module_array .= $v['id_code'] . ",";
        }
        $category_module_id = rtrim($category_module_array, ",");
        return $category_module_id;
    }
}
