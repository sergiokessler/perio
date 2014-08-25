-- $Id: schema.sql,v 1.2 2006/04/21 16:08:59 sak Exp $
--

create user saludymedios with password 'saludymedios';

create table nota
(
  nota_id serial not null primary key,
  medio varchar(256) not null,
  seccion varchar(256) not null,
  fecha date not null,
  palabras_clave text,
  pagina integer,
  clasificacion varchar(256),
  contenido varchar(256),
  carga_usuario varchar(256),
  carga_fecha text
);
grant all on nota to saludymedios;
grant all on nota_nota_id_seq to saludymedios;


