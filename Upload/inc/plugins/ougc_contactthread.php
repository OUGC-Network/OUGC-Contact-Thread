<?php

/***************************************************************************
 *
 *    OUGC Contact Thread plugin (/inc/plugins/ougc_contactthread.php)
 *    Author: Omar Gonzalez
 *    Copyright: © 2015 - 2020 Omar Gonzalez
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

// Die if IN_MYBB is not defined, for security reasons.
defined('IN_MYBB') or die('Direct initialization of this file is not allowed.');

// PLUGINLIBRARY
defined('PLUGINLIBRARY') or define('PLUGINLIBRARY', MYBB_ROOT . 'inc/plugins/pluginlibrary.php');

// Plugin API
function ougc_contactthread_info()
{
    global $contactthread;

    return $contactthread->_info();
}

// _activate() routine
function ougc_contactthread_activate()
{
    global $contactthread;

    return $contactthread->_activate();
}

// _install() routine
function ougc_contactthread_install()
{
}

// _is_installed() routine
function ougc_contactthread_is_installed()
{
    global $contactthread;

    return $contactthread->_is_installed();
}

// _uninstall() routine
function ougc_contactthread_uninstall()
{
}

// Plugin class
class OUGC_ContactThread
{
    function __construct()
    {
        global $plugins;

        // Tell MyBB when to run the hook
        if (defined('IN_ADMINCP')) {
            $plugins->add_hook('admin_config_settings_start', array($this, 'load_language'));
            $plugins->add_hook('admin_style_templates_set', array($this, 'load_language'));
            $plugins->add_hook('admin_config_settings_change', array($this, 'hook_admin_config_settings_change'));
        } else {
            $plugins->add_hook('contact_do_start', array($this, 'hook_contact_do_start'));
            $plugins->add_hook('contact_do_end', array($this, 'hook_contact_do_end'));
        }
    }

    // Plugin API:_info() routine
    function _info()
    {
        global $lang;

        $this->load_language();

        return array(
            'name' => 'OUGC Contact Thread',
            'description' => $lang->setting_group_ougc_contactthread_desc,
            'website' => 'https://ougc.network',
            'author' => 'Omar G.',
            'authorsite' => 'https://ougc.network',
            'version' => '1.8.20',
            'versioncode' => 1820,
            'compatibility' => '18*',
            'codename' => 'ougc_contactthread',
            'pl' => array(
                'version' => 13,
                'url' => 'https://community.mybb.com/mods.php?action=view&pid=573'
            )
        );
    }

    // Plugin API:_activate() routine
    function _activate()
    {
        global $PL, $lang, $mybb;
        $this->load_pluginlibrary();

        $PL->settings('ougc_contactthread', $lang->setting_group_ougc_contactthread, $lang->setting_group_ougc_contactthread_desc, array(
            'forumid' => array(
                'title' => $lang->setting_ougc_contactthread_forumid,
                'description' => $lang->setting_ougc_contactthread_forumid_desc,
                'optionscode' => $mybb->version_code < 1806 ? 'forumselect' : 'forumselectsingle',
                'value' => ''
            ),
            'disablemaling' => array(
                'title' => $lang->setting_ougc_contactthread_disablemaling,
                'description' => $lang->setting_ougc_contactthread_disablemaling_desc,
                'optionscode' => 'yesno',
                'value' => 1
            ),
        ));

        // Insert/update version into cache
        $plugins = $mybb->cache->read('ougc_plugins');
        if (!$plugins) {
            $plugins = array();
        }

        $this->load_plugin_info();

        if (!isset($plugins['contactthread'])) {
            $plugins['contactthread'] = $this->plugin_info['versioncode'];
        }

        /*~*~* RUN UPDATES START *~*~*/

        /*~*~* RUN UPDATES END *~*~*/

        $plugins['contactthread'] = $this->plugin_info['versioncode'];
        $mybb->cache->update('ougc_plugins', $plugins);
    }

    // Plugin API:_is_installed() routine
    function _is_installed()
    {
        global $settings;

        return isset($settings['ougc_contactthread_forumid']);
    }

    // Plugin API:_uninstall() routine
    function _uninstall()
    {
        global $PL, $cache;
        $this->load_pluginlibrary();

        // Delete settings
        $PL->settings_delete('ougc_contactthread');

        // Delete version from cache
        $plugins = (array)$cache->read('ougc_plugins');

        if (isset($plugins['contactthread'])) {
            unset($plugins['contactthread']);
        }

        if (!empty($plugins)) {
            $cache->update('ougc_plugins', $plugins);
        } else {
            $PL->cache_delete('ougc_plugins');
        }
    }

    // Load language file
    function load_language()
    {
        global $lang;

        isset($lang->setting_group_ougc_contactthread) or $lang->load('ougc_contactthread');
    }

    // Build plugin info
    function load_plugin_info()
    {
        $this->plugin_info = ougc_contactthread_info();
    }

    // PluginLibrary requirement check
    function load_pluginlibrary()
    {
        global $lang;
        $this->load_plugin_info();
        $this->load_language();

        if (!file_exists(PLUGINLIBRARY)) {
            flash_message($lang->sprintf($lang->ougc_contactthread_pluginlibrary_required, $this->plugin_info['pl']['ulr'], $this->plugin_info['pl']['version']), 'error');
            admin_redirect('index.php?module=config-plugins');
        }

        global $PL;
        $PL or require_once PLUGINLIBRARY;

        if ($PL->version < $this->plugin_info['pl']['version']) {
            global $lang;

            flash_message($lang->sprintf($lang->ougc_contactthread_pluginlibrary_required, $this->plugin_info['pl']['ulr'], $this->plugin_info['pl']['version']), 'error');
            admin_redirect('index.php?module=config-plugins');
        }
    }

    // Hook: admin_config_settings_change
    function hook_admin_config_settings_change()
    {
        global $db, $mybb;

        $query = $db->simple_select('settinggroups', 'name', "gid='{$mybb->get_input('gid', 1)}'");

        !($db->fetch_field($query, 'name') == 'ougc_contactthread') or $this->load_language();
    }

    // Hook: contact_do_start
    function hook_contact_do_start()
    {
        global $settings, $contactemail;

        if ($settings['ougc_contactthread_disablemaling']) {
            $contactemail = '';
        }
    }

    // Hook: contact_do_end
    function hook_contact_do_end()
    {
        global $subject, $message, $mybb, $lang, $forum_cache;

        $forum_cache or cache_forums();

        if (empty($forum_cache[($fid = (int)$mybb->settings['ougc_contactthread_forumid'])])) {
            return false;
        }

        require_once MYBB_ROOT . 'inc/datahandlers/post.php';
        $posthandler = new PostDataHandler('insert');
        $posthandler->action = 'thread';

        $new_thread = array(
            'fid' => $fid,
            'subject' => $subject,
            'icon' => -1,
            'uid' => $mybb->user['uid'] ? (int)$mybb->user['uid'] : 0,
            'username' => $mybb->user['uid'] ? $mybb->user['username'] : $lang->guest,
            'subject' => $subject,
            'message' => $message,
            'ipaddress' => $mybb->session->packedip,
            'savedraft' => 0,
            'savedraft' => 0,
            'savedraft' => 0,
            'options' => array(
                'signature' => 0,
                'subscriptionmethod' => 0,
                'disablesmilies' => 0
            ),
        );

        $posthandler->set_data($new_thread);

        if ($posthandler->validate_thread()) {
            $thread_info = $posthandler->insert_thread();

            require_once MYBB_ROOT . 'inc/functions_indicators.php';
            mark_thread_read($thread_info['tid'], $fid);
        }
    }
}

global $contactthread;

$contactthread = new OUGC_ContactThread;