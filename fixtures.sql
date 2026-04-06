-- ============================================================
-- LibraryHub Test Fixtures
-- Password for all users: 123456789
-- NOTE : This specific file is mostly AI generated with some manual ajustments such as image links. As it only serves as test data.
-- ============================================================

-- Clear existing data (order matters due to foreign keys)
DELETE FROM user_book_favorite;
DELETE FROM review;
DELETE FROM reservation;
DELETE FROM book_category;
DELETE FROM book_author;
DELETE FROM book;
DELETE FROM author;
DELETE FROM category;
DELETE FROM language;
DELETE FROM "user";

-- Reset sequences
ALTER SEQUENCE user_id_seq RESTART WITH 1;
ALTER SEQUENCE book_id_seq RESTART WITH 1;
ALTER SEQUENCE author_id_seq RESTART WITH 1;
ALTER SEQUENCE category_id_seq RESTART WITH 1;
ALTER SEQUENCE language_id_seq RESTART WITH 1;
ALTER SEQUENCE reservation_id_seq RESTART WITH 1;
ALTER SEQUENCE review_id_seq RESTART WITH 1;

-- ============================================================
-- USERS (password: 123456789)
-- ============================================================
INSERT INTO "user" (id, email, password, first_name, last_name, roles) VALUES
(1, 'basic@user.com',         '$2y$13$dOe4OkmLQeLadSJMEBYgiO6VvuH5XD4vtBdVzcWSCVfr67shacaaq', 'Basic',         'USER', '[]'),
(2, 'librarian@user.com',     '$2y$13$dOe4OkmLQeLadSJMEBYgiO6VvuH5XD4vtBdVzcWSCVfr67shacaaq', 'Librarian',     'USER', '["ROLE_LIBRARIAN"]'),
(3, 'administrator@user.com', '$2y$13$dOe4OkmLQeLadSJMEBYgiO6VvuH5XD4vtBdVzcWSCVfr67shacaaq', 'Administrator', 'USER', '["ROLE_ADMIN"]');

ALTER SEQUENCE user_id_seq RESTART WITH 4;

-- ============================================================
-- LANGUAGES
-- ============================================================
INSERT INTO language (id, name, code) VALUES
(1, 'English', 'en'),
(2, 'French',  'fr');

ALTER SEQUENCE language_id_seq RESTART WITH 3;

-- ============================================================
-- CATEGORIES
-- ============================================================
INSERT INTO category (id, name) VALUES
(1, 'Fiction'),
(2, 'Science Fiction'),
(3, 'Fantasy'),
(4, 'History'),
(5, 'Science'),
(6, 'Philosophy'),
(7, 'Romance'),
(8, 'Thriller');

ALTER SEQUENCE category_id_seq RESTART WITH 9;

-- ============================================================
-- AUTHORS
-- ============================================================
INSERT INTO author (id, first_name, last_name, biography) VALUES
(1, 'Victor',  'Hugo',       'French poet, novelist, and dramatist of the Romantic movement. Considered one of the greatest French writers.'),
(2, 'Albert',  'Camus',      'French philosopher, author, and journalist. Awarded the Nobel Prize in Literature in 1957.'),
(3, 'George',  'Orwell',     'English novelist, essayist, journalist, and critic. Best known for the allegorical novella Animal Farm and the dystopian novel 1984.'),
(4, 'Isaac',   'Asimov',     'American writer and professor of biochemistry, known for his works of science fiction and popular science.'),
(5, 'J.R.R.',  'Tolkien',    'English writer, poet, philologist, and academic. Best known as the author of The Hobbit and The Lord of the Rings.'),
(6, 'Agatha',  'Christie',   'English writer known for her detective novels. The best-selling fiction writer of all time.'),
(7, 'Jules',   'Verne',      'French novelist, poet, and playwright. Pioneer of the science fiction genre.'),
(8, 'Jane',    'Austen',     'English novelist known primarily for her six major novels about the British landed gentry.');

ALTER SEQUENCE author_id_seq RESTART WITH 9;

-- ============================================================
-- BOOKS
-- ============================================================
INSERT INTO book (id, title, description, isbn, publication_date, page_count, cover_image, stock_quantity, language_id) VALUES
(1,  'Les Miserables',
     'The story of Jean Valjean, an ex-convict who struggles for redemption in post-revolutionary France.',
     '9780140444308', '1862-04-03', 1463, 'https://m.media-amazon.com/images/I/91p594CxSpL._AC_UF1000,1000_QL80_.jpg', 3, 2),

(2,  'The Stranger',
     'The story of Meursault, an indifferent French Algerian who gets drawn into a senseless murder on a sun-drenched beach.',
     '9780679720201', '1942-06-01', 123, 'https://m.media-amazon.com/images/I/617WkdpG8xL._AC_UF1000,1000_QL80_.jpg', 5, 2),

(3,  '1984',
     'A dystopian novel set in a totalitarian society ruled by Big Brother. A masterpiece of political fiction.',
     '9780451524935', '1949-06-08', 328, 'https://m.media-amazon.com/images/I/71wANojhEKL._AC_UF1000,1000_QL80_.jpg', 4, 1),

(4,  'Foundation',
     'A complex saga of humans scattered across planets throughout the galaxy, all living under the rule of the Galactic Empire.',
     '9780553293357', '1951-05-01', 244, 'https://m.media-amazon.com/images/I/81LT+V9G4IL._AC_UF1000,1000_QL80_.jpg', 2, 1),

(5,  'The Lord of the Rings',
     'An epic high-fantasy novel that follows hobbits as they quest to destroy the One Ring and defeat the Dark Lord Sauron.',
     '9780618640157', '1954-07-29', 1178, 'https://i.ebayimg.com/images/g/ASQAAeSwYkhpHXie/s-l400.jpg', 3, 1),

