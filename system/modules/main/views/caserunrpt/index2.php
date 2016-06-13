<table class="table-frame">
    <tbody id="babyInforTb">
    <?php foreach($rpts as $nick=>$rptList):?>
        <?php foreach($rptList as $date=>$rptcaseList):?>
            <?php foreach($rptcaseList as $rpt):?>
            <tr>
                <td>
                    <?php echo $rpt["nick"];?>
                </td>
                <td>
                    <?php echo $rpt["log_date"];?>
                </td>
                <td>
                    <?php echo $rpt["casetype"];?>
                </td>
                <td>
                    <?php echo $rpt["case_budget"];?>
                </td>
                <td>
                    <?php echo $rpt["run_budget"];?>
                </td>
                <td>
                    <?php echo $rpt["rundept"];?>
                </td>
                <td>
                    <?php echo $rpt["run_budget"];?>
                </td>
                <td>
                    <?php echo $rpt["cost"];?>
                </td>
                <td>
                    <?php echo $rpt["roi"];?>
                </td>
            </tr>
            <?php endforeach;?>
        <?php endforeach;?>
    <?php endforeach;?>
    </tbody>
</table>