<?php
/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 5/4/2556 14:03 น.
 */
    if(!function_exists('get_main_report_menu')) {
        function get_main_report_menu() {
            $ci =& get_instance();
            $ci->load->model('Report_model', 'report');

            $rs = $ci->report->get_mainmenu();

            return $rs;
        }
    }