-- Drops the database if it exists
DROP DATABASE IF EXISTS my_meetic;

-- Creation of the database
CREATE DATABASE my_meetic;

-- Use the newly created database
USE my_meetic;

-- Creation of the gender table
CREATE TABLE gender (id INT PRIMARY KEY, name VARCHAR(255));

-- Creation of the user table
CREATE TABLE user (
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(255),
    lastname VARCHAR(255),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(100),
    phone VARCHAR(20),
    birthdate DATE,
    description VARCHAR(255),
    location VARCHAR(255),
    gender_id INT,
    FOREIGN KEY (gender_id) REFERENCES gender(id),
    active BOOLEAN DEFAULT true
);


-- Creation of the hobbies table
CREATE TABLE hobbies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255)
);

-- Creation of the user hobbies table
CREATE TABLE user_hobbies (
    id_user INT NOT NULL,
    id_hobbies INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES user(id),
    FOREIGN KEY (id_hobbies) REFERENCES hobbies(id)
);

-- Creation of the Zodiac Signs table
CREATE TABLE zodiac (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Inserts data into the gender table
INSERT INTO
    gender (id, name)
VALUES
    (1, 'Male'),
    (2, 'Female'),
    (3, 'Non-Binary'),
    (4, 'Other');

-- Inserts data into the user table
INSERT INTO
    user (
        firstname,
        lastname,
        email,
        password,
        phone,
        birthdate,
        description,
        location,
        gender_id
    )
VALUES
     (
        'Anna',
        'Waters',
        'annawaters@gmail.com',
        '$2y$10$V1Cu3g2xiCZpejRV9h29ieh2MKdLoTmM5J1W/q1fa6ZmQJTicMnJC',
        '0759652487',
        '1996-07-12',
        'Bonjour je suis Anna',
        'Lille',
        2
    ),
    (
        'David',
        'Campbell',
        'd.campbell@outlook.com',
        '$2y$10$iLlIbKGKe1pkLWOXBMIt2.cTbLm260dVRdss9fXkbUs6OokJ4XdQG',
        '9456218742',
        '1989-11-06',
        'Bonjour je suis David',
        'Arras',
        1
    ),
    (
        'Andrew',
        'White',
        'white.andrew@gmail.com',
        '$2y$10$1UMUtwWxzHCa48TwalhaWemNltE6sorqWihflpMBfVdWxlMJGrNp2',
        '5159874596',
        '1994-04-02',
        'Bonjour je suis Andrew',
        'Tourcoing',
        1
    ),
    (
        'Bobby',
        'Maxwell',
        'maxwellbobby@epitech.eu',
        '$2y$10$ez/62X.H1i12FQWNeBSXJOZeGven1bX8p8oLzvoc3xa3oIz4QeuwW',
        '5947665133',
        '1999-03-08',
        'Bonjour je suis Bobby',
        'Nancy',
        3
    ),
    (
        'Ellen',
        'Barton',
        'ebarton@outlook.com',
        '$2y$10$ORqY9Wb4f.xuCo8pJplrSO148p7Oe9aZp6iMOJFo0nKB38Vda2qBe',
        '5947885169',
        '2002-10-10',
        'Bonjour je suis Ellen',
        'Guéret',
        2
    ),
    (
        'Anthony',
        'Iglesias',
        'antonioiglesias@epitech.eu',
        '$2y$10$LQhKqiwQFeKqL2P7VzBZceYUNjkhtvxzl3XU5CEoQE8Nj0cJD4.5q',
        '9525429787',
        '1997-04-24',
        'Bonjour je suis Anthony',
        'Cadillac-sur-garonne',
        4
    ),
    (
        'Tayna',
        'Harris',
        'tharris@gmail.com',
        '$2y$10$Yro38bPVLh9J6RolP60bnOqxX.zj5kX2ZkoSMa.noTEOoFsjl1AyG',
        '0987654321',
        '1996-01-14',
        'Bonjour je suis Tayna',
        'Créteil',
        1
    ),
    (
        'Jimmy',
        'Falkirk',
        'jimmy.falkirk@falkirk.org',
        '$2y$10$wuBFI848ow6dlLo..f7fO.M5GFvKi.ttxeM0IfjBvWoZ7PZeFtXaS',
        '021874965',
        '1298-07-22',
        'Bonjour je suis Jimmy',
        'Lens',
        1
    );

INSERT INTO
    hobbies (name)
VALUES
    ('Cooking'),
    ('Traveling'),
    ('Hiking'),
    ('Movies'),
    ('Reading'),
    ('Sports'),
    ('Music'),
    ('Photography'),
    ('Contemporary Art'),
    ('Dancing'),
    ('Theater'),
    ('Gardening'),
    ('Board Games'),
    ('Fitness'),
    ('Camping'),
    ('Martial Arts'),
    ('Wine Tasting'),
    ('Astronomy'),
    ('Gaming'),
    ('Fashion');

-- Inserts data into the Zodiac Signs table
INSERT INTO
    zodiac (name)
VALUES
    ('Aries'),
    ('Taurus'),
    ('Gemini'),
    ('Cancer'),
    ('Leo'),
    ('Virgo'),
    ('Libra'),
    ('Scorpius'),
    ('Sagittarius'),
    ('Capricornus'),
    ('Aquarius'),
    ('Pisces');

INSERT INTO
    user_hobbies
VALUES
    (1, 3),
    (1, 6),
    (2, 19),
    (2, 15),
    (2, 10),
    (3, 14),
    (3, 2),
    (3, 11),
    (4, 14),
    (4, 11),
    (4, 12),
    (4, 16),
    (4, 11),
    (4, 15),
    (5, 17),
    (5, 1),
    (5, 12),
    (5, 7),
    (6, 7),
    (6, 4),
    (6, 11),
    (6, 5),
    (6, 9),
    (6, 3),
    (7, 1),
    (7, 7),
    (7, 4),
    (7, 17),
    (8, 17),
    (8, 11),
    (8, 13),
    (8, 15);