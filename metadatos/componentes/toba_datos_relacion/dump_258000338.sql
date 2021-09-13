------------------------------------------------------------
--[258000338]--  Gestion de Prestamo - DR 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 258
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'libros', --proyecto
	'258000338', --objeto
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
	'Gestion de Prestamo - DR', --nombre
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
	'2021-05-04 09:39:09', --creacion
	NULL  --posicion_botonera
);
--- FIN Grupo de desarrollo 258

------------------------------------------------------------
-- apex_objeto_datos_rel
------------------------------------------------------------
INSERT INTO apex_objeto_datos_rel (proyecto, objeto, debug, clave, ap, punto_montaje, ap_clase, ap_archivo, sinc_susp_constraints, sinc_orden_automatico, sinc_lock_optimista) VALUES (
	'libros', --proyecto
	'258000338', --objeto
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
	'258000548', --dep_id
	'258000338', --objeto_consumidor
	'258000316', --objeto_proveedor
	'libro', --identificador
	NULL, --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'2'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'libros', --proyecto
	'258000247', --dep_id
	'258000338', --objeto_consumidor
	'258000122', --objeto_proveedor
	'prestamo', --identificador
	NULL, --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'1'  --orden
);
--- FIN Grupo de desarrollo 258

------------------------------------------------------------
-- apex_objeto_datos_rel_asoc
------------------------------------------------------------

--- INICIO Grupo de desarrollo 258
INSERT INTO apex_objeto_datos_rel_asoc (proyecto, objeto, asoc_id, identificador, padre_proyecto, padre_objeto, padre_id, padre_clave, hijo_proyecto, hijo_objeto, hijo_id, hijo_clave, cascada, orden) VALUES (
	'libros', --proyecto
	'258000338', --objeto
	'258000036', --asoc_id
	NULL, --identificador
	'libros', --padre_proyecto
	'258000316', --padre_objeto
	'libro', --padre_id
	NULL, --padre_clave
	'libros', --hijo_proyecto
	'258000122', --hijo_objeto
	'prestamo', --hijo_id
	NULL, --hijo_clave
	NULL, --cascada
	'1'  --orden
);
--- FIN Grupo de desarrollo 258

------------------------------------------------------------
-- apex_objeto_rel_columnas_asoc
------------------------------------------------------------
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'libros', --proyecto
	'258000338', --objeto
	'258000036', --asoc_id
	'258000316', --padre_objeto
	'258000669', --padre_clave
	'258000122', --hijo_objeto
	'258000689'  --hijo_clave
);
