# 🚀 Test PHP Project

Небольшой учебный проект на **чистом PHP** без фреймворков.  
Реализует динамическую генерацию контента, фильтрацию данных в постах, валидацию и отправку формы в Google Таблицы.

🔗 Демо (Vercel, заглушка): [https://test-php.vercel.app](https://test-php.vercel.app)  
📊 Google Таблица: [открыть](https://docs.google.com/spreadsheets/d/1eN-x9JXzSbuu2pIAC7iR_f9bTK050S_6IL3tiHEXXpo/edit?gid=0#gid=0)

---

## 📌 Возможности

- 👋 Приветствие по времени суток
- 📅 Текущая дата (формат: `день месяц год`)
- 👁 Счётчик посещений через `cookie`
- 📝 Посты с фильтрацией по пользователям (локально)
- 📤 Отправка формы в Google Sheets через Google Apps Script
- ✅ Валидация формы на клиенте и сервере
- 🖼 Изображения для постов (заглушки через picsum.photos)
- 🎯 Кроссбраузерная и адаптивная вёрстка

---

## ⚙️ Используемые технологии

- PHP 8+
- HTML5 / CSS3 / Flexbox
- JavaScript (минимум, только для UX)
- JSONPlaceholder API (https://jsonplaceholder.typicode.com)
- Google Sheets API (через Web App)
- Локальная фильтрация и обработка данных

---

## 📁 Структура проекта

```text
project/
├── blocks/
│   ├── greeting.php       # Приветствие и дата
│   ├── visits.php         # Счётчик посещений
│   ├── posts.php          # Посты + фильтр + изображения
│   └── form.php           # Форма с валидацией и отправкой
├── index.php              # Главная точка входа
├── style.css              # Основные стили
├── .gitignore             # Исключения для Git
└── README.md              # Документация проекта
