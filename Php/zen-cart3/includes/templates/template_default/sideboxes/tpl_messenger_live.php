<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2009 Bouncing Limited, Philip Clarke
 * @copyright Modified 2010, Clive Vooght
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

$invitee_array = explode(',', MESSENGER_INVITEE);
$content = '
<div id="messengerliveContent" class="sideBoxContent">
<center>
<script type="text/javascript" src="http://settings.messenger.live.com/controls/1.0/PresenceButton.js"></script>
';
foreach ($invitee_array as $invitee){
#if(strlen($invitee) != 16)
#continue;
$content .= '<div
  id="Microsoft_Live_Messenger_PresenceButton_'.$invitee.'"
  msgr:width="100"
  msgr:backColor="#D7E8EC"
  msgr:altBackColor="#FFFFFF"
  msgr:foreColor="#424542"
  msgr:conversationUrl="http://settings.messenger.live.com/Conversation/IMMe.aspx?invitee='.$invitee.'@apps.messenger.live.com&mkt=en-GB"></div>
<script type="text/javascript" src="http://messenger.services.live.com/users/'.$invitee.'@apps.messenger.live.com/presence?dt=&mkt=en-GB&cb=Microsoft_Live_Messenger_PresenceButton_onPresence"></script>';
}

$content .= '</center>
<br></br>
<center><p>'.BOX_TEXT_MESSENGER_LIVE.'</p></center>
</div>';
