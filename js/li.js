var datosMM = [0, 0, 0, 0];
var datosT = [false, false, false, false];
var select = true;
var editarOp = false;
var editarControl = false;
var editadoid = 0;
var opcImp = 2;
var mostrarM = true;
var cPass = "";
var cMail = "";
var _sel_edit = false;
var opcEdit = 0;
var _muestra_listT = new Array();
var _bt_muestra_listT = 0;
var vistSub = "";
var v_val = false;
var _nuevo = false;
var _menu_h = '';
var _ingress = true;
var _regisss = true;

$(document).ready(function(){
	$("html").click(function (e) {
		if(e.target.id != "mantener2_0" && e.target.id != "mantener2_1" && e.target.id != "mantener2_2" && e.target.id != "mantener2_3" && e.target.id != "mantener2_4" && e.target.id != "mantener2" && e.target.id != "opc_imprt" && e.target.id != "imprt_b" && e.target.id != "imprt" && e.target.id != "acceso" && e.target.id != "userl" && e.target.id != "passl" && e.target.id != "pass" && e.target.id != "user" && e.target.id != "mail" && e.target.id != "registro" && e.target.id != "mantener" && e.target.id != "ingresoD" && e.target.id != "nuevo_bloque" && e.target.id != "texto" && e.target.id != "date" && e.target.id != "descr" && e.target.id != "mensaje2" && e.target.id != "mensaje1" && e.target.id != "mensaje" && !editarOp){
			$("#opc_imprt").css("display","");
			$("#ingresoD").fadeOut(300);
			$("#mensaje1").css("display","none");
			$("#mensaje2").css("display","none");
			_ingress = true;
			_regisss = true;
			if(_nuevo && getParameterByName('nvo') == "1"){
				window.history.back();
			}
			if(editarControl){
				document.getElementById("texto").value = "";
				document.getElementById("date").value = "";
				editarControl = false;
			}
			if(_sel_edit || getParameterByName('nvo') == "2"){
				cancelar();
			}
		}
		editarControl = editarOp;
		if(editarOp){
			editarOp = false;
		}
		if(e.target.id != "mantieneMen" && e.target.id != "nuevo_bloque"){
			$(".menuContenidoUser").fadeOut(200);
			mostrarM = true;
		}
		if(e.target.id != "mantener2_0" && e.target.id != "mantener2_1" && e.target.id != "mantener2_2" && e.target.id != "mantener2_3" && e.target.id != "mantener2_4" && e.target.id != "mantener2" && e.target.id != "opc_imprt" && e.target.id != "imprt_b"){
			$("#opc_imprt").css("display","");
		}
		if(e.target.id != "mantener3"){
			$(".menu_ops").fadeOut(200);
		}
		if(e.target.id != "listaT" && e.target.id != "mantenerT" && _bt_muestra_listT != 0){
			$('.listTerm' + _bt_muestra_listT).fadeOut(100);
			_muestra_listT['no-' + _bt_muestra_listT] = 0;
			_bt_muestra_listT = 0;
		}
		if(e.target.id != "mantener4" && e.target.id != "mantenerT"){
			$(".fondo").fadeOut(200);
		}
	});
});
window.addEventListener('popstate', event => {
	if(_nuevo){
		$("#nuevo_bloque").css("display","none");
		_nuevo = false;
	} else {
		if(getParameterByName('nvo') == "1"){
			nuevo();
		} else if(getParameterByName('nvo') == "2"){
			editar((getParameterByName('di') == ""? 0 : getParameterByName('di')), (getParameterByName('rdi') == ""? 2 : getParameterByName('rdi')));
		} else {
			$("#nuevo_bloque").css("display","none");
			_nuevo = false;
			v_val = false;
			if(event.state !== null){
				sust(event.state, false);
			} else {
				sust('principal', false);
			}
		}
	}
});

