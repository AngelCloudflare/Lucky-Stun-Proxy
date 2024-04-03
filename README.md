自用的一套lucky项目反代Stun穿透的demo，笨办法但好用，仅供参考！


Nginx需要加上以下代码，来避免访问反代路径被Nginx当成目录去访问。

# 添加以下location块来处理所有请求
```location / {
    try_files $uri$uri/ /index.php$is_args$args;
}
