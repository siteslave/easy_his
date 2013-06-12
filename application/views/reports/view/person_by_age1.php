<!--
/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 17/4/2556 15:31 น.
 */
-->
<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('reports'); ?>">รายงาน</a> <span class="divider">/</span></li>
    <li class="active">จำนวนประชากรในเขตรับผิดชอบ แยกตามช่วงอายุ 0 - 39 ปี</li>
</ul>

<table class="table table-striped table-hover" id="tblList">
    <thead>
    <tr>
        <th rowspan="2">หมู่ที่</th>
        <th rowspan="2">ชื่อหมู่บ้าน</th>
        <th colspan="2">ต่ำกว่า 1 ปี</th>
        <th colspan="2">1-4 ปี</th>
        <th colspan="2">5-9 ปี</th>
        <th colspan="2">10-14 ปี</th>
        <th colspan="2">15-19 ปี</th>
        <th colspan="2">20-24 ปี</th>
        <th colspan="2">25-29 ปี</th>
        <th colspan="2">30-34 ปี</th>
        <th colspan="2">35-39 ปี</th>
    </tr>
    <tr>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>ชาย</th>
        <th>หญิง</th>
    </tr>
    </thead>
    <tbody></tbody>
</table>

<div class="pagination pagination-centered" id="main_paging">
    <ul></ul>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/report.person.by.age1.js');
</script>