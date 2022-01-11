<div class="card border-top border-0 border-4 border-primary">
    <div class="card-body p-5">
        <div class="card-title d-flex align-items-center">
            <h5 class="mb-0 text-primary"><input type="date" onchange="location.assign('<?= base_url() ?>/logs/'+this.value)" value="<?= date('Y-m-d', strtotime($date)) ?>" max="<?= date('Y-m-d') ?>"></h5>
        </div>
        <hr>

        <?= nl2br($file) ?>
    </div>
</div>