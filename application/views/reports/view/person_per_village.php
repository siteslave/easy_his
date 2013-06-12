<!--
/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 11/4/2556 10:31 น.
 */
-->
<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('reports'); ?>">รายงาน</a> <span class="divider">/</span></li>
    <li class="active">จำนวนประชากร แยกรายหมู่บ้าน</li>
</ul>

<table class="table table-striped table-hover" id="tblList">
    <thead>
    <tr>
        <th>หมู่ที่</th>
        <th>ชื่อหมู่บ้าน</th>
        <th>จำนวนหลังคาเรือน</th>
        <th>ประชากรในเขต</th>
        <th>ประชากรนอกเขต</th>
    </tr>
    </thead>
    <tbody></tbody>
</table>

<div class="pagination pagination-centered" id="main_paging">
    <ul></ul>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/report.person.per.village.js');
</script>