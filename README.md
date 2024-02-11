# Traffic light task

## Требования

Перед началом убедитесь, что у вас все установлено  ниже перечисленные : 

- PHP (>= 8.1)
- Composer
- Node.js (>= 16.x) and NPM
- MySQL или на ваше усмотрение
- Git 

## Установка 

1. Clone the repository to your local machine using Git (or download the ZIP file and extract it):

   ```bash
   git clone https://github.com/Lava15/Traffic-light.git
   ```

2. Переходим в директорию:

   ```bash
   cd Traffic-light
   ```

3. Устанавливаем все зависимости:

   ```bash
   composer install
   ```

4. Устанавливаем все зависимости JS:

   ```bash
   npm install
   ```

5. Копируем `.env.example` в `.env`:

   ```bash
   cp .env.example .env
   ```

6. Генирируем ключ:

   ```bash
   php artisan key:generate
   ```

7. Настрой базу данных в  `.env`.

8. Запускаем миграции:

   ```bash
   php artisan migrate
   ```
   
## Usage

Запускаем дев сервер:

```bash
php artisan serve
```
