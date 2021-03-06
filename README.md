# REST API Калькулятор для больших чисел

## Начало работы

### Установка CLI

Для начала работы нужно склонировать репозиторий к себе на компьютер:
```json
git clone https://github.com/ilya-torlin/calculator.git
```
В корне лежит файл "Makefile". В нем записаны команды для быстрой работы с проектом.

После этого, находясь в корне проекта, в терминале запустить команду:
```json
make init
```
Начнется сборка проекта, билд образов для docker-контейнеров и их запуск.

Как только запустятся контейнеры, можно будет начинать работать с калькулятором.

#### Если при переходе на главную страницу приложения не отображается интрефейс Swagger UI, попробуйте создать в проекте папку "assets":
```json
/api/web/ - создать тут папку assets
```

### Технические особенности

Для работы с большими числами был выбран вариант перевода чисел вида: 
```json
12345678987654321.1234567890987654321
```
В числа с представлением - (sign) * 0,[digits] * 10^e:
```json
12345678987654321.1234567890987654321
{
  "sign": 1 | -1,
  "exponent": 17,
  "digits": [1,2,3,4,5,6,7,8,9,8,7,6,5,4,3,2,1,1,2,3,4,5,6,7,8,9,0,9,8,7,6,5,4,3,2,1]
} 
```
Для такого вида объектов были реализованы арифметические операции +,-,* (частично деление) и операции сравнения - more, less, equal, zeroCheck, inverseSign. 

#### Стек разработки

Для разработки использовались:
* PHP 7.1,
* Yii2,
* Swagger,
* Docker,
* Codeception.

#### URL

Калькулятор доступен на локальном компьютере по адресу:

```json
http://localhost:8081
```

#### Документация 

Для документирования REST API используются OpenApi 3 аннотации, с интрефейсом Swagger UI. 

Посмотреть описание API можно при переходе на главную страницу: 

```json
http://localhost:8081
```

#### Тестирование кода

При разработке приложения использовалось Unit тестирование и тестирование API.

Для тестирования использовалась библиотека Codeception.

Для того чтобы запустить тесты нужно в корне проекта запустить команду:
 ```json
make api-tests
 ```
После запуска начнут прогоняться Unit тесты для модулей приложения и Acceptance тесты для API.

#### Тестовый режим

По умолчанию, приложение запущено в PRODUCTION режиме. 

Есть возможность запустить приложение в DEV режиме, в котором будет доступна отладочная панель:
```json
http://localhost:8081/debug
```
Чтобы запустить приложение в DEV режиме нужно в файле с переменными окружения 
```json
/api/.env.example
``` 
изменить константу: 
```json
STAGE=prod 
``` 
на 
```json
STAGE=dev 
``` 

### P.S.

Приложение не идеально. Не хватило времени, разобраться с багой 
при операции деления чисел, поэтому деление не описано в документации. 

Проблема состоит в процессе перевода числа к обратному 
(т.е. если число 10, то его обратное будет 1/10). Нужно отдебажить механизм перевода.

Плюс, есть плавающая бага, когда приложение крашится при попытке распарсить строку в модель длинного числа 
(скорее всего где-то при переводе числа или при попытке операции надо числами уходит в бесконечный цикл). 

Принимаются pull requests для исправления.
