# Phalcon

[![Packagist](https://img.shields.io/packagist/v/liluoao/phalcon.svg?style=flat-square)](https://packagist.org/packages/liluoao/phalcon)

### 安装本库
```shell
composer create-project liluoao/phalcon
```

### 安装Phalcon
Phalcon 是使用 C 扩展编写、高性能的 PHP 框架。

Windows用户可以在https://github.com/phalcon/cphalcon/releases 下载 `.dll` 文件，加入 `php.ini` 配置中：
```ini
extension=php_phalcon.dll
```
重启你的WEB服务器后，在 `phpinfo()` 中看到 Phalcon 扩展，代表你安装成功。

### 安装Phalcon-devtool
[phalcon-devtools](https://github.com/phalcon/phalcon-devtools) 是Phalcon开发者工具，可以自动生成代码，和为IDE创建Phalcon语法提示。
```shell
git clone https://github.com/phalcon/phalcon-devtools.git
```

然后将目录加入系统环境变量**PATH**，在命令行输入：
```shell
phalcon --help
```
返回如下信息，说明设置成功：
```shell
Phalcon DevTools (3.2.12)

Help:
  Lists the commands available in Phalcon devtools

Available commands:
  info             (alias of: i)
  commands         (alias of: list, enumerate)
  controller       (alias of: create-controller)
  module           (alias of: create-module)
  model            (alias of: create-model)
  all-models       (alias of: create-all-models)
  project          (alias of: create-project)
  scaffold         (alias of: create-scaffold)
  migration        (alias of: create-migration)
  webtools         (alias of: create-webtools)
  serve            (alias of: server)
  console          (alias of: shell, psysh)
```
#### 为IDE创建语法提示
进入 `~/phalcon-devtools/ide` 文件夹，运行命令：
```shell
php gen-stubs.php
```
它会在本文件夹中生成相应版本语法目录，在你的IDE中导入 `Configure PHP Include Paths` 即可。
