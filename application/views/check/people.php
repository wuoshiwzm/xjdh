<div class="main-wrapper">
    <div class="container-fluid">
        <div class="row-fluid ">
            <div class="span12">
                <div class="primary-head">
                    <h3 class="page-header">人员管理</h3>
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
<!--                        <option value="4">管理员</option>-->
                    </select>
                </div>
                <button class="btn btn-success" type="submit" style="margin-left: 100px;">确认</button>
            </div>


        </form>

        <!--安排督导验收局站-->
        <form class="form-horizontal">
<!--            <div class="control-group">-->
<!--                <label class="control-label" style="float: left;">选择督导</label>-->
<!--                <div class="controls" style="margin-left: 20px; float: left;">-->
<!--                    <select data-placeholder="选择督导"-->
<!--                            name='user' id='user'>-->
<!--                        <option value="0">请选择督导</option>-->
<!--                        --><?php //foreach ($users as $user) { ?>
<!--                            <option value='--><?php //echo $user->id; ?><!--'>-->
<!--                                --><?php //echo htmlentities($user->full_name, ENT_COMPAT, "UTF-8"); ?><!--</option>-->
<!--                        --><?php //} ?>
<!--                    </select>-->
<!--                </div>-->
<!---->
<!---->
<!--                <label class="control-label" style="float: left;">选择督导要验收的局站</label>-->
<!--                <div class="controls" style="margin-left: 20px; float: left;">-->
<!--                    <select class="chzn-select" data-placeholder="选择局站"-->
<!--                            name='sub' id='sub'>-->
<!--                        <option value="0">请选择局站</option>-->
<!--                        --><?php //foreach ($subs as $sub) { ?>
<!--                            <option value='--><?php //echo $sub->id; ?><!--'>-->
<!--                                --><?php //echo htmlentities($sub->name, ENT_COMPAT, "UTF-8"); ?><!--</option>-->
<!--                        --><?php //} ?>
<!--                    </select>-->
<!--                </div>-->
<!--                <button class="btn btn-success" type="submit" style="margin-left: 100px;">确认</button>-->
<!--            </div>-->

        </form>

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
                            <th>用户id</th>
                            <th>用户名</th>
                            <th>目前角色</th>
                            <th width=40%">对应安排局站</th>

                            <th>操作</th>
                            <!--<th>设备验证状态</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($roleusers as $user) { ?>
                            <tr>
                                <input type="hidden" class="userID" value="<?php echo $user->id; ?>">
                                <td>

                                    <?php echo $user->id; ?></td>
                                <td>

                                    <?php echo $user->full_name ?></td>
                                <td>

                                    <?php if ($user->check_role == 1) { ?>
                                        <span class="label label-success dev-lock">吉姆督导</span><br>
                                    <?php } ?>
                                    <?php if ($user->check_role == 2) { ?>
                                        <span class="label label-success dev-lock">吉姆督查</span><br>
                                    <?php } ?>
                                    <?php if ($user->check_role == 3) { ?>
                                        <span class="label label-success dev-lock">电信督查</span><br>
                                    <?php } ?>
                                    <?php if ($user->check_role == 4) { ?>
                                        <span class="label label-success dev-lock">管理员</span><br>
                                    <?php } ?>
                                </td>
                                <td>

                                    <?php foreach ($this->mp_xjdh->get_user_subs($user->id) as $arrange) { ?>
                                        <span class="label label-success dev-lock">
                                            <?php echo $this->mp_xjdh->Get_substation_info($arrange->substation_id)->name ?>
                                        </span>

                                    <?php } ?>
                                </td>
                                <td>
                                    <select data-placeholder="选择局站" class="userRole"
                                            name='role' id='sub'>
                                        <option value="0">请选择权限</option>
                                        <option value="1">吉姆督导</option>
                                        <option value="2">吉姆督查</option>
                                        <option value="3">电信督查</option>
                                    </select>
                                </td>

                                <td>
                                    <input type="submit" class="btn btn-success updatePeople" value="更新"/>

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

