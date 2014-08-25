create table medio (
    medio_id integer primary key autoincrement,
    nombre text not null,
    zona text not null,
    provincia text not null,
    relevancia integer not null,
    tipo text not null,
    web text,
    carga_usuario text not null,
    carga_fecha datetime not null
);

create table nota (
    nota_id integer primary key autoincrement,
    medio_id integer references medio(medio_id) on update cascade on delete no action,
    fecha date not null,
    titulo text not null,
    link text,
    mencion_escala text not null,
    mencion_grupos text not null,
    mencion_resultados_inscriptos text not null,
    mencion_resultados_inversiones text not null,
    mencion_resultados_transferencia text not null,
    mencion_resultados_practicas text not null,
    mencion_resultados_entrega text not null,
    mencion_0800 text not null,
    mencion_cobertura_efectiva text not null,
    mencion_card_cong text not null,
    mencion_pueblos_orig text not null,
    mencion_asignaciones text not null,
    valoracion text not null,
    texto text not null,
    carga_usuario text not null,
    carga_fecha datetime not null
);

create virtual table nota_fts using fts4 (
    nota_id integer primary key references nota(nota_id),
    content text
);


