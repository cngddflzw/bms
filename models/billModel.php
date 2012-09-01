<?php
    class BillModel extends BaseModel {
        public function __construct() {
            parent::__construct();
        }

        #查询账单
        public function getBills($whereClause = null, $selectStr = null) {
            if($selectStr == null) $selectStr = "*";
            $query = "SELECT {$selectStr} FROM bill";
            if($whereClause != null) {
                $query .= " WHERE {$whereClause}";
            }
            $query .= " ORDER BY date";
            if($result = $this->con->query($query)) {
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                die("数据库出错,错误：{$this->con->error}");
            }
        }

        #添加新账单
        public function addBill($bill) {
            $date = date("Y-m-d");
            $totalPrice = $bill["price"] * $bill["amount"];
            if(!$stmt = $this->con->prepare("INSERT INTO bill (date, name, price, amount, totalPrice, payer, owner) VALUES (?, ?, ?, ?, ?, ?, ?)")) {
                echo "Prepare failed: (" . $this->con->errno . ") " . $this->con->error;
            }
            if(!$stmt->bind_param("ssdddss", $date, $bill["name"], $bill["price"], $bill["amount"], $totalPrice, $bill["payer"], $bill["owner"])) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            if(!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            $stmt->close();
        }

        #统计付款账单信息
        public function countBill($groupItem, $whereClause = null) {
            $query = "SELECT SUM(totalPrice) as money, " . $groupItem . " FROM bill";
            if($whereClause != null) {
                $query .= " WHERE {$whereClause}";
            }
            $query .= " GROUP BY {$groupItem}";
            if($result = $this->con->query($query)) {
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                die("数据库出错,错误：{$this->con->error}");
            }
        }

        #删除账单
        public function delBill($whereClause = null) {
            $query = "DELETE FROM bill";
            if($whereClause !== null) {
                $query .= " WHERE " . $whereClause;
            }
            if(!($result = $this->con->query($query))) {
                die("数据库出错,错误：{$this->con->error}");
            }
        }
    }