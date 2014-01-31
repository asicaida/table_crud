use daw2;
drop table daw2_viajes;

create table  daw2_viajes (
id integer auto_increment 
, nombre varchar (100) not null
,apellidos varchar (100)not null
,destino varchar(100) not null
,fecha_de_compra timestamp default current_timestamp()
,precio decimal (10,2) not null
,primary key (id)
);



