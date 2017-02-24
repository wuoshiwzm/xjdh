<div class="span12">
    <div class="content-widgets light-gray">
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

        <div class="widget-head bondi-blue">
            <h3>审核信息</h3>
        </div>

        <div class="widget-container">
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


                            <?php foreach ($case['answer'] as $img) { ?>
                        <td>
                                <input type="hidden" class="img_path" value="/public/portal/Check_image/<?php echo $img ?>">
                                <img src="/public/portal/Check_image/<?php echo $img ?>" style="height: 150px;"
                                class="approveImg">
                        </td>
                            <?php } ?>


                    </tr>
                <?php } ?>
                </tbody>
            </table>


            <input type="hidden" value="<?php echo $info->id ?>">

            <a href="/check/check/approveCase/<?php echo $info->id ?>">审核通过</a>
            <a href="/check/check/unapproveCase/<?php echo $info->id ?>">审核不通过</a>
        </div>
    </div>
</div>