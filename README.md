---
languages:
- php
description: "Lunada Bay Tile Extranet for Product Information"
products:
- azure
- azure-app-service
---

# Laravel app for Azure App Service

[Laravel website](https://laravel.com)

Based on tutorial at [Build a PHP and MySQL web app in Azure](https://docs.microsoft.com/azure/app-service/tutorial-php-mysql-app?pivots=platform-linux).

## Contributing

Contact [horacio@lunadabaytile.com](mailto:horacio@lunadabaytile.com) with questions or comments.

## Quick Installation

    git clone https://github.com/hs2600/lbt-extranet lbt-extranet

    cd lbt-extranet

    composer update

    composer install
    
    php artisan migrate
    
    npm run build

    php artisan serve
