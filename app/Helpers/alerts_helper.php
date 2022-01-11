<?php

function setSwal($icon, $title, $html) {
	$session = \Config\Services::session();
	$newdata['swal'] = ['icon' => $icon, 'title' => $title, 'html' => $html];
	$session -> setFlashdata($newdata);
}

function getSwal() {
	$session = \Config\Services::session();
	if ($swal = $session -> getFlashdata('swal')) :
		return '<script>Swal.fire({icon:"' . $swal['icon'] . '", title: "' . $swal['title'] . '", html: "' . $swal['html'] . '"});</script>';
	else :
		return null;
	endif;
}
