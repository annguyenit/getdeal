/*
 * SimpleModal Basic Modal Dialog
 * http://www.ericmmartin.com/projects/simplemodal/
 * http://code.google.com/p/simplemodal/
 *
 * Copyright (c) 2009 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Revision: $Id: basic.js 212 2009-09-03 05:33:44Z emartin24 $
 *
 */

$(document).ready(function () {
	$('.propertydetails_toplinks a.sendtofriend, p.propertylistinglinks a.sendtofriend ').click(function (e) {
		e.preventDefault();
		$('#basic-modal-content').modal();
	});
	
		$('p.propertylistinglinks span.emailagent a, p.links a.i_email_agent' ).click(function (e) {
		e.preventDefault();
		$('#basic-modal-content2').modal();
	});
		
		$('p.links a.a_image_sort').click(function (e) {
		e.preventDefault();
		$('#basic-modal-content3').modal();
	});
	
});