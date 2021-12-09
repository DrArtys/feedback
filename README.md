# Feedback

# Для запуска бэкенда.

-   Создать две базы данных utf8mb4_general_ci;
-   изменить в файле .env настройки для подключения к ним;
-   выполнить команду composer install;
-   выполнить команду php artisan migrate;
-   запустить бэкенд командой php artisan serve.

<p> Способ стандартного варианта сохранения отзывов с фронтенда меняется в файле .env в строке 'CURRENT_DB' </p>
<p> Возможные значения:</p>

-   mysql1 - для сохранения отзывов в первую базу данных;
-   mysql2 - для сохранения отзывов во вторую базу данных;
-   file - для сохранения отзывов во вторую базу данных.

<p> В файле app\Http\Controllers\api\v1\FeedbackController.php в методе store: </p>

-   Строка 50. $feedbackFactory использует стандартный способ сохранения отзывов из конфигурации .env;
-   Строка 51-52. Закоментированны, как пример использования вариантов сохранения отзывов.

# Для запуска фронтенда.

-   выполнить команду npm install или yarn install;
-   в файле feedback_frontend/store/index.js изменить значение константы apiEndpoint ('127.0.0.1:8000') на ip:port, на котором запущен бэкенд;
-   запустить фронтенд командой npm start или yarn start.

# Дополнительная информация

<p>В папке с бэкендом лежат файлы: routes.txt с выводом существующих маршрутов, а также файл коллекции для Postman.</p>
