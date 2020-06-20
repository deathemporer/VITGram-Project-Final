CREATE DATABASE vitgram;

CREATE TABLE users (
user_id             INT NOT NULL AUTO_INCREMENT,
user_dp             TEXT DEFAULT 'https://i2.wp.com/molddrsusa.com/wp-content/uploads/2015/11/profile-empty.png.250x250_q85_crop.jpg?ssl=1',
user_firstname      VARCHAR(20) NOT NULL,  
user_lastname       VARCHAR(20) NOT NULL,
user_username       VARCHAR(20),
user_email          VARCHAR(30),
user_password       VARCHAR(255) NOT NULL,
PRIMARY KEY (user_id)
);

CREATE TABLE follow (
user1_id            INT NOT NULL,
user2_id            INT NOT NULL,
follow_status       INT NOT NULL,
FOREIGN KEY (user1_id) REFERENCES users(user_id),
FOREIGN KEY (user2_id) REFERENCES users(user_id)
);

CREATE TABLE posts (
post_id             INT NOT NULL AUTO_INCREMENT,
post                TEXT NOT NULL,
post_caption        TEXT NOT NULL,
post_location       TEXT NOT NULL,
post_likes          INT NOT NULL DEFAULT 0,
post_time           TIMESTAMP NOT NULL, 
post_by             INT NOT NULL,
PRIMARY KEY (post_id),
FOREIGN KEY (post_by) REFERENCES users(user_id)
);

CREATE TABLE comments(
    comment_id      INT NOT NULL AUTO_INCREMENT,
    post_id         INT NOT NULL,
    comments         TEXT NOT NULL,
    comment_by      INT NOT NULL,
    PRIMARY KEY (comment_id),
    FOREIGN KEY (comment_by) REFERENCES user(user_id),
    FOREIGN KEY (post_id) REFERENCES posts(post_id)
);
