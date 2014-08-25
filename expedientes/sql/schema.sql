-- $Id: schema.sql,v 1.2 2006/04/21 16:08:59 sak Exp $
--

create user tesis with password 'tesis';

create table tesis 
(
  tesis_id serial not null primary key,
  titulo varchar(256) not null,
  programa varchar(256) not null,
  integrantes text,
  director varchar(128),
  codirector varchar(128),
  asesor varchar(128),
  jurado_1 varchar(128),
  jurado_2 varchar(128),
  jurado_3 varchar(128),
  sede varchar(256),
  expediente integer,
  fecha_inicio date,
  fecha_presentacion date,
  fecha_defensa date,
  estado varchar(256),
  calificacion integer,
  dictamen text,
  resumen text,
  notas text,
  palabras_clave varchar(256)
);
grant all on tesis to tesis;
grant all on tesis_tesis_id_seq to tesis;

create table persona
(
  persona_id serial not null primary key,
  apellido_nombre varchar(128) not null,
  documento_nro varchar(64),
  legajo varchar(64),
  domicilio varchar(256),
  telefonos varchar(256),
  email varchar(256),
  cv text
);
grant all on persona to tesis;
grant all on persona_persona_id_seq to tesis;


