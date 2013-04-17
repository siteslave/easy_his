<!--
/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 17/4/2556 14:42 น.
 */
-->
<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('reports'); ?>">รายงาน</a> <span class="divider">/</span></li>
    <li class="active">จำนวนประชากรในเขตรับผิดชอบ แยกตามเพศ</li>
</ul>

<table class="table table-striped table-hover" id="tblList">
    <thead>
    <tr>
        <th>หมู่ที่</th>
        <th>ชื่อหมู่บ้าน</th>
        <th>เพศชาย</th>
        <th>เพศหญิง</th>
        <th>รวม</th>
    </tr>
    </thead>
    <tbody></tbody>
</table>

<div class="pagination pagination-centered" id="main_paging">
    <ul></ul>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/report.person.by.sex.js');
</script>