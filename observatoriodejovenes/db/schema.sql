drop table medio;
create table medio (
    medio_id integer primary key autoincrement,
    nombre text not null,
    relevancia integer not null,
    tipo text not null,
    web text,
    carga_usuario text not null,
    carga_fecha datetime not null
);

drop table tabulado;
create table tabulado (
    tab_id integer primary key autoincrement,
    clave text not null,
    valor text not null,
    carga_usuario text not null,
    carga_fecha datetime not null
);

drop table region;
create table region (
    region_id integer primary key autoincrement,
    pais text not null,
    provincia text,
    localidad text,
    carga_usuario text not null,
    carga_fecha datetime not null
);

drop table nota;
create table nota (
    nota_id integer primary key autoincrement,
    medio_id integer references medio(medio_id) on update cascade on delete no action,
    fecha date not null,
    region_id text references region(region_id) on update cascade on delete no action,
    titulo text not null,
    link text,
    seccion text not null,
    tipo_de_nota text not null,
    tema text not null,
    motivo_1 text not null,
    motivo_2 text,
    voz_1 text,
    voz_2 text,
    voz_3 text,
    territorio_1 text,
    territorio_2 text,
    territorio_3 text,
    imagen text not null,
    video text not null,
    texto text not null,
    carga_usuario text not null,
    carga_fecha datetime not null
);

drop table nota_fts;
create virtual table nota_fts using fts4 (
    nota_id integer primary key references nota(nota_id),
    content text
);


