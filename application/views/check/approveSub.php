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

        <?php if ($info->is_apply == 1) { ?>
            <h3>已提交</h3>

            <a href='<?php echo site_url('check/approveCase/' . $info->substation_id); ?>'
               class="btn btn-info pull-right">审核通过</a>


            <a href='<?php echo site_url('check/unapproveCase/' . $info->substation_id); ?>'
               class="btn btn-info pull-right">审核不通过</a>
        <?php } else { ?>
            <h3>未提交</h3>
        <?php } ?>


        <div class="row-fluid">
            <div class="span12">

                <div class="content-widgets light-gray">

                    <!--head-->
                    <div class="widget-head bondi-blue">
                        <h3>提交信息</h3>
                    </div>

                    <div class="widget-container">
                        <table
                                class="table table-bordered responsive table-striped table-sortable">
                            <thead>
                            <tr>
                                <th>城市</th>
                                <th>地区</th>
                                <th>局站</th>
                                <th>提交人</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td><?php echo $info->subs_city; ?></td>
                                <td><?php echo $info->subs_county; ?></td>
                                <td><?php echo $info->subs_name; ?></td>
                                <td><?php echo $info->name; ?></td>


                            </tr>

                            </tbody>
                        </table>

                    </div>


                    <!--tag-->
                    <div class="tab-widget">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="/check/approveSub/<?php echo $info->substation_id ?>">
                                    <i class="icon-tasks"></i>局站信息</a>
                            </li>

                            <li>
                                <a href="/check/approveDev/<?php echo $info->substation_id ?>">
                                    <i class="icon-tasks"></i>设备信息</a>
                            </li>

                        </ul>
                    </div>

                    <!--局站审核-->
                    <div class="widget-head bondi-blue">
                        <h3>局站工艺审核</h3>
                    </div>
                    <div class="widget-container">
                        <?php if (empty($cases)) {
                            echo "未提交验收信息";
                        } ?>

                        <?php if (!empty($cases)) { ?>
                            <table
                                    class="table table-bordered responsive table-striped table-sortable">
                                <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>问题</th>
                                    <th>问题说明</th>
                                    <th>审核结果</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($cases as $case) { ?>
                                    <tr>
                                        <td><?php echo $case['question']->id; ?></td>
                                        <td><?php echo $case['question']->content; ?></td>
                                        <td><?php echo $case['question']->desc; ?></td>

                                        <td> <ul class="dowebokList">
                                            <?php foreach ($case['answer'] as $k=>$img) { ?><a
                                                            <?php if($k>=3){echo "style='display:none'";}?>
                                                            rel="group" class="image"
                                                       href="/public/portal/Check_image/<?php echo $img ?>">
                                                        <img src="/public/portal/Check_image/<?php echo $img ?>"
                                                             alt="" style="height: 150px;"/></a>


<!--                                                    <input type="hidden" class="img_path"-->
<!--                                                           value="/public/portal/Check_image/--><?php //echo $img ?><!--">-->
<!--                                                    <img src="/public/portal/Check_image/--><?php //echo $img ?><!--"-->
<!--                                                         style="height: 150px;"-->
<!--                                                         class="approveImg">-->

                                            <?php } ?>
                                            </ul>
                                        </td>

                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>

                        <?php } ?>


                        <input type="hidden" value="<?php echo $info->id ?>">

                    </div>


                </div>
            </div>

        </div>
    </div>
</div>