(6,  'Murder on the Orient Express',
     'Belgian detective Hercule Poirot investigates a murder aboard the famous Orient Express train.',
     '9780062693662', '1934-01-01', 256, 'https://www.betterreading.com.au/wp-content/uploads/2017/04/xmurder-on-the-orient-express_jpg_pagespeed_ic_dco_Zf1-2A.jpg.webp', 6, 1),

(7,  'Twenty Thousand Leagues Under the Seas',
     'The classic tale of Captain Nemo and his submarine, the Nautilus, as they journey beneath the oceans.',
     '9780199539277', '1870-06-20', 304, 'https://m.media-amazon.com/images/I/71mw4nYxkdL._AC_UF1000,1000_QL80_.jpg', 4, 2),

(8,  'Pride and Prejudice',
     'A romantic novel following the emotional development of Elizabeth Bennet as she deals with issues of manners and morality.',
     '9780141439518', '1813-01-28', 432, 'https://m.media-amazon.com/images/I/712P0p5cXIL._AC_UF1000,1000_QL80_.jpg', 5, 1),

(9,  'The Plague',
     'A novel about a plague sweeping the Algerian city of Oran. An allegory of the human condition.',
     '9780679720218', '1947-06-01', 308, 'https://m.media-amazon.com/images/I/514w8W0XXUL._AC_UF1000,1000_QL80_.jpg', 2, 2),

(10, 'Animal Farm',
     'An allegorical novella reflecting events leading up to the Russian Revolution and the Stalinist era of the Soviet Union.',
     '9780451526342', '1945-08-17', 112, 'https://m.media-amazon.com/images/I/61IsVimWrGL._AC_UF1000,1000_QL80_.jpg', 7, 1);

ALTER SEQUENCE book_id_seq RESTART WITH 11;

-- ============================================================
-- BOOK <-> AUTHOR
-- ============================================================
INSERT INTO book_author (book_id, author_id) VALUES
(1, 1),   -- Les Miserables       -> Victor Hugo
(2, 2),   -- The Stranger          -> Albert Camus
(3, 3),   -- 1984                  -> George Orwell
(4, 4),   -- Foundation            -> Isaac Asimov
(5, 5),   -- The Lord of the Rings -> J.R.R. Tolkien
(6, 6),   -- Murder on the Orient  -> Agatha Christie
(7, 7),   -- Twenty Thousand Leagues -> Jules Verne
(8, 8),   -- Pride and Prejudice   -> Jane Austen
(9, 2),   -- The Plague            -> Albert Camus
(10, 3);  -- Animal Farm           -> George Orwell

-- ============================================================
-- BOOK <-> CATEGORY
-- ============================================================
INSERT INTO book_category (book_id, category_id) VALUES
(1, 1),   -- Les Miserables       -> Fiction
(1, 4),   -- Les Miserables       -> History
(2, 1),   -- The Stranger          -> Fiction
(2, 6),   -- The Stranger          -> Philosophy
(3, 1),   -- 1984                  -> Fiction
(3, 2),   -- 1984                  -> Science Fiction
(4, 2),   -- Foundation            -> Science Fiction
(5, 3),   -- The Lord of the Rings -> Fantasy
(6, 1),   -- Murder on the Orient  -> Fiction
(6, 8),   -- Murder on the Orient  -> Thriller
(7, 2),   -- Twenty Thousand Leagues -> Science Fiction
(7, 1),   -- Twenty Thousand Leagues -> Fiction
(8, 1),   -- Pride and Prejudice   -> Fiction
(8, 7),   -- Pride and Prejudice   -> Romance
(9, 1),   -- The Plague            -> Fiction
(9, 6),   -- The Plague            -> Philosophy
(10, 1),  -- Animal Farm           -> Fiction
(10, 6);  -- Animal Farm           -> Philosophy

-- ============================================================
-- FAVORITES (Basic user, id=1)
-- ============================================================
INSERT INTO user_book_favorite (user_id, book_id) VALUES
(1, 1),   -- Basic -> Les Miserables
(1, 3),   -- Basic -> 1984
(1, 5),   -- Basic -> The Lord of the Rings
(1, 7);   -- Basic -> Twenty Thousand Leagues Under the Seas

-- ============================================================
-- RESERVATIONS (all by Basic user, id=1)
-- ============================================================
INSERT INTO reservation (id, start_date, end_date, status, borrower_id, book_id, created_at) VALUES
(1, '2026-04-01', '2026-04-15', 'confirmed', 1, 3,  '2026-03-30 10:00:00'),
(2, '2026-04-05', '2026-04-20', 'pending',   1, 5,  '2026-04-04 14:30:00'),
(3, '2026-03-10', '2026-03-25', 'returned',  1, 8,  '2026-03-08 09:15:00'),
(4, '2026-04-10', '2026-04-25', 'pending',   1, 6,  '2026-04-06 11:00:00');

ALTER SEQUENCE reservation_id_seq RESTART WITH 5;

-- ============================================================
-- REVIEWS (a few sample reviews)
-- ============================================================
INSERT INTO review (id, rating, comment, created_at, reviewer_id, book_id) VALUES
(1, 5, 'An absolute masterpiece. Hugo''s portrayal of human suffering and redemption is unmatched.', '2026-03-15 08:00:00', 1, 1),
(2, 4, 'A fascinating and thought-provoking read. The philosophical depth is remarkable.',           '2026-03-20 12:00:00', 1, 2),
(3, 5, 'Terrifyingly relevant even today. A must-read for everyone.',                               '2026-04-01 16:00:00', 1, 3);

ALTER SEQUENCE review_id_seq RESTART WITH 4;
