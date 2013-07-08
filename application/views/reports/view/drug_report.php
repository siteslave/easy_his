<!--
/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 9/5/2556 16:12 น.
 */
-->
<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('reports'); ?>">รายงาน</a> <span class="divider">/</span></li>
    <li class="active">รายงานการใช้ยา จากวันที่ <?php echo $date1; ?> ถึงวันที่ <?php echo $date2; ?></li>
</ul>

<table class="table table-striped table-hover" id="tblList">
    <thead>
    <tr>
        <th>รหัสมาตรฐาน</th>
        <th>ชื่อยา</th>
        <th>ความแรง</th>
        <th>หน่วยนับ</th>
        <th>รายการ</th>
        <th>จำนวน</th>
        <th>มูลค่า</th>
    </tr>
    </thead>
    <tbody></tbody>
</table>

<div class="pagination pagination-centered" id="main_paging">
    <ul></ul>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/report.drug_report.js');
</script>