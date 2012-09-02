<!DOCTYPE html>
<html>
<?php echo $header; ?>
<body>
<table>
    <thead><tr>
        <td>付款人</td>
        <td>总付款金额</td>
        <td>为自己付款金额</td>
        <td>公共付款金额</td>
        <td>为他人付款金额</td>
        <td>需支付给他人金额</td>
    </tr></thead>
    <tbody>
    <?php foreach($paidList as $payer => $data): ?>
    <tr>
        <td><?php echo $payer; ?></td>
        <td><?php echo $data["totalPaid"]; ?></td>
        <td><?php echo $data["ownPaid"]; ?></td>
        <td><?php echo $data["pubPaid"]; ?></td>
        <td><?php echo $data["othPaid"]; ?></td>
        <td><?php echo $data["oweMoney"]; ?></td>
    </tr>
    <?php endforeach;?>
    </tbody>
</table>    
<?php echo $footer; ?>
</body>
</html>