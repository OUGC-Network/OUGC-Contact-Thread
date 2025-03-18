<?php

/***************************************************************************
 *
 *    ougc Contact Thread plugin (/inc/languages/espanol/admin/ougc_contactthread.lang.php)
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
$l['setting_group_ougc_contactthread'] = 'ougc Contact Thread';
$l['setting_group_ougc_contactthread_desc'] = 'Crea un tema en un foro en lugar de enviar un mensaje de contacto por correo.';

// PluginLibrary
$l['ougc_contactthread_pluginlibrary_required'] = 'Este plugin requiere <a href="{1}">PluginLibrary</a> version {2} para funcionar. Favor de subir los archivos necesarios.';

// Settings
$l['setting_ougc_contactthread_forumid'] = 'Foro de Temas de Contacto';
$l['setting_ougc_contactthread_forumid_desc'] = 'Selecciona el foro donde se publicaran los mensajes de contacto.';
$l['setting_ougc_contactthread_disablemaling'] = 'Deshabilita Correo de Contacto';
$l['setting_ougc_contactthread_disablemaling_desc'] = 'Detener al sistema de enviar el correo de contacto.';
$l['setting_ougc_contactthread_prefix'] = 'ID de Prefijo de Tema';
$l['setting_ougc_contactthread_prefix_desc'] = 'Si el foro seleccionado requiere un prefijo de tema entonces esta opción es necesario.';