<?php
function Create_video_youtube($link, $w = 500, $h = 250)
{
    $html = '<iframe width="' . $w . '" height="' . $h . '" src="https://www.youtube.com/embed/' . $link . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    return $html;
}
function Create_fanpage($link_fanpag, $no_js = '0', $w = '', $h = 150)
{
    $html = '<div class="fb-page" data-href="' . $link_fanpag . '" data-tabs="timeline" data-width="' . $w . '" data-height="' . $h . '" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="' . $link_fanpag . '" class="fb-xfbml-parse-ignore"><a href="' . $link_fanpag . '">Facebook</a></blockquote></div>';
    if ($no_js == '1') {
        $html .= '<div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v11.0&autoLogAppEvents=1" nonce="I6BghMBZ"></script>';
    }
    return $html;
}

function getCurrentPageURL()
{
    $pageURL = 'http';
    if (!empty($_SERVER['HTTPS'])) {
        if ($_SERVER['HTTPS'] == 'on') {
            $pageURL .= "s";
        }
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

function Img($img)
{
    if ($img != '') {
        $link_img = URLPATH . 'img_data/images/' . $img;
    } else {
        $link_img = URLPATH . 'img_data/no-image.png';
    }
    return $link_img;
}

function Img_thumb($img, $w, $h, $zc)
{
    if ($img != '') {
        $link_img = "thumb.php?src=" . URLPATH . 'img_data/images/' . $img . "&h=" . $h . "&w=" . $w . "&zc=" . $zc . " ";
    } else {
        $link_img = URLPATH . 'img_data/no-image.png';
    }
    return $link_img;
}

function cre_Link($link)
{
    $link_text = URLPATH . $link . '.html';
    return $link_text;
}
function cf_tag_a($link, $nofollow = 0, $target = 0)
{
    $text = 'href="' . $link . '" ';
    if ($nofollow == 1) {
        $text .= 'rel="nofollow" ';
    }
    if ($target == 1) {
        $text .= 'target="_blank" ';
    }
    return $text;
}
function cf_tag_html($content, $tag, $class = '')
{
    $text = '<' . $tag . ' class="' . $class . '">' . $content . '</' . $tag . '>';
    return $text;
}
function cf_tag_a_url($slug, $alias, $nofollow, $target)
{
    if ($slug == '') {
        $url = URLLANG . $alias . '.html';
    } else {
        $url = URLLANG . $slug . '/' . $alias . '.html';
    }
    $text = 'href="' . $url . '" ';
    if ($nofollow == 1) {
        $text .= 'rel="nofollow" ';
    }
    if ($target == 1) {
        $text .= 'target="_blank" ';
    }
    return $text;
}
function str_to_alias($str)
{
    $unicode = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd' => 'đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i' => 'í|ì|ỉ|ĩ|ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D' => 'Đ',
        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );
    foreach ($unicode as $nonUnicode => $uni) {
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }
    $str = str_replace(' ', '-', $str);
    $str = trim($str, 'nbsp;');
    $str = str_replace('nbsp;', '-', $str);
    $search = ['%', '@', '?', '&', '!', ',', '.', '$', '(', ')', '#', ':'];
    $replace   = '';
    $str = str_replace($search, $replace, $str);
    return strtolower($str);
}
function taomucluc($content, $url)
{
    $arr_content_h2 = explode('<h2', $content);
    $list_h2 = "";
    for ($i = 1; $i < count($arr_content_h2); $i++) {
        if (trim($arr_content_h2[$i]) != "") {
            $text_h2 = '<h2' . $arr_content_h2[$i];
            //tạo mãng H3
            $arr_content_h3 = explode('<h3', $text_h2);
            $list_h3 = "";
            for ($j = 0; $j < count($arr_content_h3); $j++) {
                if (trim($arr_content_h3[$j]) != "") {
                    $text_h3 = '<h3' . $arr_content_h3[$j];
                    //tạo mãng H4
                    $arr_content_h4 = explode('<h4', $text_h3);
                    $list_h4 = "";
                    for ($h = 0; $h < count($arr_content_h4); $h++) {
                        if (trim($arr_content_h4[$h]) != "") {
                            $text_h4 = '<h4' . $arr_content_h4[$h];
                            //tạo mãng H5
                            $arr_content_h5 = explode('<h5', $text_h4);
                            $list_h5 = "";
                            for ($k = 0; $k < count($arr_content_h5); $k++) {
                                if (trim($arr_content_h5[$k]) != "") {
                                    $text_h5 = '<h5' . $arr_content_h5[$k];
                                    //tạo mãng H6
                                    $arr_content_h6 = explode('<h6', $text_h5);
                                    $list_h6 = "";
                                    for ($y = 0; $y < count($arr_content_h6); $y++) {
                                        if (trim($arr_content_h6[$y]) != "") {
                                            $text_h6 = '<h6' . $arr_content_h6[$y];
                                            $html_h6 = str_get_html($text_h6);
                                            $arr_contet_h6 = $html_h6->find('h6');
                                            foreach ($arr_contet_h6 as $value_h6) {
                                                $list_h6 .= '<li><a href="' . $url . '#' . str_to_alias(strip_tags($value_h6->innertext)) . '"><span>' . $i . '.' . $j . '.' . $h . '.' . $k . '.' . $y . '. </span> ' . strip_tags($value_h6->innertext) . '</a></li>';
                                            }
                                            if ($list_h6 != "") {
                                                $mucluc_h6 = '<ul>' . $list_h6 . '</ul>';
                                            } else {
                                                $mucluc_h6 = '';
                                            }
                                        }
                                    }
                                    $html_h5 = str_get_html($text_h5);
                                    $arr_contet_h5 = $html_h5->find('h5');
                                    foreach ($arr_contet_h5 as $value_h5) {
                                        $list_h5 .= '<li><a href="' . $url . '#' . str_to_alias(strip_tags($value_h5->innertext)) . '"><span>' . $i . '.' . $j . '.' . $h . '.' . $k . '. </span> ' . strip_tags($value_h5->innertext) . '</a>' . $mucluc_h6 . '</li>';
                                    }
                                    if ($list_h5 != "") {
                                        $mucluc_h5 = '<ul>' . $list_h5 . '</ul>';
                                    } else {
                                        $mucluc_h5 = '';
                                    }
                                }
                            }
                            $html_h4 = str_get_html($text_h4);
                            $arr_contet_h4 = $html_h4->find('h4');
                            foreach ($arr_contet_h4 as $value_h4) {
                                $list_h4 .= '<li><a href="' . $url . '#' . str_to_alias(strip_tags($value_h4->innertext)) . '"><span>' . $i . '.' . $j . '.' . $h . '.</span> ' . strip_tags($value_h4->innertext) . '</a>' . $mucluc_h5 . '</li>';
                            }
                            if ($list_h4 != "") {
                                $mucluc_h4 = '<ul>' . $list_h4 . '</ul>';
                            } else {
                                $mucluc_h4 = '';
                            }
                        }
                    }
                    $html_h3 = str_get_html($text_h3);
                    $arr_contet_h3 = $html_h3->find('h3');
                    foreach ($arr_contet_h3 as $value_h3) {
                        $list_h3 .= '<li><a href="' . $url . '#' . str_to_alias(strip_tags($value_h3->innertext)) . '"><span>' . $i . '.' . $j . '.</span> ' . strip_tags($value_h3->innertext) . '</a>' . $mucluc_h4 . '</li>';
                    }
                    if ($list_h3 != "") {
                        $mucluc_h3 = '<ul>' . $list_h3 . '</ul>';
                    } else {
                        $mucluc_h3 = '';
                    }
                }
            }
            $html_h2 = str_get_html($text_h2);
            $arr_contet_h2 = $html_h2->find('h2');
            foreach ($arr_contet_h2 as $value_h2) {
                $list_h2 .= '<li><a href="' . $url . '#' . str_to_alias(strip_tags($value_h2->innertext)) . '"><span>' . $i . '.</span> ' . strip_tags($value_h2->innertext) . '</a>' . $mucluc_h3 . '</li>';
            }
        }
    }
    $mucluc = '
    <p style="font-size: 16px;text-transform: uppercase;font-weight: bold;border-bottom: 1px solid #000;text-align: left;margin-bottom: 15px;font-family: \'avoB\';"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-ol" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z"/>
  <path d="M1.713 11.865v-.474H2c.217 0 .363-.137.363-.317 0-.185-.158-.31-.361-.31-.223 0-.367.152-.373.31h-.59c.016-.467.373-.787.986-.787.588-.002.954.291.957.703a.595.595 0 0 1-.492.594v.033a.615.615 0 0 1 .569.631c.003.533-.502.8-1.051.8-.656 0-1-.37-1.008-.794h.582c.008.178.186.306.422.309.254 0 .424-.145.422-.35-.002-.195-.155-.348-.414-.348h-.3zm-.004-4.699h-.604v-.035c0-.408.295-.844.958-.844.583 0 .96.326.96.756 0 .389-.257.617-.476.848l-.537.572v.03h1.054V9H1.143v-.395l.957-.99c.138-.142.293-.304.293-.508 0-.18-.147-.32-.342-.32a.33.33 0 0 0-.342.338v.041zM2.564 5h-.635V2.924h-.031l-.598.42v-.567l.629-.443h.635V5z"/>
</svg> Mục lục</p>
    <ul class="mucluc-pnvn">' . $list_h2 . '</ul>';
    return $mucluc;
}
function content_mucluc($content, $url)
{
    $html = str_get_html($content);
    for ($i = 2; $i < 7; $i++) {
        $arr_h2 = $html->find('h' . $i);
        $j = 0;
        foreach ($arr_h2 as $value) {
            $text = $value->innertext;
            if ($j == 0 and $i == 2) {
                $div_mucluc = '<div id="mucluc-pnvn" class="mucluc-left"></div>';
            } else {
                $div_mucluc = "";
            }
            $value->outertext = $div_mucluc . '<h' . $i . '><span id="' . str_to_alias(strip_tags($text)) . '">' . $text . '</span></h' . $i . '>';
            $j = $j + 1;
        }
    }
    $html->load($html->save());
    $mucluc = taomucluc($content, $url);
    $arr_muluc = $html->find('#mucluc-pnvn');
    foreach ($arr_muluc as $value) {
        $value->outertext = '<div id="mucluc-pnvn" class="">' . $mucluc . '</div>';
    }
    $html->load($html->save());
    $css = '<style></style>';
    return $html . $css;
}

function format_gia($price = 0, $unit = 'đ', $html = true)
{
    $str = '';
    if ($price) {
        $str .= number_format($price, 0, ',', '.');
        if ($unit != '') {
            if ($html) {
                $str .= '<span> ' . $unit . '</span>';
            } else {
                $str .= $unit;
            }
        }
    }
    return $str;
}

function transfer($msg = '', $page = '', $stt = true)
{
    $showtext = $msg;
    $page_transfer = $page;
    $stt = $stt;
    include("./sources/module/transfer.php");
    exit();
}
