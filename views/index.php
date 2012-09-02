<!DOCTYPE html>
<html>
<?php echo $header; ?>
<body>
    <h2>顺江账单管理系统</h2>
    <div class="box">
        <h4 class="title">账单列表</h4>
        <div class="tab">
            <span class="checked">账单列表</span>
            <span>新账单</span>
        </div>
        <div class="context">
            <div class="control">
                <a href="/index/countBill" target="_blank" style="color: blue; font-size: 14px;">查看详单</a>
            </div>
            <table>
                <thead><tr>
                    <td>日期</td>
                    <td class="left">名称</td>
                    <td>单价</td>
                    <td class="left">数量</td>
                    <td>总价</td>
                    <td class="left">付钱者</td>
                    <td>所有者</td>
                    <td class="left">操作</td>
                </tr></thead>
                <tbody>
                    <?php foreach($billList as $bill): ?>
                        <tr>
                            <td><?php echo $bill["date"]; ?></td>
                            <td class="left"><?php echo $bill["name"]; ?></td>
                            <td><?php echo $bill["price"]; ?></td>
                            <td class="left"><?php echo $bill["amount"]; ?></td>
                            <td><?php echo $bill["totalPrice"]; ?></td>
                            <td class="left"><?php echo $bill["payer"]; ?></td>
                            <td><?php echo $bill["owner"]; ?></td>
                            <td class="left"><a onclick="return confirm('确定要删除吗？');" href="/index/delBill?billId=<?php echo $bill["billId"]; ?>">删除</a></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <div class="context" style="display:none;">
            <form action="/index" method="post">
                <input name="duplicated" type="hidden" value="<?php echo $duplicated; ?>">
                <p>物品名称</p><input name="bill[name]" type="text"><br>
                <p>物品单价</p><input name="bill[price]" type="text"><br>
                <p>物品数量</p><input name="bill[amount]" type="text"><br>
                <p>付款人</p>
                <select name="bill[payer]">
                    <?php foreach($payerList as $name => $code): ?>
                    <option value="<?php echo $name?>"><?php echo $code; ?></option>
                    <?php endforeach; ?>
                </select>
                <br>
                <p>物品所有者</p>
                <select name="bill[owner]">
                    <?php foreach($ownerList as $name => $code): ?>
                    <option value="<?php echo $name?>"><?php echo $name; ?></option>
                    <?php endforeach; ?>
                </select>
                <br>
                <button type="submit">提交</button>
            </form>
        </div>
    </div>
<?php echo $footer; ?>
</body>
</html>