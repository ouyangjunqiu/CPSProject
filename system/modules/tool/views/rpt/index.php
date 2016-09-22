<div id="shop-rpt-list">

</div>

<script type="text/x-jquery-tmpl" id="shop-rpt-list-tmpl">
 {{if !isSuccess}}
    <div>
        <p class="text-danger">安装插件后，登录钻石展位即可同步展示！</p>
    </div>
 {{else}}
    <table data-role="list" class="baby-frame-table" style="table-layout: fixed;">
        <thead>
        <tr class="small">
            <th>日期</th>
            <th>营业额</th>
            <th>来源</th>
            <th>展现</th>
            <th>点击</th>
            <th>点击率</th>
            <th>消耗</th>
            <th>点击单价</th>
            <th>收藏数</th>
            <th>订单数</th>
            <th>回报率</th>
            <th>消耗占比(%)</th>
        </tr>
        </thead>
        <tbody>
        {{each(i) date_list}}
            <tr class="small">
            <td rowspan="2"><strong>${i}</strong></td>
            <td rowspan="2"><strong>${c[i].payAmt}</strong></td>
            <td>智钻</td>
            <td>${a[i].adPv}</td>
            <td>${a[i].click}</td>
            <td>
            {{if a[i].ctr>0}}
                ${(a[i].ctr*100).toFixed(2)}
            {{else}}
                0
            {{/if}}
            </td>
            <td>${a[i].charge}</td>
            <td>
            {{if a[i].ecpc>0}}
                ${a[i].ecpc.toFixed(2)}
            {{else}}
                0
            {{/if}}
            </td>
            <td>${a[i].dirShopColNum+a[i].inshopItemColNum}</td>
            <td>${a[i].alipayInShopNum}</td>
            <td>
            {{if a[i].roi>0}}
                ${a[i].roi.toFixed(2)}
            {{else}}
                0
            {{/if}}
            </td>

            <td>
                {{if c[i].payAmt}}
                    {{if c[i].payAmt>0}}
                        ${(a[i].charge/c[i].payAmt*100).toFixed(2)}
                    {{else}}
                        0
                    {{/if}}
                {{else}}
                    -
                {{/if}}
            </td>
            </tr>
            <tr class="small">
            <td>直通车</td>
            <td>${b[i].impressions}</td>
            <td>${b[i].click}</td>
            <td>
            {{if b[i].ctr>0}}
                ${(b[i].ctr*100).toFixed(2)}
            {{else}}
                0
            {{/if}}
            </td>
            <td>${b[i].cost}</td>
            <td>
            {{if b[i].ppc>0}}
                ${b[i].ppc.toFixed(2)}
            {{else}}
                0
            {{/if}}
            </td>
            <td>${b[i].favcount}</td>
            <td>${b[i].paycount}</td>
            <td>
            {{if b[i].roi>0}}
                ${b[i].roi.toFixed(2)}
            {{else}}
                0
            {{/if}}
            </td>

            <td>
                {{if c[i].payAmt}}
                    {{if c[i].payAmt>0}}
                        ${(b[i].cost/c[i].payAmt*100).toFixed(2)}
                    {{else}}
                        0
                    {{/if}}
                {{else}}
                    -
                {{/if}}
            </td>
            </tr>
        {{/each}}

        </tbody>

    </table>
{{/if}}
</script>

<script type="text/javascript">
    $(document).read(function(){
        var $dateList = <?php echo CJavaScript::encode($query["date_list"]);?>;
        $.when($.ajax({
            url:'<?php echo $this->createUrl("/zz/advertiserrpt/getbyclick");?>',
            data:{
                nick:'<?php echo $query["nick"];?>',
                effect:15,
                begin_date:'<?php echo $query["begin_date"];?>',
                end_date:'<?php echo $query["end_date"];?>'
            },
            dataType:"json"
        }), $.ajax({
            url:'<?php echo $this->createUrl("/ztc/custrpt/getbyclick");?>',
            data:{
                nick:'<?php echo $query["nick"];?>',
                effect:15,
                begin_date:'<?php echo $query["begin_date"];?>',
                end_date:'<?php echo $query["end_date"];?>'
            },
            dataType:"json"
        }), $.ajax({

            url:'<?php echo $this->createUrl("/zuanshi/trade/getbynick");?>',
            data:{
                nick:'<?php echo $query["nick"];?>',
                effect:15,
                begin_date:'<?php echo $query["begin_date"];?>',
                end_date:'<?php echo $query["end_date"];?>'
            },
            dataType:"json"

        })).then(function(a,b,c){
            var data = {};
            data.date_list = $dateList;
            data.a = a[0].data.list;
            data.b = b[0].data.list;
            data.c = c[0].data.list;
            $("#shop-rpt-list").html($("#shop-rpt-list-tmpl").tmpl(data));
            console.log(a,b,c)
        });
    });

</script>
