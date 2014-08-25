create table materia (
    materia_id serial not null primary key,
    nombre text not null unique
);
alter table materia owner to fotocop;

create table material (
    material_id serial not null primary key,
    materia text not null,
    titulo text not null,
    autor text not null,
    cant_hojas integer not null,
    carpeta text not null,
    folio text not null,
    archivo text,
    costo numeric(6,2) not null,
    fecha_registro timestamp(0) without time zone default localtimestamp(0)
);
alter table material owner to fotocop;
alter table material add FOREIGN KEY (materia) REFERENCES materia (nombre) on update cascade;

create table noticia (
    noticia_id serial not null primary key,
    titulo text not null,
    texto text not null,
    fecha_registro timestamp(0) without time zone default localtimestamp(0)
);
alter table noticia owner to fotocop;


