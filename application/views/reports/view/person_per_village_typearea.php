<!--
/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 17/4/2556 10:06 น.
 */
-->
<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">หน้าหลัก</a> <span class="divider">/</span></li>
    <li><a href="<?php echo site_url('reports'); ?>">รายงาน</a> <span class="divider">/</span></li>
    <li class="active">จำนวนประชากร แยกรายหมู่บ้านและ Type area</li>
</ul>

<table class="table table-striped table-hover" id="tblList">
    <thead>
    <tr>
        <th rowspan="2">หมู่ที่</th>
        <th rowspan="2">ชื่อหมู่บ้าน</th>
        <th colspan="6">Type area</th>
        <th rowspan="2">รวมทั้งหมด</th>
    </tr>
    <tr>
        <th>0</th>
        <th>1</th>
        <th>2</th>
        <th>3</th>
        <th>4</th>
        <th>1+3</th>
    </tr>
    </thead>
    <tbody></tbody>
</table>

<div class="pagination pagination-centered" id="main_paging">
    <ul></ul>
</div>

<script type="text/javascript">
    head.js('<?php echo base_url(); ?>assets/apps/js/report.person.per.village.typearea.js');
</script>