<?php
  class icbcorder {
    var $code, $title, $description, $enabled;

// class constructor
    function icbcorder() {
      global $order;

      $this->code = 'icbcorder';
      $this->title = MODULE_PAYMENT_ICBCORDER_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_ICBCORDER_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_ICBCORDER_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_ICBCORDER_STATUS == 'True') ? true : false);

      if ((int)MODULE_PAYMENT_ICBCORDER_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_ICBCORDER_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();
    
      $this->email_footer = MODULE_PAYMENT_ICBCORDER_TEXT_EMAIL_FOOTER;
    }

// class methods
    function update_status() {
      global $order, $db;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_ICBCORDER_ZONE > 0) ) {
        $check_flag = false;
        $check = $db->Execute("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_ICBCORDER_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
        while (!$check->EOF) {
          if ($check->fields['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check->fields['zone_id'] == $order->billing['zone_id']) {
            $check_flag = true;
            break;
          }
          $check->MoveNext();
        }

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }
    }

    function javascript_validation() {
      return false;
    }

    function selection() {
      return array('id' => $this->code,
                   'module' => MODULE_PAYMENT_ICBCORDER_TEXT_CATALOG_LOGO,
                   'icon' => MODULE_PAYMENT_ICBCORDER_TEXT_CATALOG_LOGO
                   );
    }

    function pre_confirmation_check() {
      return false;
    }

    function confirmation() {
      return array('title' => MODULE_PAYMENT_ICBCORDER_TEXT_DESCRIPTION);
    }

    function process_button() {
      return false;
    }

    function before_process() {
      return false;
    }

    function after_process() {
      return false;
    }

    function get_error() {
      return false;
    }

    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_ICBCORDER_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
      global $db;
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Open bank transfer payment module', 'MODULE_PAYMENT_ICBCORDER_STATUS', 'True', 'You want to use bank transfer method?', '6', '1', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now());");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Beneficiary Account: ', 'MODULE_PAYMENT_ICBCORDER_PAYTO', '', 'Payee account numbers?', '6', '1', now());");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Display order', 'MODULE_PAYMENT_ICBCORDER_SORT_ORDER', '0', 'Order by: a small display in the former.', '6', '0', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Payment Area', 'MODULE_PAYMENT_ICBCORDER_ZONE', '0', 'If you select a payment areas, only in the area can use the payment module.', '6', '2', 'zen_get_zone_class_title', 'zen_cfg_pull_down_zone_classes(', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Setting Order Status', 'MODULE_PAYMENT_ICBCORDER_ORDER_STATUS_ID', '0', 'Set through the payment method of payment order status', '6', '0', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_ICBCORDER_STATUS', 'MODULE_PAYMENT_ICBCORDER_ZONE', 'MODULE_PAYMENT_ICBCORDER_ORDER_STATUS_ID', 'MODULE_PAYMENT_ICBCORDER_SORT_ORDER', 'MODULE_PAYMENT_ICBCORDER_PAYTO');
    }
  }
?>