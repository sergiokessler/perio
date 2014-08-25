-- $Id: schema.sql,v 1.2 2006/04/21 16:08:59 sak Exp $
--

create user tpm with password 'tmp';

create table tpm
(
  id serial not null primary key,
  anio integer not null,
  organizacion varchar(256) not null,
  tipo varchar(256) not null,
  objetivo_general_diagnostico text,
  objetivo_especifico_diagnostico text,
  objetivo_general_planificacion text,
  objetivo_especifico_planificacion text,
  estrategia text,
  gestion_productos varchar(256) not null,
  observaciones text,
  equipo text not null,
  coordinador varchar(256) not null,
  contactos text,
  avance text,
  responsable varchar(256) not null
);
grant all on tpm to tpm;
grant all on tpm_id_seq to tpm;

