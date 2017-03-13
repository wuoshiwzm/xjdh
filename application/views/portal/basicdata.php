<div class="main-wrapper">
    <div class="container-fluid">
        <!-- BEGIN PAGE HEADER-->
        <div class="row-fluid ">
            <div class="span12">
                <div class="primary-head">
                    <h3 class="page-header"><?php echo $pageTitle; ?></h3>
                    <ul class="breadcrumb">
                        <li><a class="icon-home" href="/"></a> <span class="divider"><i
                                        class="icon-angle-right"></i></span></li>
                        <?php foreach ($bcList as $bcObj) { ?>
                            <?php if ($bcObj->isLast) { ?>
                                <li class="active"><?php echo htmlentities($bcObj->title, ENT_COMPAT, "UTF-8"); ?></li>
                            <?php } else { ?>
                                <li>
                                    <a href='<?php echo htmlentities($bcObj->url, ENT_COMPAT, "UTF-8"); ?>'><?php echo htmlentities($bcObj->title, ENT_COMPAT, "UTF-8"); ?></a>
                                    <span class="divider"><i class="icon-angle-right"></i></span></li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="content-widgets light-gray">
                    <div class="widget-head bondi-blue">
                        <h3>
                            <i class="icon-reorder"></i><?php if (isset($categoryKey)) echo $categoryKey; ?>
                        </h3>
                    </div>
                    <div class="widget-container">
                        <form method="post" class="form-horizontal">

                            <div class="widget-container">
                                <?php if (isset($msg)) { ?>
                                    <div class="alert alert-success">
                                        <button data-dismiss="alert" class="close">×</button>
                                        <strong>成功!</strong>
                                        <?php echo $msg; ?>
                                    </div>
                                <?php } ?>
                                <?php if (isset($errMsg)) { ?>
                                    <div class="alert alert-error">
                                        <button data-dismiss="alert" class="close">×</button>
                                        <strong>失败!</strong>
                                        <?php echo $errMsg; ?>
                                    </div>
                                <?php } ?>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <h4>提示:对于列表是"代码"=>"名称"对应关系的，填写"代码 名称"</h4>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <button id='btn-add' type="button" class="btn btn-info">
                                            <i class="icon-plus"></i> 添加
                                        </button>
                                    </div>
                                </div>
                                <br>
                                <table class="table table-bordered table-striped  table-hover"
                                       id='tabcategory'>
                                    <thead>
                                    <tr>
                                        <th>键</th>
                                        <th>值</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <?php if ($this->userObj->user_role == "admin")  { ?>
                                    <tbody id='tbodycategory'>
                                    <?php if (isset($category))
                                        foreach ($category as $key => $value) { ?>
                                            <tr category_id='<?php echo $key . $value; ?>'>
                                                <td><input type="text" name="txtKey[]" class="input-large"
                                                           id="txtKey" value="<?php echo $key; ?>"></td>
                                                <td><input type="text" name="txtValue[]" class="input-xlarge"
                                                           id="txtValue"
                                                           value="<?php if (!is_array($value)) {
                                                               echo $value;
                                                           } else {
                                                               foreach ($value as $k => $v) {
                                                                   echo $k . ' ' . $v . ',';
                                                               }
                                                           } ?>"/>
                                                </td>
                                                <td><a href="#" title='' class="delete">删除</a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } ?>

                            <?php if ($this->userObj->user_role == "city_admin")  { ?>
                            <tbody id='tbodycategory'>
                            <?php if (isset($category))
                                foreach ($category as $key => $value) { ?>
                                    <?php $city_code = $this->userObj->city_code ?>
                                    <?php if ($city_code == $key) { ?>
                                        <tr category_id='<?php echo $key . $value; ?>'>
                                            <td><input type="text" name="txtKey[]" class="input-large"
                                                       id="txtKey" value="<?php echo $key; ?>"></td>
                                            <td><input type="text" name="txtValue[]" class="input-xlarge"
                                                       id="txtValue"
                                                       value="<?php if (!is_array($value)) {
                                                           echo $value;
                                                       } else {
                                                           foreach ($value as $k => $v) {
                                                               echo $k . ' ' . $v . ',';
                                                           }
                                                       } ?>"/>
                                            </td>
                                            <td><a href="#" title='' class="delete">删除</a></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>

                            </tbody>
                    </div>
                </div>
                <?php } ?>

                <div class="row-fluid">
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success" id='btnSave'>保存</button>
                        <a href="/">取消</a>
                        <div class="control-group"></div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <!-- END BORDERED TABLE widget-->

    </div>
</div>
</div>
<div class="modal fade" id='deleteDialog' style="display: none">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class='text-error'>是否删除该记录？</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-danger" id='btn-ok-del'>确定</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</div>

