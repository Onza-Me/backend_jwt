# JWT package

Generating RSA keys

    php artisan jwt:rsa:generate
    
By default command will create directory: `storage/app/rsa`, with files `access_token_id_rsa` and `access_token_id_rsa.pub` 

`access_token_id_rsa` - Private key

`access_token_id_rsa.pub` - Public key

If you will run command again your old keys will renamed like this: `access_token_id_rsa.1591959685.bak`
