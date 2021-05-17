use students;

insert into Utilisateurs values
('JCK', '8456', 'Jean', 'Cerien', 'Jean.Cerien@gmail.com', '0444556677', 1),
('Prof67', '4433', 'Garcin', 'Lazare', 'Garcin.Lazare@gmail.com', '0668963212', 1),
('IsCool', '8888', 'Aude', 'Javel', 'Aude.Javel@gmail.com', '0656218956', 1),
('Etudiant67', '6541', 'Isse', 'Fehavoir', 'Isse.Fehavoir@gmail.com', '0521211232', 0),
('Helios67', '8524', 'John', 'Irique', 'John.Irique@gmail.com', '0321457898', 0),
('Lucky', '4791', 'Kenny', 'Mac', 'Kenny.Mac@gmail.com', '0356897845', 0),
('Jean-Eude', '7124', 'Jean-Eude', 'Lafougere', 'JeanEude.Lafougere@gmail.com', '0956897845', 0),
('Lilipuce', '8941', 'Emilie', 'Jolie', 'Emilie.Jolie@gmail.com', '0656457898', 0),
('Crazy', '3494', 'Camille', 'Zole', 'Camille.Zole@gmail.com', '0652123475', 0);


insert into cours values
('Web', 'Jean Cerien', 'Cours de langages web (html, css, js, php, sql)'),
('C/C++', 'Garcin Lazare', 'Cours de langage C'),
('Game Design', 'Aude Javel', 'Cours de game design');

insert into controle values
('RequeteSQL', 'Web'),
('Bataille Navale', 'C/C++');

insert into releveNote value
('Etudiant67', 'RequeteSQL', 'Web', '12', 'Peut mieux faire.'),
('Helios67', 'RequeteSQL', 'Web', '0', 'Non rendu.'),
('Lucky', 'RequeteSQL', 'Web', '10', 'Peut mieux faire.'),
('Jean-Eude', 'RequeteSQL', 'Web', '18', 'TB.'),
('Lilipuce', 'RequeteSQL', 'Web', '16', 'TB. Pensez aux commentaires!'),
('Crazy', 'RequeteSQL', 'Web', '13', 'Peut mieux faire.'),
('Etudiant67', 'Bataille Navale', 'C/C++', '14', 'Bien.'),
('Helios67', 'Bataille Navale', 'C/C++', '0', 'Non rendu.'),
('Lucky', 'Bataille Navale', 'C/C++', '15', 'Bien.'),
('Jean-Eude', 'Bataille Navale', 'C/C++', '17', 'TBien.'),
('Lilipuce', 'Bataille Navale', 'C/C++', '14', 'Bien. Mettez plus de commentaires!'),
('Crazy', 'Bataille Navale', 'C/C++', '13', 'Bien.');