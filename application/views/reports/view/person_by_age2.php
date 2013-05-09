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
    <li class="active">จำนวนประชากรในเขตรับผิดชอบ แยกตามช่วงอายุ 40 ปีขึ้นไป</li>
</ul>

<table class="table table-striped table-hover" id="tblList">
    <thead>
    <tr>
        <th rowspan="2">หมู่ที่</th>
        <th rowspan="2">ชื่อหมู่บ้าน</th>
        <th colspan="2">40-44 ปี</th>
        <th colspan="2">45-49 ปี</th>
        <th colspan="2">50-54 ปี</th>
        <th colspan="2">55-59 ปี</th>
        <th colspan="2">60-64 ปี</th>
        <th colspan="2">65-69 ปี</th>
        <th colspan="2">70-74 ปี</th>
        <th colspan="2">75-79 ปี</th>
        <th colspan="2">80 ปีขึ้นไป</th>
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
    head.js('<?php echo base_url(); ?>assets/apps/js/report.person.by.age2.js');
</script>