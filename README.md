自用的一套lucky项目反代Stun穿透的demo，笨办法但好用，仅供参考！


Nginx需要加上以下代码，来避免访问反代路径被Nginx当成目录去访问。

# 添加以下location块来处理所有请求

```
location / {
    try_files $uri$uri/ /index.php$is_args$args;
}
```

使用方法：
1. 正常解析域名到源站。
2. Lucky面板开启webhook，参数如下：
   - webhook地址：域名/receive_webhook.php
   - 请求方式：POST
   - 请求头：`Content-Type: application/x-www-form-urlencoded`
     

        请求主体：
     ```
        {
           "service_id": "ql.nark.cf",
            "ip": "#{ipAddr}"
          }
     ```
       响应码：200或OK
 3.手动触发一次，成功就可以保存了。
lucky仓库：[https://github.com/gdy666/lucky](https://github.com/gdy666/lucky "访问lucky仓库")
