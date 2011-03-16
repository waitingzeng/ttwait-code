<?php
/*
  $Id: ot_lev_members.php,v 1.0 2002/04/08 01:13:43 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  class ot_payment {
    var $title, $output;

    function ot_payment() {
      $this->code = 'ot_payment';
      $this->title = MODULE_PAYMENT_DISC_TITLE;
      $this->description = MODULE_PAYMENT_DISC_DESCRIPTION;
      $this->enabled = MODULE_PAYMENT_DISC_STATUS;
      $this->sort_order = MODULE_PAYMENT_DISC_SORT_ORDER;
      $this->include_shipping = MODULE_PAYMENT_DISC_INC_SHIPPING;
      $this->include_tax = MODULE_PAYMENT_DISC_INC_TAX;
      $this->percentage = MODULE_PAYMENT_DISC_PERCENTAGE;
      $this->minimum = MODULE_PAYMENT_DISC_MINIMUM;
      $this->calculate_tax = MODULE_PAYMENT_DISC_CALC_TAX;
//      $this->credit_class = true;
      $this->output = array();
    }

    function process() {
	     global $order, $currencies;
	      $od_amount = $this->calculate_credit();
	      if ($od_amount>0) {
		      $this->deduction = $od_amount;
		      $this->output[] = array('title' => $this->title . ':',
		                              'text' => '<b>' . $currencies->format($od_amount) . '</b>',
		                              'value' => $od_amount);
		      $order->info['total'] = $order->info['total'] + $od_amount;
	      }
    }


  function calculate_credit() {
    global $order, $customer_id;
    $amount = $order->info['total'];
    $od_amount=0;
    $od_pc = $this->percentage;
    $do = false;
    if ($amount > $this->minimum) {
	    $table = split("[,]" , MODULE_PAYMENT_DISC_TYPE);
	    for ($i = 0; $i < count($table); $i++) {
	          if ($_SESSION['payment'] == $table[$i]) $do = true;
	        }
	    if ($do) {
		    $od_amount = round($amount*10)/10*$od_pc/100;
	    }
    }
    return $od_amount;
  }


    function check() {
    global $db;
      if (!isset($this->check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_DISC_STATUS'");
        $this->check = $check_query->RecordCount();
      }

      return $this->check;
    }

    function keys() {
      return array('MODULE_PAYMENT_DISC_STATUS', 'MODULE_PAYMENT_DISC_SORT_ORDER','MODULE_PAYMENT_DISC_PERCENTAGE','MODULE_PAYMENT_DISC_MINIMUM', 'MODULE_PAYMENT_DISC_TYPE', 'MODULE_PAYMENT_DISC_INC_SHIPPING', 'MODULE_PAYMENT_DISC_INC_TAX', 'MODULE_PAYMENT_DISC_CALC_TAX');
    }

    function install() {
    global $db;
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Payment charges', 'MODULE_PAYMENT_DISC_STATUS', 'true', 'Do you want to open the payment module fees?', '6', '1','zen_cfg_select_option(array(\'true\', \'false\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort', 'MODULE_PAYMENT_DISC_SORT_ORDER', '999', 'Display order', '6', '2', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Including freight', 'MODULE_PAYMENT_DISC_INC_SHIPPING', 'true', 'Including freight calculation', '6', '5', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Tax', 'MODULE_PAYMENT_DISC_INC_TAX', 'true', 'Tax calculation', '6', '6','zen_cfg_select_option(array(\'true\', \'false\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Percentage fees', 'MODULE_PAYMENT_DISC_PERCENTAGE', '2', 'Percentage fees', '6', '7', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Tax Calculation', 'MODULE_PAYMENT_DISC_CALC_TAX', 'false', 'A fee calculated on the basis of tax', '6', '5','zen_cfg_select_option(array(\'true\', \'false\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Minimum Order Amount', 'MODULE_PAYMENT_DISC_MINIMUM', '100', 'The minimum order for the amount of fees and charges', '6', '2', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Payment', 'MODULE_PAYMENT_DISC_TYPE', 'cod', 'For fee payment', '6', '2', now())");
    }

    function remove() {
    global $db;
      $keys = '';
      $keys_array = $this->keys();
      for ($i=0; $i<sizeof($keys_array); $i++) {
        $keys .= "'" . $keys_array[$i] . "',";
      }
      $keys = substr($keys, 0, -1);

      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in (" . $keys . ")");
    }
  }
?>