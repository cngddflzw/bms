<?php if(!defined("BASE_URL")) die("BASE_URL is not define");
    class Index extends __BaseController {
        public function __construct() {
            parent::__construct();
        }

        public function index() {
            session_start();
            $this->pageData["payerList"] = $this->loadConfig("payerList");
            $this->pageData["ownerList"] = $this->loadConfig("ownerList");
            $billMod = $this->loadModel("billModel");

            if(empty($_POST)) {
                $_SESSION["duplicated"] = rand(0, 100000);  #防止重复提交
                $this->pageData["duplicated"] = $_SESSION["duplicated"];
            } else {
                $duplicated = $_POST["duplicated"];

                #如果页面数字和SESSION数字一样，说明不是重复提交，将提交内容插入数据库
                if($duplicated !== null && $duplicated == $_SESSION["duplicated"]) {
                    $bill = $_POST["bill"];
                    $billMod->addBill($bill);
                    $_SESSION["duplicated"] = rand(0, 100000);  #防止重复提交
                    $this->pageData["duplicated"] = $_SESSION["duplicated"];
                }
            }
            $billList = $billMod->getBills();
            $this->pageData["billList"] = $billList;
            $this->displayView("index", $this->pageData);
        }

        public function countBill() {
            $ownerList = $this->loadConfig("ownerList");
            $billMod = $this->loadModel("billModel");
            $totalPubPaid = $billMod->getBills("owner = \"" . $ownerList["公共"] . "\"", "SUM(totalPrice) as totalPrice");
            $totalPubPaid = $totalPubPaid[0]["totalPrice"]; #获取公共付款总金额
            $paidTotalList = $billMod->countBill("payer");   #每人付款总额
            $paidPubList = $billMod->countBill("payer", "owner = \"" . $ownerList["公共"] . "\""); #每人为公共的付款总额
            $paidOthList = $billMod->countBill("payer", "payer != owner and owner != \"" . $ownerList["公共"] . "\""); #每人为他人付款总额，不包括公共付款
            $paidForSelfList = $billMod->countBill("owner", "payer != owner and owner != \"" . $ownerList["公共"] . "\""); #别人为某人支付金额总额
            $paidOwnList = $billMod->countBill("payer", "payer = owner"); #为自己支付金额总额

            #整理三个数组
            $paidTotalNew = array();
            foreach($paidTotalList as $row) {
                $paidTotalNew[$row["payer"]] = array("totalPaid" => $row["money"]);
            }
            $paidPubNew = array();
            foreach($paidPubList as $row) {
                $paidPubNew[$row["payer"]] = array("pubPaid" => $row["money"]);
            }
            $paidOtherNew = array();
            foreach($paidOthList as $row) {
                $paidOtherNew[$row["payer"]] = array("othPaid" => $row["money"]);
            }
            $paidForSelfNew = array();
            foreach($paidForSelfList as $row) {
                $paidForSelfNew[$row["owner"]] = array("forSelfPaid" => $row["money"]);
            }
            $paidOwnNew = array();
            foreach($paidOwnList as $row) {
                $paidOwnNew[$row["payer"]] = array("ownPaid" => $row["money"]);
            }

            #合并三个数组
            $paidList = array_merge_recursive($paidTotalNew, $paidPubNew, $paidOtherNew, $paidForSelfNew, $paidOwnNew);

            #再次整理三个数组，将不存在的值设为0,并计算每人需要为他人支付的金额
            foreach($paidList as &$payer) {
                if(!isset($payer["totalPaid"])) $payer["totalPaid"] = 0;
                if(!isset($payer["pubPaid"])) $payer["pubPaid"] = 0;
                if(!isset($payer["othPaid"])) $payer["othPaid"] = 0;
                if(!isset($payer["forSelfPaid"])) $payer["forSelfPaid"] = 0;
                if(!isset($payer["ownPaid"])) $payer["ownPaid"] = 0;
            }

            #计算自己需要付给别人的钱
            foreach($paidList as &$payer) {
                $payer["oweMoney"] = ($totalPubPaid - 2 * $payer["pubPaid"]) / 2 + ($payer["forSelfPaid"] - $payer["othPaid"]);
            }

            $this->pageData["paidList"] = $paidList;
            $this->displayView("countBill", $this->pageData);
        }

        public function delBill() {
            $billId = $_GET["billId"];
            if($billId === null) die("请勿乱搞");
            $billId = intval($billId);
            $billMod = $this->loadModel("billModel");
            $billMod->delBill("billId = " . $billId);
            header("Location: /");
        }
    }