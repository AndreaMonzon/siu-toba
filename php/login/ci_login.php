<?php
class ci_login extends toba_ci
{
	protected $s__datos;
	protected $s__datos_openid;
	protected $en_popup = false;
	protected $s__item_inicio;
	
	/**
	 * Guarda el id de la operaci�n original as� se hace una redirecci�n una vez logueado
	 */
	function ini__operacion()
	{
		//--- Si el usuario pidio originalmente alg�n item distinto al de login, se fuerza como item de inicio de sesi�n
		$item_original = toba::memoria()->get_item_solicitado_original();
		$item_actual = toba::memoria()->get_item_solicitado();
		if (isset($item_original) && isset($item_actual) &&
				$item_actual[1] != $item_original[1]) {
			toba::proyecto()->set_parametro('item_inicio_sesion', $item_original[1]);
		}
		$this->s__item_inicio = null;
	}

	function ini()
	{
		toba_ci::set_navegacion_ajax(false);
		$this->en_popup = toba::proyecto()->get_parametro('item_pre_sesion_popup');
		if (toba::instalacion()->get_tipo_autenticacion() == 'openid') {
			try {
				toba::manejador_sesiones()->get_autenticacion()->verificar_acceso();
			} catch (toba_error_autenticacion $e) {
				//-- Caso error de validaci�n
				toba::notificacion()->agregar($e->getMessage());
			}
		}
	}
	
	function conf__login()
	{
		if ( ! toba::proyecto()->get_parametro('validacion_debug') ) {
			$this->pantalla()->eliminar_dep('seleccion_usuario');
		}
		if (toba::instalacion()->get_tipo_autenticacion() == 'openid') {
			if (! toba::manejador_sesiones()->get_autenticacion()->permite_login_toba() 
				&& $this->pantalla()->existe_dependencia('datos')) {
				$this->pantalla()->eliminar_dep('datos');
			}			
		} else {
			if ($this->pantalla()->existe_dependencia('openid')) {
				$this->pantalla()->eliminar_dep('openid');
			}
		}		
		if ($this->en_popup && toba::manejador_sesiones()->existe_usuario_activo()) {
			//Si ya esta logueado y se abre el sistema en popup, ocultar componentes visuales
			$this->pantalla()->set_titulo('');			
			if ($this->pantalla()->existe_dependencia('seleccion_usuario')) {
				$this->pantalla()->eliminar_dep('seleccion_usuario');
			}
			if ($this->pantalla()->existe_dependencia('datos')) {
				$this->pantalla()->eliminar_dep('datos');
			}			
			if ($this->pantalla()->existe_evento('Ingresar')) {
				$this->pantalla()->eliminar_evento('Ingresar');
			}
		}		
	}	
	
	function post_eventos()
	{
		if (isset($this->s__datos['usuario']) || isset($this->s__datos_openid['provider'])) {
			if (toba::instalacion()->get_tipo_autenticacion() == 'openid' && isset($this->s__datos_openid)) {
				toba::manejador_sesiones()->get_autenticacion()->set_provider($this->s__datos_openid);
			}
			$usuario = (isset($this->s__datos['usuario'])) ? $this->s__datos['usuario'] : '';
			$clave = (isset($this->s__datos['clave'])) ? $this->s__datos['clave'] : '';

			try {
				toba::manejador_sesiones()->login($usuario, $clave);
			} catch (toba_error_autenticacion $e) {
				//-- Caso error de validaci�n
				toba::notificacion()->agregar($e->getMessage());
			} catch (toba_error_autenticacion_intentos $e) {
				//-- Caso varios intentos fallidos con captcha
				list($msg, $intentos) = explode('|', $e->getMessage());
				toba::notificacion()->agregar($msg);
				toba::memoria()->set_dato_instancia('toba_intentos_fallidos_login', $intentos);
			} catch (toba_error_login_contrasenia_vencida $e) {
				$this->set_pantalla('cambiar_contrasenia');
			} catch (toba_reset_nucleo $reset) {
				//-- Caso validacion exitosa, elimino la marca de intentos fallidos
				if (toba::memoria()->get_dato_instancia('toba_intentos_fallidos_login') !== null) {
					toba::memoria()->eliminar_dato_instancia('toba_intentos_fallidos_login');
				}
				//-- Se redirige solo si no es popup
				if (! $this->en_popup) {
					throw $reset;
				}
				$this->s__item_inicio = $reset->get_item();	//Se guarda el item de inicio al que queria derivar el nucleo
			}
			return;
		}
	}
	
	
	//-------------------------------------------------------------------
	//--- DEPENDENCIAS
	//-------------------------------------------------------------------

	//---- datos -------------------------------------------------------

