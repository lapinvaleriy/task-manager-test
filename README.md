# Task manager test project

Run project

```
cp .env.local .env
bash build.sh
```

Before running make sure the project will use free ports and all settings are allowable for you

API documentation

```
%host%/api/doc
```

This project uses symfony messenger bundle. By default the transport type is async. 
That means handler will receive the message from queue broker. This project uses Rabbitmq. 
To consume message you should do:
```
docker exec php /bin/bash -c "php bin/console messenger:consume"
```

Or you can just download and configure supervisor c:
Or you can just configure synchronous `sync` transport type in `config/messenger.yaml`

####How to test
`build.sh` script will create three users by default in your database. These users will have 
emails like 'user%N%@test.com' where N is 1-3 number.
Therefore, for do some operations on tasks you must to create the token(see API documentation)
and then use token for further actions in headers in your request with key
`X-AUTH-TOKEN`.