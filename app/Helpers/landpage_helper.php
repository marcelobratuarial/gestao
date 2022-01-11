<?php
function lpLogo($codeEmpresa, $logo = null) {
	$empresaModel = new \App\Models\EmpresaModel();
	$empresa = $empresaModel->where('code', $codeEmpresa)
		->first();
	if ($logo) :
		return base_url('assets/uploads/' . $logo);
	
	else :
		return base_url('assets/uploads/' . $empresa->logo);
	endif;
}
function lpMenu($data) {
	$data = json_decode($data);
	$html = '<ul class="nav justify-content-end">';
	foreach ($data as $d) {
		$html .= '<li class="nav-item"><a class="nav-link text-white h5" href="' . $d->link . '">' . $d->nome . '</a></li>';
	}
	$html .= '</ul>';
	return $html;
}
function lpForm($codeForm) {
	$formModel = new \App\Models\FormModel();
	$form = $formModel->where('code', $codeForm)
		->first();
	$data = json_decode($form->campos);
	$html = '<!--FORM-->';
	$html = '<form>';
	$html .= '<div class="form-tittle mb-10 text-center">';
	$html .= '<h2>' . $form->titulo . '</h2>';
	$html .= '<p>' . $form->descricao . '</p>';
	$html .= '</div>';
	foreach ($data as $d) {
		$html .= '<label>' . $d . '</label>';
		$html .= '<input type="text" class="form-control mt-2 mb-2" name="' . slug($d) . '">';
	}
	$html .= '<button type="submit" class="btn btn-primary btn-lg mt-2 w-100 rounded-0">' . $form->botao . '</button>';
	$html .= '</form>';
	$html .= '<!--END FORM-->';
	return $html;
}