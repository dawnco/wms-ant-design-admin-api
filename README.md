# 前端配套后台

### 前端代码

https://github.com/dawnco/wms-ant-design-admin

### 后端代码

https://github.com/dawnco/wms-ant-design-admin-api

### 后端代码 来源

https://github.com/vbenjs/vue-vben-admin 


nginx 部署
修改对应的 root 目录
```nginx

server {
    server_name  _;
    listen 80;
    root         /www/wms-ant-design-admin/dist;
    index        index.html;
    location /api/ {
        proxy_pass http://127.0.0.1:87
    }
}


server {
    server_name  _;
    listen 87;

    location ~ \.php$ {
            fastcgi_pass 127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            include        fastcgi_params;
    }

    location / {
            try_files $uri $uri/ /index.php?$query_string;
            proxy_set_header X-Request-Id $request_id;
            proxy_set_header X-Real-IP $remote_addr;
            proxy_set_header X-Api-Path $uri;
            proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    }

    root         /www/wms-ant-design-admin-api/www;
    index        index.php;

}

```
