 <div class='row-fluid'>
                                <h4>性能指标</h4>
                      <?php if($_SESSION['XJTELEDH_USERROLE'] == 'admin'){?>
                      <p>
                                        <a class="btn btn-warning"
                                                href='<?php echo site_url('portal/device_pi_setting/'.$dataObj->model);?>'>设置性能指标</a>
                                        <a
                                                href='<?php echo site_url('portal/dynamicSetting/'.$dataObj->data_id);?>'
                                                target="_blank" class="btn btn-info">动态设置</a>
                                        <button class='btn btn-info dev-info'
                                                data_id='<?php echo $dataObj->data_id;?>'
                                                model='<?php echo $dataObj->model;?>'>详细信息</button>
                                </p>
                      <?php }?>
                      <table
                                        class="table table-bordered responsive table-striped table-sortable"
                                        id='tb-<?php echo $dataObj->data_id;?>-dc'>
                                        <thead>
                                                <tr>
                                                        <th>序号</th>
                                                        <th>变量名</th>
                                                        <th>当前值</th>
                                                        <th>告警级别</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                </table>
</div>
