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
        // CRUD Fix Phase 1: Enhanced config handling for backward compatibility
        if (isset($config['database'])) {
            // New config format: nested database array
            $db_config = $config['database'];
            $this->servername = $db_config['servername'];
            $this->username = $db_config['username'];
            $this->password = $db_config['password'];
            $this->database = $db_config['database'];
            $this->refix = $db_config['refix'];
        } else {
            // Original logic: direct assignment (for backward compatibility)
            foreach ($config as $k => $v) {
                if (property_exists($this, $k)) {
                    $this->$k = $v;
                }
            }
        }
    }

    function connect()
    {
        try {
            // CRUD Fix Phase 1: Ensure PDO object creation with proper error handling
            $this->db = new PDO("mysql:host=$this->servername;dbname=$this->database;charset=utf8mb4", $this->username, $this->password);
            // set the PDO error mode to exception
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->exec("set names utf8mb4");

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage() . "<br>";
            $this->db = null;
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
        // CRUD Fix Phase 2: Fixed query call to match old version behavior
        return $this->query($this->sql);
    }

    function query($sql)
    {
        $this->sql = str_replace('#_', $this->refix, $sql);
        try {
            if ($this->db instanceof PDO) {
                $stmt = $this->db->prepare($this->sql);
                return $stmt->execute();
            } else {
                throw new Exception("Database connection không hợp lệ");
            }
        } catch (Exception $e) {
            echo "Query Error: " . $e->getMessage() . "<br>";
            echo "SQL: " . $this->sql . "<br>";
            return false;
        }
    }

    function fetch_array($sql)
    {

        $arr = array();
        $this->sql = str_replace('#_', $this->refix, $sql);
        if ($this->db instanceof PDO) {
            $stmt = $this->db->prepare($this->sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } else {
            die("Database connection không hợp lệ");
        }
    }

    public function fetch()
    {
        $arr = array();
        $this->sql = str_replace('#_', $this->refix, $this->sql);
        if ($this->db instanceof PDO) {
            $stmt = $this->db->prepare($this->sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } else {
            die("Database connection không hợp lệ");
        }
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
        if ($this->db instanceof PDO) {
            $stmt = $this->db->prepare($this->sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } else {
            die("Database connection không hợp lệ");
        }
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
        if ($this->db instanceof PDO) {
            $stmt = $this->db->prepare($this->sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } else {
            die("Database connection không hợp lệ");
        }
    }

    function num_rows($sql)
    {
        $this->sql = str_replace('#_', $this->refix, $sql);
        if ($this->db instanceof PDO) {
            $stmt = $this->db->prepare($this->sql);
            $stmt->execute();
            return $stmt->rowCount();
        } else {
            die("Database connection không hợp lệ");
        }
    }

    function num()
    {
        $this->sql = str_replace('#_', $this->refix, $this->sql);
        if ($this->db instanceof PDO) {
            $stmt = $this->db->prepare($this->sql);
            $stmt->execute();
            return $stmt->rowCount();
        } else {
            die("Database connection không hợp lệ");
        }
    }

    function que()
    {
        $this->sql = str_replace('#_', $this->refix, $this->sql);
        if ($this->db instanceof PDO) {
            $stmt = $this->db->prepare($this->sql);
            return $stmt->execute();
        } else {
            die("Database connection không hợp lệ");
        }
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
        $this->table = "";
        $this->where = "";
        $this->order = "";
        $this->limit = "";
    }

    // insert function
    function insert($data = array())
    {
        $into = "";
        $values = "";
        foreach ($data as $int => $val) {
            $into .= "," . $int;
            $values .= ",'" . $val . "'";
        }
        // CRUD Fix Phase 3: Fixed string access for PHP 8.1 compatibility
        if (strlen($into) > 0 && $into[0] == ",") $into[0] = "(";
        $into .= ")";
        if (strlen($values) > 0 && $values[0] == ",") $values[0] = "(";
        $values .= ")";

        $this->sql = "insert into " . $this->table . $into . " values " . $values;
        $this->sql = str_replace('#_', $this->refix, $this->sql);

        if ($this->db instanceof PDO) {
            $stmt = $this->db->prepare($this->sql);
            $stmt->execute();
            return $this->db->lastInsertId();
        } else {
            die("Database connection không hợp lệ");
        }
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
        // CRUD Fix Phase 4: Fixed string access for PHP 8.1 compatibility
        if (strlen($values) > 0 && $values[0] == ",") $values[0] = " ";
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
        if ($this->db instanceof PDO) {
            $stmt = $this->db->prepare($this->sql);
            $stmt->execute();
            // $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
            $result = $stmt->fetchAll();
            if (!empty($result)) {
                return $result[0];
            }
            return array();
        } else {
            die("Database connection không hợp lệ");
        }
    }
    function findIdSub($id, $level = 0)
    {
        $str = "";
        $query = $this->o_fet("select * from #_category where id_loai=$id and hien_thi=1 order by so_thu_tu asc, id desc");
        if (count($query) > 0) {
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
            $str = $this->breadcrumbid($query['id_loai']) . $str;
        }
        return $str;
    }
    function breadcrumblist($id)
    {
        $BreadcrumbList =  trim($this->breadcrumbid($id), ',');
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
        // get_magic_quotes_gpc() was removed in PHP 8.0
        // Removed get_magic_quotes_gpc() check for PHP 8.1 compatibility
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
            // echo $this->sql; // Debug nếu cần
            $plit = "";
        } else {
            $query = $this->o_fet("select * from cf_code where id_loai=$id_loai $and order by so_thu_tu asc, id desc");
            // echo $this->sql; // Debug nếu cần
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
        $lis_id = ''; // Khởi tạo biến
        $query = $this->o_fet("select * from cf_code where id_loai= $id_code");
        foreach ($query as $key => $value) {
            $lis_id .= ',' . $value['id'];
            $query2 = $this->o_fet("select * from cf_code where id_loai= " . $value['id']);
            if (is_array($query2) && count($query2) > 0) {
                $lis_id .= $this->getIdsub($value['id']);
            }
        }
        return  $lis_id;
    }
    public function checkPermission($id_user, $id_page)
    {
        // CRUD Fix Phase 5: Restored original permission logic from old version
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
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
        // CRUD Fix Phase 5: Restored original permission logic from old version
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
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
        // CRUD Fix Phase 5: Restored original permission logic from old version  
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
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
        // CRUD Fix Phase 5: Restored original permission logic from old version
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
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
        // CRUD Fix Phase 6: Restored breadcrumb logic from old version
        $BreadcrumbList = trim($this->breadcrumbid($id), ',');
        $arrBrceList = explode(',', $BreadcrumbList);
        return $arrBrceList[0];
    }
    function getnews($id_code, $col = '*')
    {
        $row = $this->simple_fetch("SELECT $col FROM `#_tintuc`  WHERE id_code =" . $id_code . " and hien_thi = 1");
        return $row;
    }
    function getNewss($id_code, $col = '*', $home = '', $limit = '', $where2 = '')
    {
        if ($home == 1) {
            $andhome = " and home=1 ";
        } elseif ($home == 2) {
            $andhome = " and menu=1 ";
        } else {
            $andhome = "";
        }
        if ($limit != '') {
            $andLimit = " LIMIT $limit ";
        } else {
            $andLimit = "";
        }
        $row = $this->fetch_array("SELECT $col FROM `#_tintuc`  WHERE hien_thi = 1 $andhome $where2 order by so_thu_tu asc, id desc $andLimit");
        return $row;
    }
    function getProduct($id_code, $col = '*')
    {
        $row = $this->simple_fetch("SELECT $col FROM `#_sanpham`  WHERE id_code =" . $id_code . " and hien_thi = 1");
        return $row;
    }
    function getProducts($id_code, $home = '', $limit = '')
    {
        if ($home == 1) {
            $andhome = " and home=1 ";
        } elseif ($home == 2) {
            $andhome = " and menu=1 ";
        } elseif ($home == 3) {
            $andhome = " and home=1 and noibat=1 ";
        } elseif ($home == 4) {
            $andhome = " and huy=1 ";
        } else {
            $andhome = "";
        }
        if ($limit != '') {
            $andLimit = " LIMIT $limit ";
        } else {
            $andLimit = "";
        }
        $row = $this->fetch_array("SELECT * FROM `#_sanpham`  WHERE id_loai =" . $id_code . " and hien_thi = 1 $andhome order by so_thu_tu asc, id desc $andLimit");
        return $row;
    }

    function getCate($id_code, $col = '*')
    {
        $row = $this->simple_fetch("SELECT $col FROM `#_category`  WHERE id_code ='" . $id_code . "' and hien_thi = 1");
        return $row;
    }

    function getCates($id_code, $home = '')
    { //1:check home - 2:check menu
        if ($home == 1) {
            $andhome = " and home=1 ";
        } elseif ($home == 2) {
            $andhome = " and menu=1 ";
        } else {
            $andhome = "";
        }
        $row = $this->fetch_array("SELECT * FROM `#_category`  WHERE id_loai =" . $id_code . " and hien_thi = 1 $andhome order by so_thu_tu asc, id desc");
        return $row;
    }
    function getContent($id_code, $col = '')
    {
        if ($col != '') {
            $col2 = $col;
        } else {
            $col2 = "*";
        }
        $row = $this->simple_fetch("SELECT $col2 FROM `#_content`  WHERE id_code ='" . $id_code . "' and hien_thi = 1");
        return $row;
    }
    function getContents($id_code, $limit = '')
    {
        if ($limit != '') {
            $limit2 = " LIMIT $limit";
        } else {
            $limit2 = "";
        }
        $row = $this->fetch_array("SELECT * FROM `#_content`  WHERE id_loai =" . $id_code . " and hien_thi = 1 order by so_thu_tu asc, id desc $limit2");
        return $row;
    }
    function getContent_id($id_code, $limit = '')
    {
        if ($limit != '') {
            $limit2 = " LIMIT $limit";
        } else {
            $limit2 = "";
        }
        $row = $this->fetch_array("SELECT * FROM `#_content`  WHERE id =" . $id_code . " and hien_thi = 1 order by so_thu_tu asc, id desc $limit2");
        return $row;
    }

    function getData($tale, $col = '', $where = '', $limit = '')
    {
        if ($col != '') {
            $col2 = $col;
        } else {
            $col2 = "*";
        }
        if ($where != '') {
            $where2 = "WHERE $where";
        } else {
            $where2 = "";
        }
        if ($limit != '') {
            $limit2 = " LIMIT $limit";
        } else {
            $limit2 = "";
        }
        $row = $this->fetch_array("SELECT $col2 FROM `#_$tale`  $where2  order by so_thu_tu asc, id desc $limit2");
        return $row;
    }

    function getTinh($col = '*', $id = '')
    {
        if ($id != '') {
            $andhome = " and id='" . $id . "' ";
        } else {
            $andhome = "";
        }
        $row = $this->fetch_array("SELECT $col FROM `tinh`  WHERE 1 $andhome order by ten asc, id desc");
        return $row;
    }
    function getHuyen($code_tinh, $col = '*', $code = '')
    {
        if ($code != '') {
            $andhome = " and id='" . $code . "' ";
        } else {
            $andhome = "";
        }
        $row = $this->fetch_array("SELECT $col FROM `huyen`  WHERE code_tinh = '$code_tinh' $andhome order by ten asc, id desc");
        return $row;
    }
    function getXa($code_huyen, $col = '*', $code = '')
    {
        if ($code != '') {
            $andhome = " and id='" . $code . "' ";
        } else {
            $andhome = "";
        }
        $row = $this->fetch_array("SELECT $col FROM `xa`  WHERE code_huyen = '$code_huyen' $andhome order by ten asc, id desc");
        return $row;
    }

    function getDataId($tale, $id_code, $col = '*')
    {
        $row = $this->simple_fetch("SELECT $col FROM `#_$tale`  WHERE id =" . $id_code . "");
        return $row;
    }
    function getTxt($id)
    {
        $row = $this->simple_fetch("SELECT * FROM `#_ten`  WHERE id =" . $id);
        if (is_array($row) && !empty($row)) {
            return $row['ten'];
        }
    }
    function getReview($id_sp)
    {
        $product_id = $id_sp;
        $d_rating = $this->o_fet("SELECT rate FROM #_binh_luan WHERE id_sanpham = $id_sp AND  rate > 0");
        $total_rating = 0;
        $total_reviews = count($d_rating);

        if ($total_reviews > 0) {
            foreach ($d_rating as $rating) {
                $total_rating += $rating['rate'];
            }
            $average_rating = $total_rating / $total_reviews;
            $average_rating = round($average_rating, 1);
        } else {
            $average_rating = 0;
            $total_reviews = 0;
        }

        $stars = array();
        for ($i = 1; $i <= 5; $i++) {
            $count = $this->num_rows("SELECT * FROM #_binh_luan WHERE id_sanpham = $id_sp AND rate = $i");
            $stars[$i] = $count;
        }

        $stars_percentage = array();
        if ($total_reviews > 0) {
            for ($i = 1; $i <= 5; $i++) {
                $stars_percentage[$i] = ($stars[$i] / $total_reviews) * 100;
            }
        } else {
            for ($i = 1; $i <= 5; $i++) {
                $stars_percentage[$i] = 0;
            }
        }

        $result = array(
            'average_rating' => $average_rating,
            'total_reviews' => $total_reviews,
            'stars' => $stars,
            'stars_percentage' => $stars_percentage
        );

        return $result;
    }
    function getReview2($id_sp)
    {
        $product_id = $id_sp;
        $d_rating = $this->o_fet("SELECT rate FROM #_binh_luan WHERE id_sanpham = $id_sp AND  rate > 0");
        $total_rating = 0;
        $total_reviews = count($d_rating);

        if ($total_reviews > 0) {
            foreach ($d_rating as $rating) {
                $total_rating += $rating['rate'];
            }
            $average_rating = $total_rating / $total_reviews;
            $average_rating = round($average_rating, 1);
        } else {
            $average_rating = 0;
            $total_reviews = 0;
        }

        $stars = array();
        for ($i = 1; $i <= 5; $i++) {
            $count = $this->num_rows("SELECT * FROM #_binh_luan WHERE id_sanpham = $id_sp AND rate = $i");
            $stars[$i] = $count;
        }

        $stars_percentage = array();
        if ($total_reviews > 0) {
            for ($i = 1; $i <= 5; $i++) {
                $stars_percentage[$i] = ($stars[$i] / $total_reviews) * 100;
            }
        } else {
            for ($i = 1; $i <= 5; $i++) {
                $stars_percentage[$i] = 0;
            }
        }

        $result = array(
            'average_rating' => $average_rating,
            'total_reviews' => $total_reviews,
            'stars' => $stars,
            'stars_percentage' => $stars_percentage
        );

        return $result;
    }
    function showthongtin($data = '')
    {
        if ($data === '') {
            // Trả về dữ liệu từ bảng thông tin khi không có tham số
            return $this->simple_fetch("SELECT * FROM #_thongtin LIMIT 1");
        } elseif (is_array($data)) {
            if (isset($data['ho_ten'])) {
                $str = $data['ho_ten'];
            } elseif (isset($data['ten_cong_ty'])) {
                $str = $data['ten_cong_ty'];
            } else {
                $str = $data['sdt'];
            }
            return $str;
        } else {
            return $data;
        }
    }

    public function get_link_lang($com, $lang) 
    {
        $row = $this->simple_fetch("SELECT * FROM `#_content_en`  WHERE alias ='$com'  ");
        if (is_array($row) && !empty($row)) {
            if ($lang == 'vi') {
                $query = $this->simple_fetch("SELECT * FROM `#_content`  WHERE id =" . $row['id_vi'] . " ");
                if (is_array($query) && !empty($query)) {
                    return URLPATH . $query['alias'] . '.html';
                } else {
                    return URLPATH;
                }
            } else {
                return URLPATH . 'en/' . $row['alias'] . '.html';
            }
        } else {
            return URLPATH;
        }
    }
    function product_exists($code = '', $q = 1)
    {
        $ck = $this->num_rows("SELECT * FROM #_sanpham WHERE ma_sp = '$code' ");

        if ($ck > 0) {
            return 1;
        } else {
            $data = array();
            $data['ma_sp'] = $code;
            $data['so_luong'] = $q;
            $data['ngay_tao'] = date('Y-m-d H:i:s');
            $data['hien_thi'] = 1;
            $this->reset();
            $this->setTable('#_sanpham');
            $id = $this->insert($data);
            if ($id > 0) {
                $data_seo = array();
                $data_seo['id_sanpham'] = $id;
                $data_seo['meta_title'] = $code;
                $data_seo['meta_keyword'] = $code;
                $data_seo['meta_description'] = $code;
                $this->reset();
                $this->setTable('#_seo_sanpham');
                $this->insert($data_seo);
            }

            return 0;
        }
    }
    function addtocart($q = 1, $pid = 0, $mau = 0, $size = 0)
    {
        $mau_sp = ($mau > 0) ? $mau : 0;
        $size_sp = ($size > 0) ? $size : 0;
        $_SESSION['cart']['sp' . $pid . 'mau' . $mau_sp . 'size' . $size_sp] = array(
            'id' => $pid,
            'soluong' => $q,
            'mau' => $mau_sp,
            'size' => $size_sp
        );

        // $_SESSION['cart'][$pid] = array(
        //     'id' => $pid,
        //     'soluong' => $q,
        //     'mau' => $mau_sp,
        //     'size' => $size_sp
        // );
        $sanpham = $this->simple_fetch("SELECT * FROM #_sanpham WHERE  id = $pid");
        if ($sanpham['kiem_kho'] == 1) {
            $so_luong_sp = intval($sanpham['so_luong']);
            $so_luong_mua = intval($q);
            $so_luong_con = $so_luong_sp - $so_luong_mua;
            if ($so_luong_con >= 0) {
                $data_update = array();
                $data_update['so_luong'] = $so_luong_con;
                $this->reset();
                $this->setTable('#_sanpham');
                $this->setWhere('id', $pid);
                $this->update($data_update);
            }
        }
    }

    public function get_order_total()
    {
        $total = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $value) {

                $id = $value['id'];
                $mau = $value['mau'];
                $size = $value['size'];
                $gia = 0;
                // Lấy giá sản phẩm
                $sanpham = $this->simple_fetch("SELECT * FROM #_sanpham WHERE id = $id ");
                if ($sanpham['gia_km'] > 0) {
                    $gia = $sanpham['gia_km'];
                } else {
                    $gia = $sanpham['gia'];
                }
                $soluong = $value['soluong'];
                $total += $gia * $soluong;
            }
        }
        return $total;
    }
    function chuyentiente($key = 'fc01aba01229377741b9e9fa')
    {
        // Khởi tạo cURL
        $curl = curl_init();

        // Thiết lập cURL
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.freeconvert.com/v1/process/tasks",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $key,
                "Accept: application/json"
            ),
        ));

        // Thực hiện cURL và nhận phản hồi
        $response = curl_exec($curl);

        // Kiểm tra lỗi
        if (curl_error($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            return "Lỗi cURL: " . $error_msg;
        }

        // Đóng cURL
        curl_close($curl);

        // Chuyển đổi JSON thành mảng PHP
        $data = json_decode($response, true);

        // Trả về dữ liệu
        return $data;
    }
    function checkLevelCategory($id)
    {
        $level = 0;
        $query = $this->simple_fetch("SELECT * FROM #_category WHERE id = $id ");
        if ($query['id_loai'] > 0) {
            $level++;
            $level += $this->checkLevelCategory($query['id_loai']);
        }
        return $level;
    }

    function get_cate_module($module, $lang = 'vi')
    {
        $query = $this->fetch_array("SELECT * FROM #_category WHERE module = '$module' AND lang = '$lang' and hien_thi = 1 ORDER BY so_thu_tu ASC, id DESC");
        return $query;
    }
}
