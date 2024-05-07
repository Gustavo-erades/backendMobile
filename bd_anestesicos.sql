create database anestesicos;
use anestesicos;
create table anestesicoTabela(
	id int not null auto_increment,
	anestesicoLocal varchar(50),
    doseMaxima decimal(5,2),
    maximoAbsoluto int,
    numTubetes decimal(5,2),
    primary key (id)
);

insert into anestesicos.anestesicotabela(anestesicoLocal,doseMaxima,maximoAbsoluto,numTubetes,porcentagem) values("Mepivacaína 2%",4.4,300,8.3,2);
insert into anestesicos.anestesicotabela(anestesicoLocal,doseMaxima,maximoAbsoluto,numTubetes,porcentagem) values("Lidocaína 3%",4.4,300,5.5,3);
insert into anestesicos.anestesicotabela(anestesicoLocal,doseMaxima,maximoAbsoluto,numTubetes,porcentagem) values("Lidocaína 2%",4.4,300,8.3,2);
insert into anestesicos.anestesicotabela(anestesicoLocal,doseMaxima,maximoAbsoluto,numTubetes,porcentagem) values("Mepivacaína 3%",4.4,300,5.5,3);
insert into anestesicos.anestesicotabela(anestesicoLocal,doseMaxima,maximoAbsoluto,numTubetes,porcentagem) values("Articaína 4%",7,500,6.9,4);
insert into anestesicos.anestesicotabela(anestesicoLocal,doseMaxima,maximoAbsoluto,numTubetes,porcentagem) values("Bupivacaína 0.5%",1.3,90,10,0.5);
delete from anestesicos.anestesicotabela where id=17;

SELECT anestesicoLocal FROM anestesicos.anestesicoTabela;