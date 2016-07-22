CREATE TABLE User (
    id INT AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE NOT NULL ,
    password VARCHAR(255) NOT NULL,
    fullName VARCHAR(100),
    active TINYINT  DEFAULT 0,
    PRIMARY KEY(id)
);

CREATE TABLE Tweet (
    id INT AUTO_INCREMENT,
    user_id INT NOT NULL ,
    tweet VARCHAR(255),
    PRIMARY KEY(id),
    FOREIGN KEY (user_id) REFERENCES User(id)
    ON DELETE CASCADE
);

INSERT INTO `Message`(`user_id`, `text`) VALUES (2, 'Tweet Tweet tweet nr 1')

CREATE TABLE Comment (
    id INT AUTO_INCREMENT,
    user_id INT NOT NULL ,
    tweet_id INT NOT NULL,
    creation_date DATETIME,  
    comment VARCHAR(255),
    PRIMARY KEY(id),
    FOREIGN KEY (user_id) REFERENCES User(id)
    FOREIGN KEY (tweet_id) REFERENCES Message(id)
    ON DELETE CASCADE
);

CREATE TABLE Message (
    id INT AUTO_INCREMENT,
    sender_id INT NOT NULL ,
    receiver_id INT NOT NULL,
    creation_date DATETIME,  
    message VARCHAR(255),
    status TINYINT,
    PRIMARY KEY(id)
);
