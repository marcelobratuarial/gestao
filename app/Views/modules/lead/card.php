<div class="row">
    <div class="col">
        <h4 class="mb-0 text-uppercase">Leads</h4>
    </div>
    <div class="col text-end">
        <a href="#" class="btn btn-primary"><i class="bx bx-plus"></i> Adicionar</a>
    </div>
</div>

<br>

<!-- Lists container -->
<section class="lists-container">
    <?php foreach ($status as $s) : ?>

        <div class="list">

            <h5 class="list-title border-5 border-bottom border-<?= $s -> cor ?>"><?= $s -> nome ?></h5>

            <ul class="list-items">


                <?php foreach ($leads->MeusLeads($s->code) as $l) :
                //encurta o nome deixando somente o primeiro e o ultimo
				$nome = explode(' ', $l->nome); 
				$nome = $nome[0] .' '. end($nome);
				?>
                    <li id="<?= $l -> code ?>">
                        <div class="card">
                            <div class="card-body">
                                <div class="row justify-content-between">
                                    <div class="col">
                                        <h5 class="card-title d-inline" data-bs-toggle="tooltip" title="<?= $l -> nome ?>"><?= $nome ?></h5>
                                    </div>
                                </div>
                                <? /* AGRUPAR PRODUTOS */ ?>
                                <p class="card-text">
                                    <strong>Assistência Pet</strong>
                                    <a href="" class="btn btn-sm btn-primary p-1 py-0 rounded-circle"><small>+2</small></a>
                                </p>
                                <? /* AGRUPAR PRODUTOS */ ?>
                            </div>
                            <div class="card-footer">
                                <span class="text-muted float-start small cursor-pointer" style="padding-top: 0.4rem;" data-bs-toggle="tooltip" title="<?= date('d/m/Y H:i', strtotime($l -> created_at)) ?>"><?= inTime($l -> created_at) ?></span>
                                <? /*<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn-sm btn-link text-decoration-none float-end">Detalhes</a>*/ ?>
                                <a href="<?= base_url('lead/detalhe/' . $l -> code) ?>" class="btn-sm btn-link text-decoration-none float-end">Detalhes</a>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>

            </ul>

        </div>
    <?php endforeach; ?>

</section>
<!-- End of lists container -->
<? /* ?>
	 <!-- Modal -->
	 <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	 <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
	 <div class="modal-content">
	 <div class="modal-body pb-0" style="overflow-y: hidden;">
	 <div class="row">
	 <div class="col">
	 <h5 class="modal-title" id="staticBackdropLabel">João Sistemas</h5>
	 <p>
	 joaosistemas@emaildele.com
	 <br>
	 (31) 99999-9999
	 </p>
	 </div>
	 <div class="col text-end">
	 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	 </div>
	 </div>
	 </div>
	 <div class="modal-body border-1 border-top" style="overflow-y: hidden;">
	 <ul class="nav nav-tabs">
	 <li class="nav-item">
	 <a class="nav-link active" aria-current="page" href="#">Produtos</a>
	 </li>
	 <li class="nav-item">
	 <a class="nav-link" href="#">Histórico</a>
	 </li>
	 </ul>
	 <div id="produtosLead" class="mt-1" data-simplebar="true" style="height: calc(60vh - 2rem)">
	 <div class="card mb-3 mt-3">
	 <div class="row g-0">
	 <div class="col-md-4">
	 <img src="https://via.placeholder.com/1080x680?text=Assistência+Pet" class="img-fluid" alt="...">
	 </div>
	 <div class="col-md-8">
	 <div class="card-body">
	 <h5 class="card-title">Card title</h5>
	 <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
	 <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
	 </div>
	 </div>
	 </div>
	 </div>
	 <div class="card mb-3 mt-3">
	 <div class="row g-0">
	 <div class="col-md-4">
	 <img src="https://via.placeholder.com/1080x680?text=Assistência+Pet" class="img-fluid" alt="...">
	 </div>
	 <div class="col-md-8">
	 <div class="card-body">
	 <h5 class="card-title">Card title</h5>
	 <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
	 <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
	 </div>
	 </div>
	 </div>
	 </div>
	 <div class="card mb-3 mt-3">
	 <div class="row g-0">
	 <div class="col-md-4">
	 <img src="https://via.placeholder.com/1080x680?text=Assistência+Pet" class="img-fluid" alt="...">
	 </div>
	 <div class="col-md-8">
	 <div class="card-body">
	 <h5 class="card-title">Card title</h5>
	 <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
	 <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
	 </div>
	 </div>
	 </div>
	 </div>
	 </div>
	 </div>
	 <div class="modal-footer">
	 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	 <button type="button" class="btn btn-primary">Understood</button>
	 </div>
	 </div>
	 </div>
	 </div>
	 <? */
 ?>