<?php

/***************************************************************************
 *
 *    OUGC Contact Thread plugin (/inc/plugins/ougc_contactthread.php)
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

declare(strict_types=1);

// Die if IN_MYBB is not defined, for security reasons.
if (!defined('IN_MYBB')) {
    die('This file cannot be accessed directly.');
}

// PLUGINLIBRARY
if (!defined('PLUGINLIBRARY')) {
    define('PLUGINLIBRARY', MYBB_ROOT . 'inc/plugins/pluginlibrary.php');
}

// Plugin API
function ougc_contactthread_info(): array
{
    global $contactthread;

    return $contactthread->_info();
}

// _activate() routine
function ougc_contactthread_activate(): void
{
    global $contactthread;

    $contactthread->_activate();
}

// _is_installed() routine
function ougc_contactthread_is_installed(): bool
{
    global $contactthread;

    return $contactthread->_is_installed();
}

// _uninstall() routine
function ougc_contactthread_uninstall(): void
{
    global $contactthread;

    $contactthread->_uninstall();
}

// Plugin class
class OUGC_ContactThread
{
    function __construct()
    {
        global $plugins;

        // Tell MyBB when to run the hook
        if (defined('IN_ADMINCP')) {
            $plugins->add_hook('admin_config_settings_start', [$this, 'load_language']);
            $plugins->add_hook('admin_style_templates_set', [$this, 'load_language']);
            $plugins->add_hook('admin_config_settings_change', [$this, 'load_language']);
        } else {
            $plugins->add_hook('contact_do_start', [$this, 'hook_contact_do_start']);
        }
    }

    // Plugin API:_info() routine
    function _info(): array
    {
        global $lang;

        $this->load_language();

        return [
            'name' => 'OUGC Contact Thread',
            'description' => $lang->setting_group_ougc_contactthread_desc,
            'website' => 'https://community.mybb.com/mods.php?action=view&pid=1361',
            'author' => 'Omar G.',
            'authorsite' => 'https://ougc.network',
            'version' => '1.8.33',
            'versioncode' => 1833,
            'compatibility' => '183*',
            'codename' => 'ougc_contactthread',
            'pl' => [
                'version' => 13,
                'url' => 'https://community.mybb.com/mods.php?action=view&pid=573'
            ]
        ];
    }

    // Plugin API:_activate() routine
    function _activate(): void
    {
        global $PL, $lang, $cache;

        $this->load_pluginlibrary();

        $PL->settings('ougc_contactthread', $lang->setting_group_ougc_contactthread, $lang->setting_group_ougc_contactthread_desc, [
            'forumid' => [
                'title' => $lang->setting_ougc_contactthread_forumid,
                'description' => $lang->setting_ougc_contactthread_forumid_desc,
                'optionscode' => 'forumselectsingle',
                'value' => ''
            ],
            'disablemaling' => [
                'title' => $lang->setting_ougc_contactthread_disablemaling,
                'description' => $lang->setting_ougc_contactthread_disablemaling_desc,
                'optionscode' => 'yesno',
                'value' => 1
            ],
            'prefix' => [
                'title' => $lang->setting_ougc_contactthread_prefix,
                'description' => $lang->setting_ougc_contactthread_prefix_desc,
                'optionscode' => 'numeric',
                'value' => 0
            ],
        ]);

        // Insert/update version into cache
        $pluginList = (array)$cache->read('ougc_plugins');

        if (!isset($pluginList['contactthread'])) {
            $pluginList['contactthread'] = $this->_info()['versioncode'];
        }

        /*~*~* RUN UPDATES START *~*~*/

        /*~*~* RUN UPDATES END *~*~*/

        $pluginList['contactthread'] = $this->_info()['versioncode'];

        $cache->update('ougc_plugins', $pluginList);
    }

    // Plugin API:_is_installed() routine
    function _is_installed(): bool
    {
        global $cache;

        $pluginList = (array)$cache->read('ougc_plugins');

        return isset($pluginList['contactthread']);
    }

    // Plugin API:_uninstall() routine
    function _uninstall(): void
    {
        global $PL, $cache;

        if (!($PL instanceof \PluginLibrary)) {
            require_once \PLUGINLIBRARY;
        }

        // Delete settings
        $PL->settings_delete('ougc_contactthread');

        // Delete version from cache
        $pluginList = (array)$cache->read('ougc_plugins');

        if (isset($pluginList['contactthread'])) {
            unset($pluginList['contactthread']);
        }

        if (!empty($pluginList)) {
            $cache->update('ougc_plugins', $pluginList);
        } else {
            $cache->delete('ougc_plugins');
        }
    }

    // Load language file
    function load_language(): void
    {
        global $lang;

        if (!isset($lang->setting_group_ougc_contactthread)) {
            $lang->load('ougc_contactthread');
        }
    }

    // PluginLibrary requirement check
    function load_pluginlibrary(): void
    {
        global $lang, $PL;

        $this->load_language();

        $fileExists = file_exists(\PLUGINLIBRARY);

        if ($fileExists && !($PL instanceof \PluginLibrary)) {
            require_once \PLUGINLIBRARY;
        }

        if (!$fileExists || $PL->version < $this->_info()['pl']['version']) {
            \flash_message(
                $lang->sprintf(
                    $lang->ougc_contactthread_pluginlibrary_required,
                    $this->_info()['pl']['ulr'],
                    $this->_info()['pl']['version']
                ),
                'error'
            );

            \admin_redirect('index.php?module=config-plugins');
        }
    }

    // Hook: hook_my_mail_pre_send
    function hook_my_mail_pre_send(&$args): void
    {
        global $mybb, $lang, $forum_cache;

        if (!$forum_cache) {
            cache_forums();
        }

        $fid = (int)$mybb->settings['ougc_contactthread_forumid'];

        if (empty($forum_cache[$fid])) {
            return;
        }

        require_once \MYBB_ROOT . 'inc/datahandlers/post.php';

        $postHandler = new \PostDataHandler('insert');

        $postHandler->action = 'thread';

        $userID = (int)$mybb->user['uid'];

        $userName = $lang->guest;

        if ($userID) {
            $userName = $mybb->user['username'];
        }

        $threadData = [
            'fid' => $fid,
            'subject' => $args['subject'],
            'icon' => -1,
            'uid' => $userID,
            'username' => $userName,
            'message' => $args['message'],
            'ipaddress' => $mybb->session->packedip,
            'savedraft' => 0,
            'prefix' => (int)$mybb->settings['ougc_contactthread_prefix'],
            'options' => [
                'signature' => 0,
                'subscriptionmethod' => 0,
                'disablesmilies' => 0
            ],
        ];

        $postHandler->set_data($threadData);

        if ($postHandler->validate_thread()) {
            $thread_info = $postHandler->insert_thread();

            require_once \MYBB_ROOT . 'inc/functions_indicators.php';

            \mark_thread_read($thread_info['tid'], $fid);
        }

        if ($mybb->settings['ougc_contactthread_disablemaling']) {
            $args['continue_process'] = false;

            $mybb->settings['mail_logging'] = 0; // this could cause issues
        }
    }

    // Hook: contact_do_start
    function hook_contact_do_start(): void
    {
        global $plugins;

        $plugins->add_hook('my_mail_pre_send', [$this, 'hook_my_mail_pre_send']);
    }
}

global $contactthread;

$contactthread = new \OUGC_ContactThread;