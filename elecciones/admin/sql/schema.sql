-- $Id: schema.sql,v 1.2 2006/04/21 16:08:59 sak Exp $
--

create user elec with password 'elec';

create table lista 
(
  lista_id serial not null primary key,
  lista_nombre varchar(256) not null,
  activa integer,
  en_total integer,
  en_porcentaje integer
);
grant all on lista to elec;


create table mesa
(
  mesa_id serial not null primary key,
  mesa_nombre varchar(256) not null
);
grant all on mesa to elec;


create table mesa_total
(
  mesa_total_id serial not null,
  mesa_id integer not null,
  lista_id integer not null,
  fecha_hora timestamp default localtimestamp,
  votos_centro integer not null,
  votos_claustro integer not null,
  primary key(mesa_total_id, lista_id)
);
grant all on mesa_total to elec;


