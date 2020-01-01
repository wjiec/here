### Here

#### How to install(deploy)

```sh
# install docker

# install docker-compose

# docker-compose up -d

# curl http://localhost/api/status/version

# done
```


#### for redis
```shell
# WARNING overcommit_memory is set to 0! Background save may fail under low memory condition.
sysctl vm.overcommit_memory=1

# WARNING: The TCP backlog setting of 511 cannot be enforced
sysctl net.core.somaxconn=1024
```


### TODOs

```php
// Add CSP header
$this->response->setHeader('Content-Security-Policy', "default-src 'self'; style-src 'unsafe-inline'; ");
```
