```bash
openssl genrsa -des3 -out ca.key 1024

openssl rsa -in ca.key -out server.key

openssl req -new -key server.key -out server.csr

openssl x509 -req -days 365 -in server.csr -signkey server.key -out server.crt

# openssl pkcs12 -export -inkey server.key -in server.crt -out server.pfx
```
