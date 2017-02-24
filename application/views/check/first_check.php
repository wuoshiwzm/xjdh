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

        <div class="row-fluid">
            <div class="span12">
                <div class="content-widgets light-gray">
                    <div class="widget-head bondi-blue">
                        <h3>案例列表</h3>
                    </div>
                    <div class="widget-container">
                        <table
                                class="table table-bordered responsive table-striped table-sortable">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>分公司</th>
                                <th>区域</th>
                                <th>局站</th>
                                <th>申请人</th>
                                <th>操作</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($applys as $apply) { ?>
                                <tr>
                                    <td><?php echo $apply->id; ?></td>
                                    <td><?php echo $apply->subs_city; ?></td>
                                    <td><?php echo $apply->subs_county; ?></td>
                                    <td><?php echo $apply->subs_name; ?></td>
                                    <td><?php echo $apply->name; ?></td>

                                    <td>
                                        <input type="hidden"  value="<?php echo $apply->id; ?>">
                                        <a type="button"
                                           class="btn btn-info approve">处理</a>
                                    </td>
                                </tr>

                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
