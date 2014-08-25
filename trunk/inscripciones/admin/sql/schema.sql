-- $Id: schema.sql,v 1.2 2006/04/21 16:08:59 sak Exp $
--

create user ins_operador with password 'ins_operador';
create user ins_admin with password 'ins_admin';

create table alumno
(
  id serial not null primary key,
  legajo integer,
  nombre varchar(256) not null,
  doc_nro varchar(16),
  email varchar(256),
  telefono varchar(256),
  orientacion varchar(16),
  notas text
);
create unique index alumno_idx_legajo on alumno (legajo);
grant all on alumno to ins_admin;
grant all on alumno_id_seq to ins_admin;
grant all on alumno to ins_operador;
grant all on alumno_id_seq to ins_operador;

create table materia
(
  id serial not null primary key,
  nombre varchar(256) not null,
  codigo varchar(4),
  orientacion varchar(16),
  habilitada varchar(2),
  notas text
);
create unique index materia_idx_codigo on materia (codigo);
grant all on materia to ins_admin;
grant all on materia_id_seq to ins_admin;
grant select on materia to ins_operador;
grant select on materia_id_seq to ins_operador;

create table comision
(
  id serial not null primary key,
  materia_id integer not null
    references materia(id) on update cascade,
  codigo varchar(4) not null,
  dia varchar(16) not null,
  hora_comienzo varchar(6),
  hora_fin varchar(6),
  cupos integer not null default 0 check (cupos >= 0),
  notas text
);
create unique index comision_idx on comision (materia_id, codigo);
grant all on comision to ins_admin;
grant all on comision_id_seq to ins_admin;
grant all on comision to ins_operador;
grant all on comision_id_seq to ins_operador;

drop view comision_v;
create view comision_v as
    select
        m.nombre as materia_nombre,
        c.*
    from
        materia m,
        comision c
    where
        c.materia_id = m.id
        and
        m.habilitada = 'SI'
;
grant select on comision_v to ins_admin;
grant select on comision_v to ins_operador;

drop table inscripcion cascade;
create table inscripcion
(
  id serial not null primary key,
  alumno_id integer not null
    references alumno(id) on update cascade,
  materia_id integer not null
    references materia(id) on update cascade,
  comision_id integer not null
    references comision(id) on update cascade,
  fecha_hora timestamp without time zone not null default localtimestamp
);
create unique index inscripcion_idx on inscripcion (alumno_id, materia_id, comision_id);
grant all on inscripcion to ins_admin;
grant all on inscripcion_id_seq to ins_admin;
grant all on inscripcion to ins_operador;
grant all on inscripcion_id_seq to ins_operador;

drop view inscripcion_v;
create view inscripcion_v as
    select
        i.id,
        a.nombre as alumno,
        a.legajo,
        i.alumno_id,
        m.nombre as materia,
        m.codigo as materia_codigo,
        c.codigo as comision,
        i.fecha_hora
    from
        inscripcion i,
        alumno a,
        materia m,
        comision c
    where
        i.alumno_id = a.id
        and
        i.materia_id = m.id
        and
        i.comision_id = c.id
;
grant select on inscripcion_v to ins_admin;
grant select on inscripcion_v to ins_operador;

CREATE RULE cupos_up AS ON DELETE TO inscripcion DO update comision set cupos = cupos+1 WHERE id = OLD.comision_id;
CREATE RULE cupos_down AS ON INSERT TO inscripcion DO update comision set cupos = cupos-1 WHERE id = NEW.comision_id;