	function evt__datos__ingresar($datos)
	{
		if (isset($this->s__datos_openid)) {
			unset($this->s__datos_openid);
		}		
		toba::logger()->desactivar();
		if (isset($datos['test_error_repetido']) && !$datos['test_error_repetido']) {
			throw new toba_error_autenticacion('El valor ingresado de confirmaci�n no es correcto');
		} else {
			$this->s__datos = $datos;
		}
	}
	
	function conf__datos(toba_ei_formulario $form)
	{
		if (toba::memoria()->get_dato_instancia('toba_intentos_fallidos_login') === null) {
			$form->desactivar_efs(array('test_error_repetido'));
		}
		if (toba::instalacion()->get_tipo_autenticacion() != 'openid') {
			$form->set_titulo('');
		}
		if (isset($this->s__datos)) {
			if (isset($this->s__datos['clave'])) {
				unset($this->s__datos['clave']);
			}
			$form->set_datos($this->s__datos);
		}
	}	
	
	
	//---- open_id -------------------------------------------------------
	
	function evt__openid__ingresar($datos)
	{
		if (isset($this->s__datos)) {
			unset($this->s__datos);
		} 
		$this->s__datos_openid = $datos;
	}	

	function conf__openid(toba_ei_formulario $form)
	{
		$providers = $this->get_openid_providers();
		if (! empty($providers)) {
			$provider = current($providers);
			$form->set_datos_defecto(array('provider' => $provider['id']));
		}
		if (isset($this->s__datos_openid)) {
			$form->set_datos($this->s__datos_openid);
		}
	}	
	
	
	function get_openid_providers() 
	{
		return toba::manejador_sesiones()->get_autenticacion()->get_providers();
	}


	//---- seleccion_usuario -------------------------------------------------------

	function evt__seleccion_usuario__seleccion($seleccion)
	{
		$this->s__datos['usuario'] = $seleccion['usuario'];
		$this->s__datos['clave'] = null;
	}

	function conf__seleccion_usuario()
	{
		return toba::instancia()->get_lista_usuarios();
	}
	
	//-----------------------------------------------------------------------------------
	//---- form_passwd_vencido ----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__form_passwd_vencido__modificacion($datos)
	{
		$usuario = $this->s__datos['usuario'];
        //Si la clave anterior coincide
		if (toba::manejador_sesiones()->invocar_autenticar($usuario, $datos['clave_anterior'], null)) {
			//Obtengo los dias de validez de la nueva clave
			$dias = toba::proyecto()->get_parametro('dias_validez_clave', null, false);
			toba_usuario::verificar_clave_no_utilizada($datos['clave_nueva'], $usuario);
			toba_usuario::reemplazar_clave_vencida($datos['clave_nueva'], $usuario, $dias);
		} else {
			throw new toba_error_usuario('La clave ingresada no es correcta');
		}
		$this->set_pantalla('login');
	}

	function evt__form_passwd_vencido__cancelar()
	{
		$this->set_pantalla('login');
	}
	
	//-------------------------------------------------------------------
	
	function extender_objeto_js()
	{
		if (toba::instalacion()->get_tipo_autenticacion() == 'openid') {
			$personalizable = '';
			foreach ($this->get_openid_providers() as $id => $provider) {
				if (isset($provider['personalizable']) && $provider['personalizable']) {
					$personalizable = $id;
				}
			}
			echo "
				{$this->dep('openid')->objeto_js}.evt__provider__procesar = function(inicial) {
					if (this.ef('provider').get_estado() == '$personalizable') {
						this.ef('provider_url').mostrar();
					} else {
						this.ef('provider_url').ocultar();
					}
				}
			";
		}
		
		if ($this->en_popup) {
			$finalizar = toba::memoria()->get_parametro(apex_sesion_qs_finalizar);
			//Si cierra la sesi�n y es popup, cierra la ventana y al parent (si existe) lo recarga			
			if (isset($finalizar)) {
				echo '
					if (window.opener &&  window.opener.location) {
						window.opener.location.href = window.opener.location.href; 
					}
					window.close();
				';
			}
			if (toba::manejador_sesiones()->existe_usuario_activo()) {
				//Si ya esta logueado y se abre el sistema en popup, abrirlo
				if (isset($this->s__item_inicio)) {
					list($proyecto, $item) = explode($this->s__item_inicio);
				} else {
					$proyecto = toba::proyecto()->get_id();
					$item = toba::proyecto()->get_parametro('item_inicio_sesion');
				}
				$url = toba::vinculador()->get_url($proyecto, $item);
				echo "
					abrir_popup('sistema', '$url', {resizable: 1});
				";
			}
		}		
	}
}
?>