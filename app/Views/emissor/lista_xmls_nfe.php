<!-- Modal Cancelar Nota -->
<div class="modal fade" id="modal-cancelar-nota">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cancelar NFe</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/NFe/cancelar" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Justificativa</label>
                                <textarea class="form-control" name="justificativa" rows="10" required></textarea>
                                <p>
                                    <b>Obs:</b> O prazo para cancelamento da NFe é de 1 dia (24 horas) a partir da hora de emissão.
                                </p>
                            </div>
                        </div>

                        <input type="hidden" id="id_nfe" name="id_nfe" type="text">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Continuar</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row" style="margin-bottom: 15px">
                <div class="col-sm-6">
                    <h6 class="m-0 text-dark"><i class="<?= $titulo['icone'] ?>"></i> <?= $titulo['modulo'] ?></h6>
                </div><!-- /.col -->
                <div class="col-sm-6 no-print">
                    <ol class="breadcrumb float-sm-right">
                        <?php foreach ($caminhos as $caminho) : ?>
                            <?php if (!$caminho['active']) : ?>
                                <li class="breadcrumb-item"><a href="<?= $caminho['rota'] ?>"><?= $caminho['titulo'] ?></a></li>
                            <?php else : ?>
                                <li class="breadcrumb-item active"><?= $caminho['titulo'] ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ol>
                </div><!-- /.col -->
            </div>

            <div class="card col-lg-12">
                <div class="card-body">
                    <form action="/emissor/listaXMLsNFe" method="post">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Data Inicio</label>
                                    <input type="date" class="form-control" name="data_inicio" value="<?= (isset($data_inicio)) ? $data_inicio : "" ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Data Final</label>
                                    <input type="date" class="form-control" name="data_final" value="<?= (isset($data_final)) ? $data_final : "" ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success" style="margin-top: 30px"><i class="fas fa-search"></i> Pesquisar</button>

                                    <?php if(isset($data_inicio) && isset($data_final) && !empty($nfes)): ?>
                                        <a href="/NFe/baixaXMLS/<?= $data_inicio ?>/<?= $data_final ?><?= (isset($acao)) ? "/".$id_empresa : "" ?>" class="btn btn-info" style="margin-top: 30px"><i class="fas fa-download"></i> Baixar Seleção</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h6 class="m-0 text-dark"><i class="fas fa-list"></i> <?= $titulo_do_filtro ?></h6>
                        </div><!-- /.col -->
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-head-fixed text-nowrap table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 35px">Cód.</th>
                                <th>Chave</th>
                                <th>Número</th>
                                <th>Valor</th>
                                <th>Data</th>
                                <th>Hora</th>
                                <th>Tipo</th>
                                <th>Status</th>
                                <th class="no-print" style="width: 130px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($nfes)): ?>
                                <?php $valor_total_das_notas = 0 ?>
                                <?php $quantidade_de_notas = 0 ?>
                                <?php foreach($nfes as $nfe): ?>
                                    <tr>
                                        <td><?= $nfe['id_nfe'] ?></td>
                                        <td><?= $nfe['chave'] ?></td>
                                        <td><?= $nfe['numero'] ?></td>
                                        <td><?= number_format($nfe['valor_da_nota'], 2, ',', '.') ?></td>
                                        <td><?= date('d/m/Y', strtotime($nfe['data'])) ?></td>
                                        <td><?= $nfe['hora'] ?></td>
                                        
                                        <?php if($nfe['tipo'] == 1): ?>
                                            <td>Entrada</td>
                                        <?php elseif($nfe['tipo'] == 2): ?>
                                            <td>Saída</td>
                                        <?php elseif($nfe['tipo'] == 3): ?>
                                            <td>Devolução</td>
                                        <?php endif; ?>

                                        <td><?= $nfe['status'] ?></td>
                                        <td>
                                            <?php if($nfe['status'] != "Cancelada"): ?>
                                                <a href="/imprimir/DANFe/1/<?= $nfe['id_nfe'] ?>" class="btn btn-success style-action" target="_blank"><i class="fas fa-print"></i></a>
                                            <?php endif; ?>

                                            <a href="/NFe/baixarXML/<?= $nfe['id_nfe'] ?><?= (isset($acao)) ? "/".$id_empresa : "" ?>" class="btn btn-info style-action"><i class="fas fa-download"></i></a>
                                            
                                            <?php if(!isset($acao) && $nfe['status'] != "Cancelada"): ?>
                                                <button type="button" class="btn btn-danger style-action" onclick="document.getElementById('id_nfe').value = <?= $nfe['id_nfe'] ?>" data-toggle="modal" data-target="#modal-cancelar-nota" style="color: white"><i class="fas fa-window-close"></i></button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <?php $valor_total_das_notas += $nfe['valor_da_nota'] ?>
                                    <?php $quantidade_de_notas += 1 ?>
                                <?php endforeach ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9">Nenhum registro!</td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <?php if(!empty($nfes)): ?>
                <div class="card col-lg-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h6><b>Valor total das notas:</b> <?= number_format($valor_total_das_notas, 2, ',', '.') ?></h6>
                                <h6><b>Qtd de notas:</b> <?= $quantidade_de_notas ?></h6>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            <?php endif?>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
