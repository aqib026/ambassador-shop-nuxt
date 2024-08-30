        FROM php:8.0.30
        RUN docker-php-ext-install pdo pdo_mysql
        RUN curl -SS https://getcomposer.org/installer | php -- \
                --install-dir=/usr/local/bin --filename=composer

        WORKDIR /app
        COPy . . 
        RUN composer install

        CMD php artisan serve --host=0.0.0.0
