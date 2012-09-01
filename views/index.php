<html>
<?php echo $header; ?>
<body>
    <form action="/index" method="post">
        <input name="duplicated" type="hidden" value="<?php echo $duplicated; ?>">
        <span>物品名称</span><input name="bill[name]" type="text"><br>
        <span>物品单价</span><input name="bill[price]" type="text"><br>
        <span>物品数量</span><input name="bill[amount]" type="text"><br>
        <span>付款人</span>
        <select name="bill[payer]">
            <?php foreach($payerList as $name => $code): ?>
            <option value="<?php echo $name?>"><?php echo $code; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <span>物品所有者</span>
        <select name="bill[owner]">
            <?php foreach($ownerList as $name => $code): ?>
            <option value="<?php echo $name?>"><?php echo $name; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <input type="submit" value="提交">
    </form>
    <a href="/index/countBill" target="_blank">查看个人付款明细</a>
    <table border="1">
        <tr>
            <td>日期</td>
            <td>名称</td>
            <td>单价</td>
            <td>数量</td>
            <td>总价</td>
            <td>付钱者</td>
            <td>所有者</td>
            <td>操作</td>
        </tr>
    <?php foreach($billList as $bill): ?>
        <tr>
            <td><?php echo $bill["date"]; ?></td>
            <td><?php echo $bill["name"]; ?></td>
            <td><?php echo $bill["price"]; ?></td>
            <td><?php echo $bill["amount"]; ?></td>
            <td><?php echo $bill["totalPrice"]; ?></td>
            <td><?php echo $bill["payer"]; ?></td>
            <td><?php echo $bill["owner"]; ?></td>
            <td><a href="/index/delBill?billId=<?php echo $bill["billId"]; ?>">删除</a></td>
        </tr>
    <?php endforeach;?>
    </table>
<?php echo $footer; ?>
</body>
</html>