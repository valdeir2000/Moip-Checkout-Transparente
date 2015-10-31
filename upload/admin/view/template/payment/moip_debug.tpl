<?php echo $header ?><?php echo $column_left ?>
<div id="content">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="container-fluid">
      
      <!-- Título da Página -->
      <h1><?php echo $heading_title_debug ?></h1>
      
      <!-- Sub-links -->
      <ul class="breadcrumb">
        <?php foreach($breadcrumbs as $breadcrumb): ?>
        <li><a href="<?php echo $breadcrumb['href'] ?>"><?php echo $breadcrumb['text'] ?></a></li>
        <?php endforeach ?>
      </ul>
      
      <!-- Botões do topo -->
      <div class="pull-right">
        <?php if ($moip_debug_status): ?>
        <button class="btn btn-success active" data-toggle="tooltip" title="<?php echo $button_deactivate ?>" onClick="deactivate()"><i class="fa fa-power-off"></i></button>
        <?php else: ?>
        <button class="btn btn-danger active" data-toggle="tooltip" title="<?php echo $button_active ?>" onClick="active()"><i class="fa fa-power-off"></i></button>
        <?php endif ?>
        <a href="<?php echo $configuration ?>" class="btn btn-primary" data-toggle="tooltip" title="<?php echo $button_config ?>"><i class="fa fa-cog"></i></a>
        <a href="<?php echo $download ?>" class="btn btn-success" data-toggle="tooltip" title="<?php echo $button_download ?>"><i class="fa fa-download"></i></a>
        <a href="<?php echo $clear ?>" class="btn btn-danger" data-toggle="tooltip" title="<?php echo $button_clear ?>"><i class="fa fa-trash"></i></a>
        <a href="<?php echo $cancel ?>" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_cancel ?>"><i class="fa fa-reply"></i></a>
      </div>
    </div>
  </div>

  <!-- Container -->
  <div class="container-fluid">
  
    <!-- Mensagem de sucesso ao ativar/desativar -->
    <?php if ($success){ ?>
    <div class="alert alert-success">
      <?php echo $success ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    
    <!-- Mensagem de erro ao ativar/desativar -->
    <?php if ($error_warning){ ?>
    <div class="alert alert-danger">
      <?php echo $warning ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
  
    <!-- Panel -->
    <div class="panel panel-default">
      
      <!-- Title -->
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-file"></i> <?php echo $heading_title_debug ?></h3>
      </div>
      
      <!-- Body -->
      <div class="panel-body">
      
        <!-- Informação do Playground -->
        <div class="alert alert-info">
          <?php echo $text_debug_info ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        
        <!-- Exibe o log -->
        <div class="well" style="min-height:150px">
          <?php
            foreach($debug as $value) {
              echo htmlspecialchars($value) . '<br/>';
            }
          ?>
        </div>
      </div> <!-- /.panel-body -->
    </div> <!-- /.panel -->
  </div> <!-- /.container-fluid -->
</div> <!-- /#content -->

<script type="text/javascript">
  function active() {
    $.ajax({
      url: 'index.php?route=payment/moip/debug&token=<?php echo $token ?>',
      type: 'POST',
      data: 'moip_debug_status=1',
      complete: function() {
        window.location.reload();
      }
    });
  }
  
  function deactivate() {
    $.ajax({
      url: 'index.php?route=payment/moip/debug&token=<?php echo $token ?>',
      type: 'POST',
      data: 'moip_debug_status=0',
      complete: function() {
        window.location.reload();
      }
    });
  }
</script>

<?php echo $footer ?>