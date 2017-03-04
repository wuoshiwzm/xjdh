<form class="form-horizontal">
    <div class="control-group">
        <label class="control-label" style="float: left;">选择督导要验收的局站</label>
        <div class="controls" style="margin-left: 20px; float: left;">
            <select class="chzn-select" data-placeholder="选择督导"
                    name='user' id='user'>

                <option value="<?php echo $arrange->user_id?>" selected="selected">
                    <?php echo $this->mp_xjdh->get_user_fullname($arrange->user_id)?>
                </option>
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
                <option value="<?php echo $arrange->substation_id?>" selected="selected">
                    <?php echo $this->mp_xjdh->Get_Substation($arrange->substation_id)->name?>
                </option>
                <?php foreach ($subs as $sub) { ?>
                    <option value='<?php echo $sub->id; ?>'>
                        <?php echo htmlentities($sub->name, ENT_COMPAT, "UTF-8"); ?></option>
                <?php } ?>
            </select>
        </div>
        <button class="btn btn-success" type="submit" style="margin-left: 100px;">确认</button>
    </div>

</form>