<link rel="stylesheet" href="<?php echo STATICURL.'/main/css/index.css'; ?>">
<div class="index-table-div">

    <div class="search-box">
        <div class="shop-list-cont">
            <div class="row">
                <div class="col-md-11">
                    <div class="com-list-tit" style="display: block;">
                        <span class="shop-list-icon"></span>
                        <span class="shop-list-txt"><?php echo $query["nick"];?></span>
                    </div>
                </div>

                <div class="col-md-1">
                    <div class="search-right">

                    </div>
                </div>
            </div>
        </div>
    <div id="shop-rpt-list">

    </div>
    </div>
</div>

<script type="text/x-jquery-tmpl" id="shop-rpt-list-tmpl">

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
        {{each(j,i) date_list}}
            <tr class="small">
            <td rowspan="2"><strong>${i}</strong></td>
            <td rowspan="2"><strong>
            {{if c[i] && c[i].payAmt}}
                ${c[i].payAmt}
            {{else}}
                -
            {{/if}}
            </strong></td>
            <td><strong>智钻</strong></td>
            {{if a[i]}}
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
                {{if c[i] && c[i].payAmt}}
                    {{if c[i].payAmt>0}}
                        ${(a[i].charge/c[i].payAmt*100).toFixed(2)}
                    {{else}}
                        0
                    {{/if}}
                {{else}}
                    -
                {{/if}}
            </td>
            {{else}}
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            {{/if}}
            </tr>
            <tr class="small">
            <td><strong>直通车</strong></td>
            {{if b[i]}}
            <td>${b[i].impressions}</td>
            <td>${b[i].click}</td>
            <td>
               ${b[i].ctr}
            </td>
            <td>${b[i].cost}</td>
            <td>
                ${b[i].ppc}
            </td>
            <td>${b[i].favcount}</td>
            <td>${b[i].paycount}</td>
            <td>
               ${b[i].roi}
            </td>

            <td>
                {{if c[i] && c[i].payAmt}}
                    {{if c[i].payAmt>0}}
                        ${(b[i].cost/c[i].payAmt*100).toFixed(2)}
                    {{else}}
                        0
                    {{/if}}
                {{else}}
                    -
                {{/if}}
            </td>
            {{else}}
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            {{/if}}
            </tr>
        {{/each}}

        </tbody>

    </table>
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $(".top-ul>li").eq(3).addClass("top-li-hover");


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
        });
    });

</script>
