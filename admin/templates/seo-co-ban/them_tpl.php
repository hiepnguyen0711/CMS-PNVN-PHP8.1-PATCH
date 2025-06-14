
<?php 
if(isset($_POST['capnhat'])){
    //Cập nhật file robots
    if($_POST['robots'] and $_POST['robots']!=''){
        $robot_txt = check_shell($_POST['robots']);
        $fp = @fopen('../robots.txt', "w+");
        if($fp){
            fwrite($fp, $robot_txt);
            fclose($fp);
        }
    }
    //upload file xác minh 
    if (isset($_FILES['file'])){
        if($_FILES['file']['type']='text/html' || $_FILES['file']['type']='application/json'){
            $chec =  check_shell(file_get_contents($_FILES['file']['tmp_name']));
            if($chec!=''){
                move_uploaded_file($_FILES['file']['tmp_name'], '../'.$_FILES['file']['name']);
            }
        }
    }
    //cập nhật seo_footer.inc
    $body_txt = check_shell($_POST['body']);
    $fp = @fopen('../sitemap/seo_footer.inc', "w+");
    if($fp){
        fwrite($fp, $body_txt);
        fclose($fp);
    }
    //cập nhật seo_head.inc
    $head_txt = check_shell($_POST['head']);
    $fp = @fopen('../sitemap/seo_head.inc', "w+");
    if($fp){
        fwrite($fp, $head_txt);
        fclose($fp);
    }
    $d->redirect("index.php?p=".$_GET['p']."&a=man");
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Cấu hình SEO
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=urladmin?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li><a href="#">Cấu hình website</a></li>
        <li class="active">Cấu hình SEO</li>
      </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <form name="frm" method="post" class=" form-horizontal" action="index.php?p=<?=@$_REQUEST['p']?>&a=save&id=<?=@$_REQUEST['id']?>&page=<?=@$_REQUEST['page']?>" enctype="multipart/form-data">
                            <?php if(count(get_json('lang'))>1){ ?>
                            <ul id="myTabs" class="nav nav-tabs" role="tablist">
                                <?php foreach (get_json('lang') as $key => $value) {?>
                                <li role="presentation" <?php if($key==0){?>class="active" <?php } ?>>
                                    <a href="#<?=$value['code']?>" id="home-tab" role="tab" data-toggle="tab" aria-controls="<?=$value['code']?>" aria-expanded="true"><?=$value['name']?></a>
                                </li>
                                <?php } ?>
                            </ul>
                            <?php }?>
                            <div id="myTabContent" class="tab-content">
                                <?php foreach (get_json('lang') as $key => $value) {
                                $row = $d->simple_fetch("select * from #_seo where lang = '".$value['code']."' ");   
                                ?>
                                <div role="tabpanel" class="tab-pane fade <?php if($key==0){?> active in<?php }?>" id="<?=$value['code']?>" aria-labelledby="<?=$value['code']?>">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Title (<?=$value['code']?>):</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="title[]" value="<?=$row['title']?>" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Keyword (<?=$value['code']?>):</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" rows="3" name="keyword[]"><?=$row['keyword']?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Description (<?=$value['code']?>):</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" rows="3" name="des[]"><?=$row['des']?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <?php if($d->checkPermission_edit($id_module)==1){ ?>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-2">
                                    <button type="submit" name="capnhat" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save"></span> Cập nhật</button>
                                </div>
                            </div>
                            <?php }?>
                        </form>
                    </div>
                    <div class="col-sm-6">
                        <h3 class="box-title">Cấu hình seo nâng cao</h3>
                        <form method="POST" action="">
                            <div class="form-group m0">
                                <label>Upload file xác nhận:</label>
                                <input type="file" name="file" class="form-control" >
                            </div>
                            <div class="form-group m0">
                                <label>Robots.txt:</label>
                                <textarea placeholder="Nhập Description" class="form-control" rows="3" name="robots"><?= $robots?></textarea>
                            </div>
                            <div class="form-group m0">
                                <label>HTML đầu trang - <span style="color: #ff4b49;font-weight: 400;"><?=htmlentities('<head>...</head>')?></span> </label>
                                <textarea id="code2" placeholder="Chèn thêm thẻ Meta hoặc mã theo dõi của Google Analytics, Google Webmaster Tools ..." class="form-control" rows="3" name="head"><?php include '../sitemap/seo_head.inc';?></textarea>
                            </div>
                            <div class="form-group m0">
                                <label>HTML cuối trang - <span style="color: #ff4b49;font-weight: 400;"><?=htmlentities('<body>...</body>')?></span> </label>
                                <textarea placeholder="HTML chèn trước thẻ </body>" id="code" class="form-control" rows="3" name="body"><?php include '../sitemap/seo_footer.inc';?></textarea>
                            </div>
                            <?php if($d->checkPermission_edit($id_module)==1){ ?>
                            <div class="form-group text-right">
                                <button type="submit" name="capnhat" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save"></span> Cập nhật</button>
                            </div>
                            <?php }?>
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
      var editor2 = CodeMirror.fromTextArea(document.getElementById("code2"), {
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
    <style>
        .CodeMirror{
            height: 200px;
        }
    </style>