function intCambio(vista){
	$("#contenedor_carga").css("display","flex");
	var cambio = $.ajax({
		url: 'vistas/'+vista+'.php',
		method: 'GET',
		dataType: 'html'
	});
	cambio.done(function(html_r) {
		$("#contenedor_carga").css("display","none");
		$('#conten').html(html_r);
	});
	cambio.fail(function(jqXHR, textStatus) {
		console.log("Request failed: " + textStatus);
		$("#contenedor_carga").css("display","none");
		alert("Lo sentimos, ha ocurrido un error al intentar cargar el contenido.\n" + textStatus);
	});
}
function cargar(_vista){
	document.getElementById("texto").value = "";
	sust(_vista, true);

	var hoy = new Date();
	var dd = hoy.getDate();
	var mm = hoy.getMonth() + 1;

	document.getElementById("date").value = "";
	$('#date').attr("min", (hoy.getFullYear() + '-' + ((mm < 10)? '0' + mm : mm) + '-' + ((dd < 10)? '0' + dd : dd)));
}
function carga(){
	document.getElementById("texto").value = "";
	opcImp = 2;
	$("#imprt_b").html('Importancia <span class="icon-circle-down" id="mantener2"></span>');
	sust('principal',true);
	_sel_edit = false;
	
	var hoy = new Date();
	var dd = hoy.getDate();
	var mm = hoy.getMonth() + 1;
	
	document.getElementById("date").value = "";
	$('#date').attr("min", (hoy.getFullYear() + '-' + ((mm < 10)? '0' + mm : mm) + '-' + ((dd < 10)? '0' + dd : dd)));
}
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
function sust(frag, op){
	mostrarM = true;
	datosMM = [0, 0, 0, 0];
	datosT = [false, false, false, false];
	$('#conten').html('');
	$("#contenedor_carga").css("display","flex");
	var request = $.ajax({
		url: 'vistas/'+frag+'.php',
		method: 'GET',
		dataType: 'html'
	});
	request.done(function(m) {
		if(v_val && vistSub != frag){
			if(frag == 'principal'){
				window.history.pushState(frag, "", "/");
			} else {
				window.history.pushState(frag, "", "?lcv=" + frag);
			}
		} else {
			v_val = true;
		}
		if(op){
			$("#nuevo_bloque").css("display","none");
		}
		$("#contenedor_carga").css("display","none");
		$('#conten').html(m);
		if($('#conten').html() != "Sin datos..."){
			var limit = 0 + parseInt($('#cantidadPF').html());
			var fecha;
			var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
			for(var i = 1; i <= limit; i++){
				fecha = new Date($('#cfecha' + i).text().replace(/-/g, '\/'));
				$('#fecha' + i).text(fecha.toLocaleDateString("es-ES", options));
			}
		}
		vistSub = frag;
		if(getParameterByName('nvo') == "1" || getParameterByName('nvo') == "2"){
			var _t_n = getParameterByName('nvo');
			var _di = getParameterByName('di') == ""? 0 : getParameterByName('di');
			var _rdi = getParameterByName('rdi') == ""? 2 : getParameterByName('rdi');
			if(getParameterByName('lcv') == ""){
				window.history.replaceState(vistSub, "", "/");
			} else {
				window.history.replaceState(vistSub, "", "?lcv=" + vistSub);
			}
			if(_t_n == "1"){
				nuevo();
			} else if(_t_n == "2"){
				editar(_di, _rdi);
				editarOp = false;
			}
		}
	});
	request.fail(function(jqXHR, textStatus) {
		console.log("Request failed: " + textStatus);
		$("#contenedor_carga").css("display","none");
		alert("Lo sentimos, ha ocurrido un error al intentar cargar el contenido.\n" + textStatus);
	});
}
function codificarEntidad(str) {
	var array = [];
	for (var i=str.length-1;i>=0;i--) {
		array.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
	}
	return array.join('');
}
function descodificarEntidad(str) {
	return str.replace(/&#(\d+);/g, function(match, dec) {
		return String.fromCharCode(dec);
	});
}
function buscar(){
	var texto = codificarEntidad(document.getElementById("texto").value);
	var fecha = document.getElementById("date").value;
	$.post("libs/nuevo.php", {text: texto, date: fecha, opcImp: opcImp}, function(respuesta){
		if(respuesta.length == 10){
			if(respuesta.substring(1, 9) === "Correcto"){
				carga();
				$("#mensaje").css("display","none");
			} else {
				$("#mensaje").text("Error: No se puede realizar la carga de la información.");
				$("#mensaje").css("display","inline-block");
			}
		} else if(respuesta.length == 7){
			$("#mensaje").text("Error: No se puede realizar la carga de la información.");
			$("#mensaje").css("display","inline-block");
		} else {
			$("#mensaje").text("Error: No se puede conectar con el servidor.");
			$("#mensaje").css("display","inline-block");
		}
		$("#contenedor_carga").css("display","none");
	}).fail( function(){
		$("#mensaje").text("Error: No se puede conectar con el servidor.");
		$("#mensaje").css("display","inline-block");
		$("#contenedor_carga").css("display","none");
	});
}
function nuevo(){
	if(getParameterByName('nvo') != "1"){
		if(!_nuevo){
			if(getParameterByName('lcv') == ""){
				window.history.pushState(vistSub, "", "?nvo=1");
			} else {
				window.history.pushState(vistSub, "", "?lcv=" + vistSub + "&nvo=1");
			}
		}
	}
	_nuevo = true;
	$("#nuevo_bloque").css("display","inline-block");
	$(".btAceptar").css("display","inline-block");
	$(".btEditar").css("display","none");
	$("#texto").focus();
}
function editar(id, relv){
	if(getParameterByName('nvo') != "2"){
		if(!_nuevo){
			if(getParameterByName('lcv') == ""){
				window.history.pushState(vistSub, "", "?nvo=2&di=" + id + "&rdi=" + relv);
			} else {
				window.history.pushState(vistSub, "", "?lcv=" + vistSub + "&nvo=2&di=" + id + "&rdi=" + relv);
			}
		}
	}
	_nuevo = true;
	editadoid = id;
	editarOp = true;
	document.getElementById("texto").value = $(".textoP" + id).html().replace(/<br>/g, "\n");
	document.getElementById("date").value = $(".fechaP" + id).text();
	$("#nuevo_bloque").css("display","inline-block");
	$("#imprt_b").html(opcMost(relv) + ' <span class="icon-circle-down" id="mantener2"></span>');
	$(".btAceptar").css("display","none");
	$(".btEditar").css("display","inline-block");
	$("#texto").focus();
	_sel_edit = true;
	opcEdit = relv;
}
function elegImp(){
	for(var i = 0; i < 5; i++){
		$("#mantener2_" + i).css("background-color","");
	}
	if(_sel_edit){
		$("#mantener2_" + opcEdit).css("background-color","#000");
	} else {
		$("#mantener2_" + opcImp).css("background-color","#000");
	}
	$("#opc_imprt").css("display","inline-block");
}
function opcMost(opc){
	var txt = '';
	var opsc = '.' + opc;
	switch(opsc){
		case '.0':		txt = 'Imprescindible';		break;
		case '.1':		txt = 'Alta';				break;
		case '.2':		txt = 'Normal';				break;
		case '.3':		txt = 'Baja';				break;
		case '.4':		txt = 'Prescindible';		break;
		default:	txt = 'Normal';				break;
	}
	return txt;
}
function elegI(opc){
	$("#imprt_b").html(opcMost(opc) + ' <span class="icon-circle-down" id="mantener2"></span>');
	opcImp = opc;
	opcEdit = opc;
	$("#opc_imprt").css("display","");
}
function acept(type){
	$("#contenedor_carga").css("display","flex");
	if(type == 1){
		var corre = document.getElementById("mail").value;
		var usuar = document.getElementById("user").value;
		var contr = document.getElementById("pass").value;
		var mail = codificarEntidad(corre);
		var user = codificarEntidad(usuar);
		var pass = codificarEntidad(contr);
		if(corre.length >= 4 && usuar.length >= 4 && contr.length >= 4){
			$.post("libs/nUsuario.php", {mail: mail, user: user, pass: pass}, function(respuesta){
				if(respuesta === "[Correcto]"){
					$("#contenedor_carga").css("display","none");
					$("#mensaje" + type).text("Correcto: El usuario se ha creado, es necesario verificar el correo electrónico para que la cuenta sea activada.");
					$("#mensaje" + type).css("color","#fff");
					$("#mensaje" + type).css("display","inline-block");
				} else if(respuesta === "[Existente]"){
					$("#mensaje1").text("Lo sentimos el nombre de usuario que eligió ya se encuentra registrado.");
					$("#mensaje" + type).css("color","#ff7373");
					$("#mensaje1").css("display","inline-block");
					$("#contenedor_carga").css("display","none");
				} else {
					$("#mensaje1").text("Error: Hubo un problema con la carga de los datos.");
					$("#mensaje" + type).css("color","#ff7373");
					$("#mensaje1").css("display","inline-block");
					$("#contenedor_carga").css("display","none");
				}
			}).fail( function(){
				$("#mensaje1").text("Error: No se puede conectar con el servidor.");
				$("#mensaje" + type).css("color","#ff7373");
				$("#mensaje1").css("display","inline-block");
				$("#contenedor_carga").css("display","none");
			});
		} else {
			$("#mensaje1").html("Error:<br>- Los tres campos son obligatorios y deben contener 4 o más caracteres.");
			$("#mensaje1").css("display","inline-block");
			$("#contenedor_carga").css("display","none");
		}
	} else if(type == 2){
		var usuar = document.getElementById("userl").value;
		var contr = document.getElementById("passl").value;
		var userl = codificarEntidad(usuar);
		var passl = codificarEntidad(contr);
		if(usuar.length > 0 && contr.length > 0){
			$.post("libs/acceso.php", {user: userl, pass: passl}, function(respuesta){
				if(respuesta == "[Correcto]"){
					location.reload();
				} else if(respuesta == "[no]"){
					$("#mensaje2").text("Error: Usuario o contraseña incorrectos.");
					$("#mensaje" + type).css("color","#ff7373");
					$("#mensaje2").css("display","inline-block");
					$("#contenedor_carga").css("display","none");
				} else if(respuesta == "[Desactivado]"){
					$("#mensaje2").text("Error: El acceso de este usuario no está permitido hasta que se verifique.");
					$("#mensaje" + type).css("color","#ff7373");
					$("#mensaje2").css("display","inline-block");
					$("#contenedor_carga").css("display","none");
				} else {
					$("#mensaje2").text("Error: Hubo un problema con la carga de los datos.");
					$("#mensaje" + type).css("color","#ff7373");
					$("#mensaje2").css("display","inline-block");
					$("#contenedor_carga").css("display","none");
				}
			}).fail( function(){
				$("#mensaje2").text("Error: No se puede conectar con el servidor.");
				$("#mensaje" + type).css("color","#ff7373");
				$("#mensaje2").css("display","inline-block");
				$("#contenedor_carga").css("display","none");
			});
		} else {
			$("#mensaje2").html("Error:<br>- Los dos campos son obligatorios.");
			$("#mensaje" + type).css("color","#ff7373");
			$("#mensaje2").css("display","inline-block");
			$("#contenedor_carga").css("display","none");
		}
	}
}
function aceptar(){
	$("#contenedor_carga").css("display","flex");
	if(document.getElementById("texto").value != ""){
		if(document.getElementById("date").value != ""){
			buscar();
		} else {
			$("#mensaje").text("Error: No ha indicado la fecha.");
			$("#mensaje").css("display","inline-block");
			$("#contenedor_carga").css("display","none");
		}
	} else {
		$("#mensaje").text("Error: No ha escrito ninguna descripción.");
		$("#mensaje").css("display","inline-block");
		$("#contenedor_carga").css("display","none");
	}
}
function cancel(type){
	$("#ingresoD").fadeOut(300);
	$("#mensaje" + type).css("display","none");
	_ingress = true;
	_regisss = true;
}
function cancelar(){
	document.getElementById("texto").value = "";
	document.getElementById("date").value = "";
	opcImp = 2;
	_sel_edit = false;
	$("#imprt_b").html('Importancia <span class="icon-circle-down" id="mantener2"></span>');
	$("#nuevo_bloque").css("display","none");
	if(_nuevo){
		window.history.back();
	}
	$("#mensaje").text("");
	$("#mensaje").css("display","none");
}
function selecc(id, op){
	$(".acept_finlz").attr("onclick", "terminado(" + id + ", " + op + ");");
	$('.fondo').css("display","table");
	$('.listTerm' + id).fadeOut(100);
	_muestra_listT['no-' + id] = !_muestra_listT['no-' + id];
	_bt_muestra_listT = 0;
}
function terminado(id, op){
	$("#contenedor_carga").css("display","flex");
	$.post("libs/terminar.php", {id: id, estado: op}, function(respuesta){
		carga();
	}).fail( function(){
		$("#contenedor_carga").css("display","none");
	});
}
function terminarEdi(){
	$("#contenedor_carga").css("display","flex");
	if(document.getElementById("texto").value != "" && document.getElementById("date").value != ""){
		$.post("libs/editar.php",
		{
			editadoid: editadoid,
			text: codificarEntidad(document.getElementById("texto").value),
			date: document.getElementById("date").value,
			opcImp: opcEdit
		}, function(respuesta){
			if(respuesta == "[Correcto]"){
				/*
				var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
				$(".textoP" + editadoid).html(document.getElementById("texto").value.replace(/\n/g, "<br/>"));
				fecha = new Date(document.getElementById("date").value.replace(/-/g, '\/'));
				$(".fechaCambio" + editadoid).text("Para el día: " + fecha.toLocaleDateString("es-ES", options));
				*/
				window.history.back();
				carga();
				_muestra_list['no-' + editadoid] = false;
				document.getElementById("texto").value = "";
				document.getElementById("date").value = "";
				$("#nuevo_bloque").css("display","none");
				$("#mensaje").text("");
				$("#mensaje").css("display","none");
			} else {
				$("#mensaje").text("Error: No se pudo actualizar.");
				$("#mensaje").css("display","inline-block");
			}
			$("#contenedor_carga").css("display","none");
		}).fail( function(){
			$("#mensaje").text("Error: No se puede conectar con el servidor.");
			$("#mensaje").css("display","inline-block");
			$("#contenedor_carga").css("display","none");
		});
	} else {
		$("#mensaje").text("Error: Faltan datos.");
		$("#mensaje").css("display","inline-block");
		$("#contenedor_carga").css("display","none");
	}
}
function salir(){
	$(".menuContenidoUser").css("display","none");
	mostrarM = true;
	$("#contenedor_carga").css("display","none");
	$.post("libs/salir.php", {opc: "[salir]"}, function(respuesta){
		location.reload();
	}).fail( function(){
		location.reload();
	});
}
function login(){
	var request = $.ajax({
		url: 'vistas/usuario.php',
		method: 'GET',
		dataType: 'html'
	});
	request.done(function(m) {
		$("#nuevo_bloque").css("display","none");
		_nuevo = false;
		$('#conten').html(m);
		$("#contenedor_carga").css("display","none");
	});
	request.fail(function(jqXHR, textStatus) {
		console.log("Request failed: " + textStatus);
		$("#contenedor_carga").css("display","none");
		alert("Lo sentimos, ha ocurrido un error al intentar cargar el contenido.\n" + textStatus);
	});
}
function ingreso(){
	if(_ingress){
		$("#ingresoD").fadeIn(400);
		$("#registro").css("display","none");
		$("#acceso").css("display","inline-block");
		$("#userl").focus();
		_regisss = true;
		_ingress = !_ingress;
	} else {
		$("#ingresoD").fadeOut(300);
		_ingress = true;
		_regisss = true;
	}
}
function registro(){
	if(_regisss){
		$("#ingresoD").fadeIn(400);
		$("#acceso").css("display","none");
		$("#registro").css("display","inline-block");
		$("#mail").focus();
		_ingress = true;
		_regisss = !_regisss;
	} else {
		$("#ingresoD").fadeOut(300);
		_ingress = true;
		_regisss = true;
	}
}
function mostrarOcultar(id){
	datosT[id] = !datosT[id];
	if(datosT[id]){
		$("#plegado" + id).css("display","table");
		$("#bMostrar" + id).css("display","none");
		$("#bOcultar" + id).css("display","inline-block");
	} else {
		$("#plegado" + id).css("display","none");
		$("#bMostrar" + id).css("display","inline-block");
		$("#bOcultar" + id).css("display","none");
	}
}
function mostrarMas(id, limit){
	$.post("libs/mostM.php", {id: id, continua: (datosMM[id] + 1), limit: limit}, function(respuesta){
		datosMM[id]++;
		var contenidoM = $("#mostrado" + id).html();
		contenidoM+=respuesta;
		$("#mostrado" + id).html(contenidoM);
		if(parseInt($("#seccion" + id).text()) <= datosMM[id]){
			$("#bMostrarMas" + id).css("display","none");
		}
	}).fail( function(){
		alert("Ocurrió un error.");
	});
}
function cambioMailPass(tipo, dato){
	$.post("libs/cambioMailPass.php", {tipo: tipo, dato: codificarEntidad(dato)}, function(respuesta){
		if(respuesta == "[Correcto]"){
			if(tipo == 1){
				alert("Es necesario volver a iniciar sesión.");
				location.reload();
			} else {
				$("#editMail").html(document.getElementById('mailC').value);
				$(".cambioUserCancel2").css("display","none");
				$(".msgCambio2").css("display","none");
				$(".cambioUser2").text('Cambiar');
			}
			$(".msgCambio" + tipo).css("display","none");
		} else {
			$(".msgCambio" + tipo).css("color","red");
			$(".msgCambio" + tipo).css("display","flex");
			$(".msgCambio" + tipo).html("Hubo un error al intentar modificar.");
		}
	}).fail( function(){
		$(".msgCambio" + tipo).css("color","red");
		$(".msgCambio" + tipo).css("display","flex");
		$(".msgCambio" + tipo).html("Hubo un error al intentar modificar.");
	});
}
function mostrarMenu(){
	if(mostrarM){
		$(".menuContenidoUser").fadeIn(300);
	} else {
		$(".menuContenidoUser").fadeOut(200);
	}
	mostrarM = !mostrarM;
}
function cambiarOrden(opc){
	$("#contenedor_carga").css("display","flex");
	$.post("libs/cOrden.php", { opc: opc }, function(respuesta){
		if(respuesta == "[Correcto]"){
			carga();
		} else {
			alert("Ocurrió un error.");
		}
	}).fail( function(){
		alert("Ocurrió un error.");
	});
}
function generarMenu(ord){
	var htm = '';
	if(ord != 0){ htm += '<a id="mantener3" onclick="cambiarOrden(0)">Fecha más próxima</a>'; }
	if(ord != 1){ htm += '<a id="mantener3" onclick="cambiarOrden(1)">Mayor importancia</a>'; }
	if(ord != 2){ htm += '<a id="mantener3" onclick="cambiarOrden(2)">Orden de creación</a>'; }
	return htm;
}
function muestraMenuOpc(orden){
	$(".menu_ops").html(generarMenu(orden));
	$(".menu_ops").fadeIn(300);
}
function cancelKeyP(){
	$("#editPas").html("&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;");
	$(".cambioUserCancel1").css("display","none");
	$(".msgCambio1").css("display","none");
	$(".cambioUser1").text('Cambiar');
}
function cancelKeyM(){
	$("#editMail").html(cMail);
	$(".cambioUserCancel2").css("display","none");
	$(".msgCambio2").css("display","none");
	$(".cambioUser2").text('Cambiar');
}
function cambioPass(){
	if($(".cambioUser1").text() == 'Cambiar'){
		$("#editPas").html('<input id=\"passC\" type=\"password\" onkeyup="if(event.keyCode == 13){ cambioPass(); } else if(event.keyCode == 27){ cancelKeyP(); }"/>');
		$(".cambioUser1").text('Continuar');
		$(".cambioUserCancel1").css("display","inline-block");
		document.getElementById('passC').focus();
	} else if($(".cambioUser1").text() == 'Continuar'){
		if(document.getElementById('passC').value == ""){
			cancelKeyP();
		} else {
			cPass = document.getElementById('passC').value;
			document.getElementById('passC').value = "";
			$(".cambioUser1").text('Verificar nueva contraseña');
			document.getElementById('passC').focus();
		}
	} else if($(".cambioUser1").text() == 'Verificar nueva contraseña'){
		if(cPass == document.getElementById('passC').value){
			cambioMailPass(1, document.getElementById('passC').value);
		} else {
			$(".msgCambio1").css("color","red");
			$(".msgCambio1").css("display","flex");
			$(".msgCambio1").html("Las contraseñas son diferentes.");
		}
	} else {
		alert("Error.");
	}
}
function cambioMail(){
	if($(".cambioUser2").text() == 'Cambiar'){
		var textMail = $("#editMail").text();
		$("#editMail").html('<input id=\"mailC\" value="' + textMail + '" contenido="' + textMail + '" onkeyup="if(event.keyCode == 13){ cambioMail(); } else if(event.keyCode == 27){ cancelKeyM(); }"/>');
		$(".cambioUser2").text('Continuar');
		$(".cambioUserCancel2").css("display","inline-block");
		cMail = document.getElementById('mailC').value;
		document.getElementById('mailC').focus();
	} else if($(".cambioUser2").text() == 'Continuar'){
		if(cMail != document.getElementById('mailC').value){
			cambioMailPass(2, document.getElementById('mailC').value);
		} else {
			cancelKeyM();
		}
	} else {
		alert("Error.");
	}
}
function mostrarTxt(id_list){
	if($('#vis_' + id_list).text() == "0"){
		$('#vis_' + id_list).text("1");
		$('.textoP_list' + id_list).fadeIn(300);
		$('#list_' + id_list).html('Click para ocultar <span class="icon-circle-up"></span>');
		$('#hd_list_' + id_list).css("color","#48489f");
	} else {
		$('#vis_' + id_list).text("0");
		$('.textoP_list' + id_list).fadeOut(300);
		$('#list_' + id_list).html('Click para mostrar <span class="icon-circle-down"></span>');
		$('#hd_list_' + id_list).css("color","");
	}
}
function muestraListaT(id_list){
	if(!_muestra_listT['no-' + id_list]){
		if(_bt_muestra_listT != 0 && _bt_muestra_listT != id_list){
			$('.listTerm' + _bt_muestra_listT).fadeOut(100);
			_muestra_listT['no-' + _bt_muestra_listT] = false
		}
		$('.listTerm' + id_list).fadeIn(100);
		_bt_muestra_listT = id_list;
	} else {
		$('.listTerm' + id_list).fadeOut(100);
		_bt_muestra_listT = 0;
	}
	_muestra_listT['no-' + id_list] = !_muestra_listT['no-' + id_list];
}
