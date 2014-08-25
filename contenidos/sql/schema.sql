-- $Id: schema.sql,v 1.2 2007/10/10 17:59:13 develop Exp $
--

create user contenido with password 'contenido';


create table area
(
  area varchar(128) primary key not null
);
grant all on area to contenido;

create table usuario
(
  usuario varchar(128) not null primary key,
  clave varchar(128) not null
);
grant all on usuario to contenido;

create table usuario_area
(
  usuario_area_id serial not null,
  usuario varchar(128) not null references usuario(usuario) on update cascade on delete cascade,
  area varchar(128) not null references area(area) on update cascade on delete cascade,
  primary key(usuario, area)
);
grant all on usuario_area to contenido;
grant all on usuario_area_usuario_area_id_seq to contenido;


create table nota
(
  nota_id serial not null primary key,
  area varchar(128) not null references area(area) on update cascade,
  usuario varchar(128) not null references usuario(usuario) on update cascade,
  fecha timestamp not null default localtimestamp(0),
  publicar varchar(2) not null,
  prioridad integer not null,
  volanta varchar(256),
  titulo varchar(256),
  bajada text,
  texto text,
  nota_interna text,
  imagen1 text,
  imagen1_epigrafe text,
  imagen2 text,
  imagen2_epigrafe text
);
grant all on nota to contenido;
grant all on nota_nota_id_seq to contenido;

create table imagen
(
  imagen_id serial not null primary key,
  area varchar(128) not null references area(area) on update cascade,
  imagen varchar(128) not null
);
grant all on imagen to contenido;
grant all on imagen_imagen_id_seq to contenido;


