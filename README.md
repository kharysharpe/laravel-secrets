# Laravel Secrets Server (PoC)

Is a key value RESTful API for storing and retrieving secrets
## Usage

```
php artisan client:new
```

This will start a wizard to create a user (Client) and generates a token along with a public and private key.
This information should be securely transferred to the Client and will be used to store and/or retrieving secrets on the Laravel Secrets Server


## Workflow

### Storing secrets
1. Client encrypts (string) data with Public Key
2. Client does a HTTP POST to the Laravel Secrets Server using it's token
3. Server decrypts the data with Private Key and re-encrypts it with the the Private Key before storing 

### Retrieving secrets
1. Client requests Secret HTTP GET using it's token
2. Server retrieves data and sends it encrypted
3. Client decrypts data with Public Key

## TODO
- Add GUI
- Add Expiration of Secrets
- Add removing secrets (soft delete?)
- ACL ?
- 
