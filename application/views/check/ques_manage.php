<div class="main-wrapper">
    <div class="container-fluid">
        <div class="row-fluid ">
            <div class="span12">
                <div class="primary-head">
                    <h3 class="page-header">审核页面</h3>
                    <ul class="breadcrumb">
                        <li><a class="icon-home" href="/"></a> <span class="divider"><i
                                        class="icon-angle-right"></i></span></li>
                        <?php foreach ($bcList as $bcObj) { ?>
                            <?php if ($bcObj->isLast) { ?>
                                <li class="active"><?php echo htmlentities($bcObj->title, ENT_COMPAT, "UTF-8"); ?></li>
                            <?php } else { ?>
                                <li><a href='<?php echo htmlentities($bcObj->url, ENT_COMPAT, "UTF-8"); ?>'>
                                        <?php echo htmlentities($bcObj->title, ENT_COMPAT, "UTF-8"); ?>
                                    </a>
                                    <span class="divider"><i class="icon-angle-right"></i></span></li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

        <br>
        <hr>


    </div>


    <div class="row-fluid">
        <div class="span12">
            <div class="content-widgets light-gray">
                <div class="widget-head bondi-blue">
                    <h3>安排列表</h3>
                </div>
                <div class="widget-container">
                    <table
                            class="table table-bordered responsive table-striped table-sortable">
                        <thead>
                        <tr>
                            <th width="5%">顺序</th>
                            <th>问题</th>
                            <th width="55%">问题描述</th>
                            <th width="10%">操作</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($question as $q) { ?>
                            <tr>
                                <input type="hidden" class="id" value="<?php echo $q->id ?>">
                                <td><input type="text" class="input-small order" value="<?php echo $q->order ?>"></td>
                                <td><input type="text" class="input-xlarge content" value="<?php echo $q->content ?>"></td>
                                <td><input type="text" class="input-xxlarge desc" value="<?php echo $q->desc ?>"></td>
                                <td><input type="submit"
                                           class="btn btn-success update" value="更新目前问题"/></td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <input type="hidden" class="id" value="insert">
                            <td><input type="text" class="input-small order" ></td>
                            <td><input type="text" class="input-xlarge content" ></td>
                            <td><input type="text" class="input-xxlarge desc"></td>
                            <td><input type="submit"
                                       class="btn btn-success update" value="添加问题"/></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

