<!--sidebar wrapper -->

<div class="sidebar-wrapper" data-simplebar="true">

  <div class="sidebar-header">


    <div id="logo" class="d-flex">
      <?php if ($_SESSION['empresaLogo']) : ?>
      <img src="<?= base_url('assets/uploads/' . LOGOEMPRESA) ?>" class="img-fluid w-75" style="max-height:4.5em"
        alt="logo icon">
      <?php else : ?>
      <h4 class="logo-text"><?= $_SESSION['empresaNome'] ?></h4>
      <?php endif; ?>
    </div>
    <div id="icone" class="d-none">
      <?php if ($_SESSION['empresaIcone']) : ?>
      <img src="<?= base_url('assets/uploads/' . $_SESSION['empresaIcone']) ?>" class="img-fluid w-100" alt="logo icon">
      <?php endif; ?>
    </div>

    <div onclick="" class="toggle-icon ms-auto">
      <i class='bx bx-arrow-to-left'></i>

    </div>

  </div>


  <ul class="metismenu" id="menu">


    <li>
      <a href="<?= base_url('dashboard') ?>">

        <div class="parent-icon">
          <i class='bx bx-tachometer'></i>
        </div>

        <div class="menu-title">Dashboard</div>

      </a>
    </li>

    <?php if (permissao('beneficios')) : ?>
    <li>
      <a href="<?=base_url('brasilbeneficios');?>">

        <div class="menu-title">Meus Benefícios</div>
      </a>


    </li>
    <?php endif; ?>

		
    <li>
      <a href="javascript:;" class="has-arrow">

        <div class="parent-icon">
          <i class="bx bx-category"></i>
        </div>
        <div class="menu-title">Gestão de Empresas</div>
      </a>

      <ul>

        <li><a href="<?=base_url();?>/empresa">

            <div class="parent-icon">
              <i class="bx bx-mail-send"></i>
            </div>

            <div class="menu-title">Empresas</div>

          </a></li>

        <li><a href="<?=base_url();?>/empresas/dashboard">

            <div class="parent-icon">
              <i class="bx bx-book-reader"></i>
            </div>

            <div class="menu-title">Dashboard</div>

          </a></li>
        

      </ul>
    </li>

		
    <li>
      <a href="javascript:;" class="has-arrow">

        <div class="parent-icon">
          <i class="bx bx-category"></i>
        </div>
        <div class="menu-title">Gestão de Produtos</div>
      </a>

      <ul>

        <li><a href="<?=base_url();?>/produtos">

            <div class="parent-icon">
              <i class="bx bx-mail-send"></i>
            </div>

            <div class="menu-title">Produtos</div>

          </a></li>
        <li><a href="<?=base_url();?>/produtos/adicionar">

            <div class="parent-icon">
              <i class="bx bx-mail-send"></i>
            </div>

            <div class="menu-title">Adicionar produto</div>

          </a></li>

        <li><a href="<?=base_url();?>/produtos/dashboard">

            <div class="parent-icon">
              <i class="bx bx-book-reader"></i>
            </div>

            <div class="menu-title">Dashboard</div>

          </a></li>
        

      </ul>
    </li>

    <li>
      <a href="javascript:;" class="has-arrow">

        <div class="parent-icon">
          <i class="bx bx-category"></i>
        </div>
        <div class="menu-title">Gestão de vendas</div>
      </a>

      <ul>

        <li><a href="<?=base_url();?>/lead">

            <div class="parent-icon">
              <i class="bx bx-mail-send"></i>
            </div>

            <div class="menu-title">Leads</div>

          </a></li>

        <li><a href="<?=base_url();?>/proposta">

            <div class="parent-icon">
              <i class="bx bx-book-reader"></i>
            </div>

            <div class="menu-title">Propostas</div>

          </a></li>
        <li><a href="<?=base_url();?>/venda">

            <div class="parent-icon">
              <i class="bx bx-mail-send"></i>
            </div>

            <div class="menu-title">Vendas</div>

          </a></li>

      </ul>
    </li>

    <li>
      <a href="javascript:;" class="has-arrow">

        <div class="parent-icon">
          <i class="bx bx-category"></i>
        </div>
        <div class="menu-title">Gestão de Equipes</div>
      </a>

      <ul>

        <li><a href="<?=base_url();?>/usuario">

            <div class="parent-icon">
              <i class="bx bx-user"></i>
            </div>

            <div class="menu-title">Usuários</div>

          </a></li>
        <li><a href="<?=base_url();?>/filial">

            <div class="parent-icon">
              <i class="bx bx-buildings"></i>
            </div>

            <div class="menu-title">Regionais</div>

          </a></li>
        <li><a href="<?=base_url();?>/perfil">

            <div class="parent-icon">
              <i class="bx bx-lock-open"></i>
            </div>

            <div class="menu-title">Perfil de acesso</div>

          </a></li>

      </ul>
    </li>



    <li>
      <a href="javascript:;" class="has-arrow">

        <div class="parent-icon">
          <i class="bx bx-category"></i>
        </div>
        <div class="menu-title">Ferramentas</div>
      </a>

      <ul>

        <li><a href="<?=base_url();?>/manualpdf">

            <div class="parent-icon">
              <i class="bx bx-user"></i>
            </div>

            <div class="menu-title">Gerador de Manual</div>

          </a></li>


      </ul>
    </li>



</div>

<!--end sidebar wrapper -->