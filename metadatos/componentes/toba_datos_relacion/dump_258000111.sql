------------------------------------------------------------
--[258000111]--  Prestamo - datos_r 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 258
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'libros', --proyecto
	'258000111', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_datos_relacion', --clase
	'257000001', --punto_montaje
	NULL, --subclase
	NULL, --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'Prestamo - datos_r', --nombre
	NULL, --titulo
	NULL, --colapsable
	NULL, --descripcion
	'libros', --fuente_datos_proyecto
	'libros', --fuente_datos
	NULL, --solicitud_registrar
	NULL, --solicitud_obj_obs_tipo
	NULL, --solicitud_obj_observacion
	NULL, --parametro_a
	NULL, --parametro_b
	NULL, --parametro_c
	NULL, --parametro_d
	NULL, --parametro_e
	NULL, --parametro_f
	NULL, --usuario
	'2021-04-27 08:32:19', --creacion
	NULL  --posicion_botonera
);
--- FIN Grupo de desarrollo 258

------------------------------------------------------------
-- apex_objeto_datos_rel
------------------------------------------------------------
INSERT INTO apex_objeto_datos_rel (proyecto, objeto, debug, clave, ap, punto_montaje, ap_clase, ap_archivo, sinc_susp_constraints, sinc_orden_automatico, sinc_lock_optimista) VALUES (
	'libros', --proyecto
	'258000111', --objeto
	'0', --debug
	NULL, --clave
	'2', --ap
	'257000001', --punto_montaje
	NULL, --ap_clase
	NULL, --ap_archivo
	'0', --sinc_susp_constraints
	'1', --sinc_orden_automatico
	'1'  --sinc_lock_optimista
);

------------------------------------------------------------
-- apex_objeto_dependencias
------------------------------------------------------------

--- INICIO Grupo de desarrollo 258
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'libros', --proyecto
	'258000089', --dep_id
	'258000111', --objeto_consumidor
	'258000122', --objeto_proveedor
	'prestamo', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'1'  --orden
);
--- FIN Grupo de desarrollo 258
