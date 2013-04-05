<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li class="active">รายงาน</li>
</ul>
<div class="alert alert-info">
    <h4>
        <?php
        if($id == 1) {
            echo 'การให้บริการ';
        } else if($id == 2) {
            echo 'งานส่งเสริม';
        } else {
            echo 'ข้อมูลพื้นฐาน';
        }
        ?>
    </h4>
</div>
