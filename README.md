# sr-api-test

**config.json**
```json
{
    "url": "http://demo.api.aurora.{{DOMAIN_ENDING}}",
    "auth": {
        "username": "",
        "password": ""
    }
}
```

**Compare two files with folder/file**
```
diff -u dir1.txt dir2.txt
```

**Settings before every running**

1. Change the fixtures/product/post.json sku property. It will be the same in the fixtures/product/put.json 