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
            <form action="/check/unapproveCase" method="post">
                <input type="hidden" name="subsID" value="<?php echo $info->substation_id ?>">
                <textarea rows="8" class="15" name="suggestion">请输入需要整改内容 </textarea>
                <button type="submit" class="btn  btn-info">审核不通过</button>
            </form>

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
                    <!--tags-->
                    <div class="tab-widget">
                        <ul class="nav nav-tabs">
                            <li>
                                <a href="/check/approveSub/<?php echo $info->substation_id ?>">
                                    <i class="icon-tasks"></i>局站信息</a>
                            </li>

                            <li class="active">
                                <a href="/check/approveDev/<?php echo $info->substation_id ?>">
                                    <i class="icon-tasks"></i>设备信息</a>
                            </li>

                        </ul>
                    </div>

                    <!--机房审核-->
                    <div class="widget-head bondi-blue">
                        <h3>设备列表</h3>
                    </div>
                    <div class="widget-container">
                        <table
                                class="table table-bordered responsive table-striped table-sortable">
                            <?php if (empty($cases)){ ?>
                                目前还没有已验收的设备信息
                            <?php } else{ ?>
                            <thead>
                            <tr>
                                <th>设备名</th>
                                <th>机房名</th>
                                <th>上传图稿</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach ($cases as $room) { ?>
                                <tr>
                                    <td>
                                        <?php echo $room['data_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $room['room_id']; ?>
                                    </td>
                                    <td>
                                        <?php echo $room['room_name']; ?>
                                    </td>
                                    <td> <ul class="dowebokList">
                                            <?php foreach ($room['data_pics']as $k=>$img) { ?><a
                                                <?php if($k>=3){echo "style='display:none'";}?>
                                                rel="group" class="image"
                                                href="/public/portal/Check_image/<?php echo $img ?>">
                                                <img src="/public/portal/Check_image/<?php echo $img ?>"
                                                     alt="" style="height: 150px;"/></a>
                                            <?php } ?>
                                        </ul>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>
