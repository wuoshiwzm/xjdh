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
        <?php if ($checkRole == 4) { ?>
            <!--安排人员角色-->
            <form class="form-horizontal">

                <div class="control-group">
                    <label class="control-label" style="float: left;">选择人员</label>
                    <div class="controls" style="margin-left: 20px; float: left;">
                        <select class="chzn-select" data-placeholder="选择督导"
                                name='roleUser' id='user'>
                            <option value="0">请选择人员</option>
                            <?php foreach ($allUsers as $user) { ?>
                                <option value='<?php echo $user->id; ?>'>
                                    <?php echo htmlentities($user->full_name, ENT_COMPAT, "UTF-8"); ?></option>
                            <?php } ?>
                        </select>
                    </div>


                    <label class="control-label" style="float: left;">选择对应权限</label>
                    <div class="controls" style="margin-left: 20px; float: left;">
                        <select data-placeholder="选择局站"
                                name='role' id='sub'>
                            <option value="0">请选择权限</option>
                            <option value="1">吉姆督导</option>
                            <option value="2">吉姆督查</option>
                            <option value="3">电信督查</option>
                            <option value="4">管理员</option>
                        </select>
                    </div>
                    <button class="btn btn-success" type="submit" style="margin-left: 100px;">确认</button>
                </div>


            </form>

            <!--安排督导验收局站-->
            <form class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" style="float: left;">选择督导</label>
                    <div class="controls" style="margin-left: 20px; float: left;">
                        <select data-placeholder="选择督导"
                                name='user' id='user'>
                            <option value="0">请选择督导</option>
                            <?php foreach ($users as $user) { ?>
                                <option value='<?php echo $user->id; ?>'>
                                    <?php echo htmlentities($user->full_name, ENT_COMPAT, "UTF-8"); ?></option>
                            <?php } ?>
                        </select>
                    </div>


                    <label class="control-label" style="float: left;">选择督导要验收的局站</label>
                    <div class="controls" style="margin-left: 20px; float: left;">
                        <select class="chzn-select" data-placeholder="选择局站"
                                name='sub' id='sub'>
                            <option value="0">请选择局站</option>
                            <?php foreach ($subs as $sub) { ?>
                                <option value='<?php echo $sub->id; ?>'>
                                    <?php echo htmlentities($sub->name, ENT_COMPAT, "UTF-8"); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button class="btn btn-success" type="submit" style="margin-left: 100px;">确认</button>
                </div>

            </form>
        <?php } ?>
        <br>
        <hr>


        <div class="span12">
            <div class="content-widgets light-gray">
                <div class="widget-head bondi-blue">
                    <h3>
                        <i class="icon-search"></i> 综合查询
                    </h3>
                    <a class="widget-settings" href="#search-area" id='serarch-toggle'><i
                                class="icon-hand-up"></i></a>
                </div>
                <div class="widget-container"
                     id='search-area'>
                    <form class="form-horizontal">
                        <div class="control-group">
                            <div class="control-group">
                                <label class="control-label" style="float: left;">验收状态</label>
                                <div class="controls" style="margin-left: 20px; float: left;">
                                    <select data-placeholder="验收状态"
                                            name='checkStatus'>
                                        <option value="0">请选择验收状态</option>
                                        <option value='1'>已分配</option>
                                        <option value='2'>待验中</option>
<!--                                        已经提交-->
                                        <option value='3'>验收完成</option>
                                        <option value='4'>吉姆督查核查完成</option>
                                        <option value='5'>电信督查核查完成</option>
                                        <!---->
                                    </select>
                                </div>

                                <label class="control-label" style="float: left;">吉姆督导验收时间：开始时间 - 终止时间</label>
                                <div class="controls" style="margin-left: 20px; float: left;">
                                    <input type="text" class='form-control date-range-picker'
                                           name="dateRangeApply" id="dateRangeApply"
                                           value="<?php if (isset($dateRange)) echo htmlentities($dateRange, ENT_COMPAT, "UTF-8"); ?>">
                                </div>
                            </div>


                            <div class="control-group">
                                <label class="control-label" style="float: left;">吉姆督查分配时间：开始时间 - 终止时间</label>
                                <div class="controls" style="margin-left: 20px; float: left;">
                                    <input type="text" class='form-control date-range-picker'
                                           name="dateRangeArrange" id="dateRangeArrange"
                                           value="<?php if (isset($dateRange)) echo htmlentities($dateRange, ENT_COMPAT, "UTF-8"); ?>">
                                </div>

                                <label class="control-label" style="float: left;">吉姆督查审核时间：开始时间 - 终止时间</label>
                                <div class="controls" style="margin-left: 20px; float: left;">
                                    <input type="text" class='form-control date-range-picker'
                                           name="dateRangeJimApprove" id="dateRangeJimApprove"
                                           value="<?php if (isset($dateRange)) echo htmlentities($dateRange, ENT_COMPAT, "UTF-8"); ?>">
                                </div>

                            </div>

                            <div class="control-group">
                                <label class="control-label" style="float: left;">电信督查审核时间：开始时间 - 终止时间</label>
                                <div class="controls" style="margin-left: 20px; float: left;">
                                    <input type="text" class='form-control date-range-picker'
                                           name="dateRangeTelApprove" id="dateRangeTelApprove"
                                           value="<?php if (isset($dateRange)) echo htmlentities($dateRange, ENT_COMPAT, "UTF-8"); ?>">
                                </div>
                            </div>

                            <div class="form-actions">
                                <button class="btn btn-success" name="action" type="submit" value="search"
                                        id='btn-submit'>提交
                                </button>
<!--                                <button class="btn btn-success" name="export" value="exporttoexcel" type="submit">导出报表-->
<!--                                </button>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
                            <th>序号</th>
                            <th>局站</th>
                            <th>验收人</th>
                            <th>安排时间</th>
                            <th>吉姆督查</th>
                            <th>验收时间</th>
                            <th>电信督查</th>
                            <th>验收状态</th>
                            <th>审核状态</th>
                            <th>操作</th>
                            <!--<th>设备验证状态</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($arranges as $arrange) { ?>
                            <tr>
                                <td><?php echo $arrange->id; ?></td>
                                <td><?php echo $arrange->substation_name; ?></td>
                                <td><?php echo $this->mp_xjdh->get_user_fullname($arrange->user_id); ?></td>
                                <td><?php echo $arrange->arrange_time; ?></td>

                                <td><?php echo $this->mp_xjdh->get_user_fullname($arrange->check_jim_user_id); ?></td>
                                <td><?php echo $arrange->apply_time; ?></td>
                                <td><?php echo $this->mp_xjdh->get_user_fullname($arrange->check_tel_user_id); ?></td>
                                <td>
                                    <?php if ($arrange->status_check == 1) { ?>
                                        <span class="label label-success dev-lock">工艺验收通过</span><br>
                                    <?php } ?>

                                    <?php if ($arrange->status_device == 1) { ?>
                                        <span class="label label-success dev-lock">设备验收通过</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($arrange->is_apply != 1) { ?>
                                        <span class="label label-success dev-lock">验收中</span><br>
                                    <?php } ?>
                                    <?php if ($arrange->is_apply == 1) { ?>
                                        <span class="label label-success dev-lock">已经提交审核</span><br>
                                    <?php } ?>
                                    <?php if ($arrange->check_jim == 1) { ?>
                                        <span class="label label-success dev-lock">已经通过吉姆审核</span><br>
                                    <?php } ?>
                                    <?php if ($arrange->check_tel == 1) { ?>
                                        <span class="label label-success dev-lock">已经通过电信审核</span>
                                    <?php } ?>
                                </td>

                                <td>
                                    <?php if ($checkRole == 4) { ?>
                                        <input type="hidden" value="<?php echo $arrange->id; ?>">
                                        <a type="button"
                                           class="btn btn-info editArrange">编辑人员安排</a>
                                    <?php } ?>

                                    <?php if ((($checkRole == 2) && ($arrange->check_jim != 1))
                                        || (($checkRole == 3) && (($arrange->check_tel != 1) && ($arrange->check_jim == 1)))
                                        || ($checkRole == 4)
                                    ) { ?>
                                        <a type="button"
                                           href='<?php echo site_url('check/approveSub/' . $arrange->substation_id); ?>'
                                           class="btn btn-info">审核信息</a>
                                    <?php } ?>
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

