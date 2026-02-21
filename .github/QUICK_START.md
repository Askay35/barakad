# Быстрый старт: Настройка SSH для деплоя

## Вариант 1: Использовать существующий ключ

Если вы хотите использовать существующий ключ `~/.ssh/id_rsa`:

### 1. Добавьте публичный ключ на сервер

```bash
# Скопируйте публичный ключ на сервер
ssh-copy-id user@your-server-ip

# Или если у вас другой ключ:
ssh-copy-id -i ~/.ssh/id_rsa.pub user@your-server-ip
```

### 2. Добавьте приватный ключ в GitHub Secrets

1. Откройте репозиторий на GitHub → `Settings` → `Secrets and variables` → `Actions`
2. Нажмите `New repository secret`
3. Имя: `SSH_PRIVATE_KEY`
4. Значение: скопируйте весь приватный ключ:

```bash
cat ~/.ssh/id_rsa
```

Скопируйте **весь вывод**, включая строки:
```
-----BEGIN OPENSSH PRIVATE KEY-----
...
...
-----END OPENSSH PRIVATE KEY-----
```

### 3. Добавьте остальные секреты

- **SERVER_USER**: `root` (или ваш пользователь)
- **SERVER_HOST**: IP адрес сервера (например: `192.168.1.100`)
- **SERVER_PATH**: `/var/www/barakad` (или ваш путь)

## Вариант 2: Создать отдельный ключ для деплоя (рекомендуется)

### 1. Создайте новый ключ

```bash
ssh-keygen -t ed25519 -C "barakad-deploy" -f ~/.ssh/barakad_deploy
```

При запросе пароля можно оставить пустым (Enter).

### 2. Добавьте публичный ключ на сервер

```bash
# Скопируйте публичный ключ
cat ~/.ssh/barakad_deploy.pub

# Отправьте его на сервер (замените user и IP)
ssh-copy-id -i ~/.ssh/barakad_deploy.pub user@your-server-ip

# Или вручную на сервере:
# 1. Подключитесь к серверу
# 2. Выполните:
mkdir -p ~/.ssh
chmod 700 ~/.ssh
echo "ВАШ_ПУБЛИЧНЫЙ_КЛЮЧ" >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
```

### 3. Добавьте приватный ключ в GitHub

```bash
# Покажите приватный ключ
cat ~/.ssh/barakad_deploy
```

Скопируйте весь вывод в GitHub Secret `SSH_PRIVATE_KEY`.

## Проверка

Проверьте подключение:

```bash
# Если используете существующий ключ
ssh user@your-server-ip

# Если используете новый ключ
ssh -i ~/.ssh/barakad_deploy user@your-server-ip
```

Если подключение успешно, всё настроено правильно!

## Готово!

Теперь при пуше в `main`/`master` или при ручном запуске workflow будет происходить автоматический деплой.

