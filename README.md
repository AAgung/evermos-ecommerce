# Evermos - Test No. 1

# 1. Apa yang terjadi?

Terjadinya pembatalan order customer dikarenakan stok produk - produk yang dipesan tidak tersedia pada saat terjadinya event 12.12. Hal itu terjadi karena tidak adanya validasi untuk pengecekan stok produk pada sistem apakah produk tersebut masih tersedia atau tidak pada saat customer menambahkan produk yang akan dibeli ke keranjang belanja.

# 2. Solusi yang ditawarkan

Harus ada proses validasi untuk pengecekan stok pada sistem ketika customer menambahkan produk yang akan dibeli ke keranjang belanja.

## Untuk menjalankan aplikasi pada local environment

1. Buka Terminal / CMD / Git Bash pada root project folder
2. ketikkan 'composer install'
3. Salin file '.env.example' menjadi .env dan setting konfigurasi sesuai dengan yang ada pada local environtment
    - DB_DATABASE: database_name
    - DB_USERNAME: database_username
    - DB_PASSWORD: database_password
4. ketikkan 'php artisan migrate:fresh --seed' pada Terminal / CMD / Git Bash
5. ketikkan 'php artisan serve' pada Terminal / CMD / Git Bash untuk memulai server

## API ENDPOINTS

-   list Product => {base_url}/api/master/product
-   list cart => {base_url}/api/transaction/cart
-   add cart => {base_url}/api/transaction/cart
-   update cart => {base_url}/api/transaction/cart/{uid}
-   delete cart => {base_url}/api/transaction/cart/{uid}

https://documenter.getpostman.com/view/3619632/TVt2cNye#89323dd1-fef0-49ab-93f1-565402fbced2

## TESTING

-   untuk testing solusi, ketikkan perintah:
    'vendor\bin\phpunit --filter=CartTest' untuk windows
    'vendor/bin/phpunit --filter=CartTest' untuk linux
