<?php
require '__admin_required.php';
require 'init.php';

// $stmt = $pdo->query("SELECT * FROM `member_list`");

//用戶選的頁面是第幾頁? 沒有選的話就是1
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

//每一頁顯示幾筆
$perPage = 1;
$sql_total = "SELECT COUNT(1) FROM `member_list` ";
//執行SQL語法並 拿到總比數
$totalRows = $pdo->query($sql_total)->fetch(PDO::FETCH_NUM)[0];
// 有幾頁 = 總比數/每一頁顯示幾筆
$totalPages = ceil($totalRows / $perPage);

if ($page < 1) {
    header("Location: admin_backend_list.php");
    exit();
}
;

if ($page > $totalPages) {
    header("Location: admin_backend_list.php?page={$totalPages}");
    exit();
};

$sql_page = "SELECT * FROM `member_list`";
$stmt = $pdo->query($sql_page);
// $rows = $stmt_page->fetch();

include 'admin__header.php';
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

<style>

    input[type="search"]:focus{
        box-shadow: none;
        border-color:var(--dark);
    }

    .custom-select:focus{
        border-color:var(--dark);
        box-shadow: none;
    }

    .my-card{
        border: none;
        border-radius: 0;
    }

    .my-card-header{
        background-color: transparent;
        border: none;
        margin-bottom: 5px !important;
    }

    .my-card-title{
        display: flex;
    }

    .fa-check{
        color: var(--success);
    }

    .ban:hover{
        cursor: pointer;
    }

    .swal2-icon.swal2-warning {
        border-color: var(--red);
        color: var(--red);
    }

    .swal2-icon.swal2-success .swal2-success-ring {
        border: .25em solid var(--success);
    }

</style>
</header>
<body>


<?php include 'admin__nav_bar.php'; ?>
<div class="wrapper d-flex">

    <?php require "admin__left_menu.php";?>
        <div class="mainContent">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 p-0 m-5">
                        <div class="container">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link" href="admin_backend_insert.php" style="color: var(--dark);">新增使用者</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="admin_backend_list.php" style="color: var(--dark);">後台使用者總表</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="admin_company_list.php" style="color: var(--dark);">代理商列表</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="admin_teacher_list.php" style="color: var(--dark);">老師列表</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="admin_hall_list.php" style="color: var(--dark);">場地廠商列表</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="admin_hire_list.php" style="color: var(--dark);">徵才廠商列表</a>
                                </li>
                            </ul>



                        <!-- <a name="" id="" class="btn btn-primary" href="admin_insert.php" role="button">新增</a> -->
                            <div style="margin-top: 2rem;">
                                <table id="backend-table" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">編號</th>
                                            <!--  -->
                                            <th scope="col">
                                                <label class='checkbox-inline checkboxAll'>
                                                    <input id='checkAll' type='checkbox' name='checkboxall' value='1' class="regular-checkbox"><label for="checkAll" >
                                                </label>
                                            </th>
                                            <!--  -->
                                            <th scope="col">
                                                <a href="javascript:delete_all()" style="outline: none;"><i class="fas fa-trash delete_all"></i></a>
                                            </th>
                                            <th scope="col">名稱</th>
                                            <th scope="col">電子郵箱</th>
                                            
                                            <th scope="col">身份</th>
                                            <th scope="col">聯絡電話</th>
                                            <th scope="col">地址</th>

                                            <th scope="col">編輯</th>
                                            <!-- <th scope="col"><i class="fas fa-ban"></i></th> -->
                                            <th scope="col">禁用</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($r = $stmt->fetch()) {?>
                                        <tr>
                                            <td><?=$r['sid']?></td>
                                            <td>
                                                <label class=' checkbox-inline checkboxAll'>
                                                <!-- 單個刪除選sid -->
                                                    <input id="<?='delete' . $r['sid']?>" type='checkbox' name=<?='delete' . $r['sid'] . '[]'?> value='<?=$r['sid']?>'>
                                                </label>
                                            </td>
                                            <td>
                                                <!-- 刪除單個sid -->
                                                <a style="outline: none;" href="javascript:delete_one(<?=$r['sid']?>)"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                            <!--  -->
                                            <td><?=$r['name']?></td>
                                            <td><?=$r['email']?></td>
                                            
                                            <td>
                                                <div>
                                                    <?=$r['is_admin'] ? '管理員' : ''?>
                                                </div>
                                                <div>
                                                    <?=$r['is_company'] ? '代理商' : ''?>
                                                </div>
                                                <div>
                                                    <?=$r['is_teacher'] ? '老師' : ''?>
                                                </div>
                                                <div>
                                                    <?=$r['is_hall_owner'] ? '場地主' : ''?>
                                                </div>
                                                <div>
                                                    <?=$r['is_hire'] ? '徵才廠商' : ''?>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <?=$r['tel']?>
                                                </div>
                                                <div>
                                                    <?=$r['teacher_tel']?>
                                                </div>
                                            </td>
                                            <td><?=$r['addr_district'] . $r['addr']?></td>
                                            <!-- <td>
                                                <a href="javascript:delete_one(<?=$r['sid']?>)"><i class="fas fa-trash-alt"></i></a>
                                            </td> -->
                                            <td>
                                                <a href="admin_backend_list_edit.php?sid=<?=$r['sid']?>"><i class="fas fa-edit"></i></a>
                                            </td>
                                            <td>
                                                <?php if($r['is_suspended'] == 1): ?>
                                                    <a class="ban" data-baned="1" data-sid=" <?= $r['sid']?> " role="button"  >
                                                        <i class="fas fa-ban"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a class="ban" data-baned="0" data-sid=" <?= $r['sid']?> " role="button"  >
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>

                                        </tr>
                                        <?php };?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="js/admin_ban_once.js"></script>
    <script>


        //被選取的頁簽文字顏色變紅
        $('.nav-link.active').css('color','var(--red)');

        $('#backend-table').dataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "columnDefs": [
            { "orderable": false, "targets": 1},
            { "orderable": false, "targets": 2},
            { "orderable": false, "targets": 3},
            { "orderable": false, "targets": 4},
            { "orderable": false, "targets": 5},
            { "orderable": false, "targets": 6},
            { "orderable": false, "targets": 7},
            { "orderable": false, "targets": 8},
            { "orderable": false, "targets": 9},
            { "orderable": false, "targets": 10},
            ]
        });

        function delete_one(sid) {
            if(confirm(`確定要刪除編號為 ${sid} 的資料嗎?`)){
                location.href = 'data_delete.php?sid=' + sid;
            }
        }

        
        //checkbox全選
        let checkAll = $('#checkAll'); //全選
        let checkBoxes = $('tbody .checkboxAll input'); //其他勾選欄位
        // 以長度來判斷


        checkAll.click(function() {
            for (let i = 0; i < checkBoxes.length; i++) {
                checkBoxes[i].checked = this.checked ;
            }
        })

        // 批次刪除
        function delete_all() {
            let sid = [];
            checkBoxes.each(function() {
                if ($(this).prop('checked')) {
                    sid.push($(this).val())

                }
            });

            if (!sid.length) {
                alert('沒有選擇任何資料');
            } else {
                if (confirm('確定要刪除這些資料嗎？')) {
                    location.href = 'delete_all.php?sid=' + sid.toString();
                }
            }
        }


    </script>




<?php include 'admin__footer.php';?>
