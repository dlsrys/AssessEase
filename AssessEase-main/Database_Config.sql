CREATE DATABASE accounts;
#users table
CREATE TABLE users(
	userID int not null primary key auto_increment,
    firstname varchar(255),
    lastname varchar(255),
    school varchar(255),
    email varchar(255),
    pass varchar(255),
    accountType varchar(255));
#quiz table
CREATE TABLE quiz (
    quizID INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    descri text not null,
    StartDate DATETIME NOT NULL,
    EndDate DATETIME NOT NULL,
    userID int not null,
    totalPoints int,
    saved boolean,
    FOREIGN KEY (userID) REFERENCES users(userID)
);

INSERT INTO quiz (title, descri, StartDate, EndDate, userID, totalPoints) VALUES
("title", "description", "2023-11-09 10:30:45", "2023-11-09 12:30:45", 1, 10);

SELECT * FROM quiz;

#question
CREATE TABLE question (
    questionID INT AUTO_INCREMENT PRIMARY KEY,
    quizID INT,
    questionText TEXT NOT NULL,
    correctAnswer TEXT, -- For multiple choice, store the correct option; for essay, store the model answer
    points int,
    FOREIGN KEY (quizID) REFERENCES quiz(quizID)
);
#dummy question table
CREATE TABLE unansQues(
	tempID INT AUTO_INCREMENT primary key,
    quizID INT,
    questionText TEXT NOT NULL,
    correctAnswer TEXT, -- For multiple choice, store the correct option; for essay, store the model answer
    points int,
    questionID int,
    FOREIGN KEY (quizID) REFERENCES quiz(quizID)
);
#question bank
CREATE TABLE qbank (
	qbankID INT auto_increment primary key,
    userID int,
    questionText text,
    correctAnswer varchar(255),
    points int,
    foreign key (userID) references users(userID)
);

#uploaded quiz
create table upQuiz(
	upQuiz int auto_increment primary key,
    userID int,
    quizID int,
    title text,
    totalPoints int,
    foreign key (quizID) references quiz(quizID)
);

#for submission
CREATE TABLE quiz_taken (
    takenID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT, #student
    upQuiz INT,
    title text,
    takenDate DATETIME, #date taken
    totalScore int, #score of student
    feedback text, #equivalent 
    FOREIGN KEY (userID) REFERENCES users(userID), #to access in student side, get userID
    FOREIGN KEY (upQuiz) REFERENCES upQuiz(upQuiz) #to access in teacher side, select the userID in upQuiz using the this upQuiz
);

# for testing
insert into quiz_taken (upQuiz, title, takenDate, totalScore, feedback) values
(1,"Cat Quiz","2023-11-09 12:30:45",2,"Average");

select * from question;
select * from users;
select * from quiz;		
select * from qbank;
select * from upQuiz;
select * from quiz_taken;
select * from unansQues;	

#answer and correct answer
create table answers (
);


UPDATE quiz_taken SET totalScore = 100, feedback='EXCELLENT' WHERE takenID = 98;

delete from quiz_taken where upQuiz=2;
delete from unansQues where quizID=2;

#alterations
alter table unansQues add questionID int;

#to delete or update a row 
SET FOREIGN_KEY_CHECKS=0;










drop table users;
#droppings
drop table unansQues;
drop table quiz;

drop table question;
drop table upQuiz;
drop table qbank;
drop table quiz_taken;