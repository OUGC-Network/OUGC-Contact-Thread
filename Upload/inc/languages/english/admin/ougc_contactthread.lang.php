<?php

/***************************************************************************
 *
 *    OUGC Contact Thread plugin (/inc/languages/english/admin/ougc_contactthread.lang.php)
 *    Author: Omar Gonzalez
 *    Copyright: © 2015 - 2023 Omar Gonzalez
 *
 *    Website: https://ougc.network
 *
 *    Creates a forum thread instead of emailing a contact message.
 *
 ***************************************************************************
 ****************************************************************************
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 ****************************************************************************/

// Plugin API
$l['setting_group_ougc_contactthread'] = 'OUGC Contact Thread';
$l['setting_group_ougc_contactthread_desc'] = 'Creates a forum thread instead of emailing a contact message.';

// PluginLibrary
$l['ougc_contactthread_pluginlibrary_required'] = 'This plugin requires <a href="{1}">PluginLibrary</a> version {2} or later to be uploaded to your forum.';

// Settings
$l['setting_ougc_contactthread_forumid'] = 'Contact Thread Forum';
$l['setting_ougc_contactthread_forumid_desc'] = 'Select the forum where contact messages should be posted in.';
$l['setting_ougc_contactthread_disablemaling'] = 'Disable Contact Mail';
$l['setting_ougc_contactthread_disablemaling_desc'] = 'Stop the system from sending the contact mail.';
$l['setting_ougc_contactthread_prefix'] = 'Thread Prefix ID';
$l['setting_ougc_contactthread_prefix_desc'] = 'If the selected forum requires a thread prefix this setting is necessary.';