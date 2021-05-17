drop database if exists students;
create database students character set utf8;

use students;

create table Utilisateurs (
    Pseudo varchar(15) not null primary key,
    MotDePasse varchar(20) not null,
    Prenom varchar(20) not null,
    Nom varchar(20) not null,
    Email varchar(50) not null,
    Telephone varchar(10),
    EstProf boolean default false
)engine = InnoDB;

create table cours (
    Matiere varchar(20) not null primary key,
    Professeur varchar(20) not null,
    Info varchar(50)
)engine = InnoDB;

create table controle (
    Evaluation varchar(50) not null primary key,
    Matiere varchar(20) not null
)engine=InnoDB;

create table releveNote (
    Pseudo varchar(15),
    Evaluation varchar(50),
    Matiere varchar(20),
    Note int,
    Remarque varchar(100)
)engine = InnoDB;


alter table controle add foreign key (Matiere) references cours(Matiere);
alter table releveNote add foreign key (Evaluation) references controle(Evaluation);
alter table releveNote add foreign key (Matiere) references controle(Matiere);

