## 简介

一个简单的电商系统，适合微小企业使用，包含PC/WAP端（自适应），小程序端，空闲时间兴趣撸码，持续更新中... 请关注！

## 联系

邮箱：i@thankifu.com

前台演示：demo.oneue.com

后台演示：demo.oneue.com/admin

前/后台帐号：oneue

前/后台密码：oneue.com

## 使用

1.clone 项目

```
git clone https://gitee.com/thankifu/oneue.git	#Gitee
git clone https://github.com/thankifu/oneue.git	#Github
```

2.通过 composer 安装依赖。

```
composer install
```

3.复制一份.env.example并命名为.evn，并自行修改其中配置。

```
cp .env.example .env
```

4.生成密钥。

```
php artisan key:generate
```

5.创建符号链接。

```
php artisan storage:link
```

6.将oneue.sql导入到数据库 [因项目还在更新中，数据库也会随时更新]。

7.数据库默认的后台帐号密码同为：admin。

8.邮箱注册需配置。

```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.域名.com
MAIL_PORT=25/465
MAIL_USERNAME=邮箱
MAIL_PASSWORD=密码
MAIL_ENCRYPTION=null/ssl
MAIL_FROM_ADDRESS=邮箱
MAIL_FROM_NAME=发件人名/网站名
```

9.微信注册登陆需配置。

```
WECHAT_OFFICIAL_ACCOUNT_APPID = APP_ID
WECHAT_OFFICIAL_ACCOUNT_SECRET = APP_SECRET
```

10.微信支付需配置。

```
WECHAT_PAYMENT_APPID = APP_ID
WECHAT_PAYMENT_MCH_ID = 商户号
WECHAT_PAYMENT_KEY = API_KEY
```

## 功能

名曰：简单，因此只包含一个电商系统的基础功能，在这些基础功能上，你可以进行二次开发以满足业务中的各种需求。

- **后端【PC】**
  - 登录（2019.11.31）
  - 系统
    - 管理员（2019.11.31）
    - 管理组（2019.11.31）
    - 后台菜单（2019.11.31）
    - 网站设置（2019.12.02）
    - 附件设置（2019.12.05）
    - 操作日志（2019.12.05）
  - 文章
    - 文章管理（2019.12.03）
    - 文章分类（2019.12.04）
  - 商品
    - 商品管理（2019.12.05）
    - 商品分类（2019.12.11）
  - 用户
    - 用户管理（2019.12.20）
    - 用户等级（2019.12.20）
- 订单
    - 订单管理（2019.12.20）
  - 帮助
    - 帮助管理（2020.01.02）
    - 帮助分类（2020.01.02）
  - 轮播
    - 轮播管理（2020.01.02）
- **前端【PC/WAP】**
  - 首页（2019.12.12）
  - 文章
    - 列表（2019.12.13）
    - 详情（2019.12.13）
  - 商品
    - 列表（2019.12.15）
    - 详情（2019.12.15）
  - 购物
    - 购物车（2019.12.17）
    - 结算台（2019.12.17）
    - 微信支付-NATIVE（2019.12.29）
    - 微信支付-H5（2020.01.09）
    - 微信支付-JSAPI（2020.01.09）
  - 用户中心
    - 地址管理（2019.12.17）
    - 我的订单（2019.12.28）
  - 帮助
    - 详情（2020.01.02）
  - 登录（2019.12.17）
  - 注册（2020.01.01）
  - 微信中授权登录注册（2020.01.08）
- **小程序端**
  - 更新中 ...

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
| 更新中...     | 整理后会逐个写入                          |        |

部分代码来自互联网，若有异议可以联系作者进行删除。

## 版权信息

该项目签署了MIT授权许可，详情请参阅 [LICENSE.md](/LICENSE)

## 代码仓库

gitee：https://gitee.com/thankifu/oneue

github：https://github.com/thankifu/oneue

## 更新日志

v1.0.0	更新中