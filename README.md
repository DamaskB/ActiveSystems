# ActiveSystems
1) Клонировать репозитории
* Команда: git clone https://github.com/DamaskB/ActiveSystems.git your_dir
2) Зайти в корень репозитория
* Команда: cd your_dir
3) Запустить Composer
* Команда: composer install
4) Переименовать файл .env.axample и настроить подключение к БД в файле .env
5) Обновить миграции
* Команда: php artisan migration:refresh --seed
6) запустить сервер
* Команда: php artisan serve
