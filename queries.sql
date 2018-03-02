USE yeticave;

INSERT INTO categories
  (name, translation)
VALUES
  ('boards', 'Доски и лыжи'),
  ('attachment', 'Крепления'),
  ('boots', 'Ботинки'),
  ('clothing', 'Одежда'),
  ('tools', 'Инструменты'),
  ('other', 'Разное');

INSERT INTO users
  (email, name, password)
VALUES
  ('ignat.v@gmail.com', 'Игнат', '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka'),
  ('kitty_93@li.ru', 'Леночка', '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa'),
  ('warrior07@mail.ru', 'Руслан', '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW');

INSERT INTO lots
  (name, description, image_url, starting_price, rate_step, creation_date, completion_date, category_id, author_id)
VALUES
  ('2014 Rossignol District Snowboard', 'Описание 2014 Rossignol District Snowboard','img/lot-1.jpg',10999,10,DATE_ADD(NOW(), INTERVAL -1 DAY), DATE_ADD(NOW(), INTERVAL 7 DAY),1,1),
  ('DC Ply Mens 2016/2017 Snowboard', 'Описание DC Ply Mens 2016/2017 Snowboard','img/lot-2.jpg',159999,10,DATE_ADD(NOW(), INTERVAL -1 DAY), DATE_ADD(NOW(), INTERVAL 7 DAY),1,1),
  ('Крепления Union Contact Pro 2015 года размер L/XL', 'Описание Крепления Union Contact Pro 2015 года размер L/XL','img/lot-3.jpg',8000,10,DATE_ADD(NOW(), INTERVAL -1 DAY), DATE_ADD(NOW(), INTERVAL 7 DAY),2,2),
  ('Ботинки для сноуборда DC Mutiny Charocal', 'Описание Ботинок для сноуборда DC Mutiny Charocal','img/lot-4.jpg',10999,10,DATE_ADD(NOW(), INTERVAL -3 DAY), DATE_ADD(NOW(), INTERVAL 7 DAY),3,2),
  ('Куртка для сноуборда DC Mutiny Charocal', 'Описание Куртки для сноуборда DC Mutiny Charocal','img/lot-5.jpg',7500,10,DATE_ADD(NOW(), INTERVAL -3 DAY), DATE_ADD(NOW(), INTERVAL 7 DAY),4,3),
  ('Маска Oakley Canopy', 'Описание Маски Oakley Canopy','img/lot-6.jpg',5400,10,DATE_ADD(NOW(), INTERVAL -1 DAY), DATE_ADD(NOW(), INTERVAL 7 DAY),5,3);

INSERT INTO rates
  (amount, user_id, lot_id)
VALUES
  (11009, 2, 1),
  (8010, 3, 3),
  (5410, 2, 6),
  (8020, 1, 3);

/* Get all categories */
SELECT * FROM categories;

/* Get the newest lots */
SELECT
  l.name,
  l.starting_price,
  l.image_url,
  MAX(r.amount) AS 'current_price',
  COUNT(r.id) AS 'rates_count',
  c.name AS 'category'
FROM lots l
  JOIN (SELECT MAX(DATE(creation_date)) AS 'last_creation_date' FROM lots) sub ON DATE(l.creation_date) = sub.last_creation_date
  JOIN rates r ON r.lot_id = l.id
  JOIN categories c ON c.id = l.category_id
WHERE NOW() < l.completion_date
GROUP BY r.lot_id;

/* Get lot by lot id */
SELECT
  l.*,
  c.name AS 'category'
FROM lots l
  JOIN categories c ON c.id = l.category_id
WHERE l.id = 1;

/* Update lot by lot id */
UPDATE lots SET name = '2014 Rossignol District Snowboard'
WHERE id = 1;

/* Get the newest lot's rate by lot id */
SELECT
  r.*
FROM rates r
  JOIN (SELECT MAX(DATE(placement_date)) AS last_placement_date FROM rates) sub ON DATE(r.placement_date) = sub.last_placement_date
WHERE r.lot_id = 3;
