<main class="content">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-sm-12 offset-sm-0 offset-md-2 col-md-8">
                <div class="row mb-3">
                    <div class="col-auto">
                        <div class="card card-body pb-1 pt-2">Počet
                            účtů: <?php echo count($accounts) . '/' . $user->accountsLimit ?></div>
                    </div>
                    <div class="col-auto ml-auto">
                        <button class="btn btn-warning">Spravovat profily</button>
                        <button class="btn btn-success" data-toggle="modal" data-target="#addAccountModal">Přidat účet
                        </button>
                    </div>
                </div>

                <?php /** @var $account \Models\Account */ ?>
                <?php foreach ($accounts as $account): ?>
                    <div class="card w-100 mb-4">
                        <div class="card-body w-100">
                            <div class="row">
                                <div class="col-2">
                                    <div class="character">
                                        <?php foreach ($account->getOutfitImages() as $image): ?>
                                            <img src="<?php echo $image ?>" class="part">
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="row">
                                        <div class="col-auto">
                                            <h5><?php echo "$account->name - $account->level (" . $account->getLevelProgress() . "%)" ?></h5>
                                        </div>
                                        <div class="col-auto ml-auto display-flex">
                                            <select class="custom-select">
                                                <option value="<?php echo \Models\Account::PROFILE_NONE ?>"></option>
                                                <?php /** @var $profile \Models\Profile */ ?>
                                                <?php foreach ($profiles as $profile): ?>
                                                    <option value="<?php echo $profile->id ?>"><?php echo $profile->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-8">
                                            <div class="row">
                                                <div class="text-small col-auto">
                                                    <b>Status:</b> <?php echo $account->energy == 0 ? 'Hotovo' : 'Probíhá' ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="w-100 col-auto">
                                                    <div class="progress mt-1 ">
                                                        <div class="progress-bar <?php if ($account->energy == 0) echo 'bg-success' ?>"
                                                             role="progressbar"
                                                             style="width: <?php echo 100 - $account->energy ?>%"
                                                             aria-valuenow="<?php echo 100 - $account->energy ?>"
                                                             aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto ml-auto"><i
                                                    class="fas fa-map-marked-alt mt-4"></i> <?php echo $account->adventures ?>
                                            /<?php echo \Models\Profile::MAX_ADVENTURES ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="modal fade" tabindex="-1" role="dialog" id="addAccountModal">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Přidat účet</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex justify-content-center">
                                <div class="btn-group w-100 mb-4" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-sm btn-primary">Přidat existující účet</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary" disabled>Registrace nových
                                        účtů
                                    </button>
                                </div>
                            </div>
<!--                            TODO: check account limit-->
                            <form id="addAccountForm"
                                  action="<?php echo \core\Application::$app->router->generateUrl('addAccount') ?>"
                                  method="POST">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="add_name">Jméno</label>
                                        <input type="email" class="form-control" id="add_name" placeholder="Jméno"
                                               name="add_name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="add_password">Heslo</label>
                                        <input type="password" class="form-control" id="add_password"
                                               placeholder="Heslo" name="add_password">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" id="addAccountSubmit">Přidat</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="<?php echo $GLOBALS['params']['server_subdirectory'] ?>/assets/addAccount.js"></script>
