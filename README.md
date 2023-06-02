<p align="center">
    <a href="" rel="noopener">
        <img width="700" height="400" src="https://github.com/OUGC-Network/OUGC-Contact-Thread/assets/1786584/d5f06e8a-5850-4836-8a83-b7b5b4f2ecf5" alt="Project logo">
    </a>
</p>

<h3 align="center">OUGC Contact Thread</h3>

<div align="center">

[![Status](https://img.shields.io/badge/status-active-success.svg)]()
[![GitHub Issues](https://img.shields.io/github/issues/OUGC-Network/OUGC-Contact-Thread.svg)](./issues)
[![GitHub Pull Requests](https://img.shields.io/github/issues-pr/OUGC-Network/OUGC-Contact-Thread-Media.svg)](./pulls)
[![License](https://img.shields.io/badge/license-GPL-blue)](/LICENSE)

</div>

---

<p align="center"> Creates a forum thread instead of emailing a contact message.
    <br> 
</p>

## 📜 Table of Contents <a name = "table_of_contents"></a>

- [About](#about)
- [Getting Started](#getting_started)
	- [Dependencies](#dependencies)
	- [File Structure](#file_structure)
	- [Install](#install)
	- [Update](#update)
- [Settings](#settings)
- [Usage](#usage)
- [Built Using](#built_using)
- [Authors](#authors)
- [Acknowledgments](#acknowledgement)
- [Support & Feedback](#support)

## 🚀 About <a name = "about"></a>

OUGC Contact Thread is a MyBB plugin designed to streamline communication on your forum. With this easy-to-use script, whenever a user submits a message via the contact form, a dedicated thread is automatically created within a specified forum. By redirecting contact messages to the forum, the plugin reduces the volume of emails sent, making communication more efficient and organized.

[Go up to Table of Contents](#table_of_contents)

## 📍 Getting Started <a name = "getting_started"></a>

The following information will assist you into getting a copy of this plugin up and running on your forum.

### Dependencies <a name = "dependencies"></a>

A setup that meets the following requirements is necessary to use this plugin.

- [MyBB](https://mybb.com/) >= 1.8.30
- PHP >= 7.4
- [MyBB-PluginLibrary](https://github.com/frostschutz/MyBB-PluginLibrary) >= 13

### File structure <a name = "file_structure"></a>

  ```
   .
   ├── inc
   │ ├── plugins
   │ │ ├── ougc_contactthread.php
   │ ├── languages
   │ │ ├── espanol
   │ │ │ ├── admin
   │ │ │ │ ├── ougc_contactthread.lang.php
   │ │ ├── english
   │ │ │ ├── admin
   │ │ │ │ ├── ougc_contactthread.lang.php
   ```

### Installing <a name = "install"></a>

Follow the next steps in order to install a copy of this plugin on your forum.

1. Download the latest package from the [MyBB Extend](https://community.mybb.com/mods.php?action=view&pid=1361) site or from the [repository releases](https://github.com/OUGC-Network/OUGC-Contact-Thread/releases/latest).
2. Upload the contents of the _Upload_ folder to your MyBB root directory.
3. Browse to _Configuration » Plugins_ and install this plugin by clicking _Install & Activate_.

### Updating <a name = "update"></a>

Follow the next steps in order to update your copy of this plugin.

1. Browse to _Configuration » Plugins_ and deactivate this plugin by clicking _Deactivate_.
2. Follow step 1 and 2 from the [Install](#install) section.
3. Browse to _Configuration » Plugins_ and activate this plugin by clicking _Activate_.

[Go up to Table of Contents](#table_of_contents)

## 🛠 Settings <a name = "settings"></a>

Below you can find a description of the plugin settings.

### Global Settings

- **Contact Thread Forum** `select`
	- _Select the forum where contact messages should be posted in._
- **Disable Contact Mail** `yesNo` Default: `yes`
	- _Stop the system from sending the contact mail._

[Go up to Table of Contents](#table_of_contents)

## 📖 Usage <a name="usage"></a>

This plugin has no setting or configuration; installing and activating should be sufficient to get this plugin working.

[Go up to Table of Contents](#table_of_contents)

## ⛏ Built Using <a name = "built_using"></a>

- [MyBB](https://mybb.com/) - Web Framework
- [MyBB PluginLibrary](https://github.com/frostschutz/MyBB-PluginLibrary) - A collection of useful functions for MyBB
- [PHP](https://www.php.net/) - Server Environment

[Go up to Table of Contents](#table_of_contents)

## ✍️ Authors <a name = "authors"></a>

- [@Omar G](https://github.com/Sama34) - Idea & Initial work

See also the list of [contributors](https://github.com/OUGC-Network/OUGC-Contact-Thread/contributors) who participated in this project.

[Go up to Table of Contents](#table_of_contents)

## 🎉 Acknowledgements <a name = "acknowledgement"></a>

- [The Documentation Compendium](https://github.com/kylelobo/The-Documentation-Compendium)

[Go up to Table of Contents](#table_of_contents)

## 🎈 Support & Feedback <a name="support"></a>

This is free development and any contribution is welcome. Get support or leave feedback at the official [MyBB Community](https://community.mybb.com/thread-227574.html).

Thanks for downloading and using our plugins!

[Go up to Table of Contents](#table_of_contents)