<?php 
    $xml_file='page-sitemap';
    if(isset($_GET['file']) and $_GET['file']!=''){
        $xml_file = $_GET['file'];
    }
    //$page = fopen("../sitemap/page-sitemap.xml", "r") or exit("Không mở được file!");
    $sitemap='';
    $file = fopen("../sitemap.xml", "r") or exit("Không mở được file!");
    while(!feof($file))
    {
        $sitemap .= fgets($file);
    }
    fclose($file);
    if(isset($_POST['add_new'])){
        $file_name = $_POST['file_name'];
        $arr_table =    array('#_category','#_tintuc','#_album', '#_video','#_sanpham');
        
        $txt='<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="main-sitemap.xsl"?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $txt.='
            <url>
                <loc>'.URLPATH.'</loc>
                <lastmod>'.date("c",time()).'</lastmod>
            </url>';
        for($i=0;$i<count($arr_table);$i++){
            $row_data = $d->o_fet("select alias,lang, cap_nhat from ".$arr_table[$i]." where hien_thi = 1 order by cap_nhat DESC");
            foreach ($row_data as $key => $value) {
                if($value['alias']!=''){
                $txt.='
            <url>
                <loc>'.URLPATH.$value['lang'].'/'.$value['alias'].'.html</loc>
                <lastmod>'.date("c",$value['cap_nhat']).'</lastmod>
            </url>';
                }
            }
        }
        $txt.='
        </urlset>';
        $myfile = fopen("../sitemap.xml", "w");
        fwrite($myfile, $txt);
        fclose($myfile);
        $d->redirect("index.php?p=".$_GET['p']."&a=man&file=".$_GET['file']);
    }
    
    if(isset($_POST['capnhat'])){
        $txt  = check_shell($_POST['content_sitemap']);
        $myfile = fopen("../sitemap.xml", "w");
        fwrite($myfile, $txt);
        fclose($myfile);
        $d->redirect("index.php?p=".$_GET['p']."&a=man&file=".$file_name);
    }
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sitemap
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=urladmin?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li><a href="#">Cấu hình SEO</a></li>
        <li class="active">Sitemap</li>
      </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                       
                        <div class="form-group">
                            <iframe class="iframe" src="<?=URLPATH?>sitemap.xml" style="height: 534px;width: 100%;" frameborder="0"></iframe>
                        </div>
                        <form method="POST" action="?p=sitemap&a=man&file=sitemap" class="text-right">
                            <input type="hidden" value="<?=$xml_file?>" name="file_name">
                            <button class="btn btn-success " name="add_new">Tạo sitemap mới</button>
                        </form>
                    </div>
                    <div class="col-sm-6">
                        <form method="post" action="">
                            <div class="form-group">
                                <textarea class=" form-control" name="content_sitemap" id="code" rows="20"><?=$sitemap?></textarea>
                            </div>
                            <div class="text-right">
                                <button class="btn btn-primary" name="capnhat">Cập nhật</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
</div>
<link rel="stylesheet" href="css/codemirror.css">
<link rel="stylesheet" href="css/show-hint.css">
<script src="js/codemirror.js"></script>
<script src="js/show-hint.js"></script>
<script src="js/xml-hint.js"></script>
<script src="js/xml.js"></script>
<script>
      var dummy = {
        attrs: {
          color: ["red", "green", "blue", "purple", "white", "black", "yellow"],
          size: ["large", "medium", "small"],
          description: null
        },
        children: []
      };

      var tags = {
        "!top": ["top"],
        "!attrs": {
          id: null,
          class: ["A", "B", "C"]
        },
        top: {
          attrs: {
            lang: ["en", "de", "fr", "nl"],
            freeform: null
          },
          children: ["animal", "plant"]
        },
        animal: {
          attrs: {
            name: null,
            isduck: ["yes", "no"]
          },
          children: ["wings", "feet", "body", "head", "tail"]
        },
        plant: {
          attrs: {name: null},
          children: ["leaves", "stem", "flowers"]
        },
        wings: dummy, feet: dummy, body: dummy, head: dummy, tail: dummy,
        leaves: dummy, stem: dummy, flowers: dummy
      };

      function completeAfter(cm, pred) {
        var cur = cm.getCursor();
        if (!pred || pred()) setTimeout(function() {
          if (!cm.state.completionActive)
            cm.showHint({completeSingle: false});
        }, 100);
        return CodeMirror.Pass;
      }

      function completeIfAfterLt(cm) {
        return completeAfter(cm, function() {
          var cur = cm.getCursor();
          return cm.getRange(CodeMirror.Pos(cur.line, cur.ch - 1), cur) == "<";
        });
      }

      function completeIfInTag(cm) {
        return completeAfter(cm, function() {
          var tok = cm.getTokenAt(cm.getCursor());
          if (tok.type == "string" && (!/['"]/.test(tok.string.charAt(tok.string.length - 1)) || tok.string.length == 1)) return false;
          var inner = CodeMirror.innerMode(cm.getMode(), tok.state).state;
          return inner.tagName;
        });
      }

      var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        mode: "xml",
        lineNumbers: true,
        extraKeys: {
          "'<'": completeAfter,
          "'/'": completeIfAfterLt,
          "' '": completeIfInTag,
          "'='": completeIfInTag,
          "Ctrl-Space": "autocomplete"
        },
        hintOptions: {schemaInfo: tags}
      });
    </script>