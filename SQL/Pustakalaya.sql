-- table admin
CREATE TABLE admins (
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);


-- table `users`
CREATE TABLE `users` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ;

-- table `authors`
CREATE TABLE `authors` (
  `author_id` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `author_name` VARCHAR(255) NOT NULL
) ;

-- table `books`
CREATE TABLE `books` (
  `book_id` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `book_name` VARCHAR(255) NOT NULL,
  `author_name` VARCHAR(255) NOT NULL,
  `stock` INT(11) NOT NULL,
) ;



-- table `issued_books`
CREATE TABLE `issued_books` (
   `s_no` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
   `book_id` INT(11) NOT NULL,
   `book_author` VARCHAR(200) NOT NULL,
   `student_id` INT(11) NOT NULL,
   `issue_date` DATE NOT NULL,
   `renewal_date` DATE DEFAULT NULL,
   FOREIGN KEY (book_id) REFERENCES books (book_id)
);


-- authors
-- INSERT INTO `authors`(`author_id`, `author_name`) VALUES (1,'Bhupendra Singh Saud');
-- INSERT INTO `authors`(`author_id`, `author_name`) VALUES (2,'Arjun Singh Saud');
-- INSERT INTO `authors`(`author_id`, `author_name`) VALUES (3,'Ramesh Singh Saud');
