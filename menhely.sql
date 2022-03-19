-- inicializálás

drop database if exists menhely;

create database menhely
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_general_ci;
    
use menhely;

-- állat tábla

create table allat (
	id int primary key auto_increment,
    nev varchar(30) not null,
    faj varchar(50) not null,
    fajta varchar(50) not null,
    behozva date not null,
    leiras varchar (500)
);

-- tábla feltöltése

insert into allat (nev, faj, fajta, behozva, leiras) values ('Báró', 'kutya', 'németjuhász', '2016-06-12','Fekete hím, barátságos, gyerekekkel jól kijön');
insert into allat (nev, faj, fajta, behozva, leiras) values ('Buflák', 'kutya', 'foxi', '2018-09-01', 'Rövidszőrű hím, játékos');
insert into allat (nev, faj, fajta, behozva, leiras) values ('Masni', 'macska', 'bengáli', '2019-02-14', 'Barátkozós, szeret nyávogni');
insert into allat (nev, faj, fajta, behozva, leiras) values ('Maxi', 'kutya', 'foxi', '2015-04-06', 'Kék színű . nagyon jó a szimata');
insert into allat (nev, faj, fajta, behozva, leiras) values ('Rex', 'kutya', 'spániel', '2020-02-25', '');
insert into allat (nev, faj, fajta, behozva, leiras) values ('Morzsi', 'kutya', 'puli', '2017-11-12', '');
insert into allat (nev, faj, fajta, behozva, leiras) values ('Jack', 'macska', 'keverék', '2019-09-12', '');
insert into allat (nev, faj, fajta, behozva, leiras) values ('Bob', 'macska', 'perzsa', '2020-04-11', '');
insert into allat (nev, faj, fajta, behozva, leiras) values ('Feri', 'kutya', 'angol bulldog', '2020-03-12', '');
insert into allat (nev, faj, fajta, behozva, leiras) values ('Scooby', 'kutya', 'dán dog', '2017-02-18', 'Két Scooby snackért leírást is írok neki');

-- gazdi tábla létrehozása

create table gazdi(
	id int primary key auto_increment,
    nev varchar(50) not null,
    telefon varchar(15) not null,
    cim varchar (100)
);
    
-- gazdi tábla feltöltése 

insert into gazdi (nev, telefon, cim) values ('Minta János', '+36-20-1234567', '1111 Mucsaröcsöge, Kossuth u. 12.');
insert into gazdi (nev, telefon, cim) values ('Gazdi Géza', '+36-30-0011234', '1337 Sajókápolna, Mária út 34.');
insert into gazdi (nev, telefon, cim) values ('Kiss Edina', '+36-70-998675', '2145 Bikinifenék, Fő út 3.');

-- örökbefogadások tábla létrehozása
-- státusz: bool típus, 1 érték esetén az örökbefogadás végleges,
-- 0 esetén ha a vissza NULL akkor az örökbefogadás nem végleges, ha a vissza nem NULL akkor a befogadás sikertelen

create table befogad(
	id int primary key auto_increment,
    allatid int not null,
    gazdiid int not null, 
    datum date,
    vissza date,
    statusz bool,
    
	foreign key(allatid) references allat(id),
    foreign key(gazdiid) references gazdi(id)
);

-- Minta János véglegesen befogadta Bárót és Buflákot
-- Gazdi Géza "sikertelenül fogadta" Foxi Maxit, ezért Maxi 02.01-én visszakerült a menhelyre
-- Kiss Edina Jacket fogadta be, az örökbefogadás még nem végleges, próbaidőn van

insert into befogad(allatid, gazdiid, datum, vissza, statusz) values(1, 1, '2018-09-30', NULL, 1);
insert into befogad(allatid, gazdiid, datum, vissza, statusz) values(2, 1, '2020-01-21', NULL, 1);
insert into befogad(allatid, gazdiid, datum, vissza, statusz) values(4, 2, '2020-02-01', '2020-02-25', 0);
insert into befogad(allatid, gazdiid, datum, vissza, statusz) values(7, 3, '2020-05-02', NULL, 0);