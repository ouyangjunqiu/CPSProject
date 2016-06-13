<p><strong><?php echo $caserun["dept"];?></strong></p>
<table class="table-frame">
    <tbody>
    <tr>
        <td><small style="color:#828282">日期</small></td>
        <td><small style="color:#828282">花费</small></td>
        <td><small style="color:#828282">ROI</small></td>
        <td></td>
    </tr>
    <?php $i=0;?>
    <?php foreach($caserundata as $data):?>
        <tr class="<?php if($i%2==0):?>odd<?php else:?>even<?php endif;?>">
        <td><strong><?php echo $data["date"];?></strong></td>
        <td><?php echo $data["cost"];?></td>
        <td><?php echo $data["roi"];?></td>
            <td></td>
        </tr>
        <?php $i++;?>
    <?php endforeach;?>
    <tr>
        <td><input type="text" value="<?php echo date("Y-m-d");?>" name="date" class="bl"/></td>
        <td><input type="text" value="0" name="cost" class="bl"/></td>
        <td><input type="text" value="0" name="roi" class="bl"/></td>
        <td><a id="rpt_add_btn" href="javascript:void(0) "><i class="glyphicon glyphicon-plus"></i>添加</a></td>
    </tr>
    </tbody>
</table>
<script type="text/javascript">
    $("#rpt_add_btn").click(function() {
        $.ajax({
            url: '<?php echo $this->createUrl("/main/caserun/data2");?>',
            data: {
                runid:<?php echo $caserun["id"];?>,
                date: $("input[name=date]").val(),
                cost: $("input[name=cost]").val(),
                roi: $("input[name=roi]").val()
            },
            type: 'post',
            dataType: 'json',
            success: function (data) {
                window.location.reload();

            }
        })
    })
</script>