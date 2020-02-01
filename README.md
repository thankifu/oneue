## 简介

一个简单的电商系统，适合个体/微小商户企业使用，包含PC/WAP端（自适应），小程序端，空闲时间兴趣撸码，持续更新中... 请关注！

代码持续维护完善中，如有碰到BUG，欢迎反馈，谢谢！

## 联系

邮箱：i@thankifu.com

前台演示：demo.oneue.com

后台演示：demo.oneue.com/admin

前/后台帐号：oneue

前/后台密码：oneue.com

## 使用

#### 1.clone 项目

Gitee：

```bash
  git clone https://gitee.com/thankifu/oneue.git
```

Github：

```bash
  git clone https://github.com/thankifu/oneue.git
```

#### 2.通过 composer 安装依赖。

```bash
composer install
```

#### 3.复制一份.env.example并命名为.evn。

Linux系统：

```bash
  cp .env.example .env
```

Windows系统：

```bash
  copy .env.example .env
```

#### 4.修改.evn中的配置。

数据库配置：

```php
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=laravel
  DB_USERNAME=root
  DB_PASSWORD=
```

邮箱注册需配置：

```PHP
  MAIL_DRIVER=smtp
  MAIL_HOST=smtp.域名.com
  MAIL_PORT=25/465
  MAIL_USERNAME=邮箱
  MAIL_PASSWORD=密码
  MAIL_ENCRYPTION=null/ssl
  MAIL_FROM_ADDRESS=邮箱
  MAIL_FROM_NAME=发件人名/网站名
```

微信注册登陆需配置：

```
  WECHAT_OFFICIAL_ACCOUNT_APPID = APP_ID
  WECHAT_OFFICIAL_ACCOUNT_SECRET = APP_SECRET
```

微信支付需配置：

```php
  WECHAT_PAYMENT_APPID = APP_ID
  WECHAT_PAYMENT_MCH_ID = 商户号
  WECHAT_PAYMENT_KEY = API_KEY
```

#### 5.生成密钥。

```bash
php artisan key:generate
```

#### 6.创建符号链接。

```bash
php artisan storage:link
```

#### 7.将oneue.sql导入到数据库。

[因项目还在更新中，数据库也会随时更新]。

#### 8.数据库默认的后台帐号密码同为：admin。

## 功能

名曰：简单，因此只包含一个电商系统的基础功能：用户模块、文章模块、商品模块、购物模块、订单模块、支付模块。在这些基础功能上，你可以进行二次开发以满足业务中的各种需求。

## 展示

![](https://img.starslabs.com/uploads/0000000000000git/frontend-01.jpg)

![](https://img.starslabs.com/uploads/0000000000000git/backend-01.jpg)

![](https://img.starslabs.com/uploads/0000000000000git/backend-03.jpg)

## 鸣谢

| 名称          | 描述                                      | 版本   |
| ------------- | ----------------------------------------- | ------ |
| Laravel       | 一套简洁、优雅的PHP Web开发框架           | 5.8.*  |
| Bootstrap     | Twitter推出的一个用于前端开发的开源工具包 | 3.3.7  |
| Bootbox       | 让Bootstrap modals变得简单                | 5.3.2  |
| CKEditor      | 优秀的网页在线文字编辑器之一              | 4.10.1 |
| Highlight     | 代码高亮                                  | 9.17.1 |
| EasyWeChat    | 一个开源的 微信 非官方 SDK                | 4.*    |
| Simple QrCode | 二维码生成包                              | 2.0.0  |
| Jwt-Auth      | JSON Web Token Authentication for Laravel | 4.1    |
| 更新中...     | 整理后会逐个写入                          |        |

部分代码来自互联网，若有异议可以联系作者进行删除。

## 版权信息

该项目签署了MIT授权许可，详情请参阅 [LICENSE.md](/LICENSE)

## 代码仓库

gitee：https://gitee.com/thankifu/oneue

github：https://github.com/thankifu/oneue

## 更新日志

v0.1.0	更新中