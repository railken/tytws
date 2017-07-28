
# Installation

1) Clone repository
```
git clone https://github.com/EchoWine/Gate [directory]
cd [directory]
```

2) Install with composer
```
composer install
```

3) Setup environment 

```
mv .env.copy .env
mv src/Nut/env.js.copy src/Nut/env.js
```

4) Setup laravel
```
php artisan key:generate
php artisan migrate
php artisan storage:link

```

5) Create OAuth application in both github/gitlab and edit src/Nut/env.js


6) Run 
```
npm run build
```
