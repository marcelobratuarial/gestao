<?= getSwal() ?>
<!-- START Bootstrap-Cookie-Alert -->
<div class="alert text-center cookiealert" role="alert" style="position: fixed; bottom: 0;">
	<b>Você gosta de cookies?</b> &#x1F36A; Usamos cookies para garantir que você obtenha a melhor experiência em nosso website.
	<a href="https://bplink.com.br/cookies" target="_blank">Saiba mais</a>

	<button type="button" class="btn btn-primary btn-sm acceptcookies">Eu concordo</button>
</div>
<!-- END Bootstrap-Cookie-Alert -->


<span id="cfg" data-baseUrl="<?= base_url() ?>" data-accessToken="<?= $_SESSION['accessToken'] ?>"></span>
<!-- Bootstrap JS -->

<script src="<?= base_url() ?>/assets/js/bootstrap.bundle.min.js"></script>

<!--plugins-->
<script src="<?= base_url() ?>/assets/js/jquery.min.js"></script>



<script src="<?= base_url() ?>/assets/plugins/simplebar/js/simplebar.min.js"></script>

<script src="<?= base_url() ?>/assets/plugins/metismenu/js/metisMenu.min.js"></script>

<script src="<?= base_url() ?>/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>

<script src="<?= base_url() ?>/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>

<script src="<?= base_url() ?>/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>

<script src="<?= base_url() ?>/assets/plugins/chartjs/js/Chart.min.js"></script>

<script src="<?= base_url() ?>/assets/plugins/chartjs/js/Chart.extension.js"></script>

<script src="<?= base_url() ?>/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>

<script src="<?= base_url() ?>/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>

<script src="<?= base_url() ?>/assets/plugins/bootstrap-cookie-alert/cookiealert.js"></script>

<script src="<?= base_url() ?>/assets/plugins/jquery-mask/jquery.mask.js"></script>

<script src="<?= base_url() ?>/assets/js/jquery.maskMoney.min.js"></script>

<!-- <script src="<?= base_url() ?>/assets/plugins/jquery-sortable/jquery-sortable.js"></script>

<script src="<?= base_url() ?>/assets/plugins/jquery-sortable/mySortable.js"></script> -->



<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="<?= base_url() ?>/assets/plugins/fancybox/jquery.fancybox.js"></script>


	<script src="<?= base_url('assets/summernote/summernote.min.js');?>"></script>
<script src="<?= base_url() ?>/assets/plugins/select2/js/select2.min.js"></script>
<script src="<?= base_url() ?>/assets/js/app.js"></script>
<script src="<?= base_url() ?>/assets/js/custom.js"></script>
<script src="<?= base_url() ?>/assets/js/index.js"></script>


<?= listScript((isset($javaScriptSrc)) ? $javaScriptSrc : null) ?>

<script>
	$(document).ready(function() {

		$('[data-fancybox="gallery"]').fancybox({
			// Options will go here
		});

		$('#table-primary').DataTable({
			language: {
				url: '<?= base_url("assets/plugins/datatable/js/pt_br.json") ?>',
			},
			order: [
				[1, "desc"]
			]
		});

		var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
		var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
			return new bootstrap.Tooltip(tooltipTriggerEl)
		})
	});

	$(function() {

		//SORTABLE MODULOS
		$(".modulosSortable").sortable({
			connectWith: '.subModulosSortable',
			placeholder: "ui-state-highlight",
			update: function(event, ui) {
				var order = $(this).sortable('toArray');
				var action = $(this).data('action');
				$.post(action, {
					novaOrdem: order
				});
			}
		});
		$(".modulosSortable").disableSelection();


		//SORTABLE CAMPO EXTRA
		$("#sortableCampoExtra").sortable({
			placeholder: "ui-state-highlight",
			update: function(event, ui) {
				var order = $("#sortableCampoExtra").sortable('toArray');
				var tabela = $("#sortableCampoExtra").data('tabela');
				$.post("<?= base_url('configuracao/atualizarCampoExtra') ?>/" + tabela, {
					novaOrdem: order
				});
			}
		});
		$("#sortableCampoExtra").disableSelection();

		//SORTABLE STATUS
		$("#sortableStatus").sortable({
			items: "li:not(.ui-state-disabled)",
			placeholder: "ui-state-highlight",
			update: function(event, ui) {
				var order = $("#sortableStatus").sortable('toArray');
				var tabela = $("#sortableStatus").data('tabela');
				$.post("<?= base_url('configuracao/atualizarStatus') ?>/" + tabela, {
					novaOrdem: order
				});
			}
		});
		$("#sortableStatus").disableSelection();

		$('.maskMoney').maskMoney({
			prefix: "R$ ",
			decimal: ',',
			thousands: '.',
			selectAllOnFocus: true,
			allowNegative: false
		});


	});
</script>

<script>

	  $('.summernote').summernote({

	placeholder: '',

	tabsize: 2,

	height: 400

  });

</script>




</body>

</html>