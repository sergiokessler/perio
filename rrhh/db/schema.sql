--drop table empleado;
create table empleado (
    empleado_id integer primary key autoincrement,
    nombre_y_apellido text not null,
    doc_nro integer not null,
    legajo text,
    categoria integer not null,
    agrupamiento text not null,
    fecha_de_ingreso date not null,
    notas text,
    carga_usuario text not null,
    carga_fecha datetime not null
);

--drop table motivo;
create table motivo (
    motivo_id integer primary key autoincrement,
    motivo text not null,
    carga_usuario text not null,
    carga_fecha datetime not null
);

--drop table ausencia;
create table ausencia (
    ausencia_id integer primary key autoincrement,
    empleado_id integer not null,
    ausencia_fecha date not null,
    motivo_id integer not null,
    carga_usuario text not null,
    carga_fecha datetime not null
);


