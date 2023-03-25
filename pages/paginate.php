<?php
$current_url = explode('&page_no', $_SERVER["REQUEST_URI"])[0];
if ($row_num > $limit_row) {
    $last_page = ceil($row_num / $limit_row);
    if (isset($_GET['page_no'])) {
        $current_page = $_GET['page_no'];
        if($current_page>$last_page){
            echo "<script>window.location.href='".$current_url."&page_no=".$last_page."'</script>";
        }
    }
?>
    <span class="phetsarath">ໜ້າ <?= $current_page; ?> ຈາກ <?= $last_page ?></span>
    <nav aria-label="Page navigation class_page">
        <ul class="pagination">
           
                <li class="page-item <?php if($current_page == 1) echo "none-click"; ?>">
                    <a <?php 
                    if($current_page != 1){
                        echo "class='page-link' href='". $current_url ."&page_no=". ($current_page - 1) ."'";
                    }else{
                        echo "class='page-link none-click' href='#'";
                    } ?>  aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
            <?php
            if ($current_page > 1 || $last_page <= 3 || ($current_page == 1 && $last_page > 3)) {
            ?>
                <li class="page-item 
                                            <?php
                                            if (($last_page <= 3 && $current_page == 1) || ($last_page > 3 && $current_page == 1)) {
                                                echo "active";
                                            }
                                            ?>">
                    <a class="page-link" href="
                                                <?php if ($last_page <= 3) echo $current_url . "&page_no=1";
                                                else echo $current_url . "&page_no=" . $current_page - 1; ?>
                                                ">
                        <?php
                        if ($last_page <= 3 || ($current_page == 1 && $last_page > 3)) {
                            echo "1";
                        } elseif ($last_page == $current_page && $last_page > 3) {
                            echo $current_page - 2;
                        } else {
                            echo $current_page - 1;
                        }
                        ?>
                    </a>
                </li>
            <?php } ?>
            <li class="page-item 
                                            <?php
                                            if ($last_page <= 3 && $current_page == 2) echo "active";
                                            elseif ($last_page != $current_page && $current_page != 1 && $last_page > 3) echo "active";
                                            ?>
                                            ">
                <a class="page-link" href="
                                                <?php
                                                if ($last_page <= 3 || ($current_page == 1 && $last_page > 3)) {
                                                    echo $current_url . "&page_no=2";
                                                } elseif ($last_page == $current_page && $last_page > 3) {
                                                    echo $current_url . "&page_no=" . $current_page - 1;
                                                } else {
                                                    echo "#";
                                                }
                                                ?>
                                                ">
                    <?php
                    if ($last_page <= 3 || ($current_page == 1 && $last_page > 3)) {
                        echo "2";
                    } elseif ($last_page == $current_page && $last_page > 3) {
                        echo $current_page - 1;
                    } else {
                        echo $current_page;
                    }
                    ?>
                </a>
            </li>
            <?php if ($last_page > 2) { ?>
                <li class="page-item 
                                            <?php
                                            if ($last_page == 3 && $current_page == 3 || $last_page == $current_page) echo "active";
                                            ?>
                                            ">
                    <a class="page-link" href="
                                                <?php
                                                if ($last_page == 3) echo $current_url . "&page_no=3";
                                                else $current_url . "&page_no=" . $current_page + 1;
                                                ?>
                                                ">
                        <?php
                        if ($last_page == 3 || ($current_page == 1 && $last_page > 3)) {
                            echo "3";
                        } elseif ($last_page == $current_page) {
                            echo $current_page;
                        } else {
                            echo $current_page + 1;
                        }
                        ?>
                    </a>
                </li>
            <?php }?>
                <li class="page-item <?php if ($current_page == $last_page) {echo "none-click";} ?>">
                    <a <?php 
                    if ($current_page < $last_page) {
                        echo "class='page-link' href='". $current_url ."&page_no=". ($current_page + 1) ."'";
                    }else{
                        echo "class='page-link none-click' href='#'";
                    } ?> aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
        </ul>
    </nav>
<?php
}
?